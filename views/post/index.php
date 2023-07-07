<?php

use App\model\{Post, Category};
use App\Connection;
use App\URL;
use App\PaginatedQuery;

    $title = 'Les articles';
    $description = 'Retrouvez ici tous les articles que vous aimez sur notre site';

    $pdo = Connection::getPDO();


    $paginatedQuery = new PaginatedQuery(
        "SELECT * FROM post ORDER BY created_at DESC",
        "SELECT COUNT(id) FROM post"
    );
    $posts = $paginatedQuery->getItems(Post::class);

    $postsByIds = [];
    foreach($posts as $post){
        $postsByIds[$post->getId()] = $post;
    }
    
   
    $categories = $pdo
        ->query('SELECT c.* ,pc.post_id
                FROM post_category pc
                JOIN category c ON c.id = pc.category_id
                WHERE pc.post_id IN ('. implode(',', array_keys($postsByIds)) .')')
        ->fetchAll(PDO::FETCH_CLASS, Category::class);

        foreach($categories as $category){
            $postsByIds[$category->getPost_Id()]->addCategory($category);
        }

    
    $link = $router->url('blog');
    

   
?>


<h2>Mes articles</h2>

<div class="row">
    <?php foreach($posts as $post) : ?>
        <div class="col-md-3 py-4">
            
                <?php 
                require 'card.php' ?>   
        </div>
    <?php endforeach ?> 
</div>

<?php

require dirname(__DIR__) . '/layout/paging.php'?>


