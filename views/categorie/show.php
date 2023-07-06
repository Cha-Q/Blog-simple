<?php


    use App\Connection;
    use App\model\{Post, Category};
    use App\URL;

    
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


    $title = e($category->getName());


    $currentPage = URL::getPositiveInt('page', 1);

    $count = (int)$pdo->query('SELECT COUNT(category_id) FROM post_category WHERE category_id = ' . $category->getId())->fetch(PDO::FETCH_NUM)[0];
    $perPage = 12;
    $pages = ceil($count / $perPage);
    if($currentPage > $pages){
        throw new Exception("Cette page n'existe pas");
    }
    $offset = $perPage * ($currentPage - 1);
     $query = $pdo->prepare("SELECT p.id, p.slug, p.name, p.content, p.created_at
                            FROM post_category pc
                            JOIN post p ON pc.post_id = p.id
                            WHERE pc.category_id = :id
                            ORDER BY p.created_at DESC LIMIT $perPage OFFSET $offset");

    $query->execute(['id' => $category->getId()]);
    $query->setFetchMode(PDO::FETCH_CLASS, Post::class);
    /** @var Post[] */
    $posts = $query->fetchAll();
    
    $link = $router->url('categorie', ['id' => $category->getId(), 'slug' => $category->getSlug()]);
?>

<h2>Les posts correspondants à la catégorie <strong><?= $title ?></strong></h2>

<div class="row"> 
        <?php foreach($posts as $post): ?>
            <div class="col-md-3 py-4">
                <?php require dirname(__DIR__) . '/post/card.php'?>
            </div>
        <?php endforeach ?>
</div>

<?php

        require dirname(__DIR__) . '/layout/paging.php';
    

