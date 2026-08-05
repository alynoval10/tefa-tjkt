<?php

namespace App\Exports;

use App\Services\BukuKasService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanBukuKasExport implements FromCollection, WithHeadings
{
    public function __construct(
        protected ?string $tanggalAwal,
        protected ?string $tanggalAkhir,
    ) {}

    public function collection()
    {
        $service = app(BukuKasService::class);

        return $service
            ->laporan($this->tanggalAwal, $this->tanggalAkhir)
            ->map(function ($item) {

                return [

                    'Tanggal' => $item->tanggal->format('d/m/Y'),

                    'No Bukti' => $item->no_bukti,

                    'Kategori' => $item->category->name,

                    'Keterangan' => $item->keterangan,

                    'Debet' => $item->debet,

                    'Kredit' => $item->kredit,

                    'Saldo' => $item->saldo,

                ];

            });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'No Bukti',
            'Kategori',
            'Keterangan',
            'Debet',
            'Kredit',
            'Saldo',
        ];
    }
}