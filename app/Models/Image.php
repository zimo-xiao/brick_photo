<?php

namespace App\Models;

class Image extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid', 'usinauthor_name','tags','description','file_name'
    ];
}