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
            <div class="articles">
                <form action="SendToDataBase.php" method="post" id="form" name="form">
                    <label for="login">Введите Имя</label>
                    <input type="text" id="Name" name="Name" placeholder="Введите имя..." />
                    <label for="login">Введите Фамилию</label>
                    <input type="text" id="LastName" name="LastName" placeholder="Введите фамилию..." />
                    <label for="login">Введите логин</label>
                    <input type="text" id="Login" name="Login" placeholder="Введите логин..." />
                    <label for="password">Введите пароль</label>
                    <input type="password" id="Password" name="Password" placeholder="Введите пароль..." />
                    <label for="password">Введите пароль еще раз</label>
                    <input type="password" id="RePassword" name="RePassword" placeholder="Повторите пароль..." />
                    <label for="email">Email</label>
                    <input type="text" id="Email" name="Email" placeholder="adress@gmail.com" />
                    <input type="submit" value="Зарегистрироваться" id="send" name="send" />
                    <label>
                        У вас имеется аккаунт? - <a href="/auth.php">Авторизоваться</a>
                    </label>
                    <label>
                        <?php
                        if (isset($_SESSION['Message']) && !empty($_SESSION['Message'])) : ?>
                            <p class="ERPauth"> <?= $_SESSION['Message'] ?></p>
                        <?php endif;
                        unset($_SESSION['Message']);
                        ?>
                    </label>
                </form>
            </div>
        </div>
    </div>
    <?php require_once __DIR__.DIRECTORY_SEPARATOR.'footer.php'; ?>
</body>

</html>