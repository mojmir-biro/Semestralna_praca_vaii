<?php

use App\Models\ProductSize;

$productSizes = ProductSize::getAll('`productId` = ?', [@$data['product']?->getId()], orderBy: '`id` asc');
$count = 0;

$layout = 'root'; 
?>

<div class="container">
    <div class="section">
        <div class="sectionHeader">
            <?= @$data['product']?->getName() ?>
        </div>
        <div class="productWrapper">
            <div class="productImage">
                <img src="public/images/<?= @$data['product']?->getThumbnail() ?>">
            </div>
            <div class="prodDescAndPrice">
                <div class="productDescription">
                    Farba: <?= @$data['product']?->getColour() ?><br>
                    Popis produktu<br>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Quod, modi neque dignissimos exercitationem vitae porro illo qui eaque. Sequi, neque cumque. Laudantium nobis voluptatem aperiam, a fugiat minima ad consectetur?
                </div>
                <p class="spacer"></p>
                <div class="productPricing">
                    <form action="<?= $link->url('basket.add', ["id" => @$data['product']?->getId()])?>" method="post">
                        <?= @$data['product']?->getPrice() ?>€<br>
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
                            Nie je na sklade
                        <?php } else { ?>
                            <button type="submit">Pridať do košíka</button>
                        <?php } ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>