<?php

    use App\Connection;
    use App\table\PostTable;
    use App\model\Post;
    use App\Validator;
    use App\Form;
    use App\validators\PostValidator;
    use App\ObjectHelper;
    use App\Auth;


    Auth::check();
    
    $error = null;
    $title = "Créer votre article";
   
    $post = new Post;
    $post->setCreatedAt(date('Y-m-d H:i:s'));
    $error = null;


    if(!empty($_POST)){

        $pdo = Connection::getPDO();
        $postTable = (new PostTable($pdo));
        $v = new Validator($_POST);
        $v = new PostValidator($_POST, $postTable);
        $params = ['name','content','slug','created_at'];
        ObjectHelper::hydrate($post, $params);
        
        if($v->validate()) {
            $postTable->createPost($post);
            $success = true;
            header("Location: " . $router->url('admin_post', ['id' => $post->getId(), 'slug' => $post->getSlug()]) ."?success=1");
            exit(); 
        } else {
            // Errors
            $error = $v->errors();
            }
    }
    
    $form = new Form($post, $error);

?>

<h2>Créer un nouvel article</h2>


<?php if(!empty($error)) : ?>
    <div class="alert alert-danger">
        Une erreur est survenue ! 
    </div>

    <?php endif ?>

<div class='container'>
    <?= require '_form.php' ?>
</div>