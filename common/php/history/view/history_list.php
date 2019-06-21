<?php
  session_start();

  require_once 'ViewPath.php';
  require_once ViewPath::DEFINE_PATH;
  require_once ViewPath::UTILITY_PATH . 'auth.php';
  require_once ViewPath::DB_PATH . 'HistorysDao.php';
  require_once ViewPath::DB_PATH . 'ContentsDao.php';

// error_log("通った");

  // 1ページ内に表示する最大件数
  $maxCount = LIST_MAX_COUNT;

  // DB初期化
  $dao = new HistorysDao();
  $contentsDao = new ContentsDao();

  // 削除をタップ
  if (isset($_POST['delete'])) {
    // 1件以上チェックされた（チェックされない場合は空）
    if (isset($_POST['delete_id'])) {
      $result = $dao->delete($_POST['delete_id']);
    }
    
  }

  // 編集、またはコピーをタップ
  if (isset($_POST['id'])) {
    // 編集ボタンタップされた
    if (isset($_POST['edit'])) {
      header('Location:' . EDIT_PATH . '?id=' . $_POST['id']);
      return;
    }
    // コピーボタンタップされた
    else if (isset($_POST['copy'])) {
      // echo var_dump($_POST);
      $dao->copy($_POST['id']);
    }
  }

  // ページ指定を取得
  // 指定が無い場合はデフォルトとして0を設定
  $page = 0;
  if (isset($_GET['page'])) {
    $page = $_GET['page'];
  }

  // ページ数を取得

  // 表示する一覧を取得
  // 指定された件数、表示ページの分を取得
  $rows = $dao->getList($page, $maxCount);
  if (is_null($rows)) {
    header('Content-Type: text/plain; charset=UTF-8', true, 500);
    return;
  }
  $contents = array();
  foreach($rows as $row) {
    // $contentsTmp = $contentsDao->getList($row[HistorysDao::ID]);
    $contents[$row[HistorysDao::ID]] = $contentsDao->getList($row[HistorysDao::ID]);
  }
  // echo var_dump($contents);

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
  <nav class="navbar fixed-top navbar-dark bg-dark text-white">
    更新履歴マネージャー(v0.0.1 2019/3/1)
    <form class="form-inline">
      <button 
        class="btn btn-outline-warning mr-sm-2" 
        type="button"
        onclick="location.href='<?= PREVIEW_PATH ?>'">プレビュー</button>
      <button class="btn btn-success mr-sm-2" type="button">設  定</button>
      <button 
        class="btn btn-warning my-2 my-sm-0" 
        type="button"
        onclick="location.href='<?= ViewPath::ROOT_PATH . UTILITY_PATH ?>logout.php'">ログアウト</button>
    </form>
  </nav>
  
  
  <div class="content list_content">
    <div class="add">
      <input type="button" class="btn btn-primary" value="更新履歴を追加"
        onclick="location.href='history_edit.php'">
    </div>

    <div class="delete_button">
      <form method="post" id="delete_checked">
        <input type="submit" class="btn btn-danger" form="delete_checked"
          name="delete" value="削除">
      </form>
    </div>

    <table class="table table-bordered">
      <thead class="thead-light">
        <tr>
          <th></th>
          <th>日付</th>
          <th>時間</th>
          <th>カテゴリ</th>
          <th>内容</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($rows as $row) { ?>
          <tr>
            <form method="post" action="">
              <input type="hidden" name="id" value="<?= h($row[HistorysDao::ID]) ?>">
              <td scope="row" class="check_column">
                <input type="checkbox" form="delete_checked"
                  name='delete_id[]' value="<?= h($row[HistorysDao::ID]) ?>">
              </td>
              <td class="date_column"><?= h($row[HistorysDao::POST_DATE]) ?></td>
              <td class="date_column"><?= date('H:i', strtotime(h($row[HistorysDao::POST_TIME]))) ?></td>
              <td class="category_column"><?= h($row[HistorysDao::CATEGORY_NAME]) ?></td>
              
              <td class="content_column">
                <?php foreach($contents[$row[HistorysDao::ID]] as $content) { ?>
                  <div><?= h($content[ContentsDao::CONTENT]) ?></div>
                  <div class="text-secondary"><?= h($content[ContentsDao::ADDRESS]) ?></div>
                <?php } ?>
              </td>
              <td class="control_column">
                <input type="submit" class="btn btn-primary" 
                  name="edit" value="編  集">
                <input type="submit" class="btn btn-outline-primary" 
                  name="copy" value="コピー">
              </td>
            </form>
          </tr>
        <?php } ?>
      </tbody>
    </table>

  </div>
  
<?= 'page:' . $page ?>

  <nav aria-label="..." class="page">
    <ul class="pagination justify-content-center">
      <li class="page-item disabled">
        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">最初</a>
      </li>
      <li class="page-item"><a class="page-link" href="#">1</a></li>
      <li class="page-item active" aria-current="page">
        <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
      </li>
      <li class="page-item"><a class="page-link" href="#">3</a></li>
      <li class="page-item">
        <a class="page-link" href="#">最後</a>
      </li>
    </ul>
  </nav>
  
</body>
</html>