<?php

namespace Fintech\Auth\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    public $signature = 'auth:install';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
