<?php

    $title = 'Les articles';
    $description = 'Retrouvez ici tous les articles que vous aimez sur notre site';

    $pdo = new PDO('mysql:dbname=tutoblog;host=127.0.0.1','root','root',[
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    
    $query = 'SELECT * FROM post LIMIT 10';
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $posts = $stmt->fetchAll();

   
?>


<h2>Mes articles</h2>

<div class="container d-flex flex-wrap justify-content-around">
    <?php foreach($posts as $post) : ?>
        <div class="card ">
            <h3><?= $post['name'] ?></h3>
            <p><?= $post['content'] ?></p>
        </div>
    <?php endforeach ?> 
</div>


