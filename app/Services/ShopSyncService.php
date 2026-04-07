<?php

namespace App\Services;

use App\Models\Shop;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ShopSyncService
{
    public function syncFromApi(): void
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
}
