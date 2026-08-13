<?php

namespace App\Filament\Pages;

use App\Models\Kas;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Forms\Components\DatePicker;
use Illuminate\Support\Collection;
use Filament\Actions\Action;

class FinancialReport extends Page
{
    protected static ?string $navigationLabel = 'Laporan Keuangan';

    protected static ?string $title = 'Laporan Keuangan';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-chart-bar';

    protected static string|\UnitEnum|null $navigationGroup = 'Laporan';

    protected static ?int $navigationSort = 10;

    protected string $view = 'filament.pages.financial-report';

    public ?string $tanggalMulai = null;

    public ?string $tanggalSelesai = null;

    public function mount(): void
    {
        $this->tanggalMulai = now()->startOfMonth()->format('Y-m-d');

        $this->tanggalSelesai = now()->endOfMonth()->format('Y-m-d');
    }

    public function getTransaksi(): Collection
    {
        return Kas::query()
            ->with(['category', 'user'])
            ->whereBetween('tanggal', [
                $this->tanggalMulai,
                $this->tanggalSelesai,
            ])
            ->orderBy('tanggal')
            ->orderBy('id')
            ->get();
    }

            protected function getHeaderActions(): array
        {
            return [
                Action::make('cetakPdf')
                    ->label('Cetak PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('primary')
                    ->url(fn () =>
                        route('financial-report.pdf', [
                            'tanggal_mulai' => $this->tanggalMulai,
                            'tanggal_selesai' => $this->tanggalSelesai,
                        ])
                    )
                    ->openUrlInNewTab(),
            ];
        }




    public function getTotalMasuk(): float
    {
        return (float) $this->getTransaksi()
            ->filter(
                fn ($kas) =>
                    $kas->category?->type === 'income'
            )
            ->sum('nominal');
    }

    public function getTotalKeluar(): float
    {
        return (float) $this->getTransaksi()
            ->filter(
                fn ($kas) =>
                    $kas->category?->type === 'expense'
            )
            ->sum('nominal');
    }

    public function getSaldo(): float
    {
        return $this->getTotalMasuk() - $this->getTotalKeluar();
    }


    public function getRekapKategori(): Collection
    {
        return $this->getTransaksi()
            ->groupBy(function ($kas) {
                return $kas->category?->name ?? 'Tanpa Kategori';
            })
            ->map(function ($items, $namaKategori) {
                $type = $items->first()->category?->type;

                return [
                    'kategori' => $namaKategori,
                    'type' => $type,
                    'jumlah' => $items->sum('nominal'),
                ];
            })
            ->sortByDesc('jumlah')
            ->values();
    }


    public function formatRupiah(float $nominal): string
    {
        return 'Rp ' . number_format(
            $nominal,
            0,
            ',',
            '.'
        );
    }

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
        // Placeholder agar Livewire melakukan refresh data.
    }
}