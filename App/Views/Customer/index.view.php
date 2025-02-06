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
        <form action="<?= $link->url('customer.edit')?>" method="post">
            <div class="customerAttributes">
                <div>
                    <label for="email">E-mail</label>
                </div>
                <input type="text" name="email" id="email" disabled value="<?= $user->getEmail() ?>">
                <div>
                    <label for="name">Meno a priezvisko</label>
                </div>
                <input type="text" name="name" id="name" value="<?= $user->getName() ?>">
                <div>
                    <label for="street">Ulica</label>
                </div>
                <input type="text" name="street" id="street" value="<?= $user->getStreet() ?>">
                <div>
                    <label for="postal">PSČ</label>
                </div>
                <input type="text" name="postal" id="postal" value="<?= $user->getPostalCode() ?>">
                <div>
                    <label for="city">Mesto</label>
                </div>
                <input type="text" name="city" id="city" value="<?= $user->getCity() ?>">
                <div>
                    <label for="country">Krajina</label>
                </div>
                <select name="country" id="country">
                    <option <?php if (strcmp($user->getCountry(), 'NO_VAL') === 0) echo 'selected' ?> value="NO_VAL"></option>
                    <option <?php if (strcmp($user->getCountry(), 'CZE') === 0) echo 'selected' ?> value="CZE">Česká republika</option>
                    <option <?php if (strcmp($user->getCountry(), 'HUN') === 0) echo 'selected' ?> value="HUN">Maďarsko</option>
                    <option <?php if (strcmp($user->getCountry(), 'GER') === 0) echo 'selected' ?> value="GER">Nemecko</option>
                    <option <?php if (strcmp($user->getCountry(), 'POL') === 0) echo 'selected' ?> value="POL">Poľsko</option>
                    <option <?php if (strcmp($user->getCountry(), 'AUT') === 0) echo 'selected' ?> value="AUT">Rakúsko</option>
                    <option <?php if (strcmp($user->getCountry(), 'SVK') === 0) echo 'selected' ?> value="SVK">Slovensko</option>
                    <option <?php if (strcmp($user->getCountry(), 'UKR') === 0) echo 'selected' ?> value="UKR">Ukrajina</option>
                </select>
                <button type="submit">Uložiť</button>
            </div>
        </form>
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
