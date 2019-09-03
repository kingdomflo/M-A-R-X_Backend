# M-A-R-X Backend

The API for the mobile application Money And Relationship eXperience
Just an app to manage to who I owe money and who owe me money

<!-- 
### Choice of PHP

"Well, why do you use this ugly language that is PHP when you have NodeJS, C#, Java or Pyhton ?"
Good question! Because I have a nice web host in OVH.com and who only work with PHP
And PHP is not as ugly as they say he is, especially if we use a good framework like Symfony or Laravel (Lumen is an API centred framework based on Laravel)
But a NestJS version is currently in work
-->

Composer install: php composer.phar install

Lumen - Eloquent command:

Create the data base: php artisan migrate

Seed the data base: php artisan db:seed


## DataBase

![alt UML](https://raw.githubusercontent.com/kingdomflo/M-A-R-X_Backend/master/out/plantUml/class/class.png)


## API Route

All route, except login, must have the header Api-Token with the token from Auth0
The login route will have an other token to be sure that the user is from us Auth0 service

### get - relationship/relationshipType
```json
response:
{
    "id": "number",
    "relationshipType": {
        "id": "number",
        "name": "string"
    },
    "reminderDay": "number"
}
```

### put - relationship/userRelationshipTypeDelay/{id}
```json
request:
the id in the route is the id of the UserRelationshipType
{
    "reminderDate": "number"
}
response:
{
    "id": "number",
    "relationshipType": {
        "id": "number",
        "name": "string"
    },
    "reminderDate": "number"
}
```

### get - relationship 
```json
response:
[
    {
        "id": "number",
        "name": "string",
        "userRelationshipType": {
            "id": "number",
            "relationshipType": {
                "id": "number",
                "name": "string"
            },
            "reminderDay": "number"
        }
    }
]
```

### get - relationship/{id} 
```json
response:
{
    "id": "number",
    "name": "string",
    "userRelationshipType": {
        "id": "number",
        "relationshipType": {
            "id": "number",
            "name": "string"
        },
        "reminderDay": "number"
    }
}
```

### post - relationship 
```json
request: 
{
    "name": "string",
    "userRelationshipType": {
        "id": "number",
    }
}
response:
{
    "id": "number",
    "name": "string",
    "userRelationshipType": {
        "id": "number",
        "relationshipType": {
            "id": "number",
            "name": "string"
        },
        "reminderDay": "number"
    }
}
```

### put - relationship/{id}
```json
request: 
{
    "name": "string",
    "userRelationshipType": {
        "id": "number",
    }
}
response:
{
    "id": "number",
    "name": "string",
    "userRelationshipType": {
        "id": "number",
        "relationshipType": {
            "id": "number",
            "name": "string"
        },
        "reminderDay": "number"
    }
}
```


# Lumen

## Lumen PHP Framework Information

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://poser.pugx.org/laravel/lumen-framework/d/total.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/lumen-framework/v/stable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/lumen-framework/v/unstable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://poser.pugx.org/laravel/lumen-framework/license.svg)](https://packagist.org/packages/laravel/lumen-framework)

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

## Official Documentation for Lumen PHP

Documentation for the framework can be found on the [Lumen website](http://lumen.laravel.com/docs).

## License

The Lumen framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
