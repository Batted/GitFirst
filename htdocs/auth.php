<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <!-- подключение css -->
    <script src="script.js"></script>
    <link href="img/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    <!-- иконка -->
    <title> Soulmate </title>
</head>

<body>
    <div id="page-wrap">
        <!--Прикрепление футера к низу-->
        <?php require_once __DIR__.DIRECTORY_SEPARATOR.'header.php'; ?>
        <div id="wrapper">
            <div id="articles">
                <form action="ReceptFromDataBase.php" method="post" id="authform">
                    <label>
                        <?php
                        if (isset($_SESSION['Message']) && !empty($_SESSION['Message'])) : ?>
                            <p class="ERPauth"> <?= $_SESSION['Message'] ?></p>
                        <?php endif;
                        unset($_SESSION['Message']);
                        ?>
                    </label>
                    <label for="Login">Введите логин/email</label>
                    <input type="text" id="Login" name="Login" placeholder="Введите логин/email..." />
                    <label for="Password">Введите пароль</label>
                    <input type="password" id="Password" name="Password" placeholder="Введите пароль..." />
                    <input type="submit" value="Отправить" id="send" name="send" />
                    <label> У Вас нет Аккаунта? - <a href="/reg.php">Регистрация</a></label>
                </form>
            </div>
        </div>
    </div>
    <?php require_once __DIR__.DIRECTORY_SEPARATOR.'footer.php'; ?>
</body>

</html>