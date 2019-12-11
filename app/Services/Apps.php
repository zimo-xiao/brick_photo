<?php

namespace App\Services;

use App\Helpers;

class Apps
{
    protected $intl;

    public function __construct($config)
    {
        $config = \config($config);
        $this->intl = Helpers::mergeConfig(\config('intl')[$config['lang']], $config);
    }

    public function intl()
    {
        return $this->intl;
    }
}