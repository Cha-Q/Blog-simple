<?php

    use App\Connection;
    use App\table\PostTable;
    use App\model\Post;
    use Valitron\Validator;

    
    $id = (int)$params['id'];
    
    dump($_POST);
    $pdo = Connection::getPDO();
    $postTable = (new PostTable($pdo));
    $post = $postTable->find($id);
    
    $success = false;
    $slug = $post->getSlug();

   dump($post);
   $error = [];
    
    if(!empty($_POST)){

        $v = new Valitron\Validator($_POST);
        
        $v->rule('required', 'name')
            ->rule('required', 'content')
          ->rule('length', 'name', 3);

        $slug = strtolower(str_replace(" ", "-",$_POST['name']));
        
        $post->setName($_POST['name'])
            ->setContent($_POST['content'])
            ->setSlug($slug);

        if($v->validate()) {
            $postTable->updatePost($post);
            $success = true;
        } else {
            // Errors
            $errs = $v->errors();
            foreach($errs as $err){
                foreach($err as $e){
                    $error[] = $e;
                } 
            }
           
        }

    }

    

    $postName = $post->getName();
    $postContent = $post->getContent();
    
    
    $title = "Article n°$id";
    
?>

<h1>Editez l'article <strong><?= e($postName) ?></strong></h1>

<?php if($success === true) : ?>
    <div class="alert alert-success">
        La modification a bien été effectuée ! 
    </div>

<?php endif ?>
<?php if($error) :?>
    <div class="alert alert-danger">
        <?php foreach($error as $err) :?>
            <?= $err ?>
            <br>
        <?php endforeach ?>
    </div>
<?php endif ?>
<form method="POST" action=''>

    <div class="form-group">
        <label for="name">Titre :</label>
        <input class="form-control" type="text" name="name" value="<?= $postName ?>">
    </div>
     <div class="form-group">
        <label for="content">Contenu de l'article :</label>
        <textarea class="form-control" name="content" cols="30" rows="10"><?= $postContent ?></textarea>
    </div>

    

    <button class="btn btn-primary ml-2">
        Modifier
    </button>
    <a href="/admin" class="btn ml-2 btn-primary" >
    Retour
    </a>
</form>