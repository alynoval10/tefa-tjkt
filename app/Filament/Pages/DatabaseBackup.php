<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Pages\Page;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Filament\Notifications\Notification;

class DatabaseBackup extends Page
{
    protected static ?string $navigationLabel = 'Backup Database';

    protected static ?string $title = 'Backup Database';

    protected static string|\UnitEnum|null $navigationGroup = 'Sistem';

    protected static ?int $navigationSort = 110;

    protected string $view = 'filament.pages.database-backup';

    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole('admin') ?? false;
    }

    public function backup(): BinaryFileResponse
    {
        $backupPath = storage_path('app/backups');

        if (! File::exists($backupPath)) {
            File::makeDirectory($backupPath, 0755, true);
        }

        $filename = 'database_' . now()->format('Y-m-d_H-i-s') . '.sql';

        $filePath = $backupPath . DIRECTORY_SEPARATOR . $filename;

        $host = config('database.connections.mysql.host');
        $port = config('database.connections.mysql.port');
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');

        $command = sprintf(
            'mysqldump --host=%s --port=%s --user=%s --password=%s %s > %s',
            escapeshellarg($host),
            escapeshellarg($port),
            escapeshellarg($username),
            escapeshellarg($password),
            escapeshellarg($database),
            escapeshellarg($filePath)
        );

        exec($command, $output, $result);

        if (
            $result !== 0 ||
            ! File::exists($filePath) ||
            File::size($filePath) === 0
        ) {
            abort(500, 'Backup database gagal dibuat.');
        }

        return response()->download(
            $filePath,
            $filename
        );
    }

    public function getBackups(): array
    {
        $path = storage_path('app/backups');

        if (! File::exists($path)) {
            return [];
        }

        return collect(File::files($path))
    ->filter(
        fn ($file) =>
            strtolower($file->getExtension()) === 'sql'
            && str_starts_with(
                $file->getFilename(),
                'database_'
            )
    )
            ->sortByDesc(
                fn ($file) => $file->getMTime()
            )
            ->map(
                fn ($file) => [
                    'name' => $file->getFilename(),
                    'size' => $this->formatBytes($file->getSize()),
                    'created_at' => date(
                        'd M Y H:i:s',
                        $file->getMTime()
                    ),
                ]
            )
            ->values()
            ->toArray();
    }

    protected function formatBytes(int $bytes): string
    {
        if ($bytes >= 1024 * 1024) {
            return number_format(
                $bytes / 1024 / 1024,
                2
            ) . ' MB';
        }

        if ($bytes >= 1024) {
            return number_format(
                $bytes / 1024,
                2
            ) . ' KB';
        }

        return $bytes . ' B';
    }

  public function deleteBackup(string $filename): void
{
    if (! auth()->user()?->hasRole('admin')) {
        abort(403);
    }

    $filename = basename($filename);

    if (! str_ends_with(strtolower($filename), '.sql')) {
        abort(400, 'File backup tidak valid.');
    }

    $backupPath = storage_path('app/backups');

    $path = $backupPath . DIRECTORY_SEPARATOR . $filename;

    if (! File::exists($path)) {
        Notification::make()
            ->title('Backup tidak ditemukan')
            ->danger()
            ->send();

        return;
    }

    /*
     * Ambil semua backup SQL
     */
    $backupFiles = array_filter(
        File::files($backupPath),
        fn ($file) =>
            strtolower($file->getExtension()) === 'sql'
    );

    /*
     * Jangan pernah menghapus backup terakhir
     */
    if (count($backupFiles) <= 1) {
        Notification::make()
            ->title('Backup terakhir tidak dapat dihapus')
            ->body('Minimal satu backup harus tetap tersedia.')
            ->warning()
            ->send();

        return;
    }

    /*
     * Hapus backup
     */
    File::delete($path);

    Notification::make()
        ->title('Backup berhasil dihapus')
        ->success()
        ->send();
}

public function restoreBackup(string $filename): void
{
    if (! auth()->user()?->hasRole('admin')) {
        abort(403);
    }

    $filename = basename($filename);

    if (! str_ends_with(strtolower($filename), '.sql')) {
        abort(400, 'File backup tidak valid.');
    }

    $backupPath = storage_path('app/backups');
    $restoreFile = $backupPath . DIRECTORY_SEPARATOR . $filename;

    if (! File::exists($restoreFile)) {
        Notification::make()
            ->title('Backup tidak ditemukan')
            ->danger()
            ->send();

        return;
    }

    /*
    |--------------------------------------------------------------------------
    | BACKUP DATABASE SAAT INI
    |--------------------------------------------------------------------------
    */

    $safetyFilename =
        'before_restore_' .
        now()->format('Y-m-d_H-i-s') .
        '.sql';

    $safetyPath =
        $backupPath .
        DIRECTORY_SEPARATOR .
        $safetyFilename;

    $host = config('database.connections.mysql.host');
    $port = config('database.connections.mysql.port');
    $database = config('database.connections.mysql.database');
    $username = config('database.connections.mysql.username');
    $password = config('database.connections.mysql.password');

    $backupCommand = sprintf(
        'mysqldump --host=%s --port=%s --user=%s --password=%s %s > %s',
        escapeshellarg($host),
        escapeshellarg($port),
        escapeshellarg($username),
        escapeshellarg($password),
        escapeshellarg($database),
        escapeshellarg($safetyPath)
    );

    exec($backupCommand, $output, $backupResult);

    if (
        $backupResult !== 0 ||
        ! File::exists($safetyPath) ||
        File::size($safetyPath) === 0
    ) {
        Notification::make()
            ->title('Restore dibatalkan')
            ->body('Backup pengaman sebelum restore gagal dibuat.')
            ->danger()
            ->send();

        return;
    }

    /*
    |--------------------------------------------------------------------------
    | RESTORE DATABASE
    |--------------------------------------------------------------------------
    */

    $restoreCommand = sprintf(
        'mysql --host=%s --port=%s --user=%s --password=%s %s < %s',
        escapeshellarg($host),
        escapeshellarg($port),
        escapeshellarg($username),
        escapeshellarg($password),
        escapeshellarg($database),
        escapeshellarg($restoreFile)
    );

    exec($restoreCommand, $restoreOutput, $restoreResult);

    if ($restoreResult !== 0) {
        Notification::make()
            ->title('Restore gagal')
            ->body(
                'Database dikembalikan menggunakan backup pengaman.'
            )
            ->danger()
            ->send();

        /*
         * Kembalikan database menggunakan backup pengaman
         */
        $rollbackCommand = sprintf(
            'mysql --host=%s --port=%s --user=%s --password=%s %s < %s',
            escapeshellarg($host),
            escapeshellarg($port),
            escapeshellarg($username),
            escapeshellarg($password),
            escapeshellarg($database),
            escapeshellarg($safetyPath)
        );

        exec($rollbackCommand);

        return;
    }

    Notification::make()
        ->title('Restore berhasil')
        ->body(
            'Database berhasil dikembalikan dari ' . $filename
        )
        ->success()
        ->send();
}






    protected function getHeaderActions(): array
    {
        return [
            Action::make('backup')
                ->label('Buat Backup Sekarang')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('primary')
                ->action('backup'),
        ];
    }

    
}