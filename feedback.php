<?php
    if(session_status() == PHP_SESSION_NONE){
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
        <div class="wrapper">
            <div class="articles">
                <form action="ChekingBackSend.php" method="post" class="feedback">
                    <label for="subject">Тема сообщения</label>
                    <input type="text" class="subject" name="subject" placeholder="Тема сообщения" />
                    <label for="email">Email</label>
                    <input type="email" class="email" name="email" placeholder="user@email.com"
                        <?php if (isset($_SESSION["ID"], $_SESSION["UserInfo"]["Email"])) : ?> 
                            value= "<?php echo $_SESSION["UserInfo"]["Email"]?>" 
                        <?php endif; ?>/>
                    <label for="name">Введите ваше имя</label>
                    <input type="text" class="name" name="name" placeholder="Введите ваше имя" 
                        <?php if (isset($_SESSION["ID"], $_SESSION["UserInfo"]["Name"])) : ?>
                             value= "<?php echo $_SESSION["UserInfo"]["Name"]?>" 
                        <?php endif; ?>/>
                    <label for="message">Введите ваше сообщение</label>
                    <textarea class="message" name="message" placeholder="Введите ваше сообщение"></textarea>
                    <input type="submit" value="Отправить" id="send" name="send" />
                </form>
            </div>
        </div>
    </div>
    <?php require_once __DIR__.DIRECTORY_SEPARATOR.'footer.php'; ?>
</body>

</html>