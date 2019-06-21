<?php

session_start();

require_once 'ViewPath.php';
require_once ViewPath::DEFINE_PATH;
require_once ViewPath::DB_PATH . 'HistorysDao.php';
require_once ViewPath::DB_PATH . 'ContentsDao.php';

// DB初期化
$dao = new HistorysDao();
$contentsDao = new ContentsDao();

// 表示する一覧を取得
// 指定された件数、表示ページの分を取得
$rows = $dao->getViewList(VIEW_MAX_COUNT);
if (is_null($rows)) {
  header('Content-Type: text/plain; charset=UTF-8', true, 500);
  return;
}

$contents = array();
foreach($rows as $row) {
  $contents[$row[HistorysDao::ID]] = $contentsDao->getList($row[HistorysDao::ID]);
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
</head>
<body>

<nav class="navbar fixed-top navbar-dark bg-dark text-white">
    更新履歴マネージャー(v0.0.1 2019/3/1)
    <form class="form-inline">
      <button class="btn btn-success mr-sm-2" type="button">設  定</button>
      <button 
        class="btn btn-warning my-2 my-sm-0" 
        type="button"
        onclick="location.href='<?= UTILITY_PATH ?>logout.php'">ログアウト</button>
    </form>
  </nav>

<div class="content">
    <a href='<?= LIST_PATH ?>''>一覧に戻る</a>
  </div>

  <div class="edit_content">
  <?php foreach($rows as $row) { ?>
    <div class="border-bottom">
      <div class="mb-2 mt-1">
        <span class="text-dark"><?= h($row[HistorysDao::POST_DATE]) ?></span>
          <?php if ($row[HistorysDao::CATEGORY_ID] == 1) { ?>
            <span class="pr-1 pl-1 mr-2 border border-dark"><?= h($row[HistorysDao::CATEGORY_NAME]) ?></span>
          <?php } else { ?>
            <span class="pr-1 pl-1 mr-2 bg-warning"><?= h($row[HistorysDao::CATEGORY_NAME]) ?></span>
          <?php } ?>
        <?php if ($row[HistorysDao::POST_DATE] > date('Y-m-d 23:59:59', strtotime('-' . NEW_PERIOD . ' day'))) { ?>
          <span class="badge badge-danger">New</span>
        <?php } ?>
      </div>
      <div class="mb-3">
        <?php foreach($contents[$row[HistorysDao::ID]] as $content) { ?>
          <div>
            <a href="<?= h($content[ContentsDao::ADDRESS]) ?>"><?= h($content[ContentsDao::CONTENT]) ?></a>
          </div>
        <?php } ?>
      </div>
    </div>
  <?php } ?>
  </div>
</body>
</html>