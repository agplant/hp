<?php

require_once 'database.php';
require_once 'ContentsDao.php';

class HistorysDao {

  private $pdo;
  private $contentsDao;

  const TABLE_NAME = 'historys';
  const ID = 'id';
  const POST_DATE = 'post_date';
  const POST_TIME = 'post_time';
  const IS_REFLECT_SOON = 'is_reflect_soon';
  const CATEGORY_ID = 'category_id';
  const CATEGORY_NAME = 'category_name';

  function __construct() {

    $this->pdo = connect();
    // $this->pdo = $basePdo;

    // 接続失敗時は処理終了
    if (is_null($this->pdo)) {
      // エラーも吐き出す
      return null;
    }

    $this->contentsDao = new ContentsDao();
  }

  function getItem($id) {

    // $pdo = connect();
    // 接続失敗時は処理終了
    if (is_null($this->pdo)) {
      return null;
    }

    $stmt = $this->pdo->prepare('SELECT id, historys.* FROM historys WHERE id = ?');

    $stmt->bindValue(1, (int)$id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch();

    return $row;
  }

  function getViewList($maxCount) {
    // 接続失敗時は処理終了
    if (is_null($this->pdo)) {
      return null;
    }
    
    $currentDate = '"' . date('Y-m-d 23:59:59') . '"';

    $sql = 'SELECT historys.id, historys.*, categorys.name AS category_name FROM historys ' 
          . ' LEFT JOIN categorys ON categorys.id = historys.category_id '
          . ' WHERE (post_date <= ' . $currentDate
          . ' OR post_date > ' . $currentDate . ' AND is_reflect_soon = 1 )'
          . ' ORDER BY post_date DESC, post_time DESC, id DESC ' 
          . ' LIMIT ' . $maxCount;
    
    $rows = $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC|PDO::FETCH_UNIQUE);

    return $rows;
    
  }

  function getList($page, $maxCount) {

    // $pdo = connect();
    // 接続失敗時は処理終了
    if (is_null($this->pdo)) {
      return null;
    }

    $offset = $page * $maxCount;

    $sql = 'SELECT historys.id, historys.*, categorys.name AS category_name FROM historys ' 
          . 'LEFT JOIN categorys ON categorys.id = historys.category_id '
          . 'ORDER BY post_date DESC, post_time DESC, id DESC ' 
          . 'LIMIT ' . $offset . ',' . $maxCount;
    
    $rows = $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC|PDO::FETCH_UNIQUE);

    return $rows;
  }

  function insert($item, $contents) {

    // $dateOrder = 'SELECT IFNULL(MAX(date_order) + 1, 0) FROM historys WHERE post_date = ?';

    $sql = 'INSERT INTO historys('
          .       self::POST_DATE
          . ',' . self::POST_TIME
          . ',' . self::IS_REFLECT_SOON
          . ',' . self::CATEGORY_ID
          // . ',' . self::TITLE
          // . ',' . self::CONTENT
          .') VALUES(?, ?, ?, ?)'; //, ?, ?)';

    try {

      // $contentsDao = new ContentsDao();

      // プリペアドステートメントを用意
      $stmt = $this->pdo->prepare($sql);

      $this->pdo->beginTransaction();
      try {
        $stmt->bindValue(1, $item[self::POST_DATE]);
        $stmt->bindValue(2, $item[self::POST_TIME]);
        $stmt->bindValue(3, $item[self::IS_REFLECT_SOON]);
        $stmt->bindValue(4, $item[self::CATEGORY_ID]);
        
        $stmt->execute();

        $this->contentsDao->update(
          $this->pdo->lastInsertId(self::ID),
          $contents);

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
    return true;
  }

  function update($item, $contents) {
  
    // $dateOrder = 'SELECT post_date FROM historys WHERE ID = ?';

    $sql = 'UPDATE historys SET '
            .       self::POST_DATE . ' = ? '
            . ',' . self::POST_TIME . ' = ? '
            . ',' . self::IS_REFLECT_SOON . ' = ? '
            . ',' . self::CATEGORY_ID . ' = ? '
            . ' WHERE ID = ? ';

    try {

      // $contentsDao = new ContentsDao();

      // プリペアドステートメントを用意
      $stmt = $this->pdo->prepare($sql);

      $this->pdo->beginTransaction();
      try {
        $stmt->bindValue(1, $item[self::POST_DATE]);
        $stmt->bindValue(2, $item[self::POST_TIME]);
        $stmt->bindValue(3, $item[self::IS_REFLECT_SOON]);
        $stmt->bindValue(4, (int)$item[self::CATEGORY_ID], PDO::PARAM_INT);
        $stmt->bindValue(5, (int)$item[self::ID], PDO::PARAM_INT);
        $stmt->execute();

        $this->contentsDao->update($item[self::ID], $contents);

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

    return true;
  }

  function copy($id) {

    // 接続失敗時は処理終了
    if (is_null($this->pdo)) {
      return null;
    }
//, title, content)' 
    $historySql = 'INSERT INTO ' . self::TABLE_NAME . '('
          .       self::POST_DATE
          . ',' . self::POST_TIME
          . ',' . self::IS_REFLECT_SOON
          . ',' . self::CATEGORY_ID
          . ')'
          . ' SELECT ' 
          .       self::POST_DATE
          . ',' . self::POST_TIME
          . ',' . self::IS_REFLECT_SOON
          . ',' . self::CATEGORY_ID
          . ' FROM ' . self::TABLE_NAME
          . ' WHERE ' . self::ID . ' = ' . $id;

      $this->pdo->beginTransaction();

      try {
        
        $result = $this->pdo->exec($historySql);

        $this->contentsDao->copy($id, $this->pdo->lastInsertId(self::ID));

        $this->pdo->commit();
      }
      catch(PDOException $ex) {
        $this->pdo->rollBack();
        throw $ex;
      }

    return $result;
  }

  function delete($ids) {

    try {

      // プリペアドステートメントを用意
      $stmt = $this->pdo->prepare('DELETE FROM historys WHERE id = ?');

      $this->pdo->beginTransaction();
      try {

        foreach($ids as $id) {

          $this->contentsDao->delete($id);

          $stmt->bindValue(1, $id);
          $stmt->execute();
        }

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

    return true;
  }

}