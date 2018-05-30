<?php

namespace Modules\Core\Console\Installer\Scripts;

use Illuminate\Console\Command;
use Modules\Core\Console\Installer\SetupScript;

class SeedDatabase implements SetupScript
{
    protected $seeders = [
        'Cryptocurrencies' => 'Modules\Cryptocurrency\Database\Seeders\CryptocurrenciesTableSeeder',
        'CryptocurrenciesHistorical [will take hours]' => 'Modules\Cryptocurrency\Database\Seeders\CryptocurrenciesHistoricalTableSeeder'
    ];
    /**
     * Fire the install script
     *
     * @param  Command $command
     * @return mixed
     */
    public function fire(Command $command)
    {
        $command->info('Database seeding');

        collect($this->seeders)->each(function ($seederClass, $seederName) use ($command) {
            if ($command->confirm('Do you wish to execute '.$seederName.'?', true)) {
                if ($command->option('verbose')) {
                    $command->call('db:seed', [
                        '--class' => $seederClass
                    ]);

                    return true;
                }
                $command->callSilent('db:seed', [
                    '--class' => $seederClass
                ]);
            }
        });
    }
}
