<?php

namespace Denniseilander\LogFiles\Tests;

use Denniseilander\LogFiles\LogFilesServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    /**
     * @return array<array-key, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [
            LogFilesServiceProvider::class,
        ];
    }
}
