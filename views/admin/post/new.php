<?php

    use App\Connection;
    use App\table\{PostTable, CategoryTable};
    use App\model\Post;
    use App\Validator;
    use App\Form;
    use App\validators\PostValidator;
    use App\ObjectHelper;
    use App\Auth;


    Auth::check();
    
    $error = null;
    $title = "Créer votre article";
    $pdo = Connection::getPDO();
    $post = new Post;
    $post->setCreatedAt(date('Y-m-d H:i:s'));
    $error = null;
    $categoryTable = new CategoryTable($pdo);
    $categories = $categoryTable->list();
    dump($post);
    if(!empty($_POST)){

        
        $postTable = (new PostTable($pdo));
        $v = new Validator($_POST);
        $v = new PostValidator($_POST, $postTable, $categories);
        
        $params = ['name','content','slug','created_at'];
        
        ObjectHelper::hydrate($post, $params);
        

        if($v->validate()) {
            if(isset($_POST['categories_ids'])){
                $postTable->createPost($post, $_POST['categories_ids']);
            }else{
                $postTable->createPost($post);
            }
            
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