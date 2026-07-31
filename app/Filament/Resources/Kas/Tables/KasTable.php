<?php

namespace App\Filament\Resources\Kas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class KasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('no_bukti')
                ->label('No. Bukti')
                ->searchable()
                ->copyable()
                ->sortable(),

                TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->searchable(),

                TextColumn::make('category.type')
                ->label('Jenis Kas')
                ->badge()
                ->formatStateUsing(fn (string $state) => match ($state) {
                    'income' => 'Kas Masuk',
                    'expense' => 'Kas Keluar',
                    default => $state,
                })
                ->color(fn (string $state) => match ($state) {
                    'income' => 'success',
                    'expense' => 'danger',
                    default => 'gray',
                }),
                TextColumn::make('nominal')
                    ->label('Nominal')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('Input Oleh'),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->since(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}