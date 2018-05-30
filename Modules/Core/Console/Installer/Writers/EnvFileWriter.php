<?php

namespace Modules\Core\Console\Installer\Writers;

use Dotenv\Dotenv;
use Illuminate\Filesystem\Filesystem;

class EnvFileWriter
{
    /**
     * @var Filesystem
     */
    private $finder;

    /**
     * @var string
     */
    protected $template = '.env.example';

    /**
     * @var string
     */
    protected $file = '.env';

    /**
     * @param Filesystem $finder
     */
    public function __construct(Filesystem $finder)
    {
        $this->finder = $finder;
    }

    /**
     * Write in env file
     * 
     * @param string $envKey 
     * @param string $envValue 
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function write(string $envKey, string $envValue)
    {
        $environmentContent = $this->finder->get($this->file);

        $oldValue = env($envKey);

        $environmentContent = str_replace($envKey.'='.$oldValue, $envKey.'='.$envValue, $environmentContent);

        $this->finder->put($this->file, $environmentContent);
    }
}