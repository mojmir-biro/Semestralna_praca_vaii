<?php

$layout = 'root';
/** @var Array $data */
/** @var \App\Core\LinkGenerator $link */

use App\Models\User;
use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\Product;
use App\Models\ProductSize;

?>

<div class="container">
    
    <h1>Nákupný košík</h1>

    <?
    $users = User::getAll('`email` = ?', [$this->app->getAuth()->getLoggedUserId()]);
    $user = $users[0];
    
    $baskets = Basket::getAll('`customerId` = ?', [$user->getId()]);
    if (sizeof($baskets) === 0) { ?>
    <div class="basketItems">
        <h2>Košík je prázdny</h2>

    </div>
    <? } else {
        $basket = $baskets[0];
        $counter = 0;
        $sumPrice = 0;
        $basketItems = BasketItem::getAll('`basketId` = ?', [$basket->getId()]);
        ?> <div class="basketItems"> <?
        foreach($basketItems as $bi) {
            $prodSize = ProductSize::getOne($bi->getProductSizeId());
            $prod = Product::getOne($prodSize->getProductId());
            $price = round($prod->getPrice() * $prodSize->getPriceFactor(), 2);
            ?>
            <div class="basketItem">
                <div class="basketItemName">
                    <a href="<?=$link->url('product.display', ["id" => $prod->getId()])?>"><?= $prod->getName() . " - " . $prodSize->getSize() ?></a>
                </div>
                <div class="basketItemPricing">
                    <?= $bi->getQuantity() . " x " . $price . " = " . $price * $bi->getQuantity() ?>
                </div>
                <a href="<?= $link->url('basket.remove', ['id' => $bi->getId()]) ?>"><button>Odobrať</button></a>
            </div>
            <?
            $counter++;
            $sumPrice += $price * $bi->getQuantity();
            
        }
        if ($counter === 0) { ?>
            <h2>Košík je prázdny</h2>
            </div>
        <? } else { ?>
            </div>
            Cena celkom: <?= $sumPrice ?>
            <a href="<?= $link->url('basket.confirm', ['id' => $basket->getId()]) ?>"><button>Objednať</button></a>
            <a href="<?= $link->url('basket.delete', ['id' => $basket->getId()]) ?>"><button>Vyprázdniť košík</button></a>
        <? }
    }
    ?>
    
</div>