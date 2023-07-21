<h2>Liste des derniers articles</h2>

<table class="table table-striped" >
        <thead>
            <tr >
                <th scope="col">Date</th>
                <th scope="col">Nom de l'article</th>
                <th scope="col">Extrait</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
    <?php foreach($posts as $post) : ?>
        <tbody>
            <tr>
                <th scope="col"><?= $post->getCreatedAt()->format('d M Y h:m') ?></th>
                <td>
                        <?= e($post->getName()) ?>
                </td>
                <td><?= $post->getExcerpt() ?></td>
                <td>
                    <a  class="btn btn-primary" href="<?= $router->url('admin_post', ['id' => $post->getId()]) ?>">modifier</a>
                    <form onsubmit="return confirm('voulez-vous confirmer cette action')" style="display:inline;"
                        action="<?= $router->url('admin_post_delete', ['id' => $post->getId()]) ?>" 
                        method="POST">
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
        </tbody>  
    <?php endforeach ?>
</table>

