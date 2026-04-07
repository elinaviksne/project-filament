<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\User;
use Filament\Forms;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\TextInput::make('name')
                ->label('Vārds')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('email')
                ->label('E-pasts')
                ->email()
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true),

            Forms\Components\Toggle::make('is_admin')
                ->label('Admin piekļuve')
                ->default(false)
                ->disabled(fn (?User $record): bool => $record?->id === Auth::id())
                ->helperText('Nevar noņemt admin tiesības pašam sev no šī ekrāna.'),

            Forms\Components\TextInput::make('password')
                ->label('Parole')
                ->password()
                ->revealable()
                ->required(fn (string $operation): bool => $operation === 'create')
                ->dehydrated(fn (?string $state): bool => filled($state))
                ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                ->maxLength(255),
        ]);
    }
}
