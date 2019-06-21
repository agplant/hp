<?php
  // namespace utility;

  require_once 'UtilityPath.php';

  // use utility\Path;

  require_once UtilityPath::DEFINE_PATH;
  // require_once Path::DB_PATH . 'database.php';
  require_once UtilityPath::DB_PATH . 'UsersDao.php';

function execLogin($email, $password) {

  // if ($email === '') {
  //   $err['email'] = 'ユーザー名は入力必須です。';
  //   return $err;
  // }
  // if ($password === '') {
  //   $err['password'] = 'パスワードは入力必須です。';
  //   return $err;
  // }

  $usersDao = new UsersDao();
  $row = $usersDao->getItem($email);

  if (!isset($row)) {
    $err['email'] = '入力されたユーザー名は存在しません。';
    return $err;
  }

  // パスワード一致
  if (password_verify($password, $row[UsersDao::HASH])) {
  // if ($password == "pass") {
      session_regenerate_id(true);
      $_SESSION['auth'] = $email;
      // header('Location:main.php');
      return;
  }

  $err['password'] = 'ログインに失敗しました。';

  return $err;
}

?>
