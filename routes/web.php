<?php

use App\Filament\Pages\FinancialReport;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


/*
|--------------------------------------------------------------------------
| Download Database Backup
|--------------------------------------------------------------------------
*/

Route::get(
    '/database-backup/download/{filename}',
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
)
    ->name('database-backup.download')
    ->middleware('auth');


/*
|--------------------------------------------------------------------------
| Laporan Keuangan - PDF
|--------------------------------------------------------------------------
*/

Route::get(
    '/laporan-keuangan/pdf',
    function () {

        abort_unless(
            auth()->check() &&
            auth()->user()->hasRole('admin'),
            403
        );


        /*
        |--------------------------------------------------------------------------
        | Periode
        |--------------------------------------------------------------------------
        */

        $tanggalMulai = request('tanggal_mulai')
            ?: now()
                ->startOfMonth()
                ->format('Y-m-d');

        $tanggalSelesai = request('tanggal_selesai')
            ?: now()
                ->endOfMonth()
                ->format('Y-m-d');


        /*
        |--------------------------------------------------------------------------
        | Setting
        |--------------------------------------------------------------------------
        */

        $setting = Setting::with([
            'headProgram',
            'treasurer',
        ])->first();


        /*
        |--------------------------------------------------------------------------
        | Data Laporan
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
        | Logo Sekolah
        |--------------------------------------------------------------------------
        */

        $schoolLogo = null;

        if (
            $setting &&
            $setting->school_logo
        ) {

            $path = storage_path(
                'app/public/' .
                $setting->school_logo
            );

            if (File::exists($path)) {

                $mime = File::mimeType($path);

                $schoolLogo =
                    'data:' .
                    $mime .
                    ';base64,' .
                    base64_encode(
                        File::get($path)
                    );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Logo TEFA
        |--------------------------------------------------------------------------
        */

        $tefaLogo = null;

        if (
            $setting &&
            $setting->tefa_logo
        ) {

            $path = storage_path(
                'app/public/' .
                $setting->tefa_logo
            );

            if (File::exists($path)) {

                $mime = File::mimeType($path);

                $tefaLogo =
                    'data:' .
                    $mime .
                    ';base64,' .
                    base64_encode(
                        File::get($path)
                    );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Generate PDF
        |--------------------------------------------------------------------------
        */

        $pdf = Pdf::loadView(
            'filament.pages.financial-report-pdf',
            compact(
                'setting',
                'schoolLogo',
                'tefaLogo',
                'tanggalMulai',
                'tanggalSelesai',
                'transaksi',
                'totalMasuk',
                'totalKeluar',
                'saldo',
                'rekapKategori'
            )
        );


        /*
        |--------------------------------------------------------------------------
        | Ukuran Kertas
        |--------------------------------------------------------------------------
        */

        $pdf->setPaper(
            'A4',
            'portrait'
        );


        /*
        |--------------------------------------------------------------------------
        | Tampilkan PDF
        |--------------------------------------------------------------------------
        */

        return $pdf->stream(
            'laporan-keuangan-' .
            $tanggalMulai .
            '-sampai-' .
            $tanggalSelesai .
            '.pdf'
        );

    }
)
    ->name('financial-report.pdf')
    ->middleware('auth');