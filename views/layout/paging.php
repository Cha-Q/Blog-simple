<?php

use App\PaginatedQuery;
?>

<div class="d-flex justify-content-around my-4">

    <?= $paginatedQuery->previousLink($link); ?>
    <?= $paginatedQuery->nextLink($link); ?>

</div>