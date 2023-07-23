<?php

    use App\Connection;
    use App\table\PostTable;
    use App\model\Post;
    use App\Validator;
    use App\Form;
    use App\validators\PostValidator;
    use App\Rdm;

    $actualDatetitme = new DateTime('now'); 
    $dateTime = $actualDatetitme->format(('Y-m-d H:i:s'));

    $error = null;
    $success = false;

    $pdo = Connection::getPDO();
    $post = (new PostTable($pdo));
    $newPost = new Post;
    $error = null;

    if(!empty($_POST)){

        $v = new Validator($_POST);
        $v = new PostValidator($_POST, $post);
        $params = ['name','content','slug','created_at'];
        Rdm::hydrate($newPost, $params);
        
         if($v->validate()) {
            $post->createPost($newPost);
            $success = true;
            } else {
            // Errors
            $error = $v->errors();

            }
        

    }
    $_POST['created_at'] = $dateTime;
    // fix created at
    
    $form = new Form($post, $error);

?>

<h2>Créer un nouvel article</h2>

<?php if($success === true) : ?>
    <div class="alert alert-success">
        L'article a bien été créé ! <a href="<?= $router->url()?>"></a>
    </div>

<?php endif ?>

<form class="container" method="POST" action=''>

    <?= $form->input('name','Titre :', "Entrez votre titre") ?>
    <?= $form->textarea('content', 'Contenu de l\'article ', 'Ecrivez votre article'); ?>
    <div class="">
        <?= $form->input('created_at', 'Date de création :');?>
    </div>

    <div>
        <button class="btn btn-primary mt-4 ml-2">
            Créer
        </button>
        <a href="/admin" class="btn mt-4 ml-2 btn-primary" >
            Retour
        </a>
    </div>

</form>

<!-- Réaliser la page de création d'un article -->