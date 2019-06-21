<?php

require_once 'database.php';

class DivideUsersDao {

  private $pdo;

  const TABLE_NAME = 'divide_users';
  const ID = 'id';
  const NAME = 'name';
  const CHILDREN = 'children';
  const ADJUST = 'adjustment';

  const MONEY = "money";
  const ADJUST_SUM = "adjust_sum";
  const CHILDREN_SUM = "children_sum";

  function __construct() {

    $this->pdo = connect();
    // $this->pdo = $basePdo;

    // 接続失敗時は処理終了
    if (is_null($this->pdo)) {
      // エラーも吐き出す
      return null;
    }

  }

  function getMoney() {

    // $pdo = connect();
    // 接続失敗時は処理終了
    if (is_null($this->pdo)) {
      return null;
    }

    $adjustSql =' (select sum(adjustment) from divide_users) as ' . self::ADJUST_SUM . ' ';
    $childrenSql =' (select sum(children) from divide_users) as ' . self::CHILDREN_SUM . ' ';
    $stmt = $this->pdo->prepare(
      'SELECT id, divide_moneys.*, ' 
      . $adjustSql . ', '
      . $childrenSql . ' '
      . ' FROM divide_moneys');

    // $stmt->bindValue(1, (int)$id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch();

    return $row;
  }

  // function getViewList($maxCount) {
  //   // 接続失敗時は処理終了
  //   if (is_null($this->pdo)) {
  //     return null;
  //   }
    
  //   $currentDate = '"' . date('Y-m-d 23:59:59') . '"';

  //   $sql = 'SELECT historys.id, historys.*, categorys.name AS category_name FROM historys ' 
  //         . ' LEFT JOIN categorys ON categorys.id = historys.category_id '
  //         . ' WHERE (post_date <= ' . $currentDate
  //         . ' OR post_date > ' . $currentDate . ' AND is_reflect_soon = 1 )'
  //         . ' ORDER BY post_date DESC, post_time DESC, id DESC ' 
  //         . ' LIMIT ' . $maxCount;
    
  //   $rows = $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC|PDO::FETCH_UNIQUE);

  //   return $rows;
    
  // }

  function getList() {

    // $pdo = connect();
    // 接続失敗時は処理終了
    if (is_null($this->pdo)) {
      return null;
    }

    $sql = 'SELECT ' . self::TABLE_NAME . '.id, ' . self::TABLE_NAME . '.* ' 
          . ' FROM ' . self::TABLE_NAME
          . ' ORDER BY name';
    
    $rows = $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC|PDO::FETCH_UNIQUE);

    return $rows;
  }

  // function insert($item, $contents) {

  //   // $dateOrder = 'SELECT IFNULL(MAX(date_order) + 1, 0) FROM historys WHERE post_date = ?';

  //   $sql = 'INSERT INTO historys('
  //         .       self::POST_DATE
  //         . ',' . self::POST_TIME
  //         . ',' . self::IS_REFLECT_SOON
  //         . ',' . self::CATEGORY_ID
  //         // . ',' . self::TITLE
  //         // . ',' . self::CONTENT
  //         .') VALUES(?, ?, ?, ?)'; //, ?, ?)';

  //   try {

  //     // $contentsDao = new ContentsDao();

  //     // プリペアドステートメントを用意
  //     $stmt = $this->pdo->prepare($sql);

  //     $this->pdo->beginTransaction();
  //     try {
  //       $stmt->bindValue(1, $item[self::POST_DATE]);
  //       $stmt->bindValue(2, $item[self::POST_TIME]);
  //       $stmt->bindValue(3, $item[self::IS_REFLECT_SOON]);
  //       $stmt->bindValue(4, $item[self::CATEGORY_ID]);
        
  //       $stmt->execute();

  //       $this->contentsDao->update(
  //         $this->pdo->lastInsertId(self::ID),
  //         $contents);

  //       $this->pdo->commit();
  //     }
  //     catch(PDOException $ex) {
  //       $this->pdo->rollBack();
  //       throw $ex;
  //     }
  //   }
  //   catch(PDOException $ex) {
  //     // 例外メッセージを表示
  //     // header('Content-Type: text/plain; charset=UTF-8', true, 500);
  //     // exit($ex->getMessage());
  //     return $ex->getMessage();
  //   }
  //   return true;
  // }

  function updateUsers($items) {
  
    // $dateOrder = 'SELECT post_date FROM historys WHERE ID = ?';

    $sql = 'UPDATE ' . self::TABLE_NAME . ' SET '
            .       self::NAME . ' = ? '
            . ',' . self::CHILDREN . ' = ? '
            . ',' . self::ADJUST . ' = ? '
            . ' WHERE ID = ? ';

    try {

      // $contentsDao = new ContentsDao();

      // プリペアドステートメントを用意
      $stmt = $this->pdo->prepare($sql);

      $this->pdo->beginTransaction();
      try {
        foreach($items as $item) {
          $stmt->bindValue(1, $item[self::NAME]);
          $stmt->bindValue(2, $item[self::CHILDREN]);
          $stmt->bindValue(3, (int)$item[self::ADJUST], PDO::PARAM_INT);
          $stmt->bindValue(4, (int)$item[self::ID], PDO::PARAM_INT);
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

  function updateMoney($item) {

    $sql = 'UPDATE ' . 'divide_moneys' . ' SET '
            .       'money' . ' = ? ';

    try {

      // プリペアドステートメントを用意
      $stmt = $this->pdo->prepare($sql);

      $this->pdo->beginTransaction();
      try {
        $stmt->bindValue(1, (int)$item, PDO::PARAM_INT);
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

    return true;
  }

//   function copy($id) {

//     // 接続失敗時は処理終了
//     if (is_null($this->pdo)) {
//       return null;
//     }
// //, title, content)' 
//     $historySql = 'INSERT INTO ' . self::TABLE_NAME . '('
//           .       self::POST_DATE
//           . ',' . self::POST_TIME
//           . ',' . self::IS_REFLECT_SOON
//           . ',' . self::CATEGORY_ID
//           . ')'
//           . ' SELECT ' 
//           .       self::POST_DATE
//           . ',' . self::POST_TIME
//           . ',' . self::IS_REFLECT_SOON
//           . ',' . self::CATEGORY_ID
//           . ' FROM ' . self::TABLE_NAME
//           . ' WHERE ' . self::ID . ' = ' . $id;

//       $this->pdo->beginTransaction();

//       try {
        
//         $result = $this->pdo->exec($historySql);

//         $this->contentsDao->copy($id, $this->pdo->lastInsertId(self::ID));

//         $this->pdo->commit();
//       }
//       catch(PDOException $ex) {
//         $this->pdo->rollBack();
//         throw $ex;
//       }

//     return $result;
//   }

//   function delete($ids) {

//     try {

//       // プリペアドステートメントを用意
//       $stmt = $this->pdo->prepare('DELETE FROM historys WHERE id = ?');

//       $this->pdo->beginTransaction();
//       try {

//         foreach($ids as $id) {

//           $this->contentsDao->delete($id);

//           $stmt->bindValue(1, $id);
//           $stmt->execute();
//         }

//         $this->pdo->commit();
//       }
//       catch(PDOException $ex) {
//         $this->pdo->rollBack();
//         throw $ex;
//       }
//     }
//     catch(PDOException $ex) {
//       // 例外メッセージを表示
//       // header('Content-Type: text/plain; charset=UTF-8', true, 500);
//       // exit($ex->getMessage());
//       return $ex->getMessage();
//     }

//     return true;
//   }

}