<?php

namespace App\Models;

class Download extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'downloader_id', 'image_id'
    ];
}