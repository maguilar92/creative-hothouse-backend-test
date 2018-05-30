<?php

namespace Modules\Core\Support\Repository\Src\Events;

use Illuminate\Database\Eloquent\Collection;
use Modules\Core\Support\Repository\Src\Contracts\RepositoryInterface;

class RepositoryEntityInserted extends RepositoryEventBase
{
    /**
     * Action executed
     *
     * @var string
     */
    protected $action = "insert";

    /**
     * Class constructor
     *
     * @param RepositoryInterface $repository
     * @param Collection               $model
     */
    public function __construct(RepositoryInterface $repository, Collection $model)
    {
        $this->repository = $repository;
        $this->model = $model;
    }
}
