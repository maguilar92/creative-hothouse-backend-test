<?php

namespace Modules\Core\Support\Repository\Src\Traits;

use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Modules\Core\Support\Repository\Src\Helpers\CacheKeys;

trait CacheableRepository
{

    /**
     * Instance of Illuminate\Contracts\Cache\Repository
     *
     * @var CacheRepository
     */
    protected $cacheRepository = null;

    /**
     * Set Cache Repository
     *
     * @param CacheRepository $repository
     * @return $this
     */
    public function setCacheRepository(CacheRepository $repository)
    {
        $this->cacheRepository = $repository;

        return $this;
    }

    /**
     * Return instance of Cache Repository
     *
     * @return CacheRepository
     */
    public function getCacheRepository()
    {
        if (is_null($this->cacheRepository)) {
            $this->cacheRepository = app(config('repository.cache.repository', 'cache'));
        }

        return $this->cacheRepository;
    }

    /**
     * Skip Cache
     *
     * @param bool $status
     * @return $this
     */
    public function skipCache($status = true)
    {
        $this->cacheSkip = $status;

        return $this;
    }

    /**
     * Return is cache is skipped
     *
     * @return bool
     */
    public function isSkippedCache()
    {
        $skipped = isset($this->cacheSkip) ? $this->cacheSkip : false;
        $request = app('Illuminate\Http\Request');
        $skipCacheParam = config('repository.cache.params.skipCache', 'skipCache');

        if ($request->has($skipCacheParam) && $request->get($skipCacheParam)) {
            $skipped = true;
        }

        return $skipped;
    }

    /**
     * Return if cache is allowed
     *
     * @param $method
     * @return bool
     */
    protected function allowedCache($method)
    {
        $cacheEnabled = config('repository.cache.enabled', true);

        if (!$cacheEnabled) {
            return false;
        }

        $cacheOnly = isset($this->cacheOnly) ? $this->cacheOnly : config('repository.cache.allowed.only', null);
        $cacheExcept = isset($this->cacheExcept) ? $this->cacheExcept : config('repository.cache.allowed.except', null);

        if (is_array($cacheOnly)) {
            return in_array($method, $cacheOnly);
        }

        if (is_array($cacheExcept)) {
            return !in_array($method, $cacheExcept);
        }

        if (is_null($cacheOnly) && is_null($cacheExcept)) {
            return true;
        }

        return false;
    }

    /**
     * Flush cache of repository
     *
     * @return $this
     */
    public function flushCache()
    {
        $this->getCacheRepository()->tags([get_called_class()])->flush();

        CacheKeys::removeGroupKeys(get_called_class());

        return $this;
    }

    /**
     * Get model relation hashes
     *
     * @param mixed $model
     * @return string
     */
    protected function getModelRelationHashes($model)
    {
        $hashReturn = '';
        $eagerLoads = $model->getEagerLoads();
        if (!empty($eagerLoads)) {
            foreach ($eagerLoads as $eagerLoad => $constraints) {
                if (strpos($eagerLoad, '.') === false) {
                    $relation = $model->getRelation($eagerLoad);
                    //For nested eager load we check do getRelation of query if method exists
                    if (!is_string($relation) && method_exists($model->getQuery(), 'getRelation')) {
                        $relation = $model->getQuery()->getRelation($eagerLoad);
                    }
                    if (!is_string($relation)) {
                        $constraints($relation);
                        $hashReturn .= $relation->toSql().'_'.json_encode($relation->getBindings());
                        $hashReturn .= $this->getModelRelationHashes($relation);
                    }
                }
            }
        }
        return $hashReturn;
    }

    /**
     * Get Cache key for the method
     *
     * @param $method
     * @param $args
     *
     * @return string
     */
    public function getCacheKey($method, $args = null)
    {
        $args = serialize($args);

        //Model hash to prevent same page while same hash
        $model = parent::getModel();
        $modelHash = $model->toSql().'_'.$this->getModelRelationHashes($model);
        $modelHash = md5($modelHash.$method.'_'.json_encode($model->getBindings()).'_'.json_encode($args));

        //Generate the key
        $key = sprintf('%s@%s', get_called_class(), $modelHash);

        CacheKeys::putKey(get_called_class(), $key);

        return $key;
    }

    /**
     * Get cache minutes
     *
     * @return int
     */
    public function getCacheMinutes()
    {
        $cacheMinutes = isset($this->cacheMinutes) ? $this->cacheMinutes : config('repository.cache.minutes', 30);

        return $cacheMinutes;
    }

