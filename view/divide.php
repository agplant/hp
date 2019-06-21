<?php

require_once '../php/DivideUsersDao.php';

// DB初期化
$dao = new DivideUsersDao();
$count = 0;
if (isset($_POST['users_submit'])) {
  foreach($_POST[DivideUsersDao::ID] as $id) {
    
    $contents[$count] = [
      DivideUsersDao::ID => $id,
      DivideUsersDao::NAME => trim($_POST[DivideUsersDao::NAME][$id]),
      DivideUsersDao::CHILDREN => trim($_POST[DivideUsersDao::CHILDREN][$id]),
      DivideUsersDao::ADJUST => trim($_POST[DivideUsersDao::ADJUST][$id])
    ];
    $count++;
      
  }
// echo var_dump($contents);
  // 更新
  $dao->updateUsers($contents);
  
}
else if (isset($_POST['money_submit']) && isset($_POST['money'])) {
  $dao->updateMoney($_POST['money']);
}

// 表示する一覧を取得
  // 指定された件数、表示ページの分を取得
  $rows = $dao->getList();
  if (is_null($rows)) {
    header('Content-Type: text/plain; charset=UTF-8', true, 500);
    return;
  }

  $money = $dao->getMoney();
  // echo var_dump($rows);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" >
  <title>按分計算</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
</head>
<body>

  <style>
    .main {
      /* margin: 0 auto; */
      margin-top: 1%;
      margin-right:3%;
      margin-left:3%;
      width: 80%;
    }
    /* table {
      background-color: blue;
    } */
    .numeric {
      width: 50px;
    }
    /* td.user {
      width: 10%;
    }
    td.user-name {
      width: 5%;
    } */
  </style>

  <div class="main">
    <form method="post" action="#">
      <table>
        <tr >
          <th>名前</th>
          <th>子</th>
          <th>調整</th>
          <th>按分</th>
        </tr>
        
        <?php
        foreach($rows as $value) { ?>
          <tr>
            <td class="user-name">
              <input type="hidden"
                name="<?= DivideUsersDao::ID ?>[<?= h($value[DivideUsersDao::ID]) ?>]"
                value="<?= h($value[DivideUsersDao::ID]) ?>">
              <input type="text" 
                name="<?= DivideUsersDao::NAME ?>[<?= h($value[DivideUsersDao::ID]) ?>]" 
                value="<?= h($value[DivideUsersDao::NAME]) ?>"
                class="user">
            </td>
            <td class="user">
              <input type="text" 
                name="<?= DivideUsersDao::CHILDREN ?>[<?= h($value[DivideUsersDao::ID]) ?>]" 
                value="<?= h($value[DivideUsersDao::CHILDREN]) ?>"
                class="user numeric">
            </td>
            <td class="user">
              <input type="text" 
                name="<?= DivideUsersDao::ADJUST ?>[<?= h($value[DivideUsersDao::ID]) ?>]" 
                value="<?= h($value[DivideUsersDao::ADJUST]) ?>"
                class="user numeric">
            </td>
            <td>
              <?php
                if (h($money[DivideUsersDao::MONEY]) > 0) {
                  echo (floor(
                    (h($money[DivideUsersDao::MONEY]) - h($money[DivideUsersDao::ADJUST_SUM])) 
                      / h($money[DivideUsersDao::CHILDREN_SUM])
                      * h($value[DivideUsersDao::CHILDREN]))
                      + h($value[DivideUsersDao::ADJUST]));
                }
              ?>
            </td>
          </tr>
        <?php } ?>
        
      </table>
      <div class="form-group mt-2">
        <input type="submit" name="users_submit" value="ユーザー変更"
          class="btn btn-primary">
      </div>
    </form>

    <form method="post" action="#" class="mt-2 mb-2">
      <!-- <div class="form-group"> -->
        本日の精算額  
        <div class="form-group" style="width: 200px">
          <input type="text" 
            name="money"
            value="<?= h($money[DivideUsersDao::MONEY]) ?>"
            class="form-control">
        </div>
        <input type="submit" name="money_submit" value="金額変更"
          class="btn btn-primary">
      <!-- </div> -->

      <div>調整額合計：<?= h($money[DivideUsersDao::ADJUST_SUM]) ?></div>
      <div>子ども合計：<?= h($money[DivideUsersDao::CHILDREN_SUM]) ?></div>
      <div>子ども一人当たり金額：
        <?= floor(
            (h($money[DivideUsersDao::MONEY]) - h($money[DivideUsersDao::ADJUST_SUM])) 
              / h($money[DivideUsersDao::CHILDREN_SUM])) ?>
      </div>
      
    </form>

  </div>
</body>
</html>