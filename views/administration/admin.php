<?php

    use App\Connection;
    use App\model\admin\Administrator;
    use App\table\PostTable;

$pdo = Connection::getPDO();


    
$table = new PostTable($pdo);
[$posts, $pagination] = $table->findPaginated();

$admin = new Administrator($pdo);

require 'table.php';
