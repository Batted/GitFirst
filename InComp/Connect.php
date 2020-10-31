<?php
require_once "Variables.php";

if(!($connect = mysqli_connect($Host, $UserName, $Password))){
    die("Error connect!"); //Полная остановка при отсутствии подключения
}
if (!mysqli_select_db($connect, $NameBase)) {
    die("Error connect DataBase!");
}
