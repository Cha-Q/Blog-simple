<?php 

    $title = "Sign";

    use App\Auth;
    use App\model\User;
    use App\Form;
    use App\table\UserTable;
    use App\Connection;
    use App\table\Exception\NotFoundException;

    $user = new User;
    $errors = [];
    session_start();
    $check = Auth::logged();
    if($check === 'connecté'){
        header('Location: ' . $router->url('admin_posts'));
        exit();
    }
    

    if(!empty($_POST)){
        
        $user->setUsername($_POST['username']);
        $errors['password'] = "Identifiant ou mot de passe incorrect";

        if(!empty($_POST['username']) || !empty($_POST['password'])){
             $table = new UserTable(Connection::getPDO());
           try{
             $u = $table->findByUsername($user->getUsername());
            if(password_verify($_POST['password'], $u->getPassword())){
                
                $_SESSION['auth'] = $u->getId();
                header('Location: ' . $router->url('admin_posts'));
                exit();
             }
             
            } catch (NotFoundException $e){
                
            }
        }
       
        
        
        
        
        
    }
    $form = new Form($user, $errors);

?>


<div class="container bg-light mt-10 w-50 p-4 my-4 rounded">
    <h1 class="mb-4">Connectez vous à votre compte</h1>
    <form class="text-center mt-2" method="POST">
        <?= $form->input('username', 'Entrez votre nom d\'utilisateur'); ?>
        <?= $form->input('password', 'Entrez votre mot de passe', 'Entrez votre mot de passe'); ?>

        <div class="form-group m-2  justify-content-center">
            <button type="submit" class="btn btn-primary">Valider</button>
            <a href="<?= $router->url('connexion') ?>" class="btn btn-primary">retour</a>
            
        </div>
    </form>
</div>