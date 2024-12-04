<?php

$layout = 'root';
/** @var \App\Core\IAuthenticator $auth */ ?>

<div class="container">
    Vitaj, <strong><?= $auth->getLoggedUserName() ?></strong>!<br><br>
    Táto časť aplikácie je prístupná len po prihlásení.
    <a href="<?= $link->url("auth.logout") ?>"><h3>Odhlásenie</h3></a>

    <h2>Zoznam produktov</h2>

    <div class="listProducts">
        <div class="listHeader listItem">
            <div class="listCol">ID</div>
            <div class="listCol">Názov</div>
            <div class="listCol">Cena</div>
            <div class="listCol">
                Akcie
                <button>Pridať produkt</button>
            </div>
        </div>
        <div class="listItem">
            <div class="listCol">0000000001</div>
            <div class="listCol">Nike Air Jordan 1 Mid Retro Red</div>
            <div class="listCol">169,99</div>
            <div class="listCol">
                <button>Upraviť</button>
                <button>Vymazať</button>
            </div>
        </div>
    </div>

</div>