<?php

namespace App\Filament\Widgets;

use App\Models\Kas;
use Filament\Widgets\ChartWidget;

class PengeluaranChart extends ChartWidget
{
    protected ?string $heading = 'Pengeluaran Berdasarkan Kategori';

    protected int|string|array $columnSpan = 1;

    public ?string $filter = null;

    protected function getFilters(): ?array
    {
        return collect(range(date('Y'), date('Y') - 4))
            ->mapWithKeys(fn ($year) => [
                (string) $year => (string) $year,
            ])
            ->toArray();
    }

    protected function getData(): array
    {
        $year = (int) ($this->filter ?? date('Y'));

        $data = Kas::query()
            ->whereYear('tanggal', $year)
            ->whereHas('category', function ($query) {
                $query->where('type', 'expense');
            })
            ->with('category')
            ->selectRaw('category_id, SUM(nominal) as total')
            ->groupBy('category_id')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Pengeluaran',
                    'data' => $data
                        ->pluck('total')
                        ->map(fn ($value) => (float) $value)
                        ->values()
                        ->toArray(),

                    'backgroundColor' => [
                        '#3b82f6',
                        '#22c55e',
                        '#f59e0b',
                        '#ef4444',
                        '#8b5cf6',
                        '#06b6d4',
                        '#ec4899',
                        '#84cc16',
                    ],

                    'borderWidth' => 0,
                ],
            ],

            'labels' => $data
                ->map(fn ($item) => $item->category?->name ?? 'Tanpa Kategori')
                ->values()
                ->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}