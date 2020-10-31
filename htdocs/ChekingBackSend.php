<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once "Variables.php";
require_once "Check.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject = $_POST['subject'] ?? '';
    $email = $_POST['email'] ?? '';
    $name = $_POST['name'] ?? '';
    $message = $_POST['message'] ?? '';

    if(!empty($_SESSION['ID'])) $UserID = $_SESSION['UserInfo']['ID'];
    
    $subject = cleaner($subject);
    $email = cleaner($email);
    $name = cleaner($name);
    $message = cleaner($message);

    if(
        !empty($name) && !empty($subject) && !empty($email) && !empty($message) 
        ){

        $email_valclassate = filter_var($email, FILTER_VALIDATE_EMAIL);    // Проверка на mail'ы

        if (
            check_length($name, 2, 50)          // Проверка длинны строки "Имени"
            && check_length($subject, 5, 50)    // Проверка длинны строки "Темы"
            && check_length($message, 5, 250)  // Проверка длинны строки "сообщения"
            && $email_valclassate                            // Если mail'ы существует
        ) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            require_once __DIR__ . DIRECTORY_SEPARATOR . "InComp/Connect.php";
            
            if (CheckBase($NameBase)){
            } else {
                $sql = "CREATE DATABASE $NameBase";
                mysqli_query($connect, $sql);
                mysqli_select_db($connect, $NameBase);
            }
            
            if (CheckTable($connect, $NameTable)){
                $sql = "INSERT INTO $NameTable
                        VALUES (NULL, '$UserID','$name', '$email', '$subject', '$message' )";
                mysqli_query($connect, $sql);
            } else {
                $sql = "CREATE TABLE IF NOT EXISTS $NameTable
                        (
                            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                            UserID INT NOT NULL,
                            FirstName VARCHAR(50) NOT NULL,
                            Email VARCHAR(50) NOT NULL,
                            Topic VARCHAR(50) NOT NULL,
                            Request VARCHAR(250) NOT NULL
                        )";
                mysqli_query($connect, $sql);

                $sql = "INSERT INTO $NameTable 
                        VALUES (NULL, '$UserID', '$name', '$email', '$subject', '$message' )";
                        echo $sql." - sql2</br>";
                mysqli_query($connect, $sql);
            }

            $to      = $email;
            $charset = "utf-8";

            $headerss = "Content-type: text/html; charset=$charset\r<br/>";
            $headerss .= "MIME-Version: 1.0\r<br/>";
            $headerss .= "Date: " . date('D, d M Y h:i:s O') . "\r<br/>";

            $msg  = "С вашего Аккаунта было отправлено сообщение следующего содержания: <br/>";
            $msg .= "Имя пользователя: " . $name . "<br/>";
            $msg .= "Тема сообщения: " . $subject . "<br/>";
            $msg .= "<br/>$message<br/>";

            mail($email, "Soulmate, Обратная связь", $msg, $headerss);

            $to = "battedchannel@gmail.com";

            $msg = "Обратная связь с сайта 'Soulmate':<br/>";
            $msg .= "Имя пользователя: " . $name . "<br/>";
            $msg .= "Email пользователя: " . $email . "<br/><br/>";
            $msg .= "Тема сообщения: " . $subject . "<br/>";
            $msg .= "<br/>$message<br/>";

            mail($to, $subject, $msg, $headerss);
        } else {
            echo "Данные введены не корректно!<br/>";
        }
    } else {
        echo "Имеются не заполненные поля!<br/>";
    }
}

header("Location: index.php");
$_SESSION['Message'] = "Ваше сообщение отправленно!";

function cleaner($value = "")
{
    $value = trim($value);              //Отчистка от пробелов (Начало и конец)
    $value = stripslashes($value);      //Удаление слешей
    $value = strip_tags($value);        //Удаление тегов
    $value = htmlspecialchars($value);  //Преобразование спец. символов в HTML ('&' -> '&amp;')
    return $value;
}

function check_length($value = "", $min, $max)
{                        //Проверка длинны строки
    $result = (mb_strlen($value) < $min || mb_strlen($value) > $max);
    return !$result;
}
