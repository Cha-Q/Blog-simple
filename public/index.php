<?php

require dirname(__DIR__) . '/vendor/autoload.php';

define('DEBUG_TIME', microtime(true));

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

use App\Router;

$content = '';

// initialisation du rooter

$router = new Router(dirname(__DIR__) .'/views');

$router
    ->get('/', 'post/index', 'main')
    ->get('/blog', 'post/index', 'blog')
    ->get('/blog/categorie', 'categorie/show', 'categorie')
    ->run();