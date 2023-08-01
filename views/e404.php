<?php
$title = 'Error 404';

http_response_code(404);

?>

<div class="card container  align-self-center p-3">
    <h1 class='card-title'>Erreur 404 page introuvable</h1>
    <p class="card-body text-center">
        <strong class="h2">Oups !!</strong> <br>
        La page que vous cherchez actuellement <br>
        n'existe pas.
    </p>
    <div class="text-center">
        <a href="<?= $router->url('blog') ?>" class="btn btn-primary ">Blog</a>
    </div>
    
    
</div>
