<?php

namespace Modules\Core\Console\Installer\Scripts;

use Illuminate\Console\Command;
use Laravel\Passport\ClientRepository as ClientModelRepository;
use Modules\Core\Console\Installer\SetupScript;
use Modules\Core\Console\Installer\Writers\EnvFileWriter;

class SetPassport implements SetupScript
{
    /**
     * @var EnvFileWriter
     */
    protected $env;

    /**
     * The client model repository.
     *
     * @var \Laravel\Passport\ClientRepository
     */
    protected $clients;

    /**
     * Class constructor
     * 
     * @param EnvFileWriter $env
     * @param ClientModelRepository $clients 
     */
    public function __construct(EnvFileWriter $env, ClientModelRepository $clients)
    {
        $this->env = $env;
        $this->clients = $clients;
    }

    /**
     * Fire the install script
     * 
     * @param  Command $command
     * 
     * @return void
     */
    public function fire(Command $command)
    {
        $command->info('Configuring passport');

        $method = ($command->option('verbose')) ? 'call' : 'callSilent';

        $command->call('passport:client', [
                '--password' => true,
            ]);
        $command->{$method}('passport:keys', [
                '--force' => true,
            ]);

        $this->setEnvironmentClient();
    }

    /**
     * Set environment passport
     * 
     * @return void
     */
    protected function setEnvironmentClient()
    {
        $client = $this->clients->find(1);

        $this->env->write('API_CLIENT_ID', $client->id);
        $this->env->write('API_CLIENT_SECRET', $client->secret);
    }
}