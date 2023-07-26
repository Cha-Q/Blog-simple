
<div class="container">
    <form method="POST" action=''>
        <div>
            <?= $form->input('name', 'Titre');?>
        </div>


        <div>
            <button class="btn btn-primary mt-4 ml-2">
                <?= ($item->getId() === null)? "Créer" : "Modifier" ?>
            </button>
            <a href="<?= $router->url('admin_categories') ?>" class="btn mt-4 ml-2 btn-primary">
                Retour
            </a>
        </div>

    </form>
</div>
