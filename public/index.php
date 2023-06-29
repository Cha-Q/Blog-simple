<?php

require '../vendor/autoload.php';

use App\Router;

$content = '';

// initialisation du rooter

$router = new Router(dirname(__DIR__) .'/views');

$router
    ->get('/blog', 'post/index', 'blog')
    ->get('/blog/categorie', 'categorie/show', 'categorie')
    ->run();