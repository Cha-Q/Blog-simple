<?php

    use App\model\Post;
    use App\Connection;
    use App\URL;

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

?>



<div class="d-flex justify-content-around my-4">

    <?php if($currentPage > 1) : ?>
        <?php $link = $router->url('blog');
        if ($currentPage > 2) $link .= '?page=' . $currentPage - 1; ?>

        <a href="<?= $link?>" class="btn btn-primary">Page précédente</a>
    <?php endif ?>
    <?php if($currentPage < $pages) : ?>
        <a href="<?= $router->url('blog') ?>?page=<?= $currentPage +1?>" class="btn btn-primary ">Page suivante</a>
    <?php endif ?>

</div>