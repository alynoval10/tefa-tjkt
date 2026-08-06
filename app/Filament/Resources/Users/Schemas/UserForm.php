<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Role;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('name')
                    ->label('Nama')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->revealable()
                    ->dehydrateStateUsing(
                        fn (?string $state) => filled($state) ? bcrypt($state) : null
                    )
                    ->dehydrated(
                        fn (?string $state) => filled($state)
                    )
                    ->required(
                        fn (string $operation): bool => $operation === 'create'
                    ),

                Select::make('role')
                    ->label('Role')
                    ->options(
                        Role::query()
                            ->orderBy('name')
                            ->pluck('name', 'name')
                            ->toArray()
                    )
                    ->searchable()
                    ->preload()
                    ->required()
                    ->live()
                    ->default(null)
                   ->formatStateUsing(function ($state, $record) {
                            return $record?->roles()->first()?->name;
                        }),

            ]);
    }
}