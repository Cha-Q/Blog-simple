<?php

    use App\Connection;
    use App\table\PostTable;
    use App\Auth;


    Auth::check();

    $id = (int)$params['id'];
    $pdo = Connection::getPDO();
    (new PostTable($pdo))->delete($id);
    header('Location:'. $router->url('admin_posts') . "?delete=$id");
    
    