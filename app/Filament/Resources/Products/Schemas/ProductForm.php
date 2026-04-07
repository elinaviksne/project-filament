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
                ->label(__('app.common.name'))
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('model')
                ->label(__('app.products.model'))
                ->required()
                ->maxLength(255),

            Forms\Components\Select::make('category_id')
                ->label(__('app.products.category'))
                ->relationship('category', 'name')
                ->searchable()
                ->preload(),

            Forms\Components\Select::make('brand_id')
                ->label(__('app.products.brand'))
                ->relationship('brand', 'name')
                ->searchable()
                ->preload(),
        ]);
    }
}
