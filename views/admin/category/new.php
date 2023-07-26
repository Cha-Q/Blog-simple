<?php

    use App\Connection;
    use App\table\CategoryTable;
    use App\model\Category;
    use App\Validator;
    use App\Form;
    use App\validators\CategoryValidator;
    use App\ObjectHelper;
    use App\Auth;

    Auth::check();
    
    $error = null;
    $title = "Créer votre article";
   
    $item = new Category;

    $error = null;


    if(!empty($_POST)){

        $pdo = Connection::getPDO();
        $table = (new CategoryTable($pdo));
        $v = new Validator($_POST);
        $v = new CategoryValidator($_POST, $table);
        $params = ['name','slug'];
        ObjectHelper::hydrate($item, $params);
        
        if($v->validate()) {
            $id = $table->create([
                'name' => $item->getName(),
                'slug' => $item->getSlug()
            ]);
            $item->setId($id);
            
            $success = true;
            header("Location: " . $router->url('admin_category', ['id' => $item->getId(), 'slug' => $item->getSlug()]) ."?success=1");
            exit(); 
        } else {
            // Errors
            $error = $v->errors();
            }
    }
    
    $form = new Form($item, $error);

?>

<h2>Créer une nouvelle catégorie</h2>


    <?php if(!empty($error)) : ?>
        <div class="alert alert-danger">
            Une erreur est survenue ! 
        </div>
    <?php endif ?>

    <div class='container'>
        <?= require 'form.php' ?>
    </div>