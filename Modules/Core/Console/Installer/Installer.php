<?php

namespace Modules\Core\Console\Installer;

use Illuminate\Console\Command;
use Illuminate\Contracts\Foundation\Application;

class Installer
{
    /**
     * @var array
     */
    protected $scripts = [];

    /**
     * Class constructor
     * 
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Stack
     * 
     * @param  array $scripts
     * @return $this
     */
    public function stack(array $scripts)
    {
        $this->scripts = $scripts;

        return $this;
    }

    /**
     * Fire install scripts
     * 
     * @param  Command $command
     * @return bool
     */
    public function install(Command $command)
    {
        foreach ($this->scripts as $script) {
            try {
                $this->app->make($script)->fire($command);
            } catch (\Exception $e) {
                $command->error($e->getMessage());

                return false;
            }
        }

        return true;
    }
}