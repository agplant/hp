<?php

// 一覧に表示する件数
define('LIST_MAX_COUNT', 20);

// 更新履歴表示画面で表示する件数
define('VIEW_MAX_COUNT', 5);

// NEWを表示する期間
define('NEW_PERIOD', 2);

// 更新内容を登録できる件数
define('CONTENT_MAX_COUNT', 5);

define('SCRIPT_PATH', 'script/');
define('UTILITY_PATH', 'utility/');
define('VIEW_PATH', 'view/');
define('DB_PATH', UTILITY_PATH . 'db/');

define('LIST_PATH', 'history_list.php');
define('EDIT_PATH', 'history_edit.php');
define('PREVIEW_PATH', 'preview.php');

// const UTILITY_PATH = 'utility/';
// const DB_PATH = UTILITY_PATH . 'db/';
// const SCRIPT_PATH = ROOT_PATH . 'script/';

?>