<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Spatie\Activitylog\Models\Activity;

class ActivityLogs extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationLabel = 'Log Aktivitas';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClock;

    protected static string|\UnitEnum|null $navigationGroup = 'Sistem';

    protected static ?int $navigationSort = 100;

    protected static ?string $title = 'Log Aktivitas';

    protected static ?string $slug = 'activity-logs';

    protected string $view = 'filament.pages.activity-logs';

    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole('admin') ?? false;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Activity::query()->with(['causer', 'subject'])
            )
            ->columns([
                TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                TextColumn::make('causer.name')
                    ->label('User')
                    ->searchable()
                    ->default('-'),

                TextColumn::make('description')
                    ->label('Aktivitas')
                    ->searchable(),

                TextColumn::make('event')
                    ->label('Aksi')
                    ->badge()
                    ->formatStateUsing(fn (?string $state) => match ($state) {
                        'created' => 'Dibuat',
                        'updated' => 'Diubah',
                        'deleted' => 'Dihapus',
                        default => ucfirst($state ?? '-'),
                    }),

                TextColumn::make('log_name')
                    ->label('Modul')
                    ->badge(),

                TextColumn::make('subject_type')
                    ->label('Data')
                    ->formatStateUsing(function (?string $state) {
                        if (! $state) {
                            return '-';
                        }

                        return class_basename($state);
                    }),

                TextColumn::make('subject_id')
                    ->label('ID')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25, 50]);
    }
}