<?php

function CheckConnect($CC_Host, $CC_UserName, $CC_Password){
    $connect = mysqli_connect($CC_Host, $CC_UserName, $CC_Password);
    if (!$connect) {
        return false;
    }
    return true;
}

function CheckBase($CB_NameBase){
    if (mysqli_connect('localhost', 'root', 'root', $CB_NameBase)) {
        return true; 
    }
    return false;
}

function CheckTable($CT_Connect, $CT_NameTable){
    $sql = "SELECT TABLE LIKE $CT_NameTable";
    if (mysqli_query($CT_Connect, $sql)){
        return true;
    }
    return false;
}

function Search($S_Search, $S_Sort){
    if (!($S_Sort == "Select" || empty($S_Search))){
        if ($S_Sort == "Name") $S_Sort = "FirstName";
        return " `$S_Sort` LIKE \"%$S_Search%\"";
    } 
    return "";
}

function SortTable($ST_Sort,$ST_type){
    return " ORDER BY `$ST_Sort` $ST_type";
}

function GiveEmail($GE_Connect, $GE_NameTable, $GE_ID){
    $sql = "SELECT `Email` FROM `$GE_NameTable`
             WHERE `ID` = \"$GE_ID\"";
             echo "SQL = $sql<br/>";
    return mysqli_query($GE_Connect, $sql);
}