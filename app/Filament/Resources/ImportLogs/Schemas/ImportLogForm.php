<?php

namespace App\Filament\Resources\ImportLogs\Schemas;

use App\Services\ShopSyncService;
use Filament\Forms;
use Filament\Schemas\Schema;

class ImportLogForm
{
    public static function configure(Schema $schema): Schema
    {
        app(ShopSyncService::class)->syncFromApi();

        return $schema->schema([
            Forms\Components\Select::make('shop_id')
                ->label(__('app.common.shop'))
                ->relationship('shop', 'name')
                ->searchable()
                ->preload()
                ->required(),

            Forms\Components\TextInput::make('file_type')
                ->label(__('app.import_logs.file_type'))
                ->required(),

            Forms\Components\Hidden::make('imported_at')
                ->default(now()),    

        ]);
    }
}
