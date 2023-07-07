<?php

    $categories = array_map(function ($p) use ($router){
        $url = $router->url('categorie', ['id' => $p->getId(), 'slug' => $p->getSlug()]);
        return "<a href='{$url}'>{$p->getName()}</a>";
    }, $post->getCategories());
     
  

?>



<div class="card ">
    <div class="card-body">
        <h5 class="card-title"></h3><?= htmlentities($post->getName()) ?></h5>
        <p class='text-muted'>
            <?= $post->getCreated_At()->format('d F Y') ?>
            <?php if (!empty($post->getCategories())): ?>
            ::
            <?= implode(', ', $categories); ?>
            <?php endif ?>
        </p>
        <p>
            <?= $post->getExcerpt ()?>
        </p>
        <p>
            <a href="<?= $router->url('post', ['id' => $post->getId(), 'slug' => $post->getSlug()]) ?>" class='btn btn-primary'> Voir plus</a>
        </p>
    </div>
</div>