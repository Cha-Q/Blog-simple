<?php

use App\PaginatedQuery;
?>

<div class="d-flex justify-content-around my-4">

    <?= $pagination->previousLink($link); ?>
    <?= $pagination->nextLink($link); ?>

</div>