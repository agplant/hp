<?php

require_once 'database.php';

class UsersDao {

  private $pdo;

  const TABLE_NAME = 'users';
  const NAME = 'name';
  // public const __HASH = 'hash';
  const HASH = 'hash';
  

  function __construct() {

    $this->pdo = connect();
    // $this->pdo = $basePdo;

    // 接続失敗時は処理終了
    if (is_null($this->pdo)) {
      // エラーも吐き出す
      return null;
    }
  }

  function getItem($name) {
    // 接続失敗時は処理終了
    if (is_null($this->pdo)) {
      return null;
    }

    $stmt = $this->pdo->prepare(
              'SELECT ' . self::NAME . ', ' . self::TABLE_NAME . '.* ' 
            . ' FROM '. self::TABLE_NAME 
            . ' WHERE ' . self::NAME . ' = ?');

    $stmt->bindValue(1, $name);
    $stmt->execute();
    $row = $stmt->fetch();

    return $row;
  }

  function insert($name, $hash) {

    // 接続失敗時は処理終了
    if (is_null($this->pdo)) {
      return 'pdoがnullです';
    }

    $sql = 'INSERT INTO ' . self::TABLE_NAME . '('
          .       self::NAME
          . ',' . self::HASH
          . ') VALUES(?, ?)';

    try {

      // $this->pdo = connect();
      
      // プリペアドステートメントを用意
      $stmt = $this->pdo->prepare($sql);
      // $stmt = $this->pdo->prepare($sql);

      $this->pdo->beginTransaction();
      try {
        $stmt->bindValue(1, $name);
        $stmt->bindValue(2, $hash);
        
        $stmt->execute();

        $this->pdo->commit();
      }
      catch(PDOException $ex) {
        $this->pdo->rollBack();
        throw $ex;
      }
    }
    catch(PDOException $ex) {
      // 例外メッセージを表示
      // header('Content-Type: text/plain; charset=UTF-8', true, 500);
      // exit($ex->getMessage());
      return $ex->getMessage();
    }
    return null;
  }
}

?>