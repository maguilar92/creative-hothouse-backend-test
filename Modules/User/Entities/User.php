<?php

namespace Modules\User\Entities;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The database table used by the entity.
     *
     * @var string
     */
    protected $table = 'users';

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
     * Get user trades.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trades()
    {
        return $this->hasMany('Modules\Cryptocurrency\Entities\UserTrade');
    }
}
