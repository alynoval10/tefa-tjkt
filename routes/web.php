<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/admin/database-backup/download/{filename}', function ($filename): BinaryFileResponse {

    abort_unless(auth()->check() && auth()->user()->hasRole('admin'), 403);

    $filename = basename($filename);

    $path = storage_path('app/backups/' . $filename);

    abort_unless(
        File::exists($path) &&
        File::extension($path) === 'sql',
        404
    );

    return response()->download($path);

})->name('database-backup.download');