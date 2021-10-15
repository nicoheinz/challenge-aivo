<?php

use Api\Middlewares\CheckMiddlewares as CheckMiddlewares;

$app->get('/api/v1/albums', 'Api\Controllers\ArtistController:index')
    ->add(new CheckMiddlewares());