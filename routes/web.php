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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('login', 'UserController@login');

//$router->get('relationship', ['middleware' => 'auth', 'uses' => 'RelationshipController@getAll']);
$router->get('relationship', 'RelationshipController@getAll');

$router->get('relationshipType', 'RelationshipTypeController@getAll');
$router->post('relationshipType', 'RelationshipTypeController@create');

$router->put('user', 'UserController@updateName');
$router->get('user/relationshipType', 'UserController@getAllRelationshipType');
$router->post('user/relationshipType', 'UserController@addRelationshipType');
$router->delete('user/relationshipType/{id}', 'UserController@deleteRelationshipType');
