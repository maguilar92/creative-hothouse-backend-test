<?php

namespace Modules\Cryptocurrency\Entities;

use Illuminate\Database\Eloquent\Model;

class CryptocurrencyHistorical extends Model
{
    /**
     * The database table used by the entity.
     *
     * @var string
     */
    protected $table = 'cryptocurrencies_historical';

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
    protected $guarded = ['id'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get cryptocurrency.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cryptocurrency()
    {
        return $this->belongsTo('Modules\Cryptocurrency\Entities\Cryptocurrency');
    }
}
