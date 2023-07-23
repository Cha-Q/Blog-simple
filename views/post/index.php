<?php

use App\Connection;
use App\table\PostTable;
 
    $title = 'Les articles';
    $description = 'Retrouvez ici tous les articles que vous aimez sur notre site';

    $pdo = Connection::getPDO();
    
    $table = new PostTable($pdo);
    [$posts, $pagination] = $table->findPaginated();
    
    $link = $router->url('blog');

?>


<h2>Mes articles</h2>

<div class="d-flex justify-content-center flex-wrap">
    <?php foreach($posts as $post) : ?>
        <div class="col-md-3 py-4 mx-2">
            <?php require 'card.php' ?>   
        </div>
    <?php endforeach ?> 
</div>

<?php

require dirname(__DIR__) . '/layout/paging.php'?>


