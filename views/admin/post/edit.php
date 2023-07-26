<?php

    use App\Connection;
    use App\table\PostTable;
    use App\Validator;
    use App\Form;
    use App\validators\PostValidator;
    use App\ObjectHelper;
    use App\Auth;


    Auth::check();

    
    $id = (int)$params['id'];
    $pdo = Connection::getPDO();
    $postTable = (new PostTable($pdo));
    $post = $postTable->find($id);

    $success = false;
    


   $error = null;

    if(!empty($_POST)){

        $v = new Validator($_POST);
        $v = new PostValidator($_POST, $postTable, $post->getId());
        $params = ['name', 'content', 'slug', 'created_at'];

        ObjectHelper::hydrate($post, $params);

            if($v->validate()) {
            $postTable->update([
                'name' => $post->getName(),
                'content' => $post->getContent(),
                'slug' => $post->getSlug(),
                'created_at' => $post->getCreatedAt()->format('Y-m-d H:m:s')
            ], $id);
            $success = true;
            } else {
            // Errors
            $error = $v->errors();

            }
    }
    
    $postName = $post->getName();
    $postContent = $post->getContent();
    
    
    $title = "{$post->getName()}";

    $form = new Form($post, $error);
    
?>

    <h1>Editez l'article <strong><?= e($postName) ?></strong></h1>

    <?php if(isset($_GET["success"]) === "1") : ?>
    <div class="alert alert-success">
        L'article a bien été créé ! 
    </div>

    <?php endif ?>

    <?php if($success === true) : ?>
    <div class="alert alert-success">
        La modification a bien été effectuée ! 
    </div>

    <?php endif ?>
    <?php if(!empty($error)) : ?>
    <div class="alert alert-danger">
        Une erreur est survenue ! 
    </div>

    <?php endif ?>

    <?= require "_form.php"?>