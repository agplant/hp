
// var changeRank = function (button, current) {
function changeRank(button, current, nameArray) {

  // 入れ替え先の番号計算
  var target = 0;
  if (button.name == "up") {
    target = current - 1;
  }
  else {
    target = current + 1;
  }
  
  // 要素を取得
  // Name関数の場合はリストが返されるため、強制的に1番目の要素を取得
  nameArray.forEach(element => {
    
    var currentItem = document.getElementsByName(element + '[' + current + ']')[0];
    var targetItem = document.getElementsByName(element + '[' + target + ']')[0];
    // alert(currentItem.value + ':' + targetItem.value);

    var tmp = currentItem.value;
    currentItem.value = targetItem.value;
    targetItem.value = tmp;
  });

}