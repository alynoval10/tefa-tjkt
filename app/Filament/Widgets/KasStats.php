<?php

namespace App\Filament\Widgets;

use App\Models\Kas;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Category;
use App\Models\User;

class KasStats extends StatsOverviewWidget
{
    protected function getStats(): array
{
    $kasMasuk = Kas::whereHas('category', function ($query) {
        $query->where('type', 'income');
    })->sum('nominal');

    $kasKeluar = Kas::whereHas('category', function ($query) {
        $query->where('type', 'expense');
    })->sum('nominal');

    $saldo = $kasMasuk - $kasKeluar;

    $jumlahUser = User::count();

    $jumlahKategori = Category::count();

    return [

        Stat::make(
            'Saldo Kas',
            'Rp ' . number_format($saldo, 0, ',', '.')
        )
            ->description('Saldo saat ini')
            ->descriptionIcon('heroicon-m-wallet')
            ->color('success'),

        Stat::make(
            'Kas Masuk',
            'Rp ' . number_format($kasMasuk, 0, ',', '.')
        )
            ->description('Total pemasukan')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->color('primary'),

        Stat::make(
            'Kas Keluar',
            'Rp ' . number_format($kasKeluar, 0, ',', '.')
        )
            ->description('Total pengeluaran')
            ->descriptionIcon('heroicon-m-arrow-trending-down')
            ->color('danger'),

        Stat::make(
            'Total User',
            $jumlahUser
        )
            ->description('User terdaftar')
            ->descriptionIcon('heroicon-m-users')
            ->color('info'),

        Stat::make(
            'Kategori',
            $jumlahKategori
        )
            ->description('Kategori kas')
            ->descriptionIcon('heroicon-m-tag')
            ->color('warning'),

    ];
}
}