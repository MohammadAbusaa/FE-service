<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;

class Startup{
    public function __construct()
    {
        Cache::flush();
        Cache::put('index',0);
    }
}