<?php

namespace Modules\Cryptocurrency\Repositories;

use Modules\Core\Support\Repository\Src\Eloquent\BaseRepository;

class CryptocurrencyRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return 'Modules\\Cryptocurrency\\Entities\\Cryptocurrency';
    }
}
