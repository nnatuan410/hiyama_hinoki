<?php
//カレンダーの日付設定Asia/Tokyo
date_default_timezone_set('Asia/Tokyo');

//新着一覧の1ページに表示させる最大記事数
$pagemax = 10;

//管理者更新-カレンダー用メニュー設定
$schedule_array[0] = "診療日";
$schedule_array[1] = "休診日";
$schedule_array[2] = "午前休診";
$schedule_array[3] = "午後休診";
$schedule_array[4] = "その他";

//（管理者）カレンダー(一覧)用スタイル設定
$schedule_m[1] = "rest";
$schedule_m[2] = "am";
$schedule_m[3] = "pm";
$schedule_m[4] = "other";

//（管理者）カレンダー(選択)用スタイル設定
$schedule_s[0] = "work_txt";
$schedule_s[1] = "rest_txt";
$schedule_s[2] = "am_txt";
$schedule_s[3] = "pm_txt";
$schedule_s[4] = "other_txt";

//休診日のcss設定
$styletype[0] = "open";
$styletype[1] = "close";
$styletype[2] = "am_close";
$styletype[3] = "pm_close";
$styletype[4] = "other";
$styletype[5] = "irregular_open";
$styletype[6] = "irregular_close";

//土日休日のcss設定
$sun          = "holiday"; //日曜
$sat          = "saturday"; //土曜
$holiday      = "holiday"; //祝日
