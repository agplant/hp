// DOMを全て読み込んでから開始
window.onload = function(){
// alert('test');
  // タブを取得
  const tabButtons = document.getElementsByClassName('tab-button');
  // コンテンツの中身
  const tabContents = document.getElementsByClassName('tab-content');

  // タブ初期化
  setTabContent(tabButtons[0].id);

  for(const item of tabButtons) {
    
    // タブがクリックされたら対処のコンテンツを表示
    item.addEventListener('click', () => {

      anime({
        targets: `#${item.id} .navitem-img`,
        rotateY: 360,
        duration: 300,
        easing: 'easeInOutExpo',
        loop: 5,
        direction: 'alternate'
      });

      setTabContent(item.id);
      
    }, false);
  }

  $('#slideshow').slick({
    accessibility: false,
    autoplay: true,
    // autoplaySpeed: 3000,
    arrows: false,
    fade: true,
    speed: 2000
    
  });

 
  
  // 表を作成
  // createChart();

  // IDが含まれるタブ内容を表示する
  // 条件
  // ・tabIdがcontentIdに含まれなければならない(tab:hoge1, content:content-hoge1)
  // ・contentはcssで初期状態をnoneにしなければならない
  // 　読み込み完了後に処理しているため、一瞬全タブが表示されてしまう）
  function setTabContent(enableId) {
    // alert(enableId);
    for(const item of tabContents) {
      // alert(`${item.id} : ${enableId}`);
      if(item.id.indexOf(enableId) >= 0) {
        item.style.display = 'block';
      }
      else {
        item.style.display = 'none';
      }
    }
  }

  // const canvas = document.getElementById("canvas");

//   function createChart() {
//     // ガントチャート作りたい
//     // https://codezine.jp/article/detail/10541

    
//     // var context = canvas.getContext('2d');
//     var x = this.canvas.offsetLeft;
//     var y = this.canvas.offsetTop;
//   console.log("x:", x, "y:", y);

// const height = 200;
// const border = 1;
// const width = 400;


//   drawRect(x, y, border, height);
//   drawRect(x, y + height, width, border);

  

//   // const kosui = {
//   //   'name': '幸水',
//   //   'startM': 7, 
//   //   'startD': 1, 
//   //   'endM': 8, 
//   //   'endD': 2};
// console.log(Object.keys(pear).length);
//   for(let i = 0; i < Object.keys(pear).length; i++) {
    
//     drawMonthChart(i, pear[i]);
//     // drawRect(x, (y + graphMargin) * (i + 1), width, graphWidth);
//   }

//   }

  

  // 6～11月　10日で1範囲、10:0, 20:1, 30:2
  // function createChart() {

  //   // 1メモリの大きさ
  //   const cell = 20;
  //   // グラフ同士の隙間
  //   const marginY = 10;
  //   // グラフの横位置調整
  //   // const paddingLeft = 0;

  //   var offsetX = this.canvas.offsetLeft;
  //   var offsetY = this.canvas.offsetTop;
  //   var context = this.canvas.getContext('2d');

  //   const pear = {
  //     0: {
  //       'name': '幸水',
  //       'startM': 7, 
  //       'startD': 1, 
  //       'endM': 8, 
  //       'endD': 1},
  //     1: {
  //       'name': '豊水',
  //       'startM': 7, 
  //       'startD': 2, 
  //       'endM': 8, 
  //       'endD': 2},
  //   };

  //   const pearCount = Object.keys(pear).length;
  //   const rowNameWidth = 50;
  //   const startMonth = 7;
  //   const cellInMonth = 3;
  //   const fontAdjust = 15;

  //   const outerYWidth = (cell + marginY) * pearCount + marginY;
  //   const outerXWidth = (11 - startMonth) * cellInMonth * cell;
    

  //   drawRect(offsetX + rowNameWidth, offsetY, 1, outerYWidth);
  //   drawRect(offsetX + rowNameWidth, offsetY + outerYWidth, outerXWidth, 1);
  //   // context.fillText(`x 月`, offsetX + rowNameWidth, offsetY + outerYWidth + fontAdjust);
  //   console.log(`${offsetX + rowNameWidth}, ${offsetY + outerYWidth}, ${outerXWidth}`);

  //   for(let month = startMonth; month < 11; month++) {
  //     console.log(`${month} 月`);
  //     console.log((offsetX + rowNameWidth) + cellInMonth * cell * (month - startMonth));
  //     console.log(offsetY + outerYWidth);
  //     context.fillText(`${month} 月`, 
  //                   (offsetX + rowNameWidth) + cellInMonth * cell * (month - startMonth), 
  //                   offsetY + outerYWidth + fontAdjust);
  //   }

  //   for(let i = 0; i < pearCount; i++) {
  //     number = i;
  //     item = pear[i];
  //     name = item['name'];
  //     startM = item['startM'];
  //     startD = item['startD'];
  //     endM = item['endM'];
  //     endD = item['endD'];

  //     const y = offsetY + marginY + (cell + marginY) * number;
  //     const startX = offsetX + rowNameWidth + ((startM - startMonth) * cell * cellInMonth) + (startD * cell);
  //     const endX = offsetX + rowNameWidth + ((endM - startMonth) * cell * cellInMonth) + (endD * cell);

      
  //     context.fillRect(
  //       startX, 
  //       y, 
  //       endX - startX, 
  //       cell);

  //     context.fillText(name, offsetX, y + fontAdjust);
  //   }
  // }

  // function drawRect(x, y, width, height) {
  //   var context = this.canvas.getContext('2d');
  //   context.fillRect(x, y, width, height);
  // }

// メモ

// 引数渡せる
// item.addEventListener('click', (event) => {
//   // alert(item);
//   test(`いえーい ${item.id} : ${event.target.id} : ${event.target.getAttribute('class')}`);
// }, false);


}
