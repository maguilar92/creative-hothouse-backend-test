<?php

namespace Modules\Core\Support\Repository\Src\Events;

class RepositoryEntityRestored extends RepositoryEventBase
{
    /**
     * Action executed.
     *
     * @var string
     */
    protected $action = 'restore';
}
