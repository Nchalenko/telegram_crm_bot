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

$router->get('/', 'TelegramController@index');
$router->get('/set', 'TelegramController@set');
$router->get('/ololo-tele-hook', 'TelegramController@hook');
