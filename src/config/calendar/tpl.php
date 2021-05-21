<?php
include_once(dirname(__FILE__) . '/config.php');
include_once(dirname(__FILE__) . '/calendar_settings.php');
$month = ($change_month == 0) ? date('n') : $change_month;
$year = ($change_year == 0) ? date('Y') : $change_year;

// $monthEn = date( "M", mktime( 0, 0, 0, $month, 1, $year ) );
// if (array_key_exists($monthEn,$open_date)) {
// 	echo '<pre>';
// 	echo $monthEn;
// 	print_r($open_date[$monthEn]);
// 	echo '</pre>';
// }
?>
<?php if ($_GET['type'] == 'feed' && $change_month == 0) : ?>
	<?php if ($_GET['element'] == 'li') : ?>
		<li><span><?php echo $year . '.' . $month . '.01'; ?></span> <?php echo $feed_text; ?></li>
	<?php else : ?>
		<dl>
			<dt><span><?php echo $year . '.' . $month . '.01'; ?></span></dt>
			<dd><?php echo $feed_text; ?></dd>
		</dl>
	<?php endif; ?>
<?php else : ?>

	<?php
	//カレンダー出力用の変数
	$day_array = array("日", "月", "火", "水", "木", "金", "土");
	$counter = $visible_count;
	$japan_holiday = japan_holiday_ics();
	?>

	<div class="calendar">
		<?php if ($tab == 1) : ?>
			<ul class="listTab">
				<?php
				for ($start = 0; $start < $counter; ++$start) {

					$month = ($change_month == 0) ? date('n') + $start : $change_month + $start;
					if ($month >= 13) {
						$year++;
						$month = $month - 12;
					}
					$tabClass = ($start == 0) ? "on" : "";
					$tabID = $start + 1;
					echo "<li class=\"tab {$tabClass}\" id=\"tab{$tabID}\"><a href=\"#\">{$month}月</a></li>";
				}
				?>
			</ul>
		<?php endif; ?>
		<div class="calendarIn">
			<?php
			for ($start = 0; $start < $counter; ++$start) {
				$month = ($change_month == 0) ? date('n') + $start : $change_month + $start;
				$year = ($change_year == 0) ? date('Y') : $change_year;;
				if ($month >= 13) {
					$year++;
					$month = $month - 12;
				}
				$monthEn = date("M", mktime(0, 0, 0, $month, 1, $year));
				if (array_key_exists($monthEn, $open_date)) {
					$open_days  = $open_date[$monthEn];
					$close_days = $close_date[$monthEn];
					$other_days = $other_date[$monthEn];
				}
				echo "<div class=\"boxContents\" id=\"cal0" . ($start + 1) . "\">";
				// echo "<p class=\"month\">".$year."年".$month."月</p>\n";
				echo "<table class=\"wFull taCalendar\">\n";
				echo "<thead>\n";
				echo "<tr>\n";
				echo "<th class=\"holiday\" abbr=\"日曜日\" scope=\"col\">日</th>\n";
				echo "<th scope=\"col\" abbr=\"月曜日\">月</th>\n";
				echo "<th scope=\"col\" abbr=\"火曜日\">火</th>\n";
				echo "<th scope=\"col\" abbr=\"水曜日\">水</th>\n";
				echo "<th scope=\"col\" abbr=\"木曜日\">木</th>\n";
				echo "<th scope=\"col\" abbr=\"金曜日\">金</th>\n";
				echo "<th scope=\"col\" abbr=\"土曜日\" class=\"saturday\">土</th>\n";
				echo "</tr>\n";
				echo "</thead>\n";
				$fir_weekday = date("w", mktime(0, 0, 0, $month, 1, $year));
				echo "<tbody>\n";
				echo "<tr>\n";
				$i = 0;
				while ($i != $fir_weekday) {
					echo "<td><span>&nbsp;</span></td>\n";
					$i++;
				}
				for ($_day = 1; checkdate($month, $_day, $year); $_day++) {
					//曜日の最後まできたらカウント値（曜日カウンター）を戻して行を変える
					if ($i > 6) {
						$i = 0;
						echo "</tr>\n";
						echo "<tr>\n";
					}
					$week = date("D", mktime(0, 0, 0, $month, $_day, $year));
					$holidaycheck = (int) ($year . sprintf("%02d", $month) . sprintf("%02d", $_day));
					$schedule_class = '';
					if (isset($schedule[$week]) && array_key_exists($week, $schedule)) {
						switch ($schedule[$week]) {
							case 1: //休日
								$schedule_class = $styletype[1];
								break;
							case 2: //午前休み
								$schedule_class = $styletype[2];
								break;
							case 3: //午後休み
								$schedule_class = $styletype[3];
								break;
							case 4: //その他
								$schedule_class = $styletype[4];
								break;
							default:
								$schedule_class = '';
								break;
						}
					}
					if (isset($schedule['Hol']) && array_key_exists($holidaycheck, $japan_holiday)) {
						switch ($schedule['Hol']) {
							case 1: //休日
								$schedule_class = $styletype[1];
								break;
							case 2: //午前休み
								$schedule_class = $styletype[2];
								break;
							case 3: //午後休み
								$schedule_class = $styletype[3];
								break;
							case 4: //その他
								$schedule_class = $styletype[4];
								break;
							default:
								$schedule_class = '';
								break;
						}
					}
					$style = $schedule_class;
					if (array_key_exists($_day, array_flip($open_days))) 	$style = "{$styletype[0]}";
					if (array_key_exists($_day, array_flip($close_days)))  $style = "{$styletype[1]}";
					if (array_key_exists($_day, array_flip($other_days)))  $style = "{$styletype[4]}";
					echo "<td class=\"" . $style . "\"><span>" . $_day . "</span></td>";
					$i++;
				}
				while ($i < 7) { //残りの曜日分空白（&nbsp;）で埋める
					echo "<td><span>&nbsp;</span></td>";
					$i++;
				}
				echo "</tr>\n";
				echo "</tbody>\n";
				echo "</table>\n";
				echo "</div>\n";
			}
			?>
			<!-- /#calendarIn -->
		</div>
		<!--calendar-->
	</div>
<?php endif; ?>
