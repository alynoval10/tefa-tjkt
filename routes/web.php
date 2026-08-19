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
)
    ->name('database-backup.download')
    ->middleware('auth');