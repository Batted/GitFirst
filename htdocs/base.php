<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . DIRECTORY_SEPARATOR . 'InComp/Connect.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Check.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Variables.php';

/*******************************************************/

if (isset($_SESSION['UserInfo']) && $_SESSION['UserInfo']['Role'] >= 1) {
    if (isset($_POST["send_to_user"]) && is_numeric($_POST["send_to_user"])) {
        $id = $_POST["send_to_user"];
        $mail = GiveEmail($connect, $NameBase, $NameTable, $id);
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

    if ($_SESSION['UserInfo']['Role'] == 2) {
        if (isset($_POST["send_delete"])) {
            $id = $_POST['send_delete'];
            if (!mysqli_query($connect, "DELETE FROM `$NameTable` WHERE `ID` = '$id'")) {
                echo "Delete- Not Complited</br>";
            }
        }
    } else {
        header("HTTP/1.1 403 Forbidden");
    }
} else {
    header("HTTP/1.1 403 Forbidden");
}
if (!isset($_SESSION['UserInfo']) || empty($_SESSION['UserInfo']['Role'])) {
    header("HTTP/1.1 401 Unauthorized");
}
//ВЫВОД ОШИБКИ 401 402 403 и т.д. (Мол нет доступа)

/****************Формирование запроса**********************/
$sql = "SELECT * FROM `$NameTable`";
if ($_SESSION['UserInfo']['Role'] < 1) {
    $iduser = $_SESSION['UserInfo']['ID'];
    echo $iduser . " - id User</br>";
    $sql .= " WHERE `UserID` = $iduser";
}

if (isset($_GET['search']) && isset($_GET['select']) && $_GET['select'] != "Select" && !empty($_GET['search'])) {
    if (!empty($_SESSION['ID']) && $_SESSION['UserInfo']['Role'] > 1) $sql .= " WHERE";
    else $sql .= " AND";
    $sql .= Search($_GET['search'], $_GET['select']);
}


$sortDirection = trim($_GET["type"] ?? 'ASC') ?: 'ASC';
$sortName      = trim($_GET["name"] ?? 'id') ?: 'id';

$sql .= SortTable($sortName, $sortDirection);

$tableHeaders = [
    'ID'        => [
        'href'  => '',
        'title' => '#'
    ],

    'FirstName' => [
        'href'  => '',
        'title' => 'First Name'
    ],

    'Email'     => [
        'href'  => '',
        'title' =>  'Email'
    ],

    'Topic'     => [
        'href'  => '',
        'title' => 'Topic'
    ],

    'Request'   => [
        'href'  => '',
        'title' => 'Message'
    ]
];

if ($_SESSION['Role'] >= 1) {
    $tableHeaders[] = [
        '' => [
            'href' => '#',
            'title' => '&nbsp;'
        ]
    ];
};

$filteredGET = array_filter($_GET);

foreach ($tableHeaders as $index => $params) {
    if ($index == '') {
        continue;
    }

    $colSortDir = $index == $sortName ? ($sortDirection == "DESC" ? "ASC" : "DESC") : 'ASC';

    $query = $filteredGET;

    $query['name'] = $index;
    $query['type'] = $colSortDir;

    $tableHeaders[$index]['href'] = '?' . http_build_query($query);
}

/*******************************************************/
echo $sql . " = Query SQL</br>";
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
        <?php require_once __DIR__ . DIRECTORY_SEPARATOR . "header.php"; ?>
        <form type="GET">
            <table class="TableBase" border=1>
                <tr>
                    <?php foreach ($tableHeaders as $params) : ?>
                        <th mergin="center">
                            <a href="<?= $params['href']; ?>"><?= $params['title']; ?></a>
                        </th>
                    <?php endforeach; ?>
                </tr>
                <?php
                while ($arr = mysqli_fetch_assoc($SQL_res)) : ?>
                    <tr mergin="center">
                        <td> <?= $arr['id'] ?></td>
                        <td> <?= $arr['FirstName'] ?></td>
                        <td> <?= $arr['Email'] ?></td>
                        <td> <?= $arr['Topic'] ?></td>
                        <td> <?= $arr['Request'] ?></td>
                        <?php if ($_SESSION['UserInfo']['Role'] >= 1) : ?>
                            <td>
                                <button formmethod="POST" name="send_to_user" value="<?= $arr['id'] ?>">
                                    send <?= $arr['id'] ?>
                                </button>
                            </td>
                            <?php if ($_SESSION['UserInfo']['Role'] == 2) : ?>
                                <td>
                                    <button formmethod="POST" name="send_delete" value="<?= $arr['id'] ?>">
                                        Delete
                                    </button>
                                </td>
                            <?php endif; ?>
                        <?php endif; ?>
                    </tr>
                <?php endwhile; ?>
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

            </table>
        </form>
    </div>
    <?php require_once __DIR__ . DIRECTORY_SEPARATOR . 'footer.php'; ?>
</body>

</html>