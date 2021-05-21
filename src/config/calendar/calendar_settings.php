<?php
//
// 動作環境の条件 ---------------
// PHP5.4以上
// SSIまたはPHPで外部ファイルの参照が可能
// ----------------------------
//
// 自動カレンダー更新プログラムを利用する際には下記の設定を行なって下さい。
// ① 定休診・休業日の設定
// ② イレギュラーの休業日、開業日を設定
// ③ カレンダーの表示数を設定
// ④ フィードに表示される案内メッセージの設定
//
// 上記設定が完了したら、html内の表示したい箇所に下記タグを埋め込んで下さい。
// <!--#include virtual="config/calender/tpl.php"-->
//
//

// ① 定休診・休業日の設定
// 0 = 営業
// 1 = 休み
// 2 = 午前休み
// 3 = 午後休み
// 4 = その他
$schedule = array(
	'Mon' => 0, //月
	'Tue' => 0, //火
	'Wed' => 1, //水
	'Thu' => 0, //木
	'Fri' => 0, //金
	'Sat' => 0, //土
	'Sun' => 1, //日
	'Hol' => 1  //祝
);

// ② イレギュラーの休業日を設定
// カンマ区切りで休みの日を数字で指定
// 例 array(1,6,7,8,9,10)
$close_January   = array(); //1月
$close_February  = array(); //2月
$close_March     = array(); //3月
$close_April     = array(); //4月
$close_May       = array(); //5月
$close_June      = array(); //6月
$close_July      = array(); //7月
$close_August    = array(); //8月
$close_September = array(); //9月
$close_October   = array(); //10月
$close_November  = array(); //11月
$close_December  = array(); //12月

// ② イレギュラーの開業・診療日を設定
// カンマ区切りで日にちを数字で指定
// 例 array(1,6,7,8,9,10)
$open_January   = array(); //1月
$open_February  = array(); //2月
$open_March     = array(); //3月
$open_April     = array(); //4月
$open_May       = array(); //5月
$open_June      = array(); //6月
$open_July      = array(); //7月
$open_August    = array(); //8月
$open_September = array(); //9月
$open_October   = array(); //10月
$open_November  = array(); //11月
$open_December  = array(); //12月

// ② その他を設定
// カンマ区切りで日にちを数字で指定
// 例 array(1,6,7,8,9,10)
$other_January   = array(); //1月
$other_February  = array(); //2月
$other_March     = array(); //3月
$other_April     = array(); //4月
$other_May       = array(); //5月
$other_June      = array(); //6月
$other_July      = array(); //7月
$other_August    = array(); //8月
$other_September = array(); //9月
$other_October   = array(); //10月
$other_November  = array(); //11月
$other_December  = array(); //12月

// ③ カレンダーの表示数を設定
$change_year = 0; // 0 = 今年を開始年として表示、 2020 = 入力した数字を開始年として表示
$change_month = 0; // 0 = 今月を開始月として設定、 1〜12 = 入力した数字を開始月として表示
$visible_count = 2; // ※タブの数
$tab = 1; // 0 = なし、1 = あり

// ④ フィードに表示される案内メッセージの設定
// 下記の項目を設定下さい。
$feed_visible_date = 10; //メッセージが標示されている日数
$feed_text         = '診療カレンダーを更新いたしました。';


//
// ------------------------------------------------------------------------
// !!ここから下は編集しないで下さい!!
// ------------------------------------------------------------------------
//

$close_date = array(
	'Jan' => $close_January,
	'Feb' => $close_February,
	'Mar' => $close_March,
	'Apr' => $close_April,
	'May' => $close_May,
	'Jun' => $close_June,
	'Jul' => $close_July,
	'Aug' => $close_August,
	'Sep' => $close_September,
	'Oct' => $close_October,
	'Nov' => $close_November,
	'Dec' => $close_December,
);

$open_date = array(
	'Jan' => $open_January,
	'Feb' => $open_February,
	'Mar' => $open_March,
	'Apr' => $open_April,
	'May' => $open_May,
	'Jun' => $open_June,
	'Jul' => $open_July,
	'Aug' => $open_August,
	'Sep' => $open_September,
	'Oct' => $open_October,
	'Nov' => $open_November,
	'Dec' => $open_December,
);


