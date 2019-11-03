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

// rework the route

$router->post('login', 'UserController@login');

$router->get('relationship/relationshipType', 'RelationshipController@getAllRelationshipType');
$router->get('relationship', 'RelationshipController@getAllRelationship');
$router->get('relationship/{id}', 'RelationshipController@getOneRelationship');
$router->delete('relationship/{id}', 'RelationshipController@deleteOneRelationship');
$router->post('relationship', 'RelationshipController@createRelationship');
$router->put('relationship/{id}', 'RelationshipController@updateRelationship');
$router->put('relationship/userRelationshipTypeDelay/{id}', 'RelationshipController@changeUserRelationshipTypeDelay');

$router->get('payment', 'PaymentController@getAllPayment');
$router->get('payment/suggestedCurrencies', 'PaymentController@getSuggestedCurrencies');
$router->post('payment', 'PaymentController@createPayment');
$router->get('payment/{id}', 'PaymentController@getOnePayment');
$router->put('payment/{id}', 'PaymentController@updateOnePayment');
$router->delete('payment/{id}', 'PaymentController@deleteOnePayment');
$router->put('payment/refunded/{id}', 'PaymentController@refundedPayment');
$router->post('payment/reminderDate', 'PaymentController@createReminderDate');










// old route, keep it for the moment

// $router->post('login', 'UserController@login');

// $router->get('relationship', 'RelationshipController@getAll');
// $router->post('relationship', 'RelationshipController@create');
// $router->get('relationship/{id}', 'RelationshipController@getOne');
// $router->put('relationship/{id}', 'RelationshipController@update');
// $router->delete('relationship/{id}', 'RelationshipController@delete');

// $router->get('relationshipType', 'RelationshipTypeController@getAll');
// $router->post('relationshipType', 'RelationshipTypeController@create');

// $router->put('user', 'UserController@updateName');
// $router->get('relationshipType', 'UserController@getAllRelationshipType');
// $router->post('relationshipType', 'UserController@addRelationshipType');
// $router->delete('relationshipType/{id}', 'UserController@deleteRelationshipType');

// $router->get('payment', 'PaymentController@getAllByUser');
// $router->get('payment/{id}', 'PaymentController@getOneByUser');
// $router->post('payment', 'PaymentController@create');
// $router->put('payment/{id}', 'PaymentController@update');
// $router->delete('payment/{id}', 'PaymentController@delete');
// $router->put('payment/refunded/{id}', 'PaymentController@refunded');

// $router->get('reminderdate', 'ReminderDateController@getAllByUser');
// $router->post('reminderdate', 'ReminderDateController@create');
// $router->delete('reminderdate/{id}', 'ReminderDateController@delete');

