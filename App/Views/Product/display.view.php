<?php

use App\Models\ProductSize;

$productSizes = ProductSize::getAll('`productId` = ?', [@$data['product']?->getId()], orderBy: '`id` asc');
$count = 0;

$layout = 'root'; 
?>

<div class="container">
    <img src="public/images/<?= @$data['product']?->getThumbnail() ?>">
    <h1><?= @$data['product']?->getName() ?></h1>
    <?= @$data['product']?->getPrice() ?><br>

    <form action="<?= $link->url('basket.add', ["id" => @$data['product']?->getId()])?>" method="post">
        <label for="size">Veľkosť</label>
        <select name="size" id="size">
            <?php foreach ($productSizes as $ps): ?>
                <option value="<?= @$ps?->getSize()?>" 
                <?php if (@$ps?->getQuantity() === 0) { $count++ ?>
                    disabled
                <?php } ?>
                ><?= @$ps?->getSize()?></option>        
            <?php endforeach; ?>
        </select>
        <?php if ($count === 5) { ?>
            <h1>Nie je na sklade</h1>
        <?php } else { ?>
            <button type="submit">Pridať do košíka</button>
        <?php } ?>
    </form>
</div>