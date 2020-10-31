<?php
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
    require_once __DIR__.DIRECTORY_SEPARATOR.'InComp/Connect.php';
    require_once __DIR__.DIRECTORY_SEPARATOR.'Variables.php';
    require_once __DIR__.DIRECTORY_SEPARATOR.'Check.php';

    $NameUser = $_POST ["Name"] ?? '';
    $LastNameUser = $_POST ["LastName"] ?? '';
    $LoginUser = $_POST ["Login"] ?? '';
    $PasswordUser = $_POST ["Password"] ?? '';
    $RePasswordUser = $_POST ["RePassword"] ?? '';
    $EmailUser = $_POST ["Email"];
    $salt = mt_rand(100,999);
    $Reg_Day = date('d');
    $Reg_Month = date('m');
    $Reg_Year = date('Y');
    $Reg_Role = 0;

    if (CheckTable($connect, $NameUserTable)){
        if ($PasswordUser != $RePasswordUser) {
            $_SESSION['Message'] = "Пароль не совпадает!";
            header("Location: reg.php");
        } else {
            $LastPasswordUser = md5(md5($PasswordUser).$salt);
            if ($connect) {
                mysqli_query($connect, "INSERT INTO `users` (`ID`, `Name`, `LastName`, `Login`, `Email`, `Password`, `Salt`, `Reg_Day`, `Reg_Monht`, `Reg_Year`, `Role`) 
                                    VALUES (NULL, '$NameUser', '$LastNameUser', '$LoginUser', '$EmailUser', '$LastPasswordUser', '$salt', '$Reg_Day', '$Reg_Month', '$Reg_Year', '$Reg_Role')");
                $_SESSION['Message'] = "Регистрация прошла успешно!";
                $Salt = mysqli_query($connect, "SELECT * FROM `users`  
                                WHERE `Login` = '$LoginUser' 
                                OR `Email` = '$EmailUser'"); 
                $_SESSION['UserInfo'] = mysqli_fetch_assoc($Salt);
                $_SESSION['ID'] = $_SESSION['UserInfo']['ID'];
                header("Location: auth.php");
            }
            else {
                $_SESSION['Message'] = "Ошибка подключения к базе данных!";
                header("Location: reg.php");
            }
        }
    } else {
        $sql = "CREATE TABLE IF NOT EXISTS $NameUserTable
                        (      
                            ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                            Name VARCHAR(25) NOT NULL,
                            LastName VARCHAR(25) NOT NULL,
                            Login VARCHAR(25) NOT NULL,
                            Email VARCHAR(50) NOT NULL,
                            Password VARCHAR(100) NOT NULL,
                            Salt int(3) NOT NULL,
                            Reg_Day int(2) NOT NULL,
                            Reg_Monht int(2) NOT NULL,
                            Reg_Year int(4) NOT NULL,
                            Role int(1) NOT NULL
                        )";
        mysqli_query($connect, $sql); //Создает таблицу
        if ($PasswordUser != $RePasswordUser) {
            $_SESSION['Message'] = "Пароль не совпадает!";
            header("Location: reg.php");
        } else {
            $LastPasswordUser = md5(md5($PasswordUser).$salt);
            if ($connect) {
                mysqli_query($connect, "INSERT INTO `users` (`ID`, `Name`, `LastName`, `Login`, `Email`, `Password`, `Salt`, `Reg_Day`, `Reg_Monht`, `Reg_Year`, `Role`) 
                                    VALUES (NULL, '$NameUser', '$LastNameUser', '$LoginUser', '$EmailUser', '$LastPasswordUser', '$salt', '$Reg_Day', '$Reg_Month', '$Reg_Year', '$Reg_Role')");
                $_SESSION['Message'] = "Регистрация прошла успешно!";
                $Salt = mysqli_query($connect, "SELECT * FROM `users`  
                                WHERE `Login` = '$LoginUser' 
                                OR `Email` = '$EmailUser'"); 
                $_SESSION['UserInfo'] = mysqli_fetch_assoc($Salt);
                $_SESSION['ID'] = $_SESSION['UserInfo']['ID'];
                header("Location: index.php");
            }
            else {
                $_SESSION['Message'] = "Ошибка подключения к базе данных!";
                header("Location: reg.php");
            }
        }
        mysqli_query($connect, $sql);
    }