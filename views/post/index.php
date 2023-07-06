<?php

use App\helpers\Text;
use App\model\Post;
use App\Connection;
use App\URL;

    $title = 'Les articles';
    $description = 'Retrouvez ici tous les articles que vous aimez sur notre site';

    $pdo = Connection::getPDO();

    $currentPage = URL::getPositiveInt('page', 1);

    $count = (int)$pdo->query('SELECT COUNT(id) FROM post')->fetch(PDO::FETCH_NUM)[0];
    $perPage = 12;
    $pages = ceil($count / $perPage);
    if($currentPage > $pages){
        throw new Exception("Cette page n'existe pas");
    }
    $offset = $perPage * ($currentPage - 1);
    $query = "SELECT * FROM post ORDER BY created_at DESC LIMIT $perPage OFFSET $offset";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $posts = $stmt->fetchAll(PDO::FETCH_CLASS, Post::class);

    $link = $router->url('blog');

   
?>


<h2>Mes articles</h2>

<div class="row">
    <?php foreach($posts as $post) : ?>
        <div class="col-md-3 py-4">
                <?php require 'card.php' ?>   
        </div>
    <?php endforeach ?> 
</div>

<?php

require dirname(__DIR__) . '/layout/paging.php'?>


