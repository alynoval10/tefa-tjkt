<?php

namespace App\Filament\Resources\Kas\Widgets;

use App\Services\BukuKasService;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class KasStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $summary = app(BukuKasService::class)->summary();

        return [
            Stat::make(
                'Kas Masuk',
                'Rp ' . number_format($summary['total_debet'], 0, ',', '.')
            )
                ->color('success')
                ->icon('heroicon-o-arrow-trending-up'),

            Stat::make(
                'Kas Keluar',
                'Rp ' . number_format($summary['total_kredit'], 0, ',', '.')
            )
                ->color('danger')
                ->icon('heroicon-o-arrow-trending-down'),

            Stat::make(
                'Saldo',
                'Rp ' . number_format($summary['saldo_akhir'], 0, ',', '.')
            )
                ->color('primary')
                ->icon('heroicon-o-wallet'),
        ];
    }
}