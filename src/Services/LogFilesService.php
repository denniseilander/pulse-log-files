<?php

declare(strict_types=1);

namespace Denniseilander\LogFiles\Services;

use Denniseilander\LogFiles\DataTransferObjects\LogFile;
use Illuminate\Support\Collection;

class LogFilesService
{
    public function getFiles(): Collection
    {
        return Collection::make(glob(storage_path('logs/*.log')) ?: [])
            ->map(fn (string $logFile) => LogFile::fromPath($logFile));
    }
}
