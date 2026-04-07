<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\TextInput::make('name')
                ->label('Nosaukums')
                ->required()
                ->maxLength(255),

            Forms\Components\Select::make('parent_id')
                ->label('Vecākā kategorija')
                ->relationship('parent', 'name')
                ->searchable()
                ->preload()
                ->nullable(),
        ]);
    }
}
