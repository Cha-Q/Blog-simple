<?php

require dirname(__DIR__) . '/vendor/autoload.php';

define('DEBUG_TIME', microtime(true));

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

use App\Router;



// initialisation du rooter

$router = new Router(dirname(__DIR__) .'/views');

$router
    ->get('/', 'post/index', 'main')
    ->get('/blog', 'post/index', 'blog')
    ->get('/blog/categorie/[*:slug]-[i:id]', 'categorie/show', 'categorie')
    ->get('/blog/[*:slug]-[i:id]', 'post/show', 'post')
    ->get('/connexion', 'login/login', 'connexion')
    ->match('/register', 'login/register/index', 'register')
    ->match('/sign-in', 'login/sign/index', 'sign')
    ->post('/disconnect', 'login/disconnect', 'disconnect')
    // ADMIN
    // gestion des articles
    ->get('/admin', 'admin/post/index', 'admin_posts')
    ->match('/admin/post/[i:id]', 'admin/post/edit', 'admin_post')
    ->post('/admin/post/[i:id]/delete', 'admin/post/delete', 'admin_post_delete')
    ->match('/new', 'admin/post/new', 'admin_post_new')
    // gestion des categories
    ->get('/admin/categories', 'admin/category/index', 'admin_categories')
    ->match('/admin/category/[i:id]', 'admin/category/edit', 'admin_category')
    ->post('/admin/category/[i:id]/delete', 'admin/category/delete', 'admin_category_delete')
    ->match('/admin/new', 'admin/category/new', 'admin_category_new')
    ->run();
?>

