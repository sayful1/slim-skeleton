<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiSession extends Model
{
    protected $table = 'api_session';

    protected $fillable = [
        'expiration',
        'user_id',
        'key_id',
        'session_id'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function apiKey()
    {
        return $this->hasOne(ApiKey::class, 'key_id', 'id');
    }
}