<?php

require_once 'database.php';

class CategorysDao {

  private $pdo;

  const TABLE_NAME = "categorys";
  const ID = 'id';
  const NAME = 'name';

  function __construct() {

    $this->pdo = connect();
    // $this->pdo = $basePdo;

    // 接続失敗時は処理終了
    if (is_null($this->pdo)) {
      // エラーも吐き出す
      return null;
    }
  }

  function getList() {

    // $pdo = connect();
    // 接続失敗時は処理終了
    if (is_null($this->pdo)) {
      return null;
    }

    $sql = 'SELECT id, ' . self::TABLE_NAME . '.* FROM ' . self::TABLE_NAME;
    $rows = $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC|PDO::FETCH_UNIQUE);

    return $rows;
  }
  
}
?>