<?php

declare(strict_types=1);

namespace Denniseilander\LogFiles\Recorders;

use Denniseilander\LogFiles\DataTransferObjects\LogFile;
use Denniseilander\LogFiles\Services\LogFilesService;
use Illuminate\Config\Repository;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Laravel\Pulse\Events\SharedBeat;
use Laravel\Pulse\Pulse;

class LogFiles
{
    /**
     * The events to listen for.
     *
     * @var class-string
     */
    public string $listen = SharedBeat::class;

    public function __construct(
        protected Pulse $pulse,
        protected Repository $config,
        protected LogFilesService $logFilesService,
    ) {
        //
    }

    /**
     * Record the log files.
     */
    public function record(SharedBeat $event): void
    {
        $config = $this->config->get('pulse.recorders.'.self::class);
        $runEverySeconds = Arr::get($config, 'run_every_seconds', 300);

        if ($event->time->second % $runEverySeconds !== 0) {
            return;
        }

        $server = $this->config->get('pulse.recorders.'.self::class.'.server_name');
        $slug = Str::slug($server);

        $logFiles = $this->logFilesService
            ->getFiles()
            ->map(fn (LogFile $logFile) => $logFile->toArray())
            ->toJson();

        $this->pulse->set(
            type: 'log_files',
            key: $slug,
            value: $logFiles,
            timestamp: $event->time
        );
    }
}
