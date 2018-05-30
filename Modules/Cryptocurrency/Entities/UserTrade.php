<?php

namespace Modules\Cryptocurrency\Entities;

use Illuminate\Database\Eloquent\Model;

class UserTrade extends Model
{
    /**
     * The database table used by the entity.
     *
     * @var string
     */
    protected $table = 'users_trades';

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
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Get cryptocurrency.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cryptocurrency()
    {
        return $this->belongsTo('Modules\Cryptocurrency\Entities\Cryptocurrency');
    }

    /**
     * Get user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Modules\User\Entities\User');
    }
}
