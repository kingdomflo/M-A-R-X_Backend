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

$router->get('user/relationship', 'RelationshipController@getAll');
$router->post('user/relationship', 'RelationshipController@create');
$router->get('user/relationship/{id}', 'RelationshipController@getOne');
$router->put('user/relationship/{id}', 'RelationshipController@update');
$router->delete('user/relationship/{id}', 'RelationshipController@delete');

$router->get('relationshipType', 'RelationshipTypeController@getAll');
//$router->post('relationshipType', 'RelationshipTypeController@create');

$router->put('user', 'UserController@updateName');
$router->get('user/relationshipType', 'UserController@getAllRelationshipType');
$router->post('user/relationshipType', 'UserController@addRelationshipType');
$router->delete('user/relationshipType/{id}', 'UserController@deleteRelationshipType');
$router->get('user/currencies', 'UserController@getAllCurrencies');
$router->post('user/currencies', 'UserController@addCurrencies');
$router->delete('user/currencies/{id}', 'UserController@deleteCurrencies');

$router->get('user/payment', 'PaymentController@getAllByUser');
$router->get('user/payment/{id}', 'PaymentController@getOneByUser');
$router->post('user/payment', 'PaymentController@create');
$router->put('user/payment/{id}', 'PaymentController@update');
$router->delete('user/payment/{id}', 'PaymentController@delete');
$router->put('user/payment/refunded/{id}', 'PaymentController@refunded');

$router->get('user/reminderdate', 'ReminderDateController@getAllByUser');
$router->post('user/reminderdate', 'ReminderDateController@create');
$router->delete('user/reminderdate/{id}', 'ReminderDateController@delete');

$router->get('currencies', 'CurrenciesController@getAll');

