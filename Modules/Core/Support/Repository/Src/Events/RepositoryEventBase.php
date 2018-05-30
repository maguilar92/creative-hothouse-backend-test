<?php

namespace Modules\Core\Support\Repository\Src\Events;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Support\Repository\Src\Contracts\RepositoryInterface;

abstract class RepositoryEventBase
{
    /**
     * Model executed.
     *
     * @var Model
     */
    protected $model;

    /**
     * Repository executed.
     *
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * Action executed.
     *
     * @var string
     */
    protected $action;

    /**
     * Class constructor.
     *
     * @param RepositoryInterface $repository
     * @param Model               $model
     */
    public function __construct(RepositoryInterface $repository, Model $model)
    {
        $this->repository = $repository;
        $this->model = $model;
    }

    /**
     * Get model executed.
     *
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Get repository executed.
     *
     * @return RepositoryInterface
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * Get action executed.
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }
}
