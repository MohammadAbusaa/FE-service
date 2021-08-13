<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    static public $index,$url,$urls=[
        'http://192.168.1.21:8000',
        'http://192.168.1.21:7999',
        'http://192.168.1.21:7998'
    ];
    public function __construct() {
        self::$index=0;
        self::$url=self::$urls[self::$index];
    }
}
