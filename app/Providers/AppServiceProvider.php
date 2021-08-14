<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->app->bind(App\Startup::class,function($app){
        //     return new App\Startup();
        // });
        if(!Cache::has('index')){
            Cache::put('index',0);
            error_log('1st');
        }
        error_log('registering');
    }
}
