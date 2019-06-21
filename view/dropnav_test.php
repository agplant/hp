<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" >
  <title>AgPlant</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script
  src="http://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
  

  <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
  <link rel="stylesheet" type="text/css" media="screen" href="../css/dropnav_test.css">
  <!-- 
    ドロップダウンナビゲーションバー
    https://www.seleqt.net/programming/pure-css-responsive-navigation-1/ 
    大体実装できたが、リサイズ時の処理が変（ドロップダウンが壊れている）で直せないので中断
    -->
    
</head>
<body>
  <section class="navigation">
    <div class="nav-container">
      <div class="brand">
        <a href="#">一戦場梨園</a>
      </div>

      <nav>
        <div class="nav-mobile">
          <a id="nav-toggle" href="#!">
            <span id="hamburger-line"></span>
          </a>
        </div>
        <ul class="nav-list">
          <li><a class="nav-a" href="#">Home</a></li>
          <li><a class="nav-a" href="#">About</a></li>
          <li>
            <a class="nav-a nav-parent" href="#" onclick="navParentOnClick();">Service</a>
            <!-- <ul class="nav-dropdown">
              <li><a href="#">Test1</a></li>
              <li><a href="#">Test2</a></li>
              <li><a href="#">Test3</a></li>
            </ul> -->
          </li>
          <li>
            <a class="nav-a nav-parent" href="#" onclick="navParentOnClick();">Portfolio</a>
            <!-- <ul class="nav-dropdown">
              <li><a href="#">Test1</a></li>
              <li><a href="#">Test2</a></li>
              <li><a href="#">Test3</a></li>
            </ul> -->
          </li>
          <li><a class="nav-a" href="#">Contact</a></li>
        </ul>
      </nav>

    </div>
    
  </section>

  <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script> -->
  <script src="../script/dropnav_test.js"></script>

</body>
</html>