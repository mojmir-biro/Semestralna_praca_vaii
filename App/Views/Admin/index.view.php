<?php

use App\App;
use App\Models\Product;

$layout = 'root';
/** @var \App\Core\IAuthenticator $auth */ ?>

<div class="container">
    Vitaj, <strong><?= $auth->getLoggedUserName() ?></strong>!<br><br>
    Táto časť aplikácie je prístupná len po prihlásení.
    <a href="<?= $link->url("auth.logout") ?>"><h3>Odhlásenie</h3></a>

    <!-- Výsledok poslednej akcie:
    
    <?php if (@$data['result'] != null) { ?>
        <?= @$data['result'] ?>
    <?php } else { ?>
        Žiadna akcia
    <?php } ?> -->

    <h2>Zoznam produktov</h2>

    <div class="listProducts">
        <div class="listHeader listItem">
            <div class="listCol">ID</div>
            <div class="listCol">Názov</div>
            <div class="listCol">Cena</div>
            <div class="listCol">
                Akcie
                <a href="<?= $link->url('product.add') ?>"><button>Pridať produkt</button></a>
            </div>
        </div>
        
        <?php foreach (Product::getAll() as $product): ?>

            <div class="listItem">
                <div class="listCol"><?= $product->getId() ?></div>
                <div class="listCol"><?= $product->getName() ?></div>
                <div class="listCol"><?= $product->getPrice() ?></div>
                <div class="listCol">
                    <a href="<?= $link->url('product.edit', ['id' => $product->getId()]) ?>"><button>Upraviť</button></a>
                    <a href="<?= $link->url('product.delete', ['id' => $product->getId()]) ?>"><button>Vymazať</button></a>
                </div>
            </div>

        <?php endforeach; ?>

    </div>

</div>