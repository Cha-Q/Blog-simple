<?php

$description = "Page d'accueil";
$pageTitle = 'Blog';


ob_start();
?>

<header>
    <nav class="navbar navbar-light  bg-light pl-4">
        <p class="navbar-brand w-100 text-center pl-4">Bonjour le monde !</p>    
    </nav>
</header>

<?php
$content = ob_get_clean();

require '../elements/layout.php';   