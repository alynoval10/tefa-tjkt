<?php

namespace App\Filament\Widgets;

use App\Models\Kas;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class KasStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $kasMasuk = Kas::whereHas('category', function ($q) {
            $q->where('type', 'income');
        })->sum('nominal');

        $kasKeluar = Kas::whereHas('category', function ($q) {
            $q->where('type', 'expense');
        })->sum('nominal');

        $saldo = $kasMasuk - $kasKeluar;

        return [
            Stat::make(
                'Saldo Kas',
                'Rp ' . number_format($saldo, 0, ',', '.')
            )
                ->description('Saldo saat ini')
                ->color('success')
                ->icon('heroicon-o-wallet'),

            Stat::make(
                'Kas Masuk',
                'Rp ' . number_format($kasMasuk, 0, ',', '.')
            )
                ->description('Total pemasukan')
                ->color('primary')
                ->icon('heroicon-o-arrow-trending-up'),

            Stat::make(
                'Kas Keluar',
                'Rp ' . number_format($kasKeluar, 0, ',', '.')
            )
                ->description('Total pengeluaran')
                ->color('danger')
                ->icon('heroicon-o-arrow-trending-down'),
        ];
    }
}