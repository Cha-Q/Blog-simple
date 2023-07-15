<?php

    use App\Connection;
    use App\model\admin\Administrator;
    use App\model\Post;
    use App\table\CategoryTable;
    use App\table\PostTable;

    $id = (int)$params['id'];
    $slug = $params['slug'];

    $pdo = Connection::getPDO();

    $post = (new PostTable($pdo))->find($id);
    (new CategoryTable($pdo))->hydratePosts([$post]);

    
?>

<form method="POST">
    <div class="form-group">
        <label for="titre">Titre :</label>
        <input class="form-control" type="text" id="titre" value="<?= $post->getName() ?>">
    </div>
     <div class="form-group">
        <label for="content">Contenu de l'article :</label>
        <textarea class="form-control" name="content" id="" cols="30" rows="10"><?= $post->getContent() ?></textarea>
    </div>

    <button class="btn btn-primary">
        valider
    </button>
    
    <a href="/admin" class="btn btn-primary">Retour</a>
    
    
</form>