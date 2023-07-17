<?php

    use App\Connection;
    use App\table\PostTable;

    
    $id = (int)$params['id'];
    

    $pdo = Connection::getPDO();
    $post = (new PostTable($pdo))->findPost($id);

    $postName = $post->getName();
    $postContent = $post->getContent();

    
    $title = "Article n°$id";
    

       
?>

<form method="POST" action=''>
    <div class="form-group">
        <label for="titre">Titre :</label>
        <input class="form-control" type="text" name="name" id="titre" value="<?=$postName ?>">
    </div>
     <div class="form-group">
        <label for="content">Contenu de l'article :</label>
        <textarea class="form-control" name="content" id="content" cols="30" rows="10"><?= $postContent ?></textarea>
    </div>


    <a href="/admin/<?=$id. '?update=1' ?>" type='submit' class="btn btn-primary">
        Valider
    </a>
    <input type="submit" value='valider'>
    
    <a href="/admin" class="btn btn-primary">
        Retour
    </a>
    
    
</form>