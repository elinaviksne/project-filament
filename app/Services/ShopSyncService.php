<?php

namespace App\Services;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ShopSyncService
{
    public function syncFromApi(): void
    {
        $this->syncShopsFromApi();
    }

    public function syncAllFromApi(): void
    {
        $this->syncShopsFromApi();
        $this->syncCategoriesFromApi();
        $this->syncBrandsFromApi();
        $this->syncProductsFromApi();
    }

    protected function syncShopsFromApi(): void
    {
        $apiUrl = rtrim((string) config('services.internetveikals.base_url'), '/');

        if ($apiUrl === '') {
            return;
        }

        try {
            $response = Http::timeout(5)->get($apiUrl . '/api/shops');
            if (! $response->successful()) {
                Log::warning('Failed to fetch shops from internetveikals API', [
                    'status' => $response->status(),
                ]);
                return;
            }

            $shops = Collection::make($response->json());
            $remoteIds = [];

            foreach ($shops as $shopData) {
                $remoteId = data_get($shopData, 'id');
                $name = data_get($shopData, 'name');

                if (! $remoteId || ! $name) {
                    continue;
                }

                $remoteIds[] = (int) $remoteId;

                Shop::query()->updateOrCreate(
                    ['id' => (int) $remoteId],
                    [
                        'name' => (string) $name,
                        'api_url' => data_get($shopData, 'api_url'),
                        'status' => data_get($shopData, 'status', 'active'),
                    ]
                );
            }

            if (! empty($remoteIds)) {
                Shop::query()->whereNotIn('id', $remoteIds)->update(['status' => 'inactive']);
            }
        } catch (\Throwable $exception) {
            Log::warning('Shop sync from internetveikals API failed', [
                'message' => $exception->getMessage(),
            ]);
        }
    }

    protected function syncCategoriesFromApi(): void
    {
        $categories = $this->fetchCollection('/api/categories');

        foreach ($categories as $categoryData) {
            $id = (int) data_get($categoryData, 'id');
            $name = trim((string) data_get($categoryData, 'name', ''));

            if (! $id || $name === '') {
                continue;
            }

            Category::query()->updateOrCreate(
                ['id' => $id],
                ['name' => $name]
            );
        }
    }

    protected function syncBrandsFromApi(): void
    {
        $brands = $this->fetchCollection('/api/brands');

        foreach ($brands as $brandData) {
            $id = (int) data_get($brandData, 'id');
            $name = trim((string) data_get($brandData, 'name', ''));

            if (! $id || $name === '') {
                continue;
            }

            Brand::query()->updateOrCreate(
                ['id' => $id],
                ['name' => $name]
            );
        }
    }

    protected function syncProductsFromApi(): void
    {
        $products = $this->fetchCollection('/api/products');

        foreach ($products as $productData) {
            $id = (int) data_get($productData, 'id');
            $name = trim((string) data_get($productData, 'name', ''));
            $brandId = data_get($productData, 'brand_id');
            $categoryId = data_get($productData, 'category_id');

            if (! $id || $name === '' || ! $brandId || ! $categoryId) {
                continue;
            }

            Product::query()->updateOrCreate(
                ['id' => $id],
                [
                    'name' => $name,
                    'model' => Str::limit((string) data_get($productData, 'description', ''), 255, ''),
                    'ean' => null,
                    'brand_id' => (int) $brandId,
                    'category_id' => (int) $categoryId,
                ]
            );
        }
    }

    protected function fetchCollection(string $path): Collection
    {
        $apiUrl = rtrim((string) config('services.internetveikals.base_url'), '/');

        if ($apiUrl === '') {
            return Collection::make();
        }

        try {
            $response = Http::timeout(10)->get($apiUrl . $path);

            if (! $response->successful()) {
                Log::warning('Failed to fetch collection from internetveikals API', [
                    'path' => $path,
                    'status' => $response->status(),
                ]);

                return Collection::make();
            }

            $payload = $response->json();

            if (is_array($payload) && array_key_exists('data', $payload)) {
                return Collection::make($payload['data']);
            }

            return Collection::make($payload);
        } catch (\Throwable $exception) {
            Log::warning('Collection sync from internetveikals API failed', [
                'path' => $path,
                'message' => $exception->getMessage(),
            ]);

            return Collection::make();
        }
    }
}
