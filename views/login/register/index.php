<?php 
    $title = "Sign";

    use App\model\User;
    use App\Form;

    $user = new User;
    $form = new Form($user, []);

   

?>


<div class="container bg-light mt-10 w-50 p-4 my-4 rounded">
    <h1 class="mb-4">Créez votre compte </h1>
    <form class="text-center mt-2" method="POST">
        <!-- <div class="form-group m-2">
             <label for="name">Entrez votre nom d'utilisateur :</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Entrez votre nom d'utilisateur">
        </div> -->

        <!-- <div class="form-group m-2">
             <label for="password">Entrez votre mot de passe :</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Entrez votre mot de passe">
        </div> -->


        <?= $form->input('username', 'Entrez votre nom d\'utilisateur'); ?>
        <?= $form->input('password', 'Entrez votre mot de passe'); ?>
         <div class="form-group m-2">
             <label for="password2">Vérifiez votre mot de passe :</label>
            <input type="password" class="form-control" name="password2" id="password2" placeholder="Entrez votre mot de passe">
        </div>

        <div class="form-group m-2 justify-content-center">
            <button class="btn btn-primary">Valider</button>
            <a href="<?= $router->url('connexion') ?>" class="btn btn-primary">retour</a>
            
        </div>
    </form>
</div>