<?php

namespace Modules\Core\Console\Installer\Scripts;

use Illuminate\Console\Command;
use Modules\Core\Console\Installer\SetupScript;

class FreshMigrations implements SetupScript
{
    /**
     * Fire the install script
     *
     * @param  Command $command
     * @return mixed
     */
    public function fire(Command $command)
    {
        $command->info('Migrating database');

        if ($command->option('verbose')) {
            $command->call('migrate:fresh');

            return;
        }
        $command->callSilent('migrate:fresh');
    }
}
