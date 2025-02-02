<?php

use App\App;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\User;

$layout = 'root';
/** @var \App\Core\IAuthenticator $auth */ ?>

<div class="container">
    <div class="section">
        <div class="sectionHeader">
            Profilové údaje
        </div>
        <?
        $queryResult = User::getAll('`email` = ?', [$this->app->getAuth()->getLoggedUserId()]);
        $user = $queryResult[0];
        ?>
        <?= $user->getName() ?> <?= $user->getEmail() ?>
    </div>
    <div class="section">
        <div class="sectionHeader">
            Objednávky
        </div>
        <?
        
        $orders = Order::getAll('`customerId` = ?', [$user->getId()]);
        $counter = 0;
        foreach ($orders as $order) {
            $counter++;
            ?> <div class="order"> 
                    <h2>Číslo objednávky: <?= $order->getId() ?></h2>
            <?
            $oi = OrderItem::getAll('`orderId` = ?', [$order->getId()]);
            $orderPrice = 0;
            foreach ($oi as $item) {
                $prodSize = ProductSize::getOne($item->getProductSizeId());
                $prod = Product::getOne($prodSize->getProductId());
                $price = round($prod->getPrice() * $prodSize->getPriceFactor(), 2);
                ?> <div class="orderItem"> <?
                    echo $item->getQuantity() . " x " . $prod->getName() . " (" . $prodSize->getSize() . ") - " . $price . "<br>";
                ?> </div> <?
                $orderPrice += ($price * $item->getQuantity());
            }
            ?>
                Cena celkom: <?= $orderPrice ?>
                </div>
            <?
        }
        if ($counter === 0) {
            ?>
            <div class="order">
                <h2>Žiadne objednávky</h2>
            </div>
            <?
        }
        ?>
    </div>
</div>
