<?php

$layout = 'root';
/** @var Array $data */
/** @var \App\Core\LinkGenerator $link */
?>

<div class="container">
    <div class="loginContainer">
        <form method="post" action="<?= $link->url("register") ?>">
            <div class="loginForm">
                <label for="name">Meno Priezvisko</label>
                <input name="name" type="text" id="name" placeholder="Meno Priezvisko" required autofocus>
                <label for="email">E-mail</label>
                <input name="email" type="email" id="email" placeholder="E-mail" required>
                <label for="password">Heslo</label>
                <input name="password" type="password" id="password" placeholder="Heslo" required>
                <label for="confirmPassword">Potvrďte heslo</label>
                <input name="confirmPassword" type="password" id="confirmPassword" placeholder="Heslo" required>
                <button name="submit" type="submit">Zaregistrovať</button>
                <span class="incorrectLogin"><?= @$data['message'] ?></span>
            </div>
        </form>
    </div>
</div>