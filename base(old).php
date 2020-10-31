<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . DIRECTORY_SEPARATOR . 'InComp/Connect.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Check.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Variables.php';

/*******************************************************/
if (isset($_POST["send_to_user"]) && is_numeric($_POST["send_to_user"])) {

    $mail = GiveEmail($connect, $NameBase, $NameTable, $i);
    $row = mysqli_fetch_assoc($mail);
    //echo "Email = " . $row['Email'] . "<br/>";

    $to = $row['Email'];
    $charset = "utf-8";
    $subject = "Поддержка сайта - Soulmate!";
    $headerss = "Content-type: text/html; charset=$charset\r<br/>";
    $headerss .= "MIME-Version: 1.0\r<br/>";
    $headerss .= "Date: " . date('D, d M Y h:i:s O') . "\r<br/>";
    $msg = "Cпасибо за Ваше обращение! В ближайшее время мы с ним разберёмся!";

    mail($to, $subject, $msg, $headerss);
}

/**************Выбор таблицы*******************/
if (!(mysqli_select_db($connect, $NameBase))) {
    echo "Error: Select DataBase.";
}
//Request = Message; FirstName = Name; # = ID;
/****************Формирование запроса**********************/
$sql = "SELECT * FROM `$NameTable`";
if (isset($_GET['search']) && isset($_GET['select']) && !empty($_GET['search'])) {
    $sql .= Search($_GET['search'], $_GET['select']);
}
if (isset($_GET["name"]) && !empty($_GET["name"])) {
    if (isset($_GET["type"]) && !empty($_GET["type"])){
        $sort = $_GET["type"];
            $sort == "DESC" ? $sort = "ASC" : $sort = "DESC";
    } else {
        $sort = "ASC";
    }
    $sql .= SortTable($_GET["name"], $sort);
    echo "Name = " . $_GET["name"] . "<br/>"; 
    echo "Sort = " . $sort . "<br/>"; 
}


echo "$sql - SQL Code <br/>";
/*******************************************************/
if (!($SQL_res = mysqli_query($connect, $sql))) {
    echo "Error: Query connect.";
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
    <!--<script language='JavaScript' type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js'></script>
    -->
</head>

<body>
    <div id="page-wrap">
        <!--Прикрепление футера к низу-->
        <header>
            <a href="index.php" title="На главную" id="logo">Soulmate</a>
            <span class="contact">
                <a href="about.html" title="Информация о нас">О нас</a>
            </span>
            <input type="text" class="field" placeholder="Найти.." />
            <span class="right" class="contact">
                <a href="reg.php" title="Зарегистрироваться">Регистрация</a>
            </span>
            <span class="right" class="contact">
                <a href="auth.php" title="Войти">Вход</a>
            </span>
        </header>
        <form type="GET">
            <table class="TableBase" border=1>
                <tr>
                    <th width="5%" mergin="center">
                    
                        <?php echo "<a href= " . "?search=" . $_GET['search']
                            . "&select=" . $_GET['select'] . "&name=id" . "&type=$sort" . ">#</a>" ?></th>
                    <th width="10%">
                        <?php echo "<a href= " . "?search=" . $_GET['search']
                            . "&select=" . $_GET['select'] . "&name=FirstName" . "&type=$sort" . ">Name</a>" ?></th>
                    <th width="20%">
                        <?php echo "<a href= " . "?search=" . $_GET['search']
                            . "&select=" . $_GET['select'] . "&name=Email" . "&type=$sort" . ">Email</a>" ?></th>
                    <th width="25%">
                        <?php echo "<a href= " . "?search=" . $_GET['search']
                            . "&select=" . $_GET['select'] . "&name=Topic" . "&type=$sort" . ">Topic</a>" ?></th>
                    <th width="35%">
                        <?php echo "<a href= " . "?search=" . $_GET['search']
                            . "&select=" . $_GET['select'] . "&name=Request" . "&type=$sort" . ">Message</a>" ?></th>
                </tr>
                <?php
                while ($arr = mysqli_fetch_assoc($SQL_res)) : ?>
                    <tr mergin="center">
                        <td> <?= $arr['id'] ?></td>
                        <td> <?= $arr['FirstName'] ?></td>
                        <td> <?= $arr['Email'] ?></td>
                        <td> <?= $arr['Topic'] ?></td>
                        <td> <?= $arr['Request'] ?></td>
                        <td>
                            <button formmethod="POST" name="send_to_user" value="<?= $arr['id'] ?>"> send <?= $arr['id'] ?>
                            </button>
                        </td>
                    </tr>
                <?php endwhile; ?>
        </form>
        <form>
            <input type="text" name="search" class="search_text" placeholder="Найти.." />
            <select class="search_select" name="select">
                <option>Select</option>
                <option>ID</option>
                <option>Name</option>
                <option>Email</option>
                <option>Topic</option>
                <option>Request</option>
            </select>
            <input type="submit" class="updatebase_submit" value="Поиск" />
        </form>
        </table>
    </div>
    <footer>
        <span class="left">Все права защищены &copy; 2020</span>
        <span class="right">
            <a href="https://vk.com/catism" target="_blank" alt="Группа ВК">
                <img src="img/1VK.png" alt="Группа ВК" title="Группа ВК" />
            </a>
            <a href="base.php" alt="База данных">
                <img src="img/bd.png" alt="База данных" title="База данных" />
            </a>
        </span>
    </footer>
</body>

</html>