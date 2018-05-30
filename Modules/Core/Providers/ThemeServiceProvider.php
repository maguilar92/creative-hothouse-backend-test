<?php

namespace Modules\Core\Providers;

use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     * @return void
     */
    public function boot()
    {
        $this->registerAllThemes();
        $this->setActiveTheme();
    }

    /**
     * Set the active theme based on the settings
     */
    private function setActiveTheme()
    {
        $themeName = $this->app['config']->get('modules.core.core.www-theme');
        return $this->app['stylist']->activate($themeName, true);
    }

    /**
     * Register all themes with activating them
     */
    private function registerAllThemes()
    {
        $directories = $this->app['files']->directories(config('stylist.themes.paths', [base_path('/Themes')])[0]);
        foreach ($directories as $directory) {
            $this->app['stylist']->registerPath($directory);
        }
    }
}
