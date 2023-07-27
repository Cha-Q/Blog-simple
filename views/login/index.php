<?php 

    $title = "Sign";

?>


<div class="container bg-light mt-10 w-50 p-4 my-4 rounded">
    <h1 class="mb-4">Choisissez comment vous connecter</h1>
        <div class="form-group m-2">
             <a href="<?= $router->url('sign') ?>" class="btn btn-primary">Connectez vous</a>
        </div>

        <div class="form-group m-2">
             <a href="<?= $router->url('register') ?>" class="btn btn-primary">Créez votre compte</a>
        </div>
    </form>
</div>