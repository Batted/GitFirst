<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <a href="index.php" title="На главную" id="logo">
        Soulmate
    </a>
    <span class="contact">
        <a href="about.php" title="Информация о нас">
            О нас
        </a>
    </span>
    <input type="text" class="field" placeholder="Найти.." />
    <?php
    if (!empty($_SESSION["ID"])) : ?>
        <span class="right" class="contact">
            <a href="logout.php" title="Выход">
                Выход
            </a>
        </span>
    <?php 
    else : ?>
        <span class="right" class="contact">
            <a href="reg.php" title="Зарегистрироваться">
                Регистрация
            </a>
        </span>
        <span class="right" class="contact">
            <a href="auth.php" title="Войти">
                Вход
            </a>
        </span>
        <?php
    endif;
    ?>
</header>