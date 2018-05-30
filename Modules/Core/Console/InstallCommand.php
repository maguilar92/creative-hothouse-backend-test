<?php

namespace Modules\Core\Console;

use Illuminate\Console\Command;
use Modules\Core\Console\Installer\Installer;
use Modules\Core\Console\Installer\Traits\BlockMessage;

class InstallCommand extends Command
{
    use BlockMessage;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'project:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install project to start workings';

    /**
     * Create a new command instance.
     *
     * @param Installer $installer
     * @return void
     */
    public function __construct(Installer $installer)
    {
        parent::__construct();
        $this->installer = $installer;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->blockMessage('comment', 'Welcome!', 'Starting the installation process...');

        $success = $this->installer->stack([
            \Modules\Core\Console\Installer\Scripts\FreshMigrations::class,
            \Modules\Core\Console\Installer\Scripts\ConfigureUser::class,
            \Modules\Core\Console\Installer\Scripts\SetAppKey::class,
            \Modules\Core\Console\Installer\Scripts\SetPassport::class,
            \Modules\Core\Console\Installer\Scripts\SeedDatabase::class,
        ])->install($this);

        if ($success) {
            $this->info('Project ready! You can now login with your email and password at /es/intranet/login');
        }
    }
}
