<?php

namespace App\Models;

class ValidationCode extends BaseModel
{
    protected $primaryKey = 'code';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'usin', 'email'
    ];
}