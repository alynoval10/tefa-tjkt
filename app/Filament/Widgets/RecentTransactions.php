<?php

namespace App\Filament\Widgets;

use App\Models\Kas;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentTransactions extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Transaksi Terbaru';

    protected function getTableQuery(): Builder
    {
        return Kas::query()
            ->with('category')
            ->latest('tanggal');
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('tanggal')
                ->label('Tanggal')
                ->date('d M Y')
                ->sortable(),

            Tables\Columns\TextColumn::make('category.name')
                ->label('Kategori')
                ->searchable(),

            Tables\Columns\TextColumn::make('category.type')
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

            Tables\Columns\TextColumn::make('nominal')
                ->label('Nominal')
                ->money('IDR'),
        ];
    }

   public function getTableRecordsPerPage(): int
{
    return 5;
}
}