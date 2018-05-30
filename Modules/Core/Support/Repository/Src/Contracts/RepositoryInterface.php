<?php

namespace Modules\Core\Support\Repository\Src\Contracts;

interface RepositoryInterface
{
    /**
     * Flush cache of repository
     *
     * @return $this
     */
    public function flushCache();

    /**
     * Skip Cache
     *
     * @param bool $status
     * @return $this
     */
    public function skipCache($status = true);

    /**
     * Retrieve all data of repository
     *
     * @param array|array $columns
     * @return mixed
     */
    public function all(array $columns = ['*']);

    /**
     * Get data of repository
     *
     * @param array|array $columns
     * @return mixed
     */
    public function get(array $columns = ['*']);

    /**
     * Get an array with the values of a given column.
     *
     * @param  string  $column
     * @param  string|null  $key
     * @return mixed
     */
    public function pluck($column, $key = null);

    /**
     * Determine if any rows exist for the current query.
     *
     * @return bool
     */
    public function exists();

    /**
     * Get an array with the values of a given column.
     *
     * @param array|array $columns
     *
     * @return mixed
     */
    public function count(array $columns = ['*']);

    /**
     * Retrieve the minimum value of a given column.
     *
     * @param  string  $column
     * @return mixed
     */
    public function min($column);
    /**
     * Retrieve the maximum value of a given column.
     *
     * @param  string  $column
     * @return mixed
     */
    public function max($column);
    /**
     * Retrieve the sum of the values of a given column.
     *
     * @param  string  $column
     * @return mixed
     */
    public function sum($column);
    /**
     * Retrieve the average of the values of a given column.
     *
     * @param  string  $column
     * @return mixed
     */
    public function avg($column);

    /**
     * Retrieve all data of repository, paginated
     *
     * @param int|null $limit
     * @param array|array $columns
     * @return mixed
     */
    public function paginate(int $limit = null, array $columns = ['*']);

    /**
     * Retrieve all data of repository, simple paginated
     *
     * @param int|null $limit
     * @param array|array $columns
     * @return mixed
     */
    public function simplePaginate(int $limit = null, array $columns = ['*']);

    /**
     * Find data by id
     *
     * @param int $id
     * @param array|array $columns
     * @return mixed
     */
    public function find(int $id, array $columns = ['*']);

    /**
     * Find or fail data by id
     *
     * @param int $id
     * @param array|array $columns
     * @return mixed
     */
    public function findOrFail(int $id, array $columns = ['*']);

    /**
     * Get first data by id
     *
     * @param array|array $columns
     * @return mixed
     */
    public function first(array $columns = ['*']);

    /**
     * Get or fail first data by id
     *
     * @param array|array $columns
     * @return mixed
     */
    public function firstOrFail(array $columns = ['*']);

    /**
     * Save a new entity in repository
     *
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * Save a new/news entities in repository
     *
     * @param array $attributes
     * @return mixed
     */
    public function insert(array $attributes);

    /**
     * Update a entity in repository by id
     *
     * @param array $attributes
     * @param int|null $id
     * @return mixed
     */
    public function update(array $attributes, int $id = null);

    /**
     * Update or Create an entity in repository
     *
     *
     * @param array $attributes
     * @param array $values
     * @return mixed
     */
    public function updateOrCreate(array $attributes, array $values = []);

    /**
     * Restore a entity in repository by id
     *
     * @param int|null $id
     * @return int
     */
    public function restore(int $id = null);

    /**
     * Force delete a entity in repository by id
     *
     * @param int|null $id
     * @return int
     */
    public function forceDelete(int $id = null);

    /**
     * Delete a entity in repository by id
     *
     * @param int|null $id
     * @return int
     */
    public function delete(int $id = null);
}
