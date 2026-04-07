<?php

namespace App\Filament\Resources\Shops\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class ShopsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->striped()
            ->columns([
                Tables\Columns\TextColumn::make('logo')
                    ->label(__('app.common.logo'))
                    ->getStateUsing(fn ($record) => $record->name)
                    ->formatStateUsing(function (string $state, $record): HtmlString {
                        $name = mb_strtolower(trim($record->name));
                        $is220 = str_contains($name, '220.lv')
                            || $name === '220'
                            || str_starts_with($name, '220 ');

                        if ($is220) {
                            $url = asset('images/220-lv-logo.png');

                            return new HtmlString(
                                '<img src="'.e($url).'" alt="220.lv" class="fi-shop-logo-img" loading="lazy" />'
                            );
                        }

                        $initial = mb_strtoupper(mb_substr($state, 0, 1));

                        return new HtmlString('<span class="fi-shop-avatar">'.$initial.'</span>');
                    })
                    ->html()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('app.shops.shop_name'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label(__('app.common.status'))
                    ->badge()
                    ->color(fn (string $state): string => $state === 'active' ? 'success' : 'gray')
                    ->formatStateUsing(fn (string $state): string => $state === 'active' ? __('app.common.active') : __('app.common.inactive')),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('app.shops.last_updated'))
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label(__('app.common.status'))
                    ->options([
                        'active' => __('app.common.active'),
                        'inactive' => __('app.common.inactive'),
                    ]),
            ])
            ->recordActions([
                EditAction::make()
                    ->color('primary'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
