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
use Filament\Actions\Action;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;

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

                TextColumn::make('properties')
                    ->label('No. Bukti')
                    ->state(function ($record) {
                        return data_get(
                            $record->properties?->toArray(),
                            'attributes.no_bukti'
                        ) ?? data_get(
                            $record->properties?->toArray(),
                            'old.no_bukti'
                        ) ?? '-';
                    }),

                TextColumn::make('properties')
                    ->label('Nominal')
                    ->state(function ($record) {
                        $value = data_get(
                            $record->properties?->toArray(),
                            'attributes.nominal'
                        );

                        if ($value === null) {
                            $value = data_get(
                                $record->properties?->toArray(),
                                'old.nominal'
                            );
                        }

                        return $value !== null
                            ? 'Rp ' . number_format((float) $value, 0, ',', '.')
                            : '-';
                    }),

                TextColumn::make('subject_type')
                    ->label('Data')
                    ->formatStateUsing(
                        fn (?string $state) => $state
                            ? class_basename($state)
                            : '-'
                    ),
            ])
            
            ->filters([
            SelectFilter::make('causer_id')
            ->label('User')
            ->options(
                User::query()
                    ->orderBy('name')
                    ->pluck('name', 'id')
                    ->toArray()
            )
            ->searchable()
            ->preload(),
    SelectFilter::make('event')
        ->label('Aksi')
        ->options([
            'created' => 'Dibuat',
            'updated' => 'Diubah',
            'deleted' => 'Dihapus',
        ]),
SelectFilter::make('subject_type')
    ->label('Data')
    ->options(
        Activity::query()
            ->whereNotNull('subject_type')
            ->distinct()
            ->pluck('subject_type')
            ->mapWithKeys(function ($type) {
                return [
                    $type => class_basename($type),
                ];
            })
            ->toArray()
    ),

    Filter::make('created_at')
        ->label('Tanggal')
        ->form([
            DatePicker::make('from')
                ->label('Dari'),

            DatePicker::make('until')
                ->label('Sampai'),
        ])
        ->query(function (Builder $query, array $data): Builder {
            return $query
                ->when(
                    $data['from'] ?? null,
                    fn (Builder $query, $date) =>
                        $query->whereDate('created_at', '>=', $date)
                )
                ->when(
                    $data['until'] ?? null,
                    fn (Builder $query, $date) =>
                        $query->whereDate('created_at', '<=', $date)
                );
        }),
])

                ->recordActions([
                    Action::make('detail')
                        ->label('Detail')
                        ->modalWidth('2xl')
                        ->modalHeading(fn ($record) => $record->description)
                        ->modalSubmitAction(false)
                        ->modalCancelActionLabel('Tutup')
                        ->modalContent(fn ($record) => view(
                            'filament.pages.activity-detail',
                            [
                                'activity' => $record,
                            ]
                        )),
                ])


            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25, 50]);
    }
}