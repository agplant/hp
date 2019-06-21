<?php

class AgString {

  const ICONS = [
    'awesome fas fa-tree fa-fw'
  , 'awesome fas fa-map-marker-alt'
  , 'awesome far fa-smile fa-fw'
  , 'awesome fas fa-phone fa-fw'
  , 'awesome far fa-envelope fa-fw'
  ];
  const TITLES = [
    '名称'
  , '住所'
  , '責任者'
  , '電話番号'
  , 'メール'
  ];
  const CONTENTS = [
    '一戦場梨園（いっせんばなしえん）'
  , '宮城県刈田郡蔵王町円田字一戦場１－１'
  , '我妻 康夫'
  , '<div><a href="tel:0224334023">0224-33-4023</a></div>電話を取れないことも多いため、「お問い合わせ」からご連絡くださいますと確実です。'
  , '<a href="mailto:issennba-nashien@gmail.com">こちらをタップ</a>'
  ];

  const PEAR = Array(
    0 => Array (
      'name' => '幸水',
      'startMonth' => 8,
      'startPeriod' => 2,
      'endMonth' => 9,
      'endPeriod' => 1,
    ),
    1 => Array (
      'name' => '豊水',
      'startMonth' => 9,
      'startPeriod' => 1,
      'endMonth' => 10,
      'endPeriod' => 0
    ),
    2 => Array (
      'name' => 'あきづき',
      'startMonth' => 9,
      'startPeriod' => 2,
      'endMonth' => 10,
      'endPeriod' => 1
    ),
    3 => Array (
      'name' => '新高',
      'startMonth' => 10,
      'startPeriod' => 0,
      'endMonth' => 10,
      'endPeriod' => 2
    )
  );
}
?>