$other_date = array(
	'Jan' => $other_January,
	'Feb' => $other_February,
	'Mar' => $other_March,
	'Apr' => $other_April,
	'May' => $other_May,
	'Jun' => $other_June,
	'Jul' => $other_July,
	'Aug' => $other_August,
	'Sep' => $other_September,
	'Oct' => $other_October,
	'Nov' => $other_November,
	'Dec' => $other_December,
);

/**
 * JSON 生成
 * @param $ical_url
 * @return array|false
 */
function get_date_from_ics($ical_url)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $ical_url);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$result = curl_exec($ch);
	curl_close($ch);
	if (!empty($result)) {
		$items = $sort = array();
		$start = false;
		$count = 0;
		foreach (explode("\n", $result) as $row => $line) {
			// 1行目が「BEGIN:VCALENDAR」でなければ終了
			if (0 === $row && false === stristr($line, 'BEGIN:VCALENDAR')) {
				break;
			}
			// 改行などを削除
			$line = trim($line);
			// 「BEGIN:VEVENT」なら日付データの開始
			if (false !== stristr($line, 'BEGIN:VEVENT')) {
				$start = true;
			} elseif ($start) {
				// 「END:VEVENT」なら日付データの終了
				if (false !== stristr($line, 'END:VEVENT')) {
					$start = false;
					// 次のデータ用にカウントを追加
					++$count;
				} else {
					// 配列がなければ作成
					if (empty($items[$count])) {
						$items[$count] = array('date' => null, 'title' => null);
					}
					// 「DTSTART;～」（対象日）の処理
					if (0 === strpos($line, 'DTSTART;VALUE')) {
						$date = explode(':', $line);
						$date = end($date);
						$items[$count]['date'] = $date;
						// ソート用の配列にセット
						$sort[$count] = $date;
					}
					// 「SUMMARY:～」（名称）の処理
					elseif (0 === strpos($line, 'SUMMARY:')) {
						list($title) = explode('/', substr($line, 8));
						$items[$count]['title'] = trim($title);
					}
				}
			}
		}
		// 日付でソート
		$items = array_combine($sort, $items);
		ksort($items);
		return $items;
	}
}
/**
 * jsonファイルの最終更新日を見て、毎月更新される。
 * @param $file_path
 * @param $ical_url
 */
function holiday_json_write($file_path, $ical_url)
{
	// 現在日時を取得
	$now_time = (int) date('Ym');
	$file_time = 0;
	// holiday.jsonが存在し、ファイルサイズが0より大きい場合に
	// 最終更新日の取得
	if (file_exists($file_path) && filesize($file_path) > 0) {
		$file_timestamp = filemtime($file_path);
		$file_time = (int) date('Ym', $file_timestamp);
	}
	// 年月の文字列で比較して、月一更新されるようにする
	$time = $file_time - $now_time;
	if ($time < 0) {
		$holidays = get_date_from_ics($ical_url);
		// json_encodeの定数がPHP5.4未満では未定義のため、条件分岐してエラー回避
		if (defined('JSON_UNESCAPED_UNICODE') && defined('JSON_PRETTY_PRINT')) {
			file_put_contents($file_path, json_encode($holidays, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		} else {
			file_put_contents($file_path, json_encode($holidays));
		}
	}
}
$holiday_file_path    = dirname(__FILE__) . '/holiday.json';
$calendar_id = urlencode('japanese__ja@holiday.calendar.google.com');
$ical_url = 'https://calendar.google.com/calendar/ical/' . $calendar_id . '/public/full.ics';
holiday_json_write($holiday_file_path, $ical_url);


/*
 * JSON形式が取得できない場合に、iCal形式から取得する
 * 期間の指定などは不可
 * 前後3年分ほどが取得できる
 */
function japan_holiday_ics()
{
	global $holiday_file_path;
	$json = file_get_contents($holiday_file_path);
	if ($json === false) {
		// カレンダーID
		$calendar_id = urlencode('japanese__ja@holiday.calendar.google.com');
		$url = 'https://calendar.google.com/calendar/ical/' . $calendar_id . '/public/full.ics';
		return get_date_from_ics($url);
	} else {
		$data = json_decode($json, true);
		if (!isset($data)) {
			$data = array();
		}
		return $data;
	}
}
