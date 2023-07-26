<?php

    use App\Connection;
    use App\table\CategoryTable;
    use App\Validator;
    use App\Form;
    use App\validators\CategoryValidator;
    use App\ObjectHelper;
    use App\Auth;

    
    Auth::check(); 
    $id = (int)$params['id'];
    $pdo = Connection::getPDO();
    $table = (new CategoryTable($pdo));
    $item = $table->find($id);

    $success = false;
    


   $error = null;
   $params = ['name', 'slug'];

   if(!empty($_POST)){

        $v = new Validator($_POST);
        $v = new CategoryValidator($_POST, $table, $item->getId());
        

        ObjectHelper::hydrate($item, $params);
            if($v->validate()) {
            $table->updateCategory($item);
            $success = true;
            } else {
            // Errors
            $error = $v->errors();

            }
    }
    
    
    $title = "{$item->getName()}";

    
    $form = new Form($item, $error);
    
?>

    <h1>Editez la catégorie <strong><?= $item->getName() ?></strong></h1>

    <?php if(isset($_GET["success"]) == "1") : ?>
    <div class="alert alert-success">
        La catégorie a bien été créé ! 
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

    <?= require "form.php"?>