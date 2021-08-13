<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$router->get('/test',function(){
    Log::alert("HELP");
    error_log('HEEEEELP');
    return (json_encode(['0'=>'FAILED']));
});

$router->get('/',['as'=>'home','uses'=>'BooksController@index']);

$router->get('/books/search',['uses'=>'BooksController@show']);

$router->get('/info/{id}',['uses'=>'BooksController@info']);

$router->get('/purchase/{id}',['uses'=>'BooksController@purchase']);

$router->delete('/cache/invalidate/{id}',function($id){
    Cache::forget('info'.$id);
});
