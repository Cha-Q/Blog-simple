<?php

require dirname(__DIR__) . '/vendor/autoload.php';

define('DEBUG_TIME', microtime(true));

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

use App\Router;

if(isset($_GET['page']) && $_GET['page'] === '1'){
    $uri = explode('?', $_SERVER['REQUEST_URI'])[0];
    $get = $_GET;
    unset($get['page']);
    $query = http_build_query($get);
    if(!empty($query)){
        $uri = $uri . '?' . $query;
    }
    http_response_code(301);
    header('Location : ' . $uri);
    exit();
}

// initialisation du rooter

$router = new Router(dirname(__DIR__) .'/views');

$router
    ->get('/', 'index', 'main')
    ->get('/blog', 'post/index', 'blog')
    ->get('/blog/[*:slug]-[i:id]', 'post/show', 'post')
    ->get('/blog/categorie', 'categorie/show', 'categorie')
    ->run();
?>

