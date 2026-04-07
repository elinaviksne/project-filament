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
                ->label('Nosaukums')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('api_url')
                ->label('API URL')
                ->url()
                ->maxLength(255),

            Forms\Components\Select::make('status')
                ->label('Statuss')
                ->options([
                    'active' => 'Aktīvs',
                    'inactive' => 'Neaktīvs',
                ])
                ->default('active')
                ->required(),
        ]);
    }
}
