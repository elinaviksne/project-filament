<?php

namespace App\Filament\Pages;

use App\Models\ImportLog;
use App\Models\Offer;
use App\Models\PriceHistory;
use App\Models\Shop;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class Analytics extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBarSquare;
    protected static ?int $navigationSort = 10;
    protected string $view = 'filament.pages.analytics';

    public array $filters = [
        'shop_id' => '',
        'from' => '',
        'to' => '',
    ];

    public function mount(): void
    {
        $this->filters = [
            'shop_id' => (string) request()->query('shop_id', ''),
            'from' => (string) request()->query('from', ''),
            'to' => (string) request()->query('to', ''),
        ];
    }

    protected function baseFilter(Builder $query, string $columnPrefix = ''): Builder
    {
        $shopId = $this->filters['shop_id'];
        $from = $this->filters['from'] ? Carbon::parse($this->filters['from'])->startOfDay() : null;
        $to = $this->filters['to'] ? Carbon::parse($this->filters['to'])->endOfDay() : null;
        $shopColumn = $columnPrefix . 'shop_id';
        $createdAtColumn = $columnPrefix . 'created_at';

        return $query
            ->when($shopId !== '', fn (Builder $q) => $q->where($shopColumn, (int) $shopId))
            ->when($from, fn (Builder $q) => $q->where($createdAtColumn, '>=', $from))
            ->when($to, fn (Builder $q) => $q->where($createdAtColumn, '<=', $to));
    }

    protected function getViewData(): array
    {
        $offersQuery = $this->baseFilter(Offer::query());
        $importsQuery = $this->baseFilter(ImportLog::query());
        $pricesQuery = $this->baseFilter(PriceHistory::query());

        $latestImports = (clone $importsQuery)
            ->with('shop:id,name')
            ->latest('imported_at')
            ->limit(5)
            ->get();

        $shopTotals = (clone $offersQuery)
            ->selectRaw('shop_id, COUNT(*) as offers_count, ROUND(AVG(price), 2) as avg_price')
            ->with('shop:id,name')
            ->groupBy('shop_id')
            ->orderByDesc('offers_count')
            ->limit(8)
            ->get();

        return [
            'shops' => Shop::query()->orderBy('name')->pluck('name', 'id'),
            'filters' => $this->filters,
            'metrics' => [
                'shops' => Shop::query()->count(),
                'activeShops' => Shop::query()->where('status', 'active')->count(),
                'offers' => (clone $offersQuery)->count(),
                'imports' => (clone $importsQuery)->count(),
                'avgPrice' => (clone $pricesQuery)->avg('price'),
            ],
            'latestImports' => $latestImports,
            'shopTotals' => $shopTotals,
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'Kopsavilkums';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Analītika';
    }
}
