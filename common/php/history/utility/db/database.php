<?php

/**
 * PHPでデータベースに接続するときのまとめ
 * https://qiita.com/mpyw/items/b00b72c5c95aac573b71
 * 
 * 
 * database.php
 * @since 2018/09/18
 */

// 接続
// $basePdo = connect();


function h($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'utf-8');
}

function connect() {
    
    // $dsn = 'mysql:host=mysql1.php.xdomain.ne.jp;dbname=agplant_labo;charset=utf8;';
    // $username = 'agplant_root';
    // $password = 'passworddesuyo';
    $dsn = 'mysql:host=localhost;dbname=agplant;charset=utf8mb4;';
    $username = 'root';
    $password = '';
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        // PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];
    try {
        $pdo = new PDO($dsn, $username, $password, $options);
    } 
    catch(PDOException $ex) {
        // header('Content-Type: text/plain; charset=UTF-8', true, 500);
        // exit($ex->getMessage()); 
        // return $ex->getMessage();
        throw $ex;
    }

    return $pdo;
}
