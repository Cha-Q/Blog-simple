<?php


    use App\Connection;
    use App\table\{CategoryTable, PostTable};
    

    
    $description = 'Retrouvez ici toutes les catégories que vous aimez sur notre site';

    $id = (int)$params['id'];
    $slug = $params['slug'];

   
    $pdo = Connection::getPDO();
    
    
    $category = (new CategoryTable($pdo))->find($id);

    if($category->getSlug() != $slug){
        $url = $router->url('categorie', ['slug' => $category->getSlug(), 'id' => $id]);
        http_response_code(301); 
        header('Location :' . $url);
    }


    $title = e($category->getName());

    [$posts, $pagination] = (new PostTable($pdo))->findPaginatedForCategory($category->getid());
    
    $link = $router->url('categorie', ['id' => $category->getId(), 'slug' => $category->getSlug()]);


?>

<h2 class='text-light'>Les posts correspondants à la catégorie <strong><?= $title ?></strong></h2>

<div class="d-flex justify-content-center flex-wrap"> 
        <?php foreach($posts as $post): ?>
            <div class="col-md-3 py-4 mx-2">
                <?php require dirname(__DIR__) . '/post/card.php'?>
            </div>
        <?php endforeach ?>
</div>

<?php

        require dirname(__DIR__) . '/layout/paging.php';
    

