<?php

declare(strict_types=1);

namespace Denniseilander\LogFiles\Recorders;

use App\Services\Pulse\Connections\AbstractConnection;
use Illuminate\Config\Repository;
use Illuminate\Support\Collection;
use Illuminate\Support\Number;
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

    /**
     * Create a new recorder instance.
     */
    public function __construct(
        protected Pulse $pulse,
        protected Repository $config
    ) {
        //
    }

    /**
     * Record the database sizes.
     */
    public function record(SharedBeat $event): void
    {
        // Only run every 5 minutes
        //if ($event->time->second % 300 !== 0) {
        //    return;
        //}

        $server = $this->config->get('pulse.recorders.'.self::class.'.server_name');
        $slug = Str::slug($server);

        $logFiles = [];
        foreach (glob(storage_path('logs/*.log')) as $filePath) {
            $logFiles[] = [
                'name' => basename($filePath),
                'size' => $size = filesize($filePath),
                'readable_size' => Number::fileSize($size),
            ];
            info('Log file size', ['name' => basename($filePath), 'size' => $size]);
        }

        $this->pulse->set(
            type: 'log_files',
            key: $slug,
            value: json_encode($logFiles, flags: JSON_THROW_ON_ERROR),
            timestamp: $event->time
        );
    }
}