    /**
     * Get data for table
     *
     * @param string|null $search
     * @param bool|bool $paginate
     * @return type
     */
    public function getDataForTable(string $search = null, bool $paginate = false)
    {
        if (!$this->allowedCache('getDataForTable') || $this->isSkippedCache()) {
            return parent::getDataForTable($search, $paginate);
        }

        $request = app('Illuminate\Http\Request');
        $page = ($request->input('page')) ?: 1;
        $cacheKey = $this->getCacheKey('getDataForTable', array_merge(func_get_args(), ['page' => $page]));
        $minutes = $this->getCacheMinutes();
        $value = $this->getCacheRepository()->tags([get_called_class()])->remember($cacheKey, $minutes, function () use ($search, $paginate) {
            return parent::getDataForTable($search, $paginate);
        });

        parent::resetModel();

        return $value;
    }

    /**
     * Retrieve all data of repository
     *
     * @param array|array $columns
     *
     * @return mixed
     */
    public function all(array $columns = ['*'])
    {
        if (!$this->allowedCache('all') || $this->isSkippedCache()) {
            return parent::all($columns);
        }

        $cacheKey = $this->getCacheKey('all', func_get_args());
        $minutes = $this->getCacheMinutes();
        $value = $this->getCacheRepository()->tags([get_called_class()])->remember($cacheKey, $minutes, function () use ($columns) {
            return parent::all($columns);
        });

        parent::resetModel();

        return $value;
    }

    /**
     * Retrieve get data of repository
     *
     * @param array|array $columns
     *
     * @return mixed
     */
    public function get(array $columns = ['*'])
    {
        if (!$this->allowedCache('get') || $this->isSkippedCache()) {
            return parent::get($columns);
        }

        $cacheKey = $this->getCacheKey('get', func_get_args());
        $minutes = $this->getCacheMinutes();
        $value = $this->getCacheRepository()->tags([get_called_class()])->remember($cacheKey, $minutes, function () use ($columns) {
            return parent::get($columns);
        });

        parent::resetModel();

        return $value;
    }

    /**
     * Get an array with the values of a given column.
     *
     * @param  string  $column
     * @param  string|null  $key
     * @return mixed
     */
    public function pluck($column, $key = null)
    {
        if (!$this->allowedCache('pluck') || $this->isSkippedCache()) {
            return parent::pluck($column, $key);
        }

        $cacheKey = $this->getCacheKey('pluck', func_get_args());
        $minutes = $this->getCacheMinutes();
        $value = $this->getCacheRepository()->tags([get_called_class()])->remember($cacheKey, $minutes, function () use ($column, $key) {
            return parent::pluck($column, $key);
        });

        parent::resetModel();

        return $value;
    }

    /**
     * Determine if any rows exist for the current query.
     *
     * @return bool
     */
    public function exists()
    {
        if (!$this->allowedCache('exists') || $this->isSkippedCache()) {
            return parent::exists();
        }

        $cacheKey = $this->getCacheKey('exists', func_get_args());
        $minutes = $this->getCacheMinutes();
        $value = $this->getCacheRepository()->tags([get_called_class()])->remember($cacheKey, $minutes, function () {
            return parent::exists();
        });

        parent::resetModel();

        return $value;
    }

    /**
     * Get an array with the values of a given column.
     *
     * @param array|array $columns
     *
     * @return mixed
     */
    public function count(array $columns = ['*'])
    {
        if (!$this->allowedCache('count') || $this->isSkippedCache()) {
            return parent::count($columns);
        }

        $cacheKey = $this->getCacheKey('count', func_get_args());
        $minutes = $this->getCacheMinutes();
        $value = $this->getCacheRepository()->tags([get_called_class()])->remember($cacheKey, $minutes, function () use ($columns) {
            return parent::count($columns);
        });

        parent::resetModel();

        return $value;
    }

    /**
     * Retrieve the minimum value of a given column.
     *
     * @param  string  $column
     * @return mixed
     */
    public function min($column)
    {
        if (!$this->allowedCache('min') || $this->isSkippedCache()) {
            return parent::min($column);
        }

        $cacheKey = $this->getCacheKey('min', func_get_args());
        $minutes = $this->getCacheMinutes();
        $value = $this->getCacheRepository()->tags([get_called_class()])->remember($cacheKey, $minutes, function () use ($column) {
            return parent::min($column);
        });

        parent::resetModel();

        return $value;
    }

    /**
     * Retrieve the maximum value of a given column.
     *
     * @param  string  $column
     * @return mixed
     */
    public function max($column)
    {
        if (!$this->allowedCache('max') || $this->isSkippedCache()) {
            return parent::max($column);
        }

        $cacheKey = $this->getCacheKey('max', func_get_args());
        $minutes = $this->getCacheMinutes();
        $value = $this->getCacheRepository()->tags([get_called_class()])->remember($cacheKey, $minutes, function () use ($column) {
            return parent::max($column);
        });

        parent::resetModel();

        return $value;
    }

