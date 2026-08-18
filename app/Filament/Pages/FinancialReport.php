<?php

namespace App\Filament\Pages;

use App\Models\Kas;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Illuminate\Support\Collection;

class FinancialReport extends Page
{
    protected static ?string $navigationLabel = 'Laporan Keuangan';

    protected static ?string $title = 'Laporan Keuangan';

    protected static string|BackedEnum|null $navigationIcon =
        'heroicon-o-document-chart-bar';

    protected static string|\UnitEnum|null $navigationGroup = 'Laporan';

    protected static ?int $navigationSort = 10;

    protected string $view = 'filament.pages.financial-report';


    /*
    |--------------------------------------------------------------------------
    | Periode
    |--------------------------------------------------------------------------
    */

    public ?string $tanggalMulai = null;

    public ?string $tanggalSelesai = null;


    /*
    |--------------------------------------------------------------------------
    | Mount
    |--------------------------------------------------------------------------
    */

    public function mount(): void
    {
        $this->tanggalMulai = now()
            ->startOfMonth()
            ->format('Y-m-d');

        $this->tanggalSelesai = now()
            ->endOfMonth()
            ->format('Y-m-d');
    }


    /*
    |--------------------------------------------------------------------------
    | Transaksi
    |--------------------------------------------------------------------------
    */

    public function getTransaksi(): Collection
    {
        return Kas::query()
            ->with([
                'category',
                'user',
            ])
            ->whereBetween('tanggal', [
                $this->tanggalMulai,
                $this->tanggalSelesai,
            ])
            ->orderBy('tanggal')
            ->orderBy('id')
            ->get();
    }


    /*
    |--------------------------------------------------------------------------
    | Total Kas Masuk
    |--------------------------------------------------------------------------
    */

    public function getTotalMasuk(): float
    {
        return (float) $this->getTransaksi()
            ->filter(
                fn ($kas) =>
                    $kas->category?->type === 'income'
            )
            ->sum('nominal');
    }


    /*
    |--------------------------------------------------------------------------
    | Total Kas Keluar
    |--------------------------------------------------------------------------
    */

    public function getTotalKeluar(): float
    {
        return (float) $this->getTransaksi()
            ->filter(
                fn ($kas) =>
                    $kas->category?->type === 'expense'
            )
            ->sum('nominal');
    }


    /*
    |--------------------------------------------------------------------------
    | Saldo
    |--------------------------------------------------------------------------
    */

    public function getSaldo(): float
    {
        return $this->getTotalMasuk()
            - $this->getTotalKeluar();
    }


    /*
    |--------------------------------------------------------------------------
    | Rekap Kategori
    |--------------------------------------------------------------------------
    */

    public function getRekapKategori(): Collection
    {
        return $this->getTransaksi()
            ->groupBy(function ($kas) {

                return $kas->category?->name
                    ?? 'Tanpa Kategori';

            })
            ->map(function ($items, $namaKategori) {

                $type = $items->first()
                    ->category
                    ?->type;

                return [
                    'kategori' => $namaKategori,

                    'type' => $type,

                    'jumlah' => $items->sum('nominal'),
                ];

            })
            ->sortByDesc('jumlah')
            ->values();
    }


    /*
    |--------------------------------------------------------------------------
    | Format Rupiah
    |--------------------------------------------------------------------------
    */

    public function formatRupiah(float $nominal): string
    {
        return 'Rp ' . number_format(
            $nominal,
            0,
            ',',
            '.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Tombol Cetak PDF
    |--------------------------------------------------------------------------
    */

    protected function getHeaderActions(): array
    {
        return [

            Action::make('cetakPdf')

                ->label('Cetak PDF')

                ->icon(
                    'heroicon-o-document-arrow-down'
                )

                ->color('primary')

                ->url(fn () =>
                    route(
                        'financial-report.pdf',
                        [
                            'tanggal_mulai' =>
                                $this->tanggalMulai,

                            'tanggal_selesai' =>
                                $this->tanggalSelesai,
                        ]
                    )
                )

                ->openUrlInNewTab(),

        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Refresh Data
    |--------------------------------------------------------------------------
    */

    public function updatedTanggalMulai(): void
    {
        $this->resetPageData();
    }


    public function updatedTanggalSelesai(): void
    {
        $this->resetPageData();
    }


    protected function resetPageData(): void
    {
        // Livewire akan melakukan refresh otomatis.
    }
}