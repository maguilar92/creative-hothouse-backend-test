<?php

namespace Modules\Core\Support\Repository\Src\Events;

class RepositoryEntityDeleted extends RepositoryEventBase
{
    /**
     * Action executed.
     *
     * @var string
     */
    protected $action = 'delete';
}
