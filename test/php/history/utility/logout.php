<?php
require_once 'Path.php';
require_once UtilityPath::DEFINE_PATH;

  $_SESSION = array();
  // セッションクッキーを削除
  if (isset($_COOKIE["PHPSESSID"])) {
    setcookie("PHPSESSID", '', time() - 1800, '/');
  }
  // セッションの登録データを削除
  session_destroy();

  header('Location:' . UtilityPath::VIEW_PATH . 'index.php');
?>