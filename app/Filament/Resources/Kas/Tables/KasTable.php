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
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\Summarizers\Sum;

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
        return TransactionType::from($record->category->type)->isIncome()
            ? $record->nominal
            : null;
    })
    ->money('IDR')
    ->alignEnd()
    ,

TextColumn::make('kredit')
    ->label('Kredit')
    ->state(function ($record) {
        return TransactionType::from($record->category->type)->isExpense()
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
            ->filters([

    Filter::make('periode')
        ->label('Periode')
        ->form([
            DatePicker::make('tanggal_awal')
                ->label('Tanggal Awal'),

            DatePicker::make('tanggal_akhir')
                ->label('Tanggal Akhir'),
        ])
        ->query(function (Builder $query, array $data): Builder {

            return $query
                ->when(
                    $data['tanggal_awal'],
                    fn (Builder $query, $date) =>
                        $query->whereDate('tanggal', '>=', $date)
                )
                ->when(
                    $data['tanggal_akhir'],
                    fn (Builder $query, $date) =>
                        $query->whereDate('tanggal', '<=', $date)
                );
        }),

    SelectFilter::make('category')
    ->label('Kategori')
    ->relationship('category', 'name')

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