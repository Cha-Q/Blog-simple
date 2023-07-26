<?php

    use App\Connection;
    use App\Auth;
    use App\table\CategoryTable;

    Auth::check();

    $id = (int)$params['id'];
    $pdo = Connection::getPDO();
    (new CategoryTable($pdo))->delete($id);
    header('Location:'. $router->url('admin_categories') . "?delete=$id");
    
    