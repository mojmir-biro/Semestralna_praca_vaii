<?php

/** @var string $contentHTML */
/** @var \App\Core\IAuthenticator $auth */
/** @var \App\Core\LinkGenerator $link */
?>
<!DOCTYPE html>
<html lang="sk-SK">
    <head>
        <meta charset="utf-8">
        <title><?= \App\Config\Configuration::APP_NAME ?></title>
        <link rel="icon" type="image/x-icon" href="public/images/placeholder_icon.png">
        <link rel="stylesheet" href="/public/css/style.css">
    </head>
    <body>
        <div class="topBar">
            <img src="public/images/placeholder_icon.png" alt="logo">
            <a href="<?= $link->url("home.index") ?>"><h1>E-shop</h1></a>
            <p class="spacer"></p>

            <?php if ($auth->isLogged()) { ?>
                <a href="<?= $link->url("admin.index") ?>"><h1><?= $auth->getLoggedUserId() ?></h1></a>
            <?php } else { ?>
                <a href=<?= \App\Config\Configuration::LOGIN_URL ?>><h1>Prihlásenie</h1></a>
            <?php } ?>

        </div>

        <?= $contentHTML ?>

        <div class="returnToTop">
            <a href="#">▲</a>
        </div>

        <div class="footer">
            <div class="insideLinks">
                <h3>Odkazy</h3>
                <a href="<?= $link->url("home.faq") ?>">FAQ</a>
                <a>Kontakt</a>
                <a href="login_form.html">Prihlásenie</a>
            </div>
            <div class="outsideLinks">
                <h3>Sociálne siete</h3>
                <a href="" target="blank">X</a>
                <a href="" target="blank">Instagram</a>
                <a href="" target="blank">Facebook</a>
            </div>
        </div>
    </body>
</html>