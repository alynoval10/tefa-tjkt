<?php

namespace App\Filament\Pages;

use App\Services\BukuKasService;
use Filament\Pages\Page;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\LaporanBukuKasExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanBukuKas extends Page implements HasTable
{
use InteractsWithTable;    

protected static ?string $navigationLabel = 'Laporan Buku Kas';

    protected static string|\UnitEnum|null $navigationGroup = 'Keuangan';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.pages.laporan-buku-kas';

    /**
     * Filter
     */
    public ?string $tanggalAwal = null;

    public ?string $tanggalAkhir = null;

    /**
     * Data laporan
     */
    public array $summary = [];

    public array $laporan = [];

    public function mount(): void
    {
        $this->tanggalAwal = now()->startOfMonth()->toDateString();
        $this->tanggalAkhir = now()->toDateString();

        $this->loadData();
    }

    public function loadData(): void
    {
        $service = app(BukuKasService::class);

        $this->summary = $service->summary(
            $this->tanggalAwal,
            $this->tanggalAkhir
        );

        $this->laporan = $service
            ->laporan(
                $this->tanggalAwal,
                $this->tanggalAkhir
            )
            ->toArray();
    }

         public function exportPdf()
{
    $service = app(\App\Services\BukuKasService::class);

    $laporan = $service->laporan(
        $this->tanggalAwal,
        $this->tanggalAkhir
    );

    $summary = $service->summary(
        $this->tanggalAwal,
        $this->tanggalAkhir
    );

    $pdf = Pdf::loadView(
        'pdf.laporan-buku-kas',
        [
            'laporan' => $laporan,
            'summary' => $summary,
            'tanggalAwal' => $this->tanggalAwal,
            'tanggalAkhir' => $this->tanggalAkhir,
        ]
    );

    return response()->streamDownload(
        fn () => print($pdf->output()),
        'laporan-buku-kas.pdf'
    );
}

        public function exportExcel()
{
    return Excel::download(

        new LaporanBukuKasExport(
            $this->tanggalAwal,
            $this->tanggalAkhir
        ),

        'laporan-buku-kas.xlsx'

    );
}
}