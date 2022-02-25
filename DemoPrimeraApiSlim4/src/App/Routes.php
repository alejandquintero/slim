<?php

declare(strict_types=1);

$app->get('/', 'App\Controller\Home:getHelp');
$app->get('/status', 'App\Controller\Home:getStatus');

//Solo un usuario
$app->get('/user/{id}',App\Controller\User\getOne::class);
//Todos los usuarios
$app->get('/user',App\Controller\User\getAll::class);

$app->post('/user',App\Controller\User\create::class);

//Actualizar usuario
$app->put('/user/{id}',App\Controller\User\update::class);

//Eliminar usuario
$app->delete('/user/{id}',App\Controller\User\delete::class);