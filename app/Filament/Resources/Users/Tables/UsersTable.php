<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Vārds')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('E-pasts')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_admin')
                    ->label('Admin')
                    ->boolean(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Atjaunots')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_admin')
                    ->label('Admin piekļuve')
                    ->placeholder('Visi')
                    ->trueLabel('Tikai admin')
                    ->falseLabel('Tikai parastie'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
