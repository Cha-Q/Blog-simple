<?php

    use App\Connection;
    use App\table\PostTable;
    use App\model\Post;
    use App\Validator;
    use App\Form;
    use App\validators\PostValidator;

    
    $id = (int)$params['id'];
    $pdo = Connection::getPDO();
    $postTable = (new PostTable($pdo));
    $post = $postTable->find($id);
    
    $success = false;
    $slug = $post->getSlug();


   $error = null;
    
    if(!empty($_POST)){

        $v = new Validator($_POST);
        $v = new PostValidator($_POST, $postTable, $post->getId());

        $slug = strtolower(str_replace(" ", "-",$_POST['name']));
        
        // App\Object::hydrate($post, $_POST, ['name', 'content', 'slug', 'created_at']);
        $post
            ->setName($_POST['name'])
            ->setContent($_POST['content'])
            ->setSlug($slug)
            ->setCreatedAt($_POST['created_at']);

        if($v->validate()) {
            $postTable->updatePost($post);
            $success = true;
        } else {
            // Errors
            $error = $v->errors();
            
        }

    }
   
    

    $postName = $post->getName();
    $postContent = $post->getContent();
    
    
    $title = "Article n°$id";

    dump($post);
    $form = new Form($post, $error);
    
?>

    <h1>Editez l'article <strong><?= e($postName) ?></strong></h1>

    <?php if($success === true) : ?>
    <div class="alert alert-success">
        La modification a bien été effectuée ! 
    </div>

    <?php endif ?>

    <form method="POST" action=''>
        <div>
            <?= $form->input('name', 'Titre');?>
            <?= $form->textarea('content', 'Contenu de l\'article');?>
            <?= $form->input('created_at', 'Date de modification');?>

        </div>


        <div>
            <button class="btn btn-primary mt-4 ml-2">
            Modifier
            </button>
            <a href="/admin" class="btn mt-4 ml-2 btn-primary" >
            Retour
            </a>
        </div>

    </form>