<?php

namespace App\Filament\Resources\Shops\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;

class ShopForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\TextInput::make('name')
                ->label(__('app.common.name'))
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('api_url')
                ->label(__('app.shops.api_url'))
                ->url()
                ->maxLength(255),

            Forms\Components\Select::make('status')
                ->label(__('app.common.status'))
                ->options([
                    'active' => __('app.common.active'),
                    'inactive' => __('app.common.inactive'),
                ])
                ->default('active')
                ->required(),
        ]);
    }
}
