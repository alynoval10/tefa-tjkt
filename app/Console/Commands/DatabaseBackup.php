<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

#[Signature('app:database-backup')]
#[Description('Membuat backup database MySQL')]
class DatabaseBackup extends Command
{
    public function handle(): int
    {
        $backupPath = storage_path('app/backups');

        // Pastikan folder backup tersedia
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

        $this->info('Membuat backup database...');

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

        // Cek hasil backup
        if (
            $result !== 0 ||
            ! File::exists($filePath) ||
            File::size($filePath) === 0
        ) {
            if (File::exists($filePath)) {
                File::delete($filePath);
            }

            $this->error('Backup database gagal.');

            return self::FAILURE;
        }

        $size = File::size($filePath);

        $this->info('Backup berhasil dibuat.');
        $this->line('File: ' . $filename);
        $this->line('Ukuran: ' . $this->formatBytes($size));

        // Hapus backup lama, sisakan 7 backup terbaru
        $this->cleanupOldBackups($backupPath);

        return self::SUCCESS;
    }

    protected function cleanupOldBackups(string $backupPath): void
    {
        $files = collect(File::files($backupPath))
            ->filter(
                fn ($file) => $file->getExtension() === 'sql'
            )
            ->sortByDesc(
                fn ($file) => $file->getMTime()
            )
            ->values();

        $oldFiles = $files->slice(7);

        foreach ($oldFiles as $file) {
            File::delete($file->getPathname());

            $this->line(
                'Backup lama dihapus: ' . $file->getFilename()
            );
        }
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
}