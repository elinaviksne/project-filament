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
                ->label('Sinhronizēt visus datus')
                ->icon('heroicon-o-arrow-path')
                ->color('primary')
                ->action(function (): void {
                    app(ShopSyncService::class)->syncAllFromApi();

                    Notification::make()
                        ->title('Datu sinhronizācija pabeigta')
                        ->success()
                        ->send();
                }),
            CreateAction::make()->label('Pievienot veikalu'),
        ];
    }
}
