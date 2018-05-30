<?php

namespace Modules\Cryptocurrency\Entities;

use Illuminate\Database\Eloquent\Model;

class Cryptocurrency extends Model
{
    /**
     * The database table used by the entity.
     *
     * @var string
     */
    protected $table = 'cryptocurrencies';

    /**
     * The primary key for the entity.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id','created_at','updated_at'];

    /**
     * Get cryptocurrency historical.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function historical()
    {
        return $this->hasMany('Modules\Cryptocurrency\Entities\CryptocurrencyHistorical');
    }
}
