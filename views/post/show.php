<?php

    use App\Connection;
    use App\model\{Post, Category};
    use App\table\{PostTable, CategoryTable};

    
    $description = 'Retrouvez ici toutes les catégories que vous aimez sur notre site';

    $id = (int)$params['id'];
    $slug = $params['slug'];

    $pdo = Connection::getPDO();
    $post = (new PostTable($pdo))->find($id);
    (new CategoryTable($pdo))->hydratePosts([$post]);

    if($post->getSlug() != $slug){
        $url = $router->url('post', ['slug' =>$post->getSlug(), 'id' => $id]);
        http_response_code(301);
        header('Location :' . $url);
    }
    
    $query = $pdo->prepare('SELECT c.id, c.slug, c.name 
                            FROM post_category pc 
                            JOIN  category c ON pc.category_id = c.id
                            WHERE pc.post_id = :id'
                            );

    $query->execute(['id' => $post->getId()]);
    $query->setFetchMode(PDO::FETCH_CLASS, Category::class);
    /** @var Category[] */
    $categories = $query->fetchAll();
    $title = e($post->getName());

?>

<div class="container card">
    <div class="card-body">
        <h1>
            <?= e($post->getName()) ?>
        </h1>
        <p class='text-muted'> 
            <?= $post->getCreatedAt()->format('D M Y h:m') ?>
        </p>
        <p>
            <?php foreach($post->getCategories() as $category) :  ?>
                <a href="<?= $router->url('categorie', ['id' => $category->getId(), 'slug' => $category->getSlug()])?>"><?= e($category->getName()) ?></a>
                
            <?php endforeach  ?>
        </p>
        <p>
            <?= $post->getFormatedContent() ?>
        </p>
        <p>
            <a href="<?= $router->url('post', ['slug' =>$post->getSlug(), 'id' => $post->getId()]) ?>" class='btn btn-primary'>Click</a>
        </p>
    </div>
    
</div>


