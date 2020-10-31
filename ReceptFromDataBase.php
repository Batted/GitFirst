<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . DIRECTORY_SEPARATOR . 'InComp/Connect.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Variables.php';

$LoginUser = $_POST["Login"] ?? '';
$PasswordUser = $_POST["Password"] ?? '';


$Salt = mysqli_query($connect, "SELECT * FROM `users`  
                            WHERE `Login` = '$LoginUser' 
                            OR `Email` = '$LoginUser'");
$UserInformation = mysqli_fetch_assoc($Salt);
$LPU = md5(md5($PasswordUser) . $UserInformation['Salt']);  //Введенный пароль с солью от логина или пароля
if ($LPU == $UserInformation['Password']) {
    $_SESSION['ID'] = $UserInformation["ID"];
    $_SESSION['Message'] = "Вы вошли в аккаунт: " . $LoginUser;
    $_SESSION["UserInfo"] = $UserInformation; //Получаем всю строку где логин или имя совпадает
    header("Location: index.php");
} else {
    $_SESSION['Message'] = "Вы ввели неправильные данные!";
    header("Location: auth.php");
}
