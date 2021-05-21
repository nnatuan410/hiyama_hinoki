<?php
require_once dirname(__FILE__) . '/settings.php';

$json = file_get_contents(dirname(__FILE__) . '/json/setting.json');
$json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
$settings = json_decode($json, true);
$parts = $_GET['parts']; // 出力テンプレートの切り替え
$match = parse_url($_SERVER["REQUEST_URI"]);
$common = $settings['common']; // サイト共通データ
$path = str_replace(_ROOT_DIRECTORY_, '', $match["path"]);
$path_arr = explode('/', trim($path, '/')); // 各階層のディレクトリ名の配列
if (count($path_arr) === 1 && $path_arr[0] === '') {
	$path_arr = array();
}
$depth = count($path_arr); // 階層深さ
$pages = array(); // 各階層のデータを入れる配列
$page = array(); // 現在のページのデータを入れる変数 =$pages[$depth-1]
$response_code = http_response_code();

// 各階層のデータを$pagesに追加
for ($i = 0; $i < $depth; $i++) {
	if ($i === 0) {
		if (array_key_exists($path_arr[$i], $settings['directory'])) {
			$pages[$i] = $settings['directory'][$path_arr[$i]];
			$pages[$i]['url'] = '/' . implode('/', array_slice($path_arr, 0, $i + 1)) . '/'; // ドキュメントルートからのURLのデータを追加
		} else {
			$pages = null; // 階層名と同じデータが無いとき、$pagesを空に設定
			break;
		}
	} else {
		if (array_key_exists($path_arr[$i], $pages[$i - 1]['cascade'])) {
			$pages[$i] = array_merge($pages[$i - 1], $pages[$i - 1]['cascade'][$path_arr[$i]]);
			$pages[$i]['url'] = '/' . implode('/', array_slice($path_arr, 0, $i + 1)) . '/';
		} else {
			$pages = null;
			break;
		}
	}
	// 現在の階層がファイル名のとき、URL最後のスラッシュを削除
	if ($i === $depth - 1 && strpos($path_arr[$depth - 1], '.') !== false) {
		$pages[$i]['url'] = rtrim($pages[$i]['url'], '/');
	}
}

// 現在のページの情報を $page に格納
$default_title = 'ページタイトルを設定してください';
$default_title_en = 'Please set a page title';
if ($depth === 0) {
	$page = $common;
} elseif (isset($pages)) {
	for ($i = 0; $i < $depth; $i++) {
		unset($pages[$i]['cascade']);
	}
	$page = $pages[$depth - 1];
} else {
	if ($response_code === 404) {
		$pages[0] = array(
			'title' => 'ページが見つかりません',
			'title-en' => 'Not found',
			'noindex' => true,
			'url' => '/404.php'
		);
		$page = $pages[0];
		$depth = 1;
	} else {
		$page['title'] = $default_title;
		$page['title-en'] = $default_title_en;
	}
}

// ページ設定
$title = !empty($page['title']) ? $page['title'] : $default_title;
$title_en = !empty($page['title-en']) ? $page['title-en'] : $default_title_en;
$title_html = !empty($page['title-html']) ? $page['title-html'] : $title;
$page_title = $common['site-title'];
$title_separator = '｜';
if ($page['page-title']) {
	$page_title = $page['page-title'];
} elseif ($depth === 0 && $page['title']) {
	$page_title = $page['title'] . $title_separator . $common['site-title'];
} elseif (isset($pages)) {
	$page_title = '';
	for ($i = $depth - 1; $i >= 0; $i--) {
		$page_title .= $pages[$i]['title'] . $title_separator;
	}
	$page_title .= $common['site-title'];
}
$keyword = !empty($page['keyword']) ? $page['keyword'] : $common['keyword'];
$description = !empty($page['description']) ? $page['description'] : $common['description'];
$seo_text = !empty($page['seo-text']) ? $page['seo-text'] : $common['seo-text'];
$noindex = !empty($page['noindex']) ? $page['noindex'] : $common['noindex'];

// データ処理終了 以下テンプレート
?>

<?php
//ページタイトル
if ($parts == 'page-title') :
?>
	<h1><?php echo $title_html; ?><span class="en"><?php echo $title_en; ?></span></h1>

<?php
//パンくずリスト
elseif ($parts == 'breadcrumb') :
	$pos = 1; // 階層深さ
?>
	<ul itemscope itemtype="http://schema.org/BreadcrumbList">
		<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
			<a itemprop="item" href="<?php echo _ROOT_DIRECTORY_; ?>/"><span itemprop="name"><?php echo $common['home-title']; ?></span></a>
			<meta itemprop="position" content="<?php echo $pos; ?>" />
		</li>
		<?php $pos++; ?>
		<?php for ($i = 0; $i < count($pages); $i++) : ?>
			<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<a itemprop="item" href="<?php echo _ROOT_DIRECTORY_ . $pages[$i]['url']; ?>"><span itemprop="name"><?php echo $pages[$i]['title']; ?></span></a>
				<meta itemprop="position" content="<?php echo $pos; ?>" />
			</li>
			<?php $pos++; ?>
		<?php endfor; ?>
	</ul>

<?php
//SEOテキスト
elseif ($parts == 'seo') :
	echo $seo_text;
?>

<?php
//METAタグ関連
elseif ($parts == 'meta') :
?>
	<meta name="format-detection" content="telephone=no">
	<meta name="keywords" content="<?php echo $keyword; ?>">
	<meta name="description" content="<?php echo $description; ?>">
	<title><?php echo $page_title; ?>
	</title>
	<?php if ($noindex === true) : ?>
		<meta name="robots" content="noindex,nofollow">
	<?php endif; ?>
	<link rel="icon" href="<?php echo _ROOT_DIRECTORY_; ?>/favicon.ico">
	<link rel="apple-touch-icon" href="<?php echo _ROOT_DIRECTORY_; ?>/apple-touch-icon.png" sizes="180x180">
<?php endif;
