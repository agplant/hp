<?php

require_once 'database.php';

class ContentsDao {

  private $pdo;

  const TABLE_NAME ='contents';
  const HISTORYS_ID = 'historys_id';
  const ID = 'id';
  const CONTENT = 'content';
  const ADDRESS = 'address';
  // const VIEW_ORDER = 'view_order';

  function __construct() {

    $this->pdo = connect();
    // $this->pdo = $basePdo;

    // 接続失敗時は処理終了
    if (is_null($this->pdo)) {
      // エラーも吐き出す
      return null;
    }
  }

  function getList($historysId) {

    // 接続失敗時は処理終了
    if (is_null($this->pdo)) {
      return null;
    }

    $sql = 'SELECT contents.id, contents.* FROM contents ' 
          . 'WHERE historys_id = ? '
          . 'ORDER BY id ASC' ;
    
    $stmt = $this->pdo->prepare($sql);

    $stmt->bindValue(1, (int)$historysId, PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->fetchAll();

    return $rows;
  }

  function update($historyId, $contents) {

    $deleteSql = 'DELETE FROM ' . self::TABLE_NAME 
                  . ' WHERE ' . self::HISTORYS_ID . ' = ?';

    $insertSql = 'INSERT INTO ' . self::TABLE_NAME . ' ( '
                  .       self::ID
                  . ',' . self::HISTORYS_ID
                  . ',' . self::CONTENT
                  . ',' . self::ADDRESS
                  .') VALUES(?, ?, ?, ?)';

    // プリペアドステートメントを用意
    $deleteStmt = $this->pdo->prepare($deleteSql);
    $insertStmt = $this->pdo->prepare($insertSql);

    // $this->pdo->beginTransaction();
    try {
      $deleteStmt->bindValue(1, $historyId);
      $deleteStmt->execute();

      for($i = 0; $i < count($contents); $i++) {
        $item = $contents[$i];

        $insertStmt->bindValue(1, $item[self::ID]);
        $insertStmt->bindValue(2, $historyId);
        $insertStmt->bindValue(3, $item[self::CONTENT]);
        $insertStmt->bindValue(4, $item[self::ADDRESS]);
        // echo $item[self::ID] . ':' . $historyId . ',' . $item[self::CONTENT] . ',' . $item[self::ADDRESS] . '<br>';
        
        $insertStmt->execute();
      }
      

      // $this->pdo->commit();
    }
    catch(PDOException $ex) {
      // $this->pdo->rollBack();
      throw $ex;
    }
      
      return true;
  }
  
  function copy($historyId, $newHistoryId) {

    $insertSql = 'INSERT INTO ' . self::TABLE_NAME . ' ( '
                  .       self::ID
                  . ',' . self::HISTORYS_ID
                  . ',' . self::CONTENT
                  . ',' . self::ADDRESS
                  . ')'
                  . ' SELECT ' 
                  .       self::ID
                  . ', ? '
                  . ',' . self::CONTENT
                  . ',' . self::ADDRESS
                  . ' FROM ' . self::TABLE_NAME
                  . ' WHERE ' . self::HISTORYS_ID . ' = ? ';

    // $this->pdo->beginTransaction();
    try {
// echo 'copy:' . $historyId . ',' . $newHistoryId . ',' . $insertSql;
      // プリペアドステートメントを用意
      $insertStmt = $this->pdo->prepare($insertSql);
      
      $insertStmt->bindValue(1, $newHistoryId);
      $insertStmt->bindValue(2, $historyId);
      
      $insertStmt->execute();
      
      // $this->pdo->commit();
    }
    catch(PDOException $ex) {
      // $this->pdo->rollBack();
      throw $ex;
    }
      
    return true;
  }

  function delete($id) {

    // プリペアドステートメントを用意
    $stmt = $this->pdo->prepare(
      'DELETE FROM ' . self::TABLE_NAME . ' WHERE ' . self::HISTORYS_ID . ' = ?');

    try {

      $stmt->bindValue(1, $id);
      
    }
    catch(PDOException $ex) {
      throw $ex;
    }

    return true;
  }
}