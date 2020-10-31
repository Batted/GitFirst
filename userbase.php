<?php
$StatusCode = 200;
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . DIRECTORY_SEPARATOR . 'InComp/Connect.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Check.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Variables.php';

if (!isset($_SESSION['UserInfo']['Role']) || empty($_SESSION['UserInfo']['Role'])) {
    header("HTTP/1.1 401 Unauthorized");
    $StatusCode = 401;
} else if ($_SESSION['UserInfo']['Role'] == 2) {
    if (isset($_POST["User_up"])) {
        $id = $_POST['User_up'];
        if ($sqli = mysqli_query($connect, "SELECT * FROM `users` WHERE `ID` = '$id'")) {
            $info = mysqli_fetch_assoc($sqli);
            if ($info['Role'] < 2) {
                $plus = $info['Role'] + 1;
                if (!mysqli_query($connect, "UPDATE `users` SET `Role` = $plus WHERE `ID` = $id ")) {
                    echo "UP - Not Complited</br>";
                }
            }
        }
    }
    if (isset($_POST["User_down"])) {
        $id = $_POST['User_down'];
        if ($sqli = mysqli_query($connect, "SELECT * FROM `users` WHERE `ID` = $id")) {
            $info = mysqli_fetch_assoc($sqli);
            if ($info['Role'] > 0) {
                $plus = $info['Role'] - 1;
                if (!mysqli_query($connect, "UPDATE `users` SET `Role` = $plus WHERE `ID` = $id ")) {
                    echo "Down - Not Complited</br>";
                }
            }
        }
    }
} else {
    header("HTTP/1.1 403 Forbidden");
    $StatusCode = 403;
}

$sql = "SELECT * FROM `$NameUserTable`";
if (isset($_GET['search']) && isset($_GET['select']) && !empty($_GET['search'])) {
    $sql .= Search($_GET['search'], $_GET['select']);
}

$sortDirection = trim($_GET["type"] ?? 'ASC') ?: 'ASC';
$sortName      = trim($_GET["name"] ?? 'id') ?: 'id';

$sql .= SortTable($sortName, $sortDirection);

//Структура данных
$tableHeaders = [
    'ID'        => [
        'href' => '',
        'title' => '#'
    ],
    'Name' => [
        'href' => '',
        'title' => 'Name'
    ],
    'LastName' => [
        'href' => '',
        'title' => 'LastName'
    ],
    'Login'     => [
        'href' => '',
        'title' => 'Login'
    ],
    'Email'     => [
        'href' => '',
        'title' => 'Email'
    ],
    'Reg_Day'   => [
        'href' => '',
        'title' => 'Day'
    ],
    'Reg_Monht' => [
        'href' => '',
        'title' => 'Monht'
    ],
    'Reg_Year'  => [
        'href' => '',
        'title' => 'Year'
    ],
    'Role'      => [
        'href' => '',
        'title' => 'Role'
    ],
];

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

/**************Проверка на ошибку при запросе********************/
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
        <?php require_once __DIR__ . DIRECTORY_SEPARATOR . 'header.php'; ?>
        <div class="contact">
            <?php
            if (isset($_SESSION['Message']) && !empty($_SESSION['Message'])) : ?>
                <p class="ERPauth"> <?= $_SESSION['Message'] ?></p>
            <?php endif;
            ?>
        </div>
        <?php if ($StatusCode == 200) : ?>
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
                            <td> <?= $arr['ID'] ?></td>
                            <td> <?= $arr['Name'] ?></td>
                            <td> <?= $arr['LastName'] ?></td>
                            <td> <?= $arr['Login'] ?></td>
                            <td> <?= $arr['Email'] ?></td>
                            <td> <?= $arr['Reg_Day'] ?></td>
                            <td> <?= $arr['Reg_Monht'] ?></td>
                            <td> <?= $arr['Reg_Year'] ?></td>
                            <td> <?= $arr['Role'] ?></td>
                            <?php if ($_SESSION['UserInfo']['Role'] == 2) : ?>
                                <td>
                                    <button formmethod="POST" name="User_up" value="<?= $arr['ID'] ?>">
                                        Up
                                    </button>
                                </td>
                                <td>
                                    <button formmethod="POST" name="User_down" value="<?= $arr['ID'] ?>">
                                        Down
                                    </button>
                                </td>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endwhile; ?>
                    <input type="text" name="search" class="search_text" placeholder="Найти.." />
                    <select class="search_select" name="select">
                        <option>Select</option>
                        <option>ID</option>
                        <option>Name</option>
                        <option>LastName</option>
                        <option>Login</option>
                        <option>Email</option>
                        <option>Day</option>
                        <option>Monht</option>
                        <option>Year</option>
                        <option>Role</option>
                    </select>
                    <input type="submit" class="updatebase_submit" value="Поиск" />
                </table>
            </form>
        <?php
        else :
        ?>
            <h1> Status Code: <?php echo $StatusCode ?> </h1>
        <?php
        endif;
        ?>
    </div>
    <?php require_once __DIR__ . DIRECTORY_SEPARATOR . 'footer.php'; ?>
</body>

</html>