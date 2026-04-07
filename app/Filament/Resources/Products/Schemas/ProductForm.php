<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\TextInput::make('name')
                ->label('Nosaukums')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('model')
                ->label('Modelis')
                ->required()
                ->maxLength(255),

            Forms\Components\Select::make('category_id')
                ->label('Kategorija')
                ->relationship('category', 'name')
                ->searchable()
                ->preload(),

            Forms\Components\Select::make('brand_id')
                ->label('Zīmols')
                ->relationship('brand', 'name')
                ->searchable()
                ->preload(),
        ]);
    }
}
