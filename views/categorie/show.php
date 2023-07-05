<?php


    use App\Connection;
    use App\model\{Post, Category};

    $title = 'Les catégories';
    $description = 'Retrouvez ici toutes les catégories que vous aimez sur notre site';

    $id = (int)$params['id'];
    $slug = $params['slug'];

   
    $pdo = Connection::getPDO();
    function getId(int $id, PDO $pdo){
        $query = "SELECT * FROM category WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Category::class);
        /** @var Category|false */
        $categories = $stmt->fetch();
        return $categories;
    }

    $category = getId($id, $pdo);

    if($category === false){
        throw new Exception('Cette categorie n\'existe pas'); 
    }

    if($category->getSlug() != $slug){
        $url = $router->url('categorie', ['slug' => $category->getSlug(), 'id' => $id]);
        http_response_code(301); 
        header('Location :' . $url);
    }

    $query = $pdo->prepare('SELECT p.id, p.slug, p.name, p.content, p.created_at
                            FROM post_category pc
                            JOIN post p ON pc.post_id = p.id
                            WHERE pc.category_id = :id');

    $query->execute(['id' => $category->getId()]);
    $query->setFetchMode(PDO::FETCH_CLASS, Post::class);
    /** @var Post[] */
    $posts = $query->fetchAll();

   
?>

<h2>Les posts correspondants à la catégorie <strong><?= $category->getName() ?></strong></h2>

<div class="row"> 
        <?php foreach($posts as $post): ?>
            <div class="col-md-3 py-4">
                <?php require dirname(__DIR__) . '/post/card.php'?>
            </div>
        <?php endforeach ?>
</div>

<?php

require dirname(__DIR__) . '/layout/paging.php'?>
    

