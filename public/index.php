<?php

require '../vendor/autoload.php';
$content = '';

// initialisation du rooter

$router = new AltoRouter();

define('VIEW_PATH', dirname(__DIR__) .'/views');


$router->map('GET', '/', function (){
    require VIEW_PATH. '/post/index.php';
});

$router->map('GET', '/blog', function (){
    require VIEW_PATH. '/post/index.php';
});
$router->map('GET', '/blog/categorie', function (){
    require VIEW_PATH. '/categorie/show.php';
});

$description = "Page d'accueil";
$pageTitle = 'Blog';

$match = $router->match();
$match['target']();

require '../views/elements/layout.php';