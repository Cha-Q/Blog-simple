<!DOCTYPE html>
<html lang="fr" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $description ?? 'Mon super blog' ?>">
    <title><?= isset($title) ? e($title) : 'Mon site' ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">
    
</svg>
</head>

<body class="d-flex flex-column h-100">
    <nav class="navbar p-2 navbar-dark wrap bg-info">
        <a href="#" class="navbar-brand p-2">Mon Site</a>
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
