<?php

    use App\Connection;
    use App\model\Post;

    $title = 'Les catégories';
    $description = 'Retrouvez ici toutes les catégories que vous aimez sur notre site';

    $id = (int)$params['id'];

    $pdo = Connection::getPDO();
    function getId(int $id, PDO $pdo){
        $query = "SELECT * FROM post WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        $posts = $stmt->fetchAll(PDO::FETCH_CLASS, Post::class);
        return $posts[0];
    }
    
    $post = getId($id, $pdo);

    dd($post);

    
?>

<div class="container">
    <h1><?= $post->name ?></h1>
    <p class='text-muted'> <?= $post->created_at ?></p>
    <p><?= $post->content ?></p>
</div>


