<?php

namespace Modules\Core\Console\Installer\Scripts;

use Illuminate\Console\Command;
use Modules\Core\Console\Installer\SetupScript;

class SetAppKey implements SetupScript
{
    /**
     * Fire the install script
     * 
     * @param  Command $command
     * @return mixed
     */
    public function fire(Command $command)
    {
        $command->info('Setting app key');

        $method = ($command->option('verbose')) ? 'call' : 'callSilent';

        $command->{$method}('key:generate');
    }
}