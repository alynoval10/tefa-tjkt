<?php

namespace App\Filament\Resources\Kas\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class KasForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
    ->components([
        DatePicker::make('tanggal')
            ->label('Tanggal')
            ->required()
            ->default(now()),

        Select::make('category_id')
            ->label('Kategori')
            ->relationship('category', 'name')
            ->searchable()
            ->preload()
            ->required(),

        

        TextInput::make('nominal')
            ->label('Nominal')
            ->numeric()
            ->prefix('Rp')
            ->required(),

        Textarea::make('keterangan')
            ->label('Keterangan')
            ->rows(3)
            ->columnSpanFull(),
    ]);
    }
}
