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
                    ->label(__('app.common.shop'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('file_type')
                    ->label(__('app.import_logs.file_type'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('imported_at')
                    ->label(__('app.import_logs.imported'))
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('shop_id')
                    ->label(__('app.common.shop'))
                    ->relationship('shop', 'name'),

                Tables\Filters\Filter::make('imported_today')
                    ->label(__('app.import_logs.imported_today'))
                    ->query(fn ($query) => $query->whereDate('imported_at', today())),

                // 👇 Jauns filtrs pēc datuma un laika diapazona
                Tables\Filters\Filter::make('imported_range')
                    ->label(__('app.import_logs.imported_between'))
                    ->form([
                        Forms\Components\DateTimePicker::make('from')
                            ->label(__('app.import_logs.from')),
                        Forms\Components\DateTimePicker::make('to')
                            ->label(__('app.import_logs.until')),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn ($query, $date) => 
                                $query->where('imported_at', '>=', $date))
                            ->when($data['to'], fn ($query, $date) => 
                                $query->where('imported_at', '<=', $date));
                    }),
            ])
            ->searchPlaceholder(__('app.import_logs.search_placeholder'))
            ->actions([])
            ->bulkActions([]);
    }
}
