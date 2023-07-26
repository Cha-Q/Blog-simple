
<div class="container">
    <form method="POST" action=''>
        <div>
            <?= $form->input('name', 'Titre');?>
            <?= $form->textarea('content', 'Contenu de l\'article');?>
            <?= $form->input('created_at', 'Date de modification');?>

        </div>


        <div>
            <button class="btn btn-primary mt-4 ml-2">
            <?= ($post->getId() === null)? "Créer" : "Modifier" ?>
            </button>
            <a href="/admin" class="btn mt-4 ml-2 btn-primary" >
            Retour
            </a>
        </div>

    </form>
</div>
