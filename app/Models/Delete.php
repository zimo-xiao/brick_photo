<?php

namespace App\Models;

class Delete extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image_id', 'user_id', 'reason'
    ];
}
