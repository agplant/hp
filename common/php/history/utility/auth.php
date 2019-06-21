<?php

  // 認証済み
  if (!isset($_SESSION['auth'])) {
    header('Location:../view/index.php');
    return;
  }