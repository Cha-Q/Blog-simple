<h2>Liste des derniers articles</h2>

<table class="table" >
        <thead>
            <tr >
                <th scope="col">Date</th>
                <th scope="col"> Nom de l'article</th>
                <th scope="col">Extrait</th>
            </tr>
        </thead>
    <?php foreach($posts as $post) : ?>
        <tbody>
            <tr>
                <th scope="col"><?= $post->getCreated_At()->format('D d M Y h:m') ?></th>
                <td><?= $post->getName() ?></td>
                <td><?= $post->getExcerpt() ?></td>
                <td><button class="btn btn-primary">supprimer</button>
                <button class="btn btn-primary">modifier</button></td>
            </tr>
        </tbody>  
    <?php endforeach ?>
</table>
