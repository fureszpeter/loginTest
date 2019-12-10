<?php

namespace App\Domain;

use Cartalyst\Sentinel\Users\EloquentUser as OriginalEloquentUser;

class EloquentUser extends OriginalEloquentUser
{
    protected $loginNames = ['username'];

    protected $fillable = [
        'email',
        'password',
        'username',
        'last_name',
        'first_name',
        'permissions',
    ];
}
