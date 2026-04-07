<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Tables;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('app.common.name'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('model')
                    ->label(__('app.products.model'))
                    ->sortable()
                    ->searchable(),    

                Tables\Columns\TextColumn::make('category.name')
                    ->label(__('app.products.category'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('brand.name')
                    ->label(__('app.products.brand'))
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('brand_id')
                    ->label(__('app.products.brand'))
                    ->relationship('brand', 'name'),

                Tables\Filters\SelectFilter::make('category_id')
                    ->label(__('app.products.category'))
                    ->relationship('category', 'name'),
            ])
            ->searchPlaceholder(__('app.products.search_placeholder'))
            ->actions([
                
            ])
            ->bulkActions([
                
            ]);
    }
}
