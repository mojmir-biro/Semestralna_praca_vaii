<?php

$layout = 'root'; ?>

<div class="container">
    Editovanie produktu: <?= @$data['product']?->getId() ?>
    <form action="<?= $link->url('product.save') ?>" method="post">
        <input type="hidden" name="id" value="<?= @$data['product']?->getId() ?>">
        <input type="text" name="productName" id="productName">
        <input type="number" name="price" id="price">
        <input type="text" name="thumbnail" id="thumbnail">
    </form>
</div>