    /**
     * Retrieve the sum of the values of a given column.
     *
     * @param  string  $column
     * @return mixed
     */
    public function sum($column)
    {
        if (!$this->allowedCache('sum') || $this->isSkippedCache()) {
            return parent::sum($column);
        }

        $cacheKey = $this->getCacheKey('sum', func_get_args());
        $minutes = $this->getCacheMinutes();
        $value = $this->getCacheRepository()->tags([get_called_class()])->remember($cacheKey, $minutes, function () use ($column) {
            return parent::sum($column);
        });

        parent::resetModel();

        return $value;
    }

    /**
     * Retrieve the average of the values of a given column.
     *
     * @param  string  $column
     * @return mixed
     */
    public function avg($column)
    {
        if (!$this->allowedCache('avg') || $this->isSkippedCache()) {
            return parent::avg($column);
        }

        $cacheKey = $this->getCacheKey('avg', func_get_args());
        $minutes = $this->getCacheMinutes();
        $value = $this->getCacheRepository()->tags([get_called_class()])->remember($cacheKey, $minutes, function () use ($column) {
            return parent::avg($column);
        });

        parent::resetModel();

        return $value;
    }

    /**
     * Retrieve all data of repository, paginated
     *
     * @param int|null $limit
     * @param array|array $columns
     * @return mixed
     */
    public function paginate(int $limit = null, array $columns = ['*'])
    {
        if (!$this->allowedCache('paginate') || $this->isSkippedCache()) {
            return parent::paginate($limit, $columns);
        }

        $request = app('Illuminate\Http\Request');
        $page = ($request->input('page')) ?: 1;
        $cachekey = $this->getCacheKey('paginate', array_merge(func_get_args(), ['page' => $page]));
        $minutes = $this->getCacheMinutes();
        $value = $this->getCacheRepository()->tags([get_called_class()])->remember($cachekey, $minutes, function () use ($limit, $columns) {
            return parent::paginate($limit, $columns);
        });

        parent::resetModel();

        return $value;
    }

    /**
     * Find data by id
     *
     * @param int $id
     * @param array|array $columns
     * @return mixed
     */
    public function find(int $id, array $columns = ['*'])
    {
        if (!$this->allowedCache('find') || $this->isSkippedCache()) {
            return parent::find($id, $columns);
        }

        $cachekey = $this->getCacheKey('find', func_get_args());
        $minutes = $this->getCacheMinutes();
        $value = $this->getCacheRepository()->tags([get_called_class()])->remember($cachekey, $minutes, function () use ($id, $columns) {
            return parent::find($id, $columns);
        });

        parent::resetModel();

        return $value;
    }

    /**
     * Find or fail data by id
     *
     * @param int $id
     * @param array|array $columns
     * @return mixed
     */
    public function findOrFail(int $id, array $columns = ['*'])
    {
        if (!$this->allowedCache('findOrFail') || $this->isSkippedCache()) {
            return parent::findOrFail($id, $columns);
        }

        $cachekey = $this->getCacheKey('findOrFail', func_get_args());
        $minutes = $this->getCacheMinutes();
        $value = $this->getCacheRepository()->tags([get_called_class()])->remember($cachekey, $minutes, function () use ($id, $columns) {
            return parent::findOrFail($id, $columns);
        });

        parent::resetModel();

        return $value;
    }

    /**
     * Get first data by id
     *
     * @param array|array $columns
     * @return mixed
     */
    public function first(array $columns = ['*'])
    {
        if (!$this->allowedCache('first') || $this->isSkippedCache()) {
            return parent::first($columns);
        }

        $cachekey = $this->getCacheKey('first', func_get_args());
        $minutes = $this->getCacheMinutes();
        $value = $this->getCacheRepository()->tags([get_called_class()])->remember($cachekey, $minutes, function () use ($columns) {
            $return = parent::first($columns);
            return (is_null($return)) ? 'null' : $return;
        });
        $value = ($value === 'null') ? null : $value;

        parent::resetModel();

        return $value;
    }

    /**
     * Get or fail first data by id
     *
     * @param array|array $columns
     * @return mixed
     */
    public function firstOrFail(array $columns = ['*'])
    {
        if (!$this->allowedCache('firstOrFail') || $this->isSkippedCache()) {
            return parent::firstOrFail($columns);
        }

        $cachekey = $this->getCacheKey('firstOrFail', func_get_args());
        $minutes = $this->getCacheMinutes();
        $value = $this->getCacheRepository()->tags([get_called_class()])->remember($cachekey, $minutes, function () use ($columns) {
            return parent::firstOrFail($columns);
        });

        parent::resetModel();

        return $value;
    }
}
