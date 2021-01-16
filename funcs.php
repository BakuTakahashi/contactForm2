<?php
//共通に使う関数

//XSS対応
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES);
}

//DB接続関数
function db_con()
{
    try {
        $db_name = "results_db";    //データベース名
        $db_id   = "root";      //アカウント名
        $db_pw   = "root";      //パスワード：XAMPPはパスワード無しに修正してください。
        $db_host = "localhost"; //DBホスト
        $pdo = new PDO('mysql:dbname='.$db_name.';charset=utf8;host='.$db_host, $db_id, $db_pw);
        return $pdo;
    } catch (PDOException $e) {
        exit('DB Connection Error:'.$e->getMessage());
    }
}

function sql_error($stmt){

    $error = $stmt->errorInfo();
    exit("SQLError:".$error[2]);
}

function redirect($file_name){

    header("Location: $file_name");
    exit();
}




