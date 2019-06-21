<?php

const PHP_PATH = '../common/php/';
require_once 'php/AgString.php';

require_once PHP_PATH . 'history/define.php';
require_once PHP_PATH . 'history/' . DB_PATH . 'HistorysDao.php';
require_once PHP_PATH . 'history/' . DB_PATH . 'ContentsDao.php';

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

function getColorClass($pear, $i, $j, $k) {
  $color = ' harvest-target-' . $i;
  if ($j < $pear[$i]['startMonth']
  || $pear[$i]['endMonth'] < $j ) {
    $color = '';
  }
  else {
    if ($pear[$i]['startMonth'] === $j
    && $k < $pear[$i]['startPeriod']) {
      $color = '';
    }  
    else if ($pear[$i]['endMonth'] === $j
        && $pear[$i]['endPeriod'] < $k) {
      $color = '';
    }
  }
  return $color;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" >
  <title>一戦場梨園</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link rel="stylesheet" type="text/css" media="screen" href="css/pear.css">
  
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
</head>
<body>
  
  <header class="header-line">  
    <div class="logo">一戦場梨園</div>
      
    <nav class="menu"> 
      <ul>
        <li class="navitem">
          <button class="tab-button" id="tab0">
            <svg version="1.1" id="home" class="navitem-img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
              <g>
                <polygon class="st0" points="442.531,218 344.828,120.297 256,31.469 167.172,120.297 69.438,218.047 0,287.469 39.984,327.453 
                  109.406,258.031 207.156,160.281 256,111.438 304.844,160.281 402.531,257.984 472.016,327.453 512,287.469 	"></polygon>
                <polygon class="st0" points="85.719,330.375 85.719,480.531 274.75,480.531 274.75,361.547 343.578,361.547 343.578,480.531 
                  426.281,480.531 426.281,330.328 256.016,160.063 	"></polygon>
              </g>
            </svg>
            <p class="desc">ホーム</p>
          </button>
        </li>
        <li class="navitem">
          <button class="tab-button" id="tab1">
            <svg version="1.1" id="pearfarm" class="navitem-img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
              <g>
                <path class="st0" d="M314.788,32.521c-64.516,60.219-51.609,123.297-58.797,123.297c-7.156,0,5.75-63.078-58.766-123.297
                  C132.694-27.697,42.366,5.287,50.96,54.037c8.594,48.734,90.328,80.297,117.578,87.438c27.234,7.188,57.156,14.344,64.328,33
                  c5.047,13.125,2.969,24.094,1.313,68.125H93.132c-8.313,0-15.063,6.734-15.063,15.063v44.234c0,8.313,6.75,15.063,15.063,15.063
                  h19.547l30.734,178.688c0,9.031,7.328,16.359,16.375,16.359H352.21c9.031,0,16.359-7.328,16.359-16.359l30.75-178.688h19.547
                  c8.313,0,15.047-6.75,15.047-15.063v-44.234c0-8.328-6.734-15.063-15.047-15.063H275.241c-1.656-43.578-3.703-53.594,1.344-66.703
                  c7.172-18.641,39.641-27.234,66.875-34.422c27.25-7.141,108.969-38.703,117.578-87.438
                  C469.647,5.287,379.319-27.697,314.788,32.521z"></path>
              </g>
            </svg>
            <p class="desc">梨</p>
          </button>
        </li>
        <li class="navitem">
          <button class="tab-button" id="tab2">
            <svg version="1.1" id="sale" class="navitem-img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
              <g>
                <path class="st0" d="M438.528,131.72H73.472L34.477,512h443.047L438.528,131.72z M156.842,220.051
                  c-9.029,0-16.34-7.319-16.34-16.34c0-9.022,7.311-16.34,16.34-16.34c9.03,0,16.34,7.318,16.34,16.34
                  C173.183,212.732,165.872,220.051,156.842,220.051z M355.149,220.051c-9.03,0-16.34-7.319-16.34-16.34
                  c0-9.022,7.311-16.34,16.34-16.34c9.029,0,16.34,7.318,16.34,16.34C371.489,212.732,364.178,220.051,355.149,220.051z"></path>
                <path class="st0" d="M194.374,51.668c15.813-15.787,37.515-25.515,61.626-25.523c24.111,0.008,45.814,9.736,61.626,25.523
                  c15.787,15.813,25.516,37.515,25.524,61.626h26.144C369.285,50.714,318.579,0.009,255.999,0
                  c-62.578,0.009-113.285,50.714-113.294,113.294h26.145C168.859,89.183,178.587,67.481,194.374,51.668z"></path>
              </g>
            </svg>
            <p class="desc">販売</p>
          </button>
        </li>
        <li class="navitem">
          <button class="tab-button" id="tab3">
            <svg version="1.1" id="access" class="navitem-img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">

              <g>
                <path class="st0" d="M500.325,211.661l-34.024-54.143c-11.508-18.302-31.61-29.402-53.216-29.402H254.645
                  c-26.654,0-52.195,10.719-70.849,29.745l-45.216,46.107L30.738,228.933C12.733,233.11,0,249.147,0,267.615v42.348
                  c0,9.122,7.406,16.538,16.538,16.538h57.336c-0.074,1.141-0.185,2.274-0.185,3.425c0,29.8,24.167,53.958,53.977,53.958
                  c29.792,0,53.958-24.158,53.958-53.958c0-1.151-0.111-2.284-0.185-3.425h169.67c-0.074,1.141-0.185,2.274-0.185,3.425
                  c0,29.8,24.166,53.958,53.958,53.958c29.81,0,53.958-24.158,53.958-53.958c0-1.151-0.092-2.284-0.166-3.425h36.789
                  c9.132,0,16.538-7.416,16.538-16.538v-57.81C512,237.824,507.954,223.801,500.325,211.661z M127.666,351.43
                  c-11.879,0-21.494-9.643-21.494-21.504c0-11.871,9.615-21.495,21.494-21.495c11.86,0,21.494,9.624,21.494,21.495
                  C149.16,341.786,139.526,351.43,127.666,351.43z M264.13,215.754h-97.188l37.198-37.93c13.216-13.476,31.628-21.198,50.505-21.198
                  h9.486V215.754z M374.998,215.754h-85.94v-59.128h85.94V215.754z M404.882,351.43c-11.86,0-21.494-9.643-21.494-21.504
                  c0-11.871,9.634-21.495,21.494-21.495c11.879,0,21.494,9.624,21.494,21.495C426.376,341.786,416.761,351.43,404.882,351.43z
                  M399.944,215.754v-59.128h13.142c11.879,0,22.756,6.004,29.067,16.065l27.062,43.063H399.944z"></path>
              </g>
            </svg>

            <p class="desc">当園</p>
          </button>
        </li>
      </ul>
      
    </nav>
  </header>

  <div class="content">
    <div class="tab-content" id="tab0-content">
      <div class="signboard">
        <img src="img/background1.jpg" alt="一戦場梨園1" class="signboard-back">
        <div id="slideshow">
          <img src="img/background1.jpg" alt="一戦場梨園1">
          <img src="img/background2.jpg" alt="一戦場梨園2">
        </div>
        <div class="signboard-str1">蔵王の麓で育まれた</div>
        <div class="signboard-str2">瑞々しい梨をお楽しみください</div>
      </div>
      <div class="history">
        <div class="title stripe">更新履歴</div>
        <div class="detail">
          <?php foreach($rows as $row) { ?>
            
            <div class="history-row">
              <span class="text-dark"><?= h($row[HistorysDao::POST_DATE]) ?></span>
                <?php if ($row[HistorysDao::CATEGORY_ID] == 1) { ?>
                  <span class="history-normal"><?= h($row[HistorysDao::CATEGORY_NAME]) ?></span>
                <?php } else { ?>
                  <span class="history-important"><?= h($row[HistorysDao::CATEGORY_NAME]) ?></span>
                <?php } ?>
              <?php if ($row[HistorysDao::POST_DATE] > date('Y-m-d 23:59:59', strtotime('-' . NEW_PERIOD . ' day'))) { ?>
                <span class="history-new">New</span>
              <?php } ?>
            </div>
            <div class="mb-3">
              <?php foreach($contents[$row[HistorysDao::ID]] as $content) { ?>
                <div>
                  <?php if(strlen(trim($content[ContentsDao::ADDRESS])) > 0) { ?>
                    <a href="<?= h($content[ContentsDao::ADDRESS]) ?>"><?= h($content[ContentsDao::CONTENT]) ?></a>
                  <?php } else { ?>
                    <?= h($content[ContentsDao::CONTENT]) ?>
                  <?php } ?>
                </div>
              <?php } ?>
            </div>
            
          <?php } ?>
        </div>
      </div>
    </div>
    <div class="tab-content" id="tab1-content">
      
      <div class="about">
        <div class="farm-owner">
          <img src="img/farm-owner.png">
          <div class="farm-owner-desc">園主の近影</div>
        </div>
        <div>
          <h2><i class="far fa-lightbulb icon"></i>種類</h2>
          <p>当園では幸水、豊水、あきづき、新高の4種類の梨を育てています。</p>
          <p>※以下の表は当園の収穫時期の目安です。気候により前後いたします。</p>
          <h2><i class="far fa-lightbulb icon"></i>梨の保存方法</h2>
          <p>梨は生ものですのでお早めにお召し上がりください。新聞紙に包んで冷蔵庫に入れることでおいしく保存できます。</p>
        </div>
      </div>
      
      <div class="harvest">
        <div class="harvest-header">
          <div class="harvest-name">品種名</div>
          <div class="harvest-month-7">7月</div>
          <div class="harvest-month-8">8月</div>
          <div class="harvest-month-9">9月</div>
          <div class="harvest-month-10">10月</div>
        </div>
          <?php   
          for($i = 0; $i < count(AgString::PEAR); $i++) { ?>
            <div class="harvest-row-<?= $i ?>">
              <div class="harvest-name"><?= AgString::PEAR[$i]['name'] ?></div>
              <?php 
              for($j = 7; $j < 11; $j++) { 
                for($k = 0; $k < 3; $k++) { 
                  $startMonth = ($k === 0) ? ' harvest-period ' : '';
                  $endMonth = ($j === 10 && $k === 2) ? ' harvest-end ' : '';
                  $color = getColorClass(AgString::PEAR, $i, $j, $k);
              ?>
                <div class="harvest-col-<?= $j ?>-<?= $k ?> 
                  <?= $color ?><?= $startMonth ?><?= $endMonth ?>">
                </div>
              <?php 
                }
              } ?>
            </div>
          <?php } ?>
      </div>
    </div>
    <div class="tab-content" id="tab2-content">
      <div>
        <div>
          <h2><i class="far fa-smile icon"></i>販売方法</h2>
          <p>現在は直販のみ行っています。</p>
        </div>
        <div>
          <h2><i class="fas fa-yen-sign icon"></i>価格</h2>
          <p>未定（収穫量に応じて値付けしているため）</p>
        </div>
        <div class="price-ref">
          <h3>※前年度の参考価格</h3>
          <table>
          <tr>
              <th>量</th>
              <th>金額（税込み）</th>
            </tr>
            <tr>
              <td>1kg（箱無し）</td>
              <td class="yen">500円</td>
            </tr>
            <tr>
              <td>5kg（箱入り）</td>
              <td class="yen">2,700円</td>
            </tr>
            <tr>
              <td>10kg（箱入り）</td>
              <td class="yen">4,860円</td>
            </tr>
          </table>
        </div>
        <h2><i class="fas fa-truck-moving icon"></i>配送</h2>
        <p>別料金で配送（ヤマト運輸）を承っております。</p>
        <h2><i class="far fa-question-circle icon"></i>その他</h2>
        <p>小規模な梨園のため売り切れになる場合もございます。その際はご容赦ください。</p>
        <p>詳しくは「お問い合わせ」からご連絡ください。</p>
      </div>
    </div>
    <div class="tab-content" id="tab3-content">
      <address>
        <?php
          for($i = 0; $i < count(AgString::ICONS); $i++) {
        ?>
          <div class="address-parent">
            <div class="address-icon icon">
              <i class="<?= AgString::ICONS[$i] ?>" ></i>
            </div>
            <div class="address-content">
              <div><?= AgString::TITLES[$i] ?></div>
              <div><?= AgString::CONTENTS[$i] ?></div>
            </div>
          </div>

          <?php }?>
      </address>
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3138.8713626893705!2d140.64868244921246!3d38.11992699990271!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x5f8a39aebdad3fbd%3A0xfc256962de621911!2z44CSOTg5LTA4MjEg5a6u5Z-O55yM5YiI55Sw6YOh6JS1546L55S65YaG55Sw5LiA5oim5aC077yR4oiS77yR!5e0!3m2!1sja!2sjp!4v1551967216973"
        width="100%" height="200" style="border:0"></iframe>
    </div>
    
  </div>
  
  <footer>
    <i class="far fa-copyright"></i>
    <span>2019</span>
    <span>一戦場梨園</span>
    <!-- <span>お問い合わせ</span> -->
  </footer>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
  <script src="../lib/animejs/lib/anime.min.js"></script>
  <script src="script/pear.js"></script>

</body>
</html>