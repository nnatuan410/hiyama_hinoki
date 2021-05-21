<?php require_once(dirname(__FILE__) . '/../../config/settings.php'); ?>
<?php
// 現在の階層を取得
$path = str_replace(_ROOT_DIRECTORY_, '',  parse_url($_SERVER['REQUEST_URI'])['path']);
$path_arr = explode('/', trim($path, '/'));
if (count($path_arr) === 1 && $path_arr[0] === '') $path_arr = array();
$path_depth = count($path_arr); // 階層深さ
?>
<script src="<?php echo _ROOT_DIRECTORY_; ?>/common/js/viewport.min.js" defer></script>

<header id="header">
	<div class="top onlyPC">
		<div class="container">
			<p class="seo">
				<?php $_GET['parts'] = 'seo';
				include(dirname(__FILE__) . '/../../config/template.php'); ?>
			</p>
			<a href="#" target="_blank" rel="noopener" class="reserve">
				<picture>
					<source media="(max-width: 750px)" srcset="//:0">
					<img src="<?php echo _ROOT_DIRECTORY_; ?>/common/img/txt_reserve_header.png" srcset="<?php echo _ROOT_DIRECTORY_; ?>/common/img/txt_reserve_header@2x.png 2x" alt="">
				</picture>
			</a>
			<a href="<?php echo _ROOT_DIRECTORY_; ?>/contact" class="mail">
				<picture>
					<source media="(max-width: 750px)" srcset="//:0">
					<img src="<?php echo _ROOT_DIRECTORY_; ?>/common/img/txt_mail_header.png" srcset="<?php echo _ROOT_DIRECTORY_; ?>/common/img/txt_mail_header@2x.png 2x" alt="">
				</picture>
			</a>
		</div>
	</div>
	<div class="main">
		<div class="container">
			<?php if ($path_depth === 0) : ?>
				<h1 class="logo">
					<a href="<?php echo _ROOT_DIRECTORY_; ?>/">
						<picture>
							<source media="(max-width: 750px)" srcset="<?php echo _ROOT_DIRECTORY_; ?>/common/img/logo_sp.png">
							<img src="<?php echo _ROOT_DIRECTORY_; ?>/common/img/logo.png" srcset="<?php echo _ROOT_DIRECTORY_; ?>/common/img/logo@2x.png 2x" alt="">
						</picture>
					</a>
				</h1>
			<?php else : ?>
				<div class="logo">
					<a href="<?php echo _ROOT_DIRECTORY_; ?>/">
						<picture>
							<source media="(max-width: 750px)" srcset="<?php echo _ROOT_DIRECTORY_; ?>/common/img/logo_sp.png">
							<img src="<?php echo _ROOT_DIRECTORY_; ?>/common/img/logo.png" srcset="<?php echo _ROOT_DIRECTORY_; ?>/common/img/logo@2x.png 2x" alt="">
						</picture>
					</a>
				</div>
			<?php endif; ?>
			<div class="schedule onlyPC">
				<p>
					<picture>
						<source media="(max-width: 750px)" srcset="//:0">
						<img src="<?php echo _ROOT_DIRECTORY_; ?>/common/img/txt_schedule_header.png" srcset="<?php echo _ROOT_DIRECTORY_; ?>/common/img/txt_schedule_header@2x.png 2x" alt="">
					</picture>
				</p>
				<dl>
					<dt>月・火・金</dt>
					<dd>0:00～00:00/00:00～00:00</dd>
					<dt>木曜日</dt>
					<dd>0:00～00:00/00:00～00:00</dd>
					<dt>土曜日</dt>
					<dd>0:00～00:00/00:00～00:00</dd>
				</dl>
			</div>
			<a href="tel:0000000000" class="tel onlyPC">
				<picture>
					<source media="(max-width: 750px)" srcset="//:0">
					<img src="<?php echo _ROOT_DIRECTORY_; ?>/common/img/txt_tel_header.png" srcset="<?php echo _ROOT_DIRECTORY_; ?>/common/img/txt_tel_header@2x.png 2x" alt=" ">
				</picture>
			</a>
		</div>
	</div>
</header>

<a href="javascript:void(0);" id="menuBtn" class="onlySP">
	<div></div>
	<div></div>
	<div></div>
</a>

<?php include(dirname(__FILE__) . '/gnavi.php');
