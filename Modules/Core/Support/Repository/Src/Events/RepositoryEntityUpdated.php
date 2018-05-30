<?php

namespace Modules\Core\Support\Repository\Src\Events;

class RepositoryEntityUpdated extends RepositoryEventBase
{
    /**
     * Action executed.
     *
     * @var string
     */
    protected $action = 'update';
}
