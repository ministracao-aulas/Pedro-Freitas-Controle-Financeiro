<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Illuminate\Support\Arr;

class UploadAndSendBackupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:upload-and-replicate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make upload and send copy of backup file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //TODO:
        $this->info('TODO: aqui colocar ações como upload para GDrive, FTP, e-mail etc');
        // ci-scripts/scripts/db-backups/backup-banco.sh

        /* TODO: aqui pegar a conexão por parâmetro ou valor default */
        $connection = config('database.default');
        $toZipFile = true; // TODO: pegar valor por parâmetro

        $commandData = static::getBackupCommand($connection);

        $command = $commandData['command'] ?? [];
        $envs = $commandData['envs'] ?? [];

        if (!$command) {
            $this->error('Invalid command');

            return 5;
        }

        $process = new Process($command, env: $envs);

        $success = true;
        $lines = [];

        $process->run(function ($type, $buffer) use (&$success, &$lines): void {
            $lines[] = $buffer;

            if (Process::ERR === $type) {
                $this->error('ERR > ' . $buffer);
                $success = false;

                return;
            }

            $buffer = trim("{$buffer}");

            if (!$buffer) {
                // return;
            }

            $this->line($buffer);
        });

        if (!$success) {
            $this->error('Houve um erro ao fazer o backup');

            return 5;
        }

        $finalFilePath = str(collect(explode(PHP_EOL, implode($lines)))
            ->map(fn ($line) => trim("{$line}"))
            ->first(fn ($line) => str($line)->contains('Arquivo salvo em ')))
            ->after('Arquivo salvo em ')
            ->trim()
            ->trim('\'\"');

        $this->info('Backup finalizado!');

        if ($finalFilePath && is_file($finalFilePath)) {
            $this->info("Arquivo salvo em {$finalFilePath}");

            static::dispatchFile($finalFilePath, $toZipFile);
        }

        return 0;
    }

    public static function getBackupCommand(string|array $connection): array
    {
        $connection = is_string($connection)
            ? (array) config('database.connections.' . $connection)
            : $connection;

        $driver = Arr::get($connection, 'driver');

        return match ($driver) {
            'pgsql' => static::getPgsqlConfig($connection),
            default => [],
        };
    }

    public static function getPgsqlConfig(array $connectionData): array
    {
        // $backupScriptPath = base_path('ci-scripts/scripts/db-backups/backup-banco.sh');
        $backupScriptPath = base_path('ci-scripts/bin/db-backup.sh');

        $envs = static::getDefaultEnvs();
        $envs['DB_HOST'] ??= Arr::get($connectionData, 'host');
        $envs['DB_PORT'] ??= Arr::get($connectionData, 'port');
        $envs['DB_DATABASE'] ??= Arr::get($connectionData, 'database');
        $envs['DB_USERNAME'] ??= Arr::get($connectionData, 'username');
        $envs['DB_PASSWORD'] ??= Arr::get($connectionData, 'password');
        $envs['PGPASSWORD'] = $envs['DB_PASSWORD'] ?? '';

        $envs['FILE_NAME'] = str('backup-' . date('Y-m-d_His') . '___' . ($envs['DB_DATABASE']) . '.sql')
            ->trim()->replace(' ', '-')->toString();

        return [
            'command' => ['bash', $backupScriptPath],
            'envs' => $envs,
        ];
    }

    public static function getDefaultEnvs(): array
    {
        return [
            'DIR_PATH_TO_SAVE' => static::getBackupPath(),
            'FILE_NAME' => 'backup-' . date('Y-m-d_His') . '.sql',
        ];
    }

    public static function getBackupPath(): string
    {
        $backupPath = storage_path('db-backups');

        if (file_exists($backupPath) && !is_dir($backupPath)) {
            unlink($backupPath);
        }

        if (!is_dir($backupPath)) {
            mkdir($backupPath, 0777, true);
        }

        chmod($backupPath, 0777);

        return $backupPath;
    }

    public static function dispatchFile(string $filePath, bool $toZipFile = true): bool
    {
        if (!is_file($filePath)) {
            return false;
        }

        $zipFilePath = "{$filePath}.zip";

        if ($toZipFile && static::zipFile($filePath, $zipFilePath)) {
            $filePath = $zipFilePath;
        }

        // Aqui dispachar job que envia backup para destinos

        return true;
    }

    public static function zipFile(string $source, string $target): bool
    {
        $command = ['zip', '-r', '-FS'];
        $command[] = $target;
        $command[] = $source;

        $process = new Process($command);
        $success = true;
        $process->run(function ($type, $buffer) use (&$success): void {
            if (Process::ERR === $type) {
                $success = false;

                $buffer = trim("{$buffer}");

                if ($buffer && !app()->isProduction()) {
                    throw new \Exception($buffer, 1);
                }

                return;
            }
        });

        return $success;
    }
}
