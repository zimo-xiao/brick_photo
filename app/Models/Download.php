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
        'downloader_id', 'image_id'
    ];
}