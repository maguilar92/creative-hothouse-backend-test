<?php

namespace Modules\Core\Support\Repository\Src\Eloquent;

use Closure;
use Exception;
use Modules\Core\Support\Repository\Src\Contracts\RepositoryInterface;
use Modules\Core\Support\Repository\Src\Exceptions\RepositoryException;
use Modules\Core\Support\Repository\Src\Traits\BaseRepositoryRead;
use Modules\Core\Support\Repository\Src\Traits\BaseRepositoryWrite;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements RepositoryInterface
{
    use BaseRepositoryRead, BaseRepositoryWrite;
    /**
     * Laravel Application
     *
     * @var Application
     */
    protected $app;
    
    /**
     * Model
     *
     * @var Model
     */
    protected $model;

    /**
     * Class constructor
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->makeModel();
        $this->boot();
    }

    /**
     * Flush cache of repository
     *
     * @return $this
     */
    public function flushCache()
    {
        return $this;
    }

    /**
     * Skip Cache
     *
     * @param bool $status
     * @return $this
     */
    public function skipCache($status = true)
    {
        return $this;
    }

    /**
     * Get model
     *
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Boot repository
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Reset model
     *
     * @return void
     */
    public function resetModel()
    {
        $this->makeModel();
        return $this;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    abstract public function model();

    /**
     * Make app model
     *
     * @return Model
     * @throws RepositoryException
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    /**
     * Overloading __call
     *
     * @param mixed $method
     * @param mixed $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        if (empty($arguments)) {
            $this->model = call_user_func([$this->model, $method]);
            return $this;
        }
        $this->model = call_user_func_array([$this->model, $method], $arguments);
        return $this;
    }
}
