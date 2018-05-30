<?php

namespace Modules\Core\Support\Repository\Src\Traits;

use Modules\Core\Support\Repository\Src\Events\RepositoryEntitiesDeleted;
use Modules\Core\Support\Repository\Src\Events\RepositoryEntitiesRestored;
use Modules\Core\Support\Repository\Src\Events\RepositoryEntitiesUpdated;
use Modules\Core\Support\Repository\Src\Events\RepositoryEntityCreated;
use Modules\Core\Support\Repository\Src\Events\RepositoryEntityDeleted;
use Modules\Core\Support\Repository\Src\Events\RepositoryEntityInserted;
use Modules\Core\Support\Repository\Src\Events\RepositoryEntityRestored;
use Modules\Core\Support\Repository\Src\Events\RepositoryEntityUpdated;

trait BaseRepositoryWrite
{
    /**
     * Save a new entity in repository
     *
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        $model = $this->model->create($attributes);
        $model->save();
        
        $this->resetModel();

        event(new RepositoryEntityCreated($this, $model));

        return $model;
    }

    /**
     * Save a new/news entities in repository
     *
     * @param array $attributes
     * @return mixed
     */
    public function insert(array $attributes)
    {
        $keyName = $this->app->make($this->model())->getKeyName();

        $startId = $this->model->max($keyName) + 1;
        $this->model->insert($attributes);
        $endId = $this->model->max($keyName) + 1;
        $models = $this->model->whereBetween($keyName, [$startId, $endId])->limit($endId - $startId + 1)->get();

        $this->resetModel();

        event(new RepositoryEntityInserted($this, $models));

        return $models;
    }

    /**
     * Update a entity in repository by id or entities by conditionals
     *
     * @param array $attributes
     * @param int|null $id
     * @return mixed
     */
    public function update(array $attributes, int $id = null)
    {
        if (is_null($id)) {
            $this->model->update($attributes);
            $models = $this->model->get();

            $this->resetModel();

            event(new RepositoryEntitiesUpdated($this, $models));

            return $models;
        }

        $model = $this->model->findOrFail($id);
        $model->fill($attributes);
        $model->save();

        $this->resetModel();

        event(new RepositoryEntityUpdated($this, $model));

        return $model;
    }

    /**
     * Update or Create an entity in repository
     *
     * @param array $attributes
     * @param array $values
     * @return mixed
     */
    public function updateOrCreate(array $attributes, array $values = [])
    {
        $model = $this->model->updateOrCreate($attributes, $values);

        $this->resetModel();

        event(new RepositoryEntityUpdated($this, $model));

        return $model;
    }

    /**
     * Restore a entity in repository by id or entities by conditionals
     *
     * @param int|null $id
     * @return int
     */
    public function restore(int $id = null)
    {
        if (is_null($id)) {
            $originalModels = $this->withTrashed()->model->get();
            $restored = $this->model->restore();

            $this->resetModel();

            event(new RepositoryEntitiesRestored($this, $originalModels));

            return $restored;
        }

        $model = $this->withTrashed()->find($id);

        $originalModel = clone $model;
        $restored = $model->restore();

        $this->resetModel();

        event(new RepositoryEntityRestored($this, $originalModel));

        return $restored;
    }

    /**
     * Force delete a entity in repository by id or entities by conditionals
     *
     * @param int|null $id
     * @return int
     */
    public function forceDelete(int $id = null)
    {
        if (is_null($id)) {
            $originalModels = $this->withTrashed()->model->get();
            $deleted = $this->model->forceDelete();

            $this->resetModel();

            event(new RepositoryEntitiesDeleted($this, $originalModels));

            return $deleted;
        }

        $model = $this->withTrashed()->find($id);
        $originalModel = clone $model;
        $deleted = $model->forceDelete();

        $this->resetModel();

        event(new RepositoryEntityDeleted($this, $originalModel));

        return $deleted;
    }

    /**
     * Delete a entity in repository by id or entities by conditionals
     *
     * @param int|null $id
     * @return int
     */
    public function delete(int $id = null)
    {
        if (is_null($id)) {
            $originalModels = $this->model->get();
            $deleted = $this->model->delete();

            $this->resetModel();

            event(new RepositoryEntitiesDeleted($this, $originalModels));

            return $deleted;
        }

        $model = $this->find($id);
        $originalModel = clone $model;
        $deleted = $model->delete();

        $this->resetModel();

        event(new RepositoryEntityDeleted($this, $originalModel));

        return $deleted;
    }
}
