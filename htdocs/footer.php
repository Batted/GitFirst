<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<footer>
    <span class="left">Все права защищены &copy; 2020</span>
    <span class="right">
        <a href="https://vk.com/catism" target="_blank" alt="Группа ВК">
            <img src="img/1VK.png" alt="Группа ВК" title="Группа ВК" />
        </a>
        <?php
        if (!empty($_SESSION["ID"])) : 
            if($_SESSION['UserInfo']['Role']>=1) :?>
                <a href="userbase.php" alt="Пользователи">
                    <img src="img/bd.png" alt="Пользователи" title="Пользователи" />
                </a>
            <?php endif; ?>
                <a href="base.php" alt="База данных">
                    <img src="img/bd.png" alt="База данных" title="База данных" />
                </a>
        <?php 
        endif; 
        ?>
    </span>
</footer>