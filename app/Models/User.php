<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    const STATUS_ACTIVE = 'active';

    const STATUS_DISABLED = 'disabled';

    protected $table = 'users';

    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'password_reset_date',
        'status'
    ];

    public function keys()
    {
        return $this->hasMany(ApiKey::class, 'id', 'user_id');
    }
}