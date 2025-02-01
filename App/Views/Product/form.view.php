<?php

use App\Models\ProductSize;

$layout = 'root'; 
?>

<form action="<?= $link->url('product.save') ?>" method="post" enctype="multipart/form-data">
    <div class="productForm">
        <input type="hidden" name="id" value="<?= @$data['product']?->getId() ?>">
        <label for="productName">Názov produktu:</label>
        <input required type="text" name="productName" id="productName" value="<?= @$data['product']?->getName() ?>">
        <label for="price">Cena:</label>
        <input required type="text" name="price" id="price" value="<?= @$data['product']?->getPrice() ?>">
        <label for="colour">Farba</label>
        <input type="text" name="colour" id="colour" value="<?= @$data['product']?->getColour() ?>">
        <label for="thumbnail">Titulný obrázok:</label>
        <input required type="text" name="thumbnail" id="thumbnail" value="<?= @$data['product']?->getThumbnail() ?>">

        <label for="image">Obrázok</label>
        <input type="file" id="image" name="image" accept="image/png, image/jpeg"/>

        <?php foreach (ProductSize::getAll('`productId` = ?', [@$data['product']?->getId()]) as $productSize): ?>
            <div class="sizeRow">
                <div class="sizeCol">
                    <label for="<?= @$productSize?->getSize()?>">Počet kusov <?= @$productSize?->getSize()?></label>
                    <input type="number" id="<?= @$productSize?->getSize()?>" name="<?= @$productSize?->getSize()?>" value="<?= @$productSize?->getQuantity()?>">
                </div>
                <div class="sizeCol">
                    <label for="<?= @$productSize?->getSize()?>_PF">Cenový faktor pre veľkosť <?= @$productSize?->getSize()?></label>
                    <input type="text" id="<?= @$productSize?->getSize()?>_PF" name="<?= @$productSize?->getSize()?>_PF" value="<?= @$productSize?->getPriceFactor()?>">
                </div>
            </div>
        <?php endforeach; ?>

        <button type="submit">Uložiť</button>
    </div>
</form>