<?php

use Illuminate\Routing\Router;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->group(function (Router $route) {
    $route->get('/users', 'UserController@index');
    $route->get('/users/{user}', 'UserController@baseShow');
    $route->put('/users/{user}', 'UserController@update');
    $route->put('/users/{user}/restore', 'UserController@baseRestore');
    $route->delete('/users/{user}', 'UserController@baseDestroy');
});

Route::middleware('api')->group(function (Router $route) {
    $route->post('/users', 'UserController@store');
});
