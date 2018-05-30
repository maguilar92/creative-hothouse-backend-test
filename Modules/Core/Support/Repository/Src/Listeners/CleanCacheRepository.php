<?php

namespace Modules\Core\Support\Repository\Src\Listeners;

use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Modules\Core\Support\Repository\Src\Contracts\RepositoryInterface;
use Modules\Core\Support\Repository\Src\Events\RepositoryEventBase;
use Modules\Core\Support\Repository\Src\Helpers\CacheKeys;

class CleanCacheRepository
{
    /**
     * Cache config param.
     *
     * @var CacheRepository
     */
    protected $cache = null;

    /**
     * Repository executed.
     *
     * @var RepositoryInterface
     */
    protected $repository = null;

    /**
     * Model executed.
     *
     * @var Model
     */
    protected $model = null;

    /**
     * Action executed.
     *
     * @var string
     */
    protected $action = null;

    /**
     * Class constructo.
     *
     * @return void
     */
    public function __construct()
    {
        $this->cache = app(config('repository.cache.repository', 'cache'));
    }

    /**
     * Event handle.
     *
     * @param RepositoryEventBase $event
     *
     * @return void
     */
    public function handle(RepositoryEventBase $event)
    {
        try {
            $cleanEnabled = config('repository.cache.clean.enabled', true);

            if ($cleanEnabled) {
                $this->repository = $event->getRepository();
                $this->model = $event->getModel();
                $this->action = $event->getAction();

                if (config("repository.cache.clean.on.{$this->action}", true)) {
                    CacheKeys::removeGroupKeys(get_class($this->repository));
                    $this->repository->flushCache();
                }
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
