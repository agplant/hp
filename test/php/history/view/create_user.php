<?php
// 2018年のパスワードハッシュ
// https://qiita.com/rana_kualu/items/3ef57485be1103362f56
require_once 'ViewPath.php';
require_once ViewPath::DEFINE_PATH;
require_once ViewPath::DB_PATH . 'UsersDao.php';

  $hash = '';
  $result = false;

  if (isset($_POST['name'])) {

    $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);//PASSWORD_ARGON2I);

    $dao = new UsersDao();

    $result = $dao->insert($_POST['name'], $hash);
  }

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Page Title</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

  <link rel="stylesheet" type="text/css" media="screen" href="../css/common.css">

  <!-- <script src="main.js"></script> -->
</head>
<body>

  <div class="edit_content">
    <form method="post" action="#">
      <div class="form-group m-4">
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="inputEmail4">ユーザ名（email）</label>
            <input type="email" class="form-control" name="name" placeholder="email" required autofocus>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="inputPassword4">パスワード</label>
            <input type="text" class="form-control"name="password" placeholder="パスワード" required>
          </div>
        </div>
        <input type="submit" class="btn btn-primary" name="submit" value="登録">
      </div>
    <form>

    <?php 
    if (isset($result)) { 
      echo $result;
    } 
    else {
    ?>
      ハッシュ値は「<?= $hash ?>」です
    <?php } ?>

  </div>
</body>

</html>