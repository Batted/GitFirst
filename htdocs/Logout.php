<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

unset($_SESSION['ID']);
unset($_SESSION['UserInfo']['Role']);
unset($_SESSION['UserInfo']);
header("Location: index.php");