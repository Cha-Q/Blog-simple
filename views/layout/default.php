<!DOCTYPE html>
<html lang="fr" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $description ?? 'Mon super blog' ?>">
    <title><?= isset($title) ? e($title) : 'Mon site' ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="/CSS/main.css">
    
</svg>
</head>

<body class="d-flex flex-column h-100 bg-secondary">
    <style>
        .hover-effect{
            transition: all 0.2s linear;
        }
        .hover-effect:hover{
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
            transform: scale(1.03); 
            
        }
    </style>

    <nav class="navbar p-2 navbar-dark wrap bg-primary">
        <div class="p-2 h-1">
            <a href="<?= $router->url('blog')?>" class="navbar-brand p-2 h-1">Mon Site</a>
        </div>
        
        <?php if($title != 'Sign'): ?>
            <ul class="navbar-nav d-flex">
                <li class="nav-item">
                    <a href="<?= $router->url('connexion')?>" class="btn btn-secondary nav-link text-light  px-2">Se connecter</a>
                </li>
                
            </ul>
        <?php endif?>
        <?php if(isset($_SESSION['auth'])): ?>
            <form action="POST" action="<?= $router->url('disconnect')?>" style="display:inline;">
                <button class="btn btn-danger nav-link text-light px-2" type="submit">Se déconnecter</button>
            </form>
        <?php endif?>
    </nav>
    <div class="h-100">

        <?= $content ?>
        
    </div>

    <?php if(isset($title) === 'Les articles'): ?>
         <footer class='bg-light py-4 footer text-center mt-auto'>
            <?php if(defined('DEBUG_TIME')) : ?>
                page générée en <?= round(1000 * (microtime(true) - DEBUG_TIME), 2) ?> ms.
            <?php endif ?>
        </footer>
    <?php endif ?>
   
</body>
</html>
