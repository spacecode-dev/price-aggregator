<?php

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

/** @var $router Router */

use Laravel\Lumen\Routing\Router;

$router->post('login', ['as' => 'login', 'uses' => 'AuthController@signIn']);
$router->post('registration', ['as' => 'registration', 'uses' => 'AuthController@signUp']);

/** Only authorized users */
$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);

    $router->get('me', ['as' => 'me', 'uses' => 'AuthController@me']);

    $router->get('/', function () use ($router) {
        return $router->app->version();
    });

    $router->post('category', ['as' => 'category', 'uses' => 'CategoryController@upload']);
    $router->post('category/delete', ['as' => 'category', 'uses' => 'CategoryController@delete']);
    $router->post('product', ['as' => 'category', 'uses' => 'ProductController@upload']);
    $router->post('product/delete', ['as' => 'category', 'uses' => 'ProductController@delete']);
});
