<?php

    use App\Connection;
    use App\table\CategoryTable;
    use App\Auth;

    $title = "Dashboard admin";
    $pdo = Connection::getPDO();

    Auth::check();

    
    $title = 'Gestion des catégories';
    $table = new CategoryTable($pdo);
    $items= $table->all();

    $link = $router->url("admin_categories");

    if(isset($_GET['delete'])): ?>
        <div class="alert alert-success">
            L'article <?= $_GET['delete']?> a bien été supprimmé
        </div>
    <?php endif; ?>
        <table class="table table-striped m-auto w-50 justify-content-center" >
        <thead>
            <tr >
                <th scope="col">#id</th>
                <th scope="col">Nom de la categorie</th>
                <th scope="col"><a class="nav-link text-light btn btn-secondary " href="<?= $router->url('admin_category_new')?>"> Nouveau +</a></th>
            </tr>
        </thead>
        <?php foreach($items as $item) : ?>
        <tbody>
            <tr>
                <th scope="col"><?= $item->getId()?></th>
                <td>
                        <?= e($item->getName()) ?>
                </td>
                <td>
                    <a  class="btn btn-primary" href="<?= $router->url('admin_category', ['id' => $item->getId()]) ?>">modifier</a>
                    <form onsubmit="return confirm('voulez-vous confirmer cette action')" style="display:inline;" action="<?= $router->url('admin_category_delete', ['id' => $item->getId()]) ?>" method="POST">
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
        </tbody>  
    <?php endforeach ?>
    </table>

    

    <?php
    

