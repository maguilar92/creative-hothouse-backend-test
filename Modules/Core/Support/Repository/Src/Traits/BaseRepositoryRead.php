<?php

namespace Modules\Core\Support\Repository\Src\Traits;

use Illuminate\Database\Eloquent\Builder;

trait BaseRepositoryRead
{
    /**
     * Retrieve all data of repository
     *
     * @param array|array $columns
     * @return mixed
     */
    public function all(array $columns = ['*'])
    {
        $this->resetModel();

        $results = $this->model->all($columns);

        $this->resetModel();

        return $results;
    }

    /**
     * Get data of repository
     *
     * @param array|array $columns
     * @return mixed
     */
    public function get(array $columns = ['*'])
    {

        if ($this->model instanceof Builder) {
            $results = $this->model->get($columns);
        } else {
            $results = $this->model->all($columns);
        }

        $this->resetModel();

        return $results;
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

        $results = $this->model->pluck($column, $key);

        $this->resetModel();

        return $results;
    }

    /**
     * Determine if any rows exist for the current query.
     *
     * @return bool
     */
    public function exists()
    {

        $results = $this->model->exists();

        $this->resetModel();

        return $results;
    }

    /**
     * Retrieve the "count" result of the query
     *
     * @param array|array $columns
     * @return mixed
     */
    public function count(array $columns = ['*'])
    {

        $results = $this->model->count($columns);

        $this->resetModel();

        return $results;
    }

    /**
     * Retrieve the minimum value of a given column.
     *
     * @param  string  $column
     * @return mixed
     */
    public function min($column)
    {

        $results = $this->model->min($column);

        $this->resetModel();

        return $results;
    }

    /**
     * Retrieve the maximum value of a given column.
     *
     * @param  string  $column
     * @return mixed
     */
    public function max($column)
    {

        $results = $this->model->max($column);

        $this->resetModel();

        return $results;
    }

    /**
     * Retrieve the sum of the values of a given column.
     *
     * @param  string  $column
     * @return mixed
     */
    public function sum($column)
    {

        $results = $this->model->sum($column);

        $this->resetModel();

        return $results ?: 0;
    }

    /**
     * Retrieve the average of the values of a given column.
     *
     * @param  string  $column
     * @return mixed
     */
    public function avg($column)
    {

        $results = $this->model->count($column);

        $this->resetModel();

        return $results;
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
        $limit = is_null($limit) ? config('repository.pagination.limit', 15) : $limit;
        $results = $this->model->paginate($limit, $columns);
        $results->appends(app('request')->query());
        $this->resetModel();

        return $results;
    }

    /**
     * Retrieve all data of repository, simple paginated
     *
     * @param int|null $limit
     * @param array|array $columns
     * @return mixed
     */
    public function simplePaginate(int $limit = null, array $columns = ['*'])
    {
        return $this->paginate($limit, $columns, "simplePaginate");
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
        $model = $this->model->find($id, $columns);
        
        $this->resetModel();

        return $model;
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
        $model = $this->model->findOrFail($id, $columns);
        
        $this->resetModel();

        return $model;
    }

    /**
     * Get first data by id
     *
     * @param array|array $columns
     * @return mixed
     */
    public function first(array $columns = ['*'])
    {
        $model = $this->model->first($columns);
        
        $this->resetModel();

        return $model;
    }

    /**
     * Get or fail first data by id
     *
     * @param array|array $columns
     * @return mixed
     */
    public function firstOrFail(array $columns = ['*'])
    {
        $model = $this->model->firstOrFail($columns);
        
        $this->resetModel();

        return $model;
    }
}
