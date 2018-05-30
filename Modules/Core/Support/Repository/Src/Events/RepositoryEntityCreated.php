<?php

namespace Modules\Core\Support\Repository\Src\Events;

class RepositoryEntityCreated extends RepositoryEventBase
{
    /**
     * Action executed.
     *
     * @var string
     */
    protected $action = 'create';
}
