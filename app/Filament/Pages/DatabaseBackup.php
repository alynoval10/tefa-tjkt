<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Pages\Page;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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

        if ($result !== 0 || ! File::exists($filePath) || File::size($filePath) === 0) {
            abort(500, 'Backup database gagal dibuat.');
        }

        return response()->download(
            $filePath,
            $filename
        );
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