<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends BaseModel implements AuthenticatableContract, AuthorizableContract
{
    public const PERMISSION_READ = 1;

    public const PERMISSION_WRITE = 2;

    public const PERMISSION_ADMIN = 3;

    use HasApiTokens, Authenticatable, Authorizable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'password', 'usin', 'name', 'permission', 'email'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
}