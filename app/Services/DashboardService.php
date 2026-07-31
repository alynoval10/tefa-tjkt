<?php

namespace App\Services;

use App\Models\Kas;

class DashboardService
{
    public function summary(): array
    {
        $kasMasuk = Kas::whereHas('category', function ($query) {
            $query->where('type', 'income');
        })->sum('nominal');

        $kasKeluar = Kas::whereHas('category', function ($query) {
            $query->where('type', 'expense');
        })->sum('nominal');

        return [
            'kas_masuk' => $kasMasuk,
            'kas_keluar' => $kasKeluar,
            'saldo' => $kasMasuk - $kasKeluar,
            'jumlah_transaksi' => Kas::count(),
        ];
    }
}