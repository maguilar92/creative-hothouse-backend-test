<?php

namespace Modules\User\Repositories;

use Modules\Core\Support\Repository\Src\Eloquent\BaseRepository;

class UserRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return 'Modules\\User\\Entities\\User';
    }
}
