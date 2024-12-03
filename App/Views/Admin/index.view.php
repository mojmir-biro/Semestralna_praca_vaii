<?php

/** @var \App\Core\IAuthenticator $auth */ ?>


<div class="container">
    Vitaj, <strong><?= $auth->getLoggedUserName() ?></strong>!<br><br>
    Táto časť aplikácie je prístupná len po prihlásení.
    <a href="<?= $link->url("auth.logout") ?>"><h1>Odhlásenie</h1></a>

</div>