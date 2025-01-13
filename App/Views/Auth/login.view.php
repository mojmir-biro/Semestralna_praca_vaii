<?php

$layout = 'root';
/** @var Array $data */
/** @var \App\Core\LinkGenerator $link */
?>

<div class="container">
    <div class="loginContainer">
        <form method="post" action="<?= $link->url("login") ?>">
            <div class="loginForm">
                <label for="email">E-mail</label>
                <input name="email" type="email" id="email" placeholder="E-mail" required autofocus>
                <label for="password">Heslo</label>
                <input name="password" type="password" id="password" placeholder="Heslo" required>
                <button name="submit" type="submit">Prihlásiť</button>
                <span class="incorrectLogin"><?= @$data['message'] ?></span>
            </div>
        </form>
        <a href="<?= $link->url('auth.register') ?>">
            <div class="loginForm">
                Ešte nemáte účet? Zaregistrujte sa teraz.
            </div>
        </a>
    </div>
    
</div>