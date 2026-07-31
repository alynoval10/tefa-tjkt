<?php

namespace App\Services;

use App\Enums\TransactionType;
use App\Models\Kas;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class BukuKasService
{
    public function query(
        ?string $tanggalAwal = null,
        ?string $tanggalAkhir = null
    ): Builder {
        $query = Kas::query()
            ->with(['category', 'user'])
            ->orderBy('tanggal')
            ->orderBy('id');

        if ($tanggalAwal) {
            $query->whereDate('tanggal', '>=', $tanggalAwal);
        }

        if ($tanggalAkhir) {
            $query->whereDate('tanggal', '<=', $tanggalAkhir);
        }

        return $query;
    }

    public function laporan(
        ?string $tanggalAwal = null,
        ?string $tanggalAkhir = null
    ): Collection {
        $saldo = 0;

        return $this->query($tanggalAwal, $tanggalAkhir)
            ->get()
            ->map(function ($kas) use (&$saldo) {

                $type = TransactionType::from($kas->category->type);

                $kas->debet = null;
                $kas->kredit = null;

                if ($type->isIncome()) {
                    $kas->debet = $kas->nominal;
                    $saldo += $kas->nominal;
                } else {
                    $kas->kredit = $kas->nominal;
                    $saldo -= $kas->nominal;
                }

                $kas->saldo = $saldo;

                return $kas;
            });
    }

    public function summary(
        ?string $tanggalAwal = null,
        ?string $tanggalAkhir = null
    ): array {
        $laporan = $this->laporan($tanggalAwal, $tanggalAkhir);

        $totalDebet = $laporan->sum(fn ($item) => $item->debet ?? 0);
        $totalKredit = $laporan->sum(fn ($item) => $item->kredit ?? 0);

        return [
            'total_debet' => $totalDebet,
            'total_kredit' => $totalKredit,
            'saldo_akhir' => $laporan->last()?->saldo ?? 0,
            'jumlah_transaksi' => $laporan->count(),
        ];
    }
}