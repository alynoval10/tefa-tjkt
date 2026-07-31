<?php

namespace App\Filament\Resources\Kas\Tables;

use App\Enums\TransactionType;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Models\Category;

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
                ->formatStateUsing(
                    fn (string $state) => TransactionType::from($state)->label()
                )
                ->color(
                    fn (string $state) => TransactionType::from($state)->badgeColor()
                ),
                TextColumn::make('debet')
                ->label('Debet')
                ->state(function ($record) {
                                        $type = TransactionType::from($record->category->type);

                    return $type->isIncome()
                        ? $record->nominal
                        : null;
                                    })
                ->money('IDR')
                ->alignEnd(),

            TextColumn::make('kredit')
                ->label('Kredit')
                ->state(function ($record) {
                                        $type = TransactionType::from($record->category->type);

                    return $type->isExpense()
                        ? $record->nominal
                        : null;
                })
                ->money('IDR')
                ->alignEnd(),

                

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