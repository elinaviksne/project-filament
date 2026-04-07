<?php

namespace App\Filament\Resources\Shops\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables;
use Filament\Tables\Table;

class ShopsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Veikals')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('api_url')
                    ->label('API URL')
                    ->toggleable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Statuss')
                    ->colors([
                        'success' => 'active',
                        'gray' => 'inactive',
                    ])
                    ->formatStateUsing(fn (string $state): string => $state === 'active' ? 'Aktīvs' : 'Neaktīvs'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Atjaunots')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Statuss')
                    ->options([
                        'active' => 'Aktīvs',
                        'inactive' => 'Neaktīvs',
                    ]),
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
