<?php

namespace App\Filament\Resources\ImportLogs\Tables;

use App\Services\ShopSyncService;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms;

class ImportLogsTable
{
    public static function configure(Table $table): Table
    {
        app(ShopSyncService::class)->syncFromApi();

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('shop.name')
                    ->label('Veikals')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('file_type')
                    ->label('Faila tips')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('imported_at')
                    ->label('Importēts')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('shop_id')
                    ->label('Veikals')
                    ->relationship('shop', 'name'),

                Tables\Filters\Filter::make('imported_today')
                    ->label('Importēts šodien')
                    ->query(fn ($query) => $query->whereDate('imported_at', today())),

                // 👇 Jauns filtrs pēc datuma un laika diapazona
                Tables\Filters\Filter::make('imported_range')
                    ->label('Importēts no/līdz')
                    ->form([
                        Forms\Components\DateTimePicker::make('from')
                            ->label('No'),
                        Forms\Components\DateTimePicker::make('to')
                            ->label('Līdz'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn ($query, $date) => 
                                $query->where('imported_at', '>=', $date))
                            ->when($data['to'], fn ($query, $date) => 
                                $query->where('imported_at', '<=', $date));
                    }),
            ])
            ->searchPlaceholder('Meklēt pēc veikala vai faila tipa...')
            ->actions([])
            ->bulkActions([]);
    }
}
