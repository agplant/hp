<?php
  
  require_once 'ViewPath.php';
  // use view\Path;
  require_once ViewPath::DEFINE_PATH;
  require_once ViewPath::UTILITY_PATH . 'login.php';

  session_start();

  // const LIST_PATH = "history_list.php";

  // POST以外の場合は初期化しないと変な値が入る
  $email = "";
  $err = "";

  if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');

    $err = execLogin($email, $password);
  
  }
  
  // 認証済み
  if ($err == "" && isset($_SESSION['auth'])) {
    header('Location:' . LIST_PATH);
    return;
  }

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>更新履歴ログイン</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

  <link rel="stylesheet" type="text/css" media="screen" href="../css/common.css">
</head>
<body>
  <form method="post" action="">
    <p>
      <label for="email">メールアドレス</label>
      <input type="email" name="email" value="<?= $email ?>" required autofocus>
      <?php if (isset($err['email'])) : ?>
        <p class="error"><?= h($err['email']); ?></p>
      <?php endif; ?>
    </p>
    <p>
      <label for="password">パスワード</label>
      <input id="password" type="password" name="password" required>
      <?php if (isset($err['password'])) : ?>
        <p class="error"><?= h($err['password']); ?></p>
      <?php endif; ?>
    </p>
    <input type="submit" name="login" value="ログイン">
  </form>
</body>
</html>