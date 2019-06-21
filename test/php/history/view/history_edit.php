<?php
  session_start();

  // use view\Path;

  require_once 'ViewPath.php';
  require_once ViewPath::DEFINE_PATH;
  require_once ViewPath::UTILITY_PATH . 'auth.php';
  require_once ViewPath::DB_PATH . 'HistorysDao.php';
  require_once ViewPath::DB_PATH . 'ContentsDao.php';
  require_once ViewPath::DB_PATH . 'CategorysDao.php';
  

  // echo var_dump($_POST);

  function getContents($contentsDao, $id) {
    
    $contents = array();
    for($i = 0; $i < CONTENT_MAX_COUNT; $i++) {
      // $contents[$i][ContentsDao::TABLE_NAME . '_' . ContentsDao::ID] = '';
      $contents[$i][ContentsDao::CONTENT] = '';
      $contents[$i][ContentsDao::ADDRESS] = '';
      // $contents[$i][ContentsDao::VIEW_ORDER] = '';
    }

    $contentsTmp = $contentsDao->getList($id);

    // データが存在しないパターンもある（一時保存した場合など）
    if (isset($contents)) {
      $i = 0;
      foreach($contentsTmp as $content) {
        // $contents[$i][ContentsDao::TABLE_NAME . '_' . ContentsDao::ID] = $content[ContentsDao::ID];
        $contents[$i][ContentsDao::CONTENT] = $content[ContentsDao::CONTENT];
        $contents[$i][ContentsDao::ADDRESS] = $content[ContentsDao::ADDRESS];
        // $contents[$i][ContentsDao::VIEW_ORDER] = $content[ContentsDao::VIEW_ORDER];
        $i++;
        // echo var_dump($content);
      }
    }
// echo var_dump($contents);
    return $contents;
  }

  function regist($historysDao) {
// echo var_dump($_POST);
    $isNoReserv = false;
    if (isset($_POST[HistorysDao::IS_REFLECT_SOON])) {
      $isNoReserv = $_POST[HistorysDao::IS_REFLECT_SOON];
    }

    $item = [
      HistorysDao::ID => $_POST[HistorysDao::ID],
      HistorysDao::POST_DATE => $_POST[HistorysDao::POST_DATE],
      HistorysDao::POST_TIME => $_POST[HistorysDao::POST_TIME],
      HistorysDao::IS_REFLECT_SOON => $isNoReserv,
      HistorysDao::CATEGORY_ID => $_POST[HistorysDao::CATEGORY_ID]
      // HistorysDao::TITLE => $_POST[HistorysDao::TITLE],
      // HistorysDao::CONTENT => $_POST[HistorysDao::CONTENT]
    ];
    
    $contents = array();
    $count = 0;

    // 内容とアドレスどちらかが入っていた場合、前から詰めて配列に入れる
    // 内容無し&アドレスありの場合はちゃんと表示されないが、一時保存を許容するため
    for($i = 1; $i <= CONTENT_MAX_COUNT; $i++) {
      $content = trim($_POST[ContentsDao::CONTENT][$i]);
      $address = trim($_POST[ContentsDao::ADDRESS][$i]);
      if (strlen($content) > 0 || strlen($address) > 0) {
        $contents[$count] = [
          ContentsDao::ID => $count + 1,
          ContentsDao::CONTENT => $content,
          ContentsDao::ADDRESS => $address
        ];
        $count++;
        // echo $i . ':' . $count . ',' . $content . ',' . $address . '<br>';
      }
    }
echo var_dump($item) . '<br>' . var_dump($contents);
    // 更新
    if (isset($_GET['id'])) {
      return $historysDao->update($item, $contents);
    }
    // 追加
    else {
      return $historysDao->insert($item, $contents);
    }

  }

  // DB初期化
  $historysDao = new HistorysDao();
  $contentsDao = new ContentsDao();
  $categorysDao = new CategorysDao();

  // id指定を取得
  // 指定が無い場合は新規作成
  $id = -1;
  date_default_timezone_set('Asia/Tokyo');
  $postDate = date('Y-m-d');
  $postTime = date('H:i');
  $isNoReserv = false;
  $categoryId = 0;
  $title = '';
  $content = '';
  $contents = array();

// $debug = "";
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
  }

  // 更新ボタンが押された
  if (isset($_POST['update'])) {

    // 登録成功
    if (regist($historysDao)) {
      // header('Location:' . LIST_PATH);
      // return;
    }
    // // 登録失敗
    // else {

    // }
  }


  // 表示
  if (isset($_GET['id'])) {
    // $debug = "id=" . $_GET['id'];
    $item = $historysDao->getItem($id);

    if (!$item) {
      // データが存在しない
      // $debug = "データが存在しない";
      header('Content-Type: text/plain; charset=UTF-8', true, 500);
      return;
    }

    // echo var_dump($item);
    $postDate = $item[HistorysDao::POST_DATE];
    $postTime = $item[HistorysDao::POST_TIME];
    $isNoReserv = $item[HistorysDao::IS_REFLECT_SOON];
    $categoryId = $item[HistorysDao::CATEGORY_ID];

    // echo var_dump($contents);
  }

  // 内容を取得
  $contents = getContents($contentsDao, $id);
  

  // カテゴリ一覧を取得
  $categorys = $categorysDao->getList();
  if (!$categorys) {
    // データが存在しない
    // $debug = "データが存在しない";
    header('Content-Type: text/plain; charset=UTF-8', true, 500);
    return;
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
      <button class="btn btn-success mr-sm-2" type="button">設定</button>
      <button 
        class="btn btn-warning my-2 my-sm-0" 
        type="button"
        onclick="location.href='../utility/logout.php'">ログアウト</button>
    </form>
  </nav>
  
  <div class="content">
    <a href='<?= LIST_PATH ?>''>一覧に戻る</a>
  </div>

  <div class="edit_content">

    <form method='post' action=''>
      <input type='hidden' name='<?= HistorysDao::ID ?>' value='<?= $id ?>'>
      
      <div class="form-row">
        <div class="form-group col-md-3">
          <label><span class="text-success mr-2">■</span>日付</label>
          <input type="date" class="form-control" 
            name="<?= HistorysDao::POST_DATE ?>"
            value="<?= h($postDate) ?>">
        </div>
        <div class="form-group col-md-9">
          <div class="form-check mt-4">
            <input type="checkbox" class="form-check-input" 
              name="<?= HistorysDao::IS_REFLECT_SOON ?>"
              value="<?= $isNoReserv ?>">
            <label class="form-check-label">今すぐ反映する</label>
          </div>
          <small id="passwordHelpBlock" class="form-text text-muted">
            チェック時：未来日を入力した場合、待たずに今すぐ更新履歴に表示します
          </small>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-3">
          <label><span class="text-success mr-2">■</span>時間</label>
          <input type="time" class="form-control" 
            name="<?= HistorysDao::POST_TIME ?>"
            value="<?= h($postTime) ?>">
        </div>
      </div>
      <div class="form-group">
        <label for="exampleFormControlSelect1"><span class="text-success mr-2">■</span>カテゴリー</label>
        <select class="form-control" id="exampleFormControlSelect1"
          name="<?= HistorysDao::CATEGORY_ID ?>">
          <?php foreach($categorys as $category) { ?>
            <option value="<?= $category[CategorysDao::ID] ?>"
              <?= $category[CategorysDao::ID] == $categoryId ? ' selected' : '' ?>>
              <?= $category[CategorysDao::NAME] ?>
            </option>
          <?php } ?>
        </select>
      </div>
      <div class="form-group">
        <label><span class="text-success mr-2">■</span>内容</label>
          <?php 
          $i = 1;
          foreach($contents as $content) { ?>

            <div class="bg-light border form-group mb-0">
              <div class="form-group">
                <span class="m-3 text-info"><?= $i ?>行目</span>
                <input type="button"
                  onclick="changeRank(
                    this, <?= $i ?>, 
                    new Array('<?= ContentsDao::CONTENT ?>','<?= ContentsDao::ADDRESS ?>'))" 
                  class="pl-3 pr-3 m-2 btn btn-outline-info <?= $i == 1 ? 'invisible' : '' ?>" 
                  value="▲" name="up">
                <input type="button" 
                  onclick="changeRank(
                    this, <?= $i ?>,
                    new Array('<?= ContentsDao::CONTENT ?>','<?= ContentsDao::ADDRESS ?>'))" 
                  class="pl-3 pr-3 m-2 btn btn-outline-info <?= $i == CONTENT_MAX_COUNT ? 'invisible' : '' ?>" 
                  value="▼" name="down">
                <textarea class="form-control" rows="2" placeholder="更新内容を入力" 
                  name="<?= ContentsDao::CONTENT . '[' . $i . ']' ?>"><?= $content[ContentsDao::CONTENT] ?></textarea>
              </div>  
              <div class="form-group">
                <label>更新内容のリンク先アドレス</label>
                <input type="text" placeholder="「http://www.～～」、「koushin.html」等のURL" 
                  class="form-control" 
                  name="<?= ContentsDao::ADDRESS . '[' . $i . ']' ?>"
                  value="<?= $content[ContentsDao::ADDRESS] ?>">
              </div>
            </div>
          <?php 
            $i++;
          } ?>
        
      </div>

      <div class="regist_button">
        <input type="submit" class="btn btn-primary" name="update" value="登録">
      </div>
    </form>
    
  </div>

  <script type="text/javascript" src="<?= SCRIPT_PATH ?>history.js"></script>

</body>
</html>