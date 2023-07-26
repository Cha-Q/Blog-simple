<?php

    use App\Connection;
    use App\table\PostTable;
    use App\Auth;

    $title = "Dashboard admin";
    $pdo = Connection::getPDO();

    Auth::check();

   
    
    $table = new PostTable($pdo);
    [$posts, $pagination] = $table->findPaginated();

    $link = $router->url("admin_posts");

    if(isset($_GET['delete'])): ?>
        <div class="alert alert-success">
            L'article <?= $_GET['delete']?> a bien été supprimmé
        </div>
    <?php endif; ?>

    <?php
    require dirname(__DIR__) .'/table.php';

    require dirname(__DIR__,2) .'/layout/paging.php';