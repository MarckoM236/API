<?php

/** @var \Laravel\Lumen\Routing\Router $router */



/* $router->get('/', function () use ($router) {
    return $router->app->version();
}); */

$router->get('/','BookController@index');
$router->get('/{id}','BookController@show');
$router->delete('/{id}','BookController@destroy');
$router->post('/','BookController@store');
$router->patch('/{id}','BookController@update');
