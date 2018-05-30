<?php

namespace Modules\Core\Support\Repository\Src\Events;

use Illuminate\Database\Eloquent\Collection;
use Modules\Core\Support\Repository\Src\Contracts\RepositoryInterface;

class RepositoryEntityRestored extends RepositoryEventBase
{
    /**
     * Action executed
     *
     * @var string
     */
    protected $action = "restore";
}
