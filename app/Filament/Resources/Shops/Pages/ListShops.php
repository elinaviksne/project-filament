<?php

namespace App\Filament\Resources\Shops\Pages;

use App\Filament\Resources\Shops\ShopResource;
use App\Services\ShopSyncService;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListShops extends ListRecords
{
    protected static string $resource = ShopResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('sync')
                ->label(__('app.shops.sync_all'))
                ->icon('heroicon-o-arrow-path')
                ->color('primary')
                ->action(function (): void {
                    app(ShopSyncService::class)->syncAllFromApi();

                    Notification::make()
                        ->title(__('app.shops.sync_done'))
                        ->success()
                        ->send();
                }),
            CreateAction::make()
                ->label(__('app.shops.add_shop'))
                ->color('primary'),
        ];
    }
}
