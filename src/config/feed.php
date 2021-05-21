<?php require_once(dirname(__FILE__) . '/settings.php'); ?>
<?php if (!empty($_GET)) : ?>

	<?php if (!empty($_GET['info']) && isset($_GET['info'])) : ?>
		<?php

		$json = file_get_contents(dirname(__FILE__) . '/json/info.json');
		$json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
		$infos = json_decode($json, true);
		$common = $infos['common']; // お知らせフィードの設定
		$arr_info = $infos['info']; // お知らせのデータ

		//カレンダーお知らせの記述
		if (!empty($common['calendar'])) {
			$month = date('m');
			$year = date("Y");
			$calendar = array(
				'time'  => $year . '-' . $month . '-01 00:00',
				'title' => '',
				'text'  => $common['calendar']
			);
			array_push($arr_info, $calendar);
		}
		// echo "<pre>";
		// print_r($arr_info);
		// echo "</pre>";
		$sort = array();
		foreach ($arr_info as $key => $val) {
			// timeでソートする準備　
			$sort[$key] = $val['time'];
		}
		// 配列のkeyのtimeでソート
		array_multisort($sort, SORT_DESC, $arr_info);
		// データ処理終了 以下テンプレート
		?>

		<?php

		// 日付のフォーマット
		switch ($common['format']) {
			case '1':
				$format = 'Y.m.d';
				break;
			case '2':
				$format = 'Y/m/d';
				break;
			case '3':
				$format = 'Y年m月d日';
				break;
			default:
				$format = 'Y.m.d';
				break;
		}
		$html = "";
		if ($common['html'] == 'dl') {
			$html .= "<dl>";
			foreach ($arr_info as $key => $val) {
				// 出力
				$date = $val["time"];
				$date = date($format,  strtotime($date));
				$html .= "<dt>{$date}</dt>";
				$html .= "<dd>";
				if (!empty($val['title'])) {
					$html .= "【{$val['title']}】</br>";
				}
				if (!empty($val['text'])) {
					$html .= "{$val['text']}";
				}
				$html .= "</dd>";
			}
			$html .= "</dl>";
		} else {
			$html .= "<ul>";
			foreach ($arr_info as $key => $val) {
				// 出力
				$date = $val["time"];
				$date = date($format,  strtotime($date));
				$html .= "<li>{$date}</br>";
				if (!empty($val['title'])) {
					$html .= "【{$val['title']}】</br>";
				}
				if (!empty($val['text'])) {
					$html .= "{$val['text']}";
				}
				$html .= "</li>";
			}
			$html .= "</ul>";
		}
		echo $html;
		// print_r($arr_info);
		?>

	<?php else : ?>
		<?php
		// print_r($_GET);
		//directory
		if (empty($_GET['directory']) || !isset($_GET['directory'])) {
			$directory = 'cms';
		} else {
			$directory = $_GET['directory'];
		}
		//post type
		if (empty($_GET['post_type']) || !isset($_GET['post_type'])) {
			$post_type = 'blog';
		} else {
			$post_type = $_GET['post_type'];
		}
		//num
		if (empty($_GET['count']) || !isset($_GET['count'])) {
			$count = 5;
		} else {
			$count = $_GET['count'];
		}
		//category
		if (empty($_GET['category']) || !isset($_GET['category'])) {
			$category = '';
			$taxonomy = '';
			$tax_array = '';
		} else {
			$category = $_GET['category'];
			$taxonomy = $post_type.'_category';
			$tax_array = array(
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'term_id',
					'terms'    => array( $category ),
				),
			);
		}
		//element
		if (empty($_GET['element']) || !isset($_GET['element'])) {
			$element = 'dl';
		} else {
			$element = $_GET['element'];
		}
		/** Loads the WordPress Environment and Template */
		$cms_path = dirname(__FILE__) . '/../' . $directory . '/wp-config.php';
		?>

		<?php
		if(file_exists($cms_path)):?>
			<?php
			require($cms_path);
			$wp->init();
			$wp->parse_request();
			$wp->query_posts();
			$wp->register_globals();

			$args = array(
				'post_type' => $post_type,
				'posts_per_page' => $count,
				'tax_query'  => $tax_array
			);
			$myquery = new WP_Query($args);
			if ($myquery->have_posts()) : ?>
				<?php if ($element == 'ul') : ?>
					<ul>
						<?php while ($myquery->have_posts()) :
							$myquery->the_post(); ?>
							<li><a href="<?php the_permalink(); ?>"><?php the_time('Y.m.d'); ?> <?php the_title(); ?></a></li>
						<?php endwhile;
						wp_reset_postdata(); ?>
					</ul>
				<?php else : ?>
					<?php while ($myquery->have_posts()) :
						$myquery->the_post(); ?>
						<dl>
							<dt><?php the_time('Y.m.d'); ?></dt>
							<dd><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></dd>
						</dl>
					<?php endwhile;
					wp_reset_postdata(); ?>
				<?php endif; ?>
			<?php else : ?>
				<p class="noneCenter">只今準備中です。</p>
			<?php endif; ?>
			<?php wp_reset_query(); ?>
		<?php else : ?>
			<dl>
				<dt>0000.00.00</dt>
				<dd>テキストが入りますテキストが入ります</dd>
				<dt>0000.00.00</dt>
				<dd>テキストが入りますテキストがりますテキスト<br class="onlySP" />テキストが入りますテキストが入ります</dd>
				<dt>0000.00.00</dt>
				<dd>テキストが入りますテキストがります</dd>
				<dt>0000.00.00</dt>
				<dd>テキストが入りますテキストがります</dd>
				<dt>0000.00.00</dt>
				<dd>テキストが入りますテキストがります</dd>
				<dt>0000.00.00</dt>
				<dd>テキストが入りますテキストがります</dd>
			</dl>
		<?php endif; ?>
	<?php endif; ?>

<?php else : ?>
	<p>只今準備中です。</p>
<?php endif; ?>
