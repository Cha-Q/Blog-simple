<?php

    use App\Connection;
    use App\table\PostTable;

$pdo = Connection::getPDO();


    
$table = new PostTable($pdo);
[$posts, $pagination] = $table->findPaginated();

dd($posts);