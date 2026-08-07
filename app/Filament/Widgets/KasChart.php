<?php

namespace App\Filament\Widgets;

use App\Models\Kas;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class KasChart extends ChartWidget
{
    protected ?string $heading = 'Grafik Kas Bulanan';

    protected function getData(): array
    {
        $income = [];
        $expense = [];
        $labels = [];

        for ($month = 1; $month <= 12; $month++) {

            $labels[] = date('M', mktime(0, 0, 0, $month, 1));

            $income[] = Kas::query()
                ->whereMonth('tanggal', $month)
                ->whereHas('category', fn ($q) => $q->where('type', 'income'))
                ->sum('nominal');

            $expense[] = Kas::query()
                ->whereMonth('tanggal', $month)
                ->whereHas('category', fn ($q) => $q->where('type', 'expense'))
                ->sum('nominal');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Kas Masuk',
                    'data' => $income,
                    'borderColor' => '#22c55e',
                    'backgroundColor' => 'rgba(34,197,94,0.15)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Kas Keluar',
                    'data' => $expense,
                    'borderColor' => '#ef4444',
                    'backgroundColor' => 'rgba(239,68,68,0.15)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],

            'labels' => $labels,
        ];
    }

    protected function getOptions(): array
{
    return [
        'plugins' => [
            'legend' => [
                'display' => true,
            ],
        ],
        'scales' => [
            'y' => [
                'ticks' => [
                    'callback' => \Illuminate\Support\Js::from(
                        'function(value){ return (value / 1000000) + " Jt"; }'
                    ),
                ],
            ],
        ],
    ];
}

    protected function getType(): string
    {
        return 'line';
    }


}