<?php

namespace App\Services;

class Apps
{
    protected $config;

    protected $intl;

    public function __construct($config)
    {
        $this->config = \config($config);
        $this->intl = \config('intl')[$this->config['lang']];
    }

    public function intl()
    {
        return $this->intl;
    }
}