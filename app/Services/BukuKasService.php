<?php

namespace App\Services;

use App\Models\Kas;

class BukuKasService
{
    public function laporan($tanggalAwal = null, $tanggalAkhir = null)
    {
        $query = Kas::with('category', 'user')
            ->orderBy('tanggal')
            ->orderBy('id');

        if ($tanggalAwal) {
            $query->whereDate('tanggal', '>=', $tanggalAwal);
        }

        if ($tanggalAkhir) {
            $query->whereDate('tanggal', '<=', $tanggalAkhir);
        }

        $saldo = 0;

        return $query->get()->map(function ($item) use (&$saldo) {

            $item->debet = 0;
            $item->kredit = 0;

            if ($item->category->type === 'income') {
                $item->debet = $item->nominal;
                $saldo += $item->nominal;
            } else {
                $item->kredit = $item->nominal;
                $saldo -= $item->nominal;
            }

            $item->saldo = $saldo;

            return $item;
        });
    }
}