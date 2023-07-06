
<div class="d-flex justify-content-around my-4">

    <?php if($currentPage > 1) : ?>
        <?php
        $l = $link;
        if ($currentPage > 2) $l .= '?page=' . $currentPage - 1; ?>
        <a href="<?= $l?>" class="btn btn-primary">Page précédente</a>
    <?php endif ?>
    <?php if($currentPage < $pages) : ?>
        <a href="<?= $link ?>?page=<?= $currentPage +1?>" class="btn btn-primary ">Page suivante</a>
    <?php endif ?>

</div>