
// JQueryであることを認識させる
(function($) {
  // DOMを全て読み込んでから開始
  $(function() {
    $('#nav-toggle').click( function() {
      $('nav ul').slideToggle();
      // alert("test");
    } );

    // this.classList：自分 （$("#nav-gottle")）配下の要素
    // toggle：activeが無かったら付与し、あったら削除する関数
    $('#nav-toggle').on('click', function() {
      this.classList.toggle('active');
      // alert("test");
    });

    
  });
})(jQuery);

// //リサイズ時の処理を定義
// (function () {
//   var timer = 0;
 
//   window.onresize = function () {
//     if (timer > 0) {
//       clearTimeout(timer);
//     }
 
//     timer = setTimeout(function () {
//       var obj = document.getElementById("#nav-toggle").classList.remove('active');
//       console.log('window resized'); //ここに処理の内容が入る
//     }, 200);
//   };
// }());