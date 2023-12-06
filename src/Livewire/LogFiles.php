<?php

declare(strict_types=1);

namespace Denniseilander\LogFiles\Livewire;

use Carbon\CarbonImmutable;
use Denniseilander\LogFiles\DataTransferObjects\LogFile;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;
use Laravel\Pulse\Facades\Pulse;
use Laravel\Pulse\Livewire\Card;
use Livewire\Attributes\Lazy;

#[Lazy]
class LogFiles extends Card
{
    public function render(): View
    {
        $servers = Pulse::values('log_files')
            ->map(function (object $logFile) {
                $logFiles = LogFile::multipleFromJson($logFile->value);

                return (object) [
                    'serverName' => $logFile->key,
                    'logFiles' => $logFiles,
                    'updated_at' => CarbonImmutable::createFromTimestamp($logFile->timestamp),
                ];
            });

        return ViewFacade::make('pulse-log-files::livewire.log-files', [
            'servers' => $servers,
        ]);
    }
}
