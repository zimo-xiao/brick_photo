<?php

namespace App\Services;

class Apps
{
    protected $intl;

    public function __construct($config)
    {
        $config = \config($config);
        $this->intl = array_merge(\config('intl')[$config['lang']], $config);
    }

    public function intl()
    {
        return $this->intl;
    }
}