<?php

use App\Filament\Pages\FinancialReport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

Route::get('/', function () {
    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| Download Database Backup
|--------------------------------------------------------------------------
*/

Route::get(
    '/admin/database-backup/download/{filename}',
    function ($filename): BinaryFileResponse {

        abort_unless(
            auth()->check() &&
            auth()->user()->hasRole('admin'),
            403
        );

        $filename = basename($filename);

        $path = storage_path(
            'app/backups/' . $filename
        );

        abort_unless(
            File::exists($path) &&
            strtolower(File::extension($path)) === 'sql',
            404
        );

        return response()->download($path);

    }
)->name('database-backup.download')->middleware('auth');


/*
|--------------------------------------------------------------------------
| Laporan Keuangan - PDF
|--------------------------------------------------------------------------
*/

Route::get('/admin/laporan-keuangan/pdf', function () {

    abort_unless(
        auth()->check() &&
        auth()->user()->hasRole('admin'),
        403
    );

    $tanggalMulai = request('tanggal_mulai')
        ?: now()->startOfMonth()->format('Y-m-d');

    $tanggalSelesai = request('tanggal_selesai')
        ?: now()->endOfMonth()->format('Y-m-d');


    /*
    |--------------------------------------------------------------------------
    | Ambil data dari FinancialReport
    |--------------------------------------------------------------------------
    */

    $page = app(FinancialReport::class);

    $page->tanggalMulai = $tanggalMulai;
    $page->tanggalSelesai = $tanggalSelesai;


    $transaksi = $page->getTransaksi();

    $totalMasuk = $page->getTotalMasuk();

    $totalKeluar = $page->getTotalKeluar();

    $saldo = $page->getSaldo();

    $rekapKategori = $page->getRekapKategori();


    /*
    |--------------------------------------------------------------------------
    | Generate PDF
    |--------------------------------------------------------------------------
    */

    $pdf = Pdf::loadView(
        'filament.pages.financial-report-pdf',
        compact(
            'tanggalMulai',
            'tanggalSelesai',
            'transaksi',
            'totalMasuk',
            'totalKeluar',
            'saldo',
            'rekapKategori'
        )
    );

    $pdf->setPaper('A4', 'portrait');


    return $pdf->stream(
        'laporan-keuangan-' .
        $tanggalMulai .
        '-sampai-' .
        $tanggalSelesai .
        '.pdf'
    );

})->name('financial-report.pdf')->middleware('auth');