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
        'author_id', 'author_name','tags','description','file_name','file_format','path'
    ];
}
