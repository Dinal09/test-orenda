<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\UserController;

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
$router->post('/api/register', 'UserController@create');
$router->post('/api/putin', 'UserController@addKoli');
$router->post('/api/takeout', 'UserController@removeKoli');
$router->post('/api/koli/common', 'UserController@index');