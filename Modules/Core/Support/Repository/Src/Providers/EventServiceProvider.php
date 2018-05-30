<?php

namespace Modules\Core\Support\Repository\Src\Providers;

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Modules\Core\Support\Repository\Src\Events\RepositoryEntityInserted' => [
            'Modules\Core\Support\Repository\Src\Listeners\CleanCacheRepository',
        ],
        'Modules\Core\Support\Repository\Src\Events\RepositoryEntityCreated' => [
            'Modules\Core\Support\Repository\Src\Listeners\CleanCacheRepository',
        ],
        'Modules\Core\Support\Repository\Src\Events\RepositoryEntityUpdated' => [
            'Modules\Core\Support\Repository\Src\Listeners\CleanCacheRepository',
        ],
        'Modules\Core\Support\Repository\Src\Events\RepositoryEntitiesUpdated' => [
            'Modules\Core\Support\Repository\Src\Listeners\CleanCacheRepository',
        ],
        'Modules\Core\Support\Repository\Src\Events\RepositoryEntityDeleted' => [
            'Modules\Core\Support\Repository\Src\Listeners\CleanCacheRepository',
        ],
        'Modules\Core\Support\Repository\Src\Events\RepositoryEntitiesDeleted' => [
            'Modules\Core\Support\Repository\Src\Listeners\CleanCacheRepository',
        ],
        'Modules\Core\Support\Repository\Src\Events\RepositoryEntityRestored' => [
            'Modules\Core\Support\Repository\Src\Listeners\CleanCacheRepository',
        ],
        'Modules\Core\Support\Repository\Src\Events\RepositoryEntitiesRestored' => [
            'Modules\Core\Support\Repository\Src\Listeners\CleanCacheRepository',
        ],
    ];

    /**
     * Register the application's event listeners.
     *
     * @return void
     */
    public function boot()
    {
        $events = app('events');

        foreach ($this->listen as $event => $listeners) {
            foreach ($listeners as $listener) {
                $events->listen($event, $listener);
            }
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the events and handlers.
     *
     * @return array
     */
    public function listens()
    {
        return $this->listen;
    }
}
