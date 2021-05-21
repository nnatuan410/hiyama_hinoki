<?php require_once(dirname(__FILE__) . '/../../config/settings.php'); ?>
<?php
// 現在の階層を取得
$path = str_replace(_ROOT_DIRECTORY_, '',  parse_url($_SERVER['REQUEST_URI'])['path']);
$path_arr = explode('/', trim($path, '/'));
if (count($path_arr) === 1 && $path_arr[0] === '') $path_arr = array();
$path_depth = count($path_arr); // 階層深さ
?>

<?php if ($path_depth >= 1) : ?>
	<div id="menuBottomTreatment">
		<div class="container">
			<h3 class="title scrollEffect">
				<picture>
					<source media="(max-width: 750px)" srcset="<?php echo _ROOT_DIRECTORY_; ?>/common/img/h3_menu@2x.png" alt="">
					<img src="<?php echo _ROOT_DIRECTORY_; ?>/common/img/h3_menu.png" srcset="<?php echo _ROOT_DIRECTORY_; ?>/common/img/h3_menu@2x.png 2x" alt="">
				</picture>
			</h3>
			<ul class="list scrollEffectParent">
				<li>
					<a href="<?php echo _ROOT_DIRECTORY_; ?>/mtm/">
						<figure>
							<picture>
								<img src="<?php echo _ROOT_DIRECTORY_; ?>/common/img/ico_menu01.svg" alt="">
							</picture>
						</figure>
						<h4>MTM<br><span class="brackets">（診療の流れ）</span></h4>
					</a>
				</li>
				<li>
					<a href="<?php echo _ROOT_DIRECTORY_; ?>/pedodontics/">
						<figure>
							<picture>
								<img src="<?php echo _ROOT_DIRECTORY_; ?>/common/img/ico_menu02.svg" alt="">
							</picture>
						</figure>
						<h4>小児歯科</h4>
					</a>
				</li>
				<li>
					<a href="<?php echo _ROOT_DIRECTORY_; ?>/preventive/">
						<figure>
							<picture>
								<img src="<?php echo _ROOT_DIRECTORY_; ?>/common/img/ico_menu03.svg" alt="">
							</picture>
						</figure>
						<h4>予防歯科</h4>
					</a>
				</li>
				<li>
					<a href="<?php echo _ROOT_DIRECTORY_; ?>/periodontics/">
						<figure>
							<picture>
								<img src="<?php echo _ROOT_DIRECTORY_; ?>/common/img/ico_menu04.svg" alt="">
							</picture>
						</figure>
						<h4>歯周病治療</h4>
					</a>
				</li>
				<li>
					<a href="<?php echo _ROOT_DIRECTORY_; ?>/implant/">
						<figure>
							<picture>
								<img src="<?php echo _ROOT_DIRECTORY_; ?>/common/img/ico_menu05.svg" alt="">
							</picture>
						</figure>
						<h4>インプラント治療</h4>
					</a>
				</li>
				<li>
					<a href="<?php echo _ROOT_DIRECTORY_; ?>/cosmetic/">
						<figure>
							<picture>
								<img src="<?php echo _ROOT_DIRECTORY_; ?>/common/img/ico_menu06.svg" alt="">
							</picture>
						</figure>
						<h4>審美歯科</h4>
					</a>
				</li>
				<li>
					<a href="<?php echo _ROOT_DIRECTORY_; ?>/whitening/">
						<figure>
							<picture>
								<img src="<?php echo _ROOT_DIRECTORY_; ?>/common/img/ico_menu07.svg" alt="">
							</picture>
						</figure>
						<h4>ホワイトニング</h4>
					</a>
				</li>
				<li>
					<a href="<?php echo _ROOT_DIRECTORY_; ?>/oral/">
						<figure>
							<picture>
								<img src="<?php echo _ROOT_DIRECTORY_; ?>/common/img/ico_menu08.svg" alt="">
							</picture>
						</figure>
						<h4>口腔外科</h4>
					</a>
				</li>
			</ul>
		</div>
	</div>

	<div id="menuBottomOther" class="onlyPC">
		<div class="container scrollEffect">
			<ul>
				<li>
					<a href="<?php echo _ROOT_DIRECTORY_; ?>/price/">
						<p>治療費について</p>
						<figure>
							<picture>
								<img src="<?php echo _ROOT_DIRECTORY_; ?>/common/img/pic_menu_bottom03.jpg" srcset="<?php echo _ROOT_DIRECTORY_; ?>/common/img/pic_menu_bottom03@2x.jpg 2x" alt="">
							</picture>
						</figure>
					</a>
				</li>
				<li>
					<a href="<?php echo _ROOT_DIRECTORY_; ?>/cases/">
						<p>治療症例集</p>
						<figure>
							<picture>
								<img src="<?php echo _ROOT_DIRECTORY_; ?>/common/img/pic_menu_bottom04.jpg" srcset="<?php echo _ROOT_DIRECTORY_; ?>/common/img/pic_menu_bottom04@2x.jpg 2x" alt="">
							</picture>
						</figure>
					</a>
				</li>
				<li>
					<a href="<?php echo _ROOT_DIRECTORY_; ?>/recruit/">
						<p>求人情報</p>
						<figure>
							<picture>
								<img src="<?php echo _ROOT_DIRECTORY_; ?>/common/img/pic_menu_bottom05.jpg" srcset="<?php echo _ROOT_DIRECTORY_; ?>/common/img/pic_menu_bottom05@2x.jpg 2x" alt="">
							</picture>
						</figure>
					</a>
				</li>
				<li>
					<a href="<?php echo _ROOT_DIRECTORY_; ?>/news/">
						<p>お知らせ</p>
						<figure>
							<picture>
								<img src="<?php echo _ROOT_DIRECTORY_; ?>/common/img/pic_menu_bottom06.jpg" srcset="<?php echo _ROOT_DIRECTORY_; ?>/common/img/pic_menu_bottom06@2x.jpg 2x" alt="">
							</picture>
						</figure>
					</a>
				</li>
				<li>
					<a href="<?php echo _ROOT_DIRECTORY_; ?>/blog/">
						<p>スタッフブログ</p>
						<figure>
							<picture>
								<img src="<?php echo _ROOT_DIRECTORY_; ?>/common/img/pic_menu_bottom07.jpg" srcset="<?php echo _ROOT_DIRECTORY_; ?>/common/img/pic_menu_bottom07@2x.jpg 2x" alt="">
							</picture>
						</figure>
					</a>
				</li>
				<li>
					<a href="<?php echo _ROOT_DIRECTORY_; ?>/access/#parking">
						<p>コインパーキングのご案内</p>
						<figure>
							<picture>
								<img src="<?php echo _ROOT_DIRECTORY_; ?>/common/img/pic_menu_bottom08.jpg" srcset="<?php echo _ROOT_DIRECTORY_; ?>/common/img/pic_menu_bottom08@2x.jpg 2x" alt="">
							</picture>
						</figure>
					</a>
				</li>
			</ul>
		</div>
	</div>
<?php endif; ?>

<div id="contact">
	<div class="container scrollEffect">
		<h3 class="title">
			<picture>
				<source media="(max-width: 750px)" srcset="<?php echo _ROOT_DIRECTORY_; ?>/common/img/h3_contact_sp.png">
				<img src="<?php echo _ROOT_DIRECTORY_; ?>/common/img/h3_contact.png" srcset="<?php echo _ROOT_DIRECTORY_; ?>/common/img/h3_contact@2x.png 2x" alt="">
			</picture>
		</h3>
		<p>
			<a href="tel:0000000000" class="tel">
				<picture>
					<source media="(max-width: 750px)" srcset="<?php echo _ROOT_DIRECTORY_; ?>/common/img/txt_tel_contact_sp.png">
					<img src="<?php echo _ROOT_DIRECTORY_; ?>/common/img/txt_tel_contact.png" srcset="<?php echo _ROOT_DIRECTORY_; ?>/common/img/txt_tel_contact@2x.png 2x" alt="">
				</picture>
			</a>
		</p>
		<p>
			<a href="#" target="_blank" rel="noopener" class="btn">
				<picture>
					<source media="(max-width: 750px)" srcset="<?php echo _ROOT_DIRECTORY_; ?>/common/img/btn_reserve_contact_sp.png">
					<img src="<?php echo _ROOT_DIRECTORY_; ?>/common/img/btn_reserve_contact.png" srcset="<?php echo _ROOT_DIRECTORY_; ?>/common/img/btn_reserve_contact@2x.png 2x" alt="">
				</picture>
			</a>
		</p>
		<p>
			<a href="<?php echo _ROOT_DIRECTORY_; ?>/contact/" class="btn">
				<picture>
					<source media="(max-width: 750px)" srcset="<?php echo _ROOT_DIRECTORY_; ?>/common/img/btn_mail_contact_sp.png">
					<img src="<?php echo _ROOT_DIRECTORY_; ?>/common/img/btn_mail_contact.png" srcset="<?php echo _ROOT_DIRECTORY_; ?>/common/img/btn_mail_contact@2x.png 2x" alt="">
				</picture>
			</a>
		</p>
		<figure class="pic">
			<picture>
				<source media="(max-width: 750px)" srcset="<?php echo _ROOT_DIRECTORY_; ?>/common/img/pic_contact_sp.png">
				<img src="<?php echo _ROOT_DIRECTORY_; ?>/common/img/pic_contact.png" srcset="<?php echo _ROOT_DIRECTORY_; ?>/common/img/pic_contact@2x.png 2x" alt="">
			</picture>
		</figure>
	</div>
</div>

<footer id="footer">
	<div class="container scrollEffect">
		<div class="access">
			<h3 class="title">
				<a href="#">
					<picture>
						<source media="(max-width: 750px)" srcset="<?php echo _ROOT_DIRECTORY_; ?>/common/img/logo_footer_sp.png">
						<img src="<?php echo _ROOT_DIRECTORY_; ?>/common/img/logo.png" srcset="<?php echo _ROOT_DIRECTORY_; ?>/common/img/logo@2x.png 2x" alt="">
					</picture>
				</a>
			</h3>
			<p class="address">
				ダミーテキスト。ダミーテキスト。ダミーテキスト。ダミーテキスト。ダミー<br class="onlySP">
				ダミーテキスト。ダミー<br>
				ダミーテキスト。ダミー
			</p>
			<div class="schedule">
				<table>
					<thead>
						<tr>
							<th>診療時間</th>
							<td>月</td>
							<td>火</td>
							<td>水</td>
							<td>木</td>
							<td>金</td>
							<td>土</td>
							<td>日・祝</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th>0:00〜00:00</th>
							<td>●</td>
							<td>●</td>
							<td>／</td>
							<td class="wide">0:00～00:00</td>
							<td>●</td>
							<td class="wide">0:00～00:00</td>
							<td>／</td>
						</tr>
						<tr>
							<th>00:00〜00:00</th>
							<td>●</td>
							<td>●</td>
							<td>／</td>
							<td class="wide">00:00～00:00</td>
							<td>●</td>
							<td class="wide">00:00～00:00</td>
							<td>／</td>
						</tr>
					</tbody>
				</table>
				<p>
					ダミーテキスト。ダミーテキスト。ダミーテ<br>
					ダミーテキスト。ダミーテキスト。ダミーテ<br>
					ダミーテキスト。ダミーテキスト。ダミーテ<br>
					ダミーテキスト。ダミーテキスト。ダミーテ
				</p>
			</div>
		</div>

		<div class="link onlyPC">
			<ul>
				<li><a href="<?php echo _ROOT_DIRECTORY_; ?>/">ホーム</a></li>
				<li><a href="<?php echo _ROOT_DIRECTORY_; ?>/charm/">当院の5つの特徴</a></li>
				<li><a href="<?php echo _ROOT_DIRECTORY_; ?>/staff/">院長・スタッフ紹介</a></li>
				<li><a href="<?php echo _ROOT_DIRECTORY_; ?>/access/">医院紹介・アクセス</a></li>
				<li><a href="<?php echo _ROOT_DIRECTORY_; ?>/equipment/">院内設備</a></li>
				<li><a href="<?php echo _ROOT_DIRECTORY_; ?>/recruit/">求人情報</a></li>
				<li><a href="<?php echo _ROOT_DIRECTORY_; ?>/contact/">お問い合わせ</a></li>
			</ul>
			<ul>
				<li><a href="<?php echo _ROOT_DIRECTORY_; ?>/mtm/">MTM(診療の流れ)</a></li>
				<li><a href="<?php echo _ROOT_DIRECTORY_; ?>/pedodontics/">小児歯科</a></li>
				<li><a href="<?php echo _ROOT_DIRECTORY_; ?>/preventive/">予防歯科</a></li>
				<li><a href="<?php echo _ROOT_DIRECTORY_; ?>/periodontics/">歯周病治療</a></li>
				<li><a href="<?php echo _ROOT_DIRECTORY_; ?>/implant/">インプラント治療</a></li>
				<li><a href="<?php echo _ROOT_DIRECTORY_; ?>/cosmetic/">審美歯科</a></li>
				<li><a href="<?php echo _ROOT_DIRECTORY_; ?>/whitening/">ホワイトニング</a></li>
				<li><a href="<?php echo _ROOT_DIRECTORY_; ?>/oral/">口腔外科</a></li>
			</ul>
			<ul>
				<li><a href="<?php echo _ROOT_DIRECTORY_; ?>/price/">治療費について</a></li>
				<li><a href="<?php echo _ROOT_DIRECTORY_; ?>/cases/">治療症例集</a></li>
				<li><a href="<?php echo _ROOT_DIRECTORY_; ?>/news/">お知らせ</a></li>
				<li><a href="<?php echo _ROOT_DIRECTORY_; ?>/blog/">スタッフブログ</a></li>
			</ul>
		</div>
	</div>
	<div class="map">
		<iframe data-src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3240.4929176132914!2d139.72171195043325!3d35.68948598009512!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60188ba2aee0bc4b%3A0x60d79f4818e6f330!2z44Om44OL44OQ44O844K144Or44O744Kk44Oz44K_44Op44Kv44OG44Kj44OW5qCq5byP5Lya56S-!5e0!3m2!1sja!2sjp!4v1560921678893!5m2!1sja!2sjp" frameborder="0" style="border:0" allowfullscreen class="lazyload"></iframe>
	</div>
	<p class="copyright">Copyright &copy; ◯◯ dental clinic All rights reserved.</p>
</footer>

<footer id="footer02" class="end">
	<div class="container scrollEffect">
		<div class="access">
			<h3 class="title">
				<picture>
					<source media="(max-width: 750px)" data-srcset="<?php echo _ROOT_DIRECTORY_; ?>/common/img/02/h3_access_sp.png">
					<img data-src="<?php echo _ROOT_DIRECTORY_; ?>/common/img/02/h3_access.png" data-srcset="<?php echo _ROOT_DIRECTORY_; ?>/common/img/02/h3_access@2x.png 2x" alt="" class="lazyload">
				</picture>
			</h3>
			<div class="map">
				<div class="mask">
					<iframe data-src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3240.4929176132914!2d139.72171195043325!3d35.68948598009512!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60188ba2aee0bc4b%3A0x60d79f4818e6f330!2z44Om44OL44OQ44O844K144Or44O744Kk44Oz44K_44Op44Kv44OG44Kj44OW5qCq5byP5Lya56S-!5e0!3m2!1sja!2sjp!4v1560921678893!5m2!1sja!2sjp" frameborder="0" style="border:0" allowfullscreen class="lazyload"></iframe>
				</div>

				<p class="btn onlySP">
					<a href="https://goo.gl/maps/vjBG29xBuSGDphoy8" target="_blank" rel="noopener">
						<picture>
							<source media="(max-width: 750px)" data-srcset="<?php echo _ROOT_DIRECTORY_; ?>/common/img/02/btn_map_sp.png">
							<img data-src="//:0" alt="Google Mapで見る" class="lazyload">
						</picture>
					</a>
				</p>
			</div>
			<p class="address">
				〒000-0000<br>ダミーテキスト。ダミーテキスト。ダミーテキスト。<br>
				TEL 0000-00-0000
			</p>
			<div class="schedule">
				<table>
					<thead>
						<tr>
							<th></th>
							<td>月</td>
							<td>火</td>
							<td>水</td>
							<td>木</td>
							<td>金</td>
							<td>土</td>
							<td>日</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th>
								00:00 - 00:00
							</th>
							<td>●</td>
							<td>●</td>
							<td>●</td>
							<td>●</td>
							<td>●</td>
							<td>●</td>
							<td>●</td>
						</tr>
						<tr>
							<th>
								00:00 - 00:00
							</th>
							<td>●</td>
							<td>●</td>
							<td>●</td>
							<td>●</td>
							<td>●</td>
							<td>●</td>
							<td>●</td>
						</tr>
					</tbody>
				</table>
				<p>休診日：○○日</p>
			</div>
		</div>

		<div class="bottom">
			<h3 class="logo">
				<a href="<?php echo _ROOT_DIRECTORY_; ?>/">
					<picture>
						<source media="(max-width: 750px)" data-srcset="<?php echo _ROOT_DIRECTORY_; ?>/common/img/logo_footer_sp.png">
						<img data-src="<?php echo _ROOT_DIRECTORY_; ?>/common/img/logo.png" data-srcset="<?php echo _ROOT_DIRECTORY_; ?>/common/img/logo@2x.png 2x" alt="" class="lazyload">
					</picture>
				</a>
			</h3>
			<div class="link">
				<ul class="onlyPC">
					<li><a href="<?php echo _ROOT_DIRECTORY_; ?>/">ホーム</a></li>
					<li><a href="<?php echo _ROOT_DIRECTORY_; ?>/charm/">当院の5つの特徴</a></li>
					<li><a href="<?php echo _ROOT_DIRECTORY_; ?>/staff/">院長・スタッフ紹介</a></li>
					<li><a href="<?php echo _ROOT_DIRECTORY_; ?>/access/">医院紹介・アクセス</a></li>
					<li><a href="<?php echo _ROOT_DIRECTORY_; ?>/equipment/">院内設備</a></li>
					<li><a href="<?php echo _ROOT_DIRECTORY_; ?>/recruit/">求人情報</a></li>
					<li><a href="<?php echo _ROOT_DIRECTORY_; ?>/contact/">お問い合わせ</a></li>
				</ul>
				<ul class="onlyPC">
					<li><a href="<?php echo _ROOT_DIRECTORY_; ?>/mtm/">MTM(診療の流れ)</a></li>
					<li><a href="<?php echo _ROOT_DIRECTORY_; ?>/pedodontics/">小児歯科</a></li>
					<li><a href="<?php echo _ROOT_DIRECTORY_; ?>/preventive/">予防歯科</a></li>
					<li><a href="<?php echo _ROOT_DIRECTORY_; ?>/periodontics/">歯周病治療</a></li>
					<li><a href="<?php echo _ROOT_DIRECTORY_; ?>/implant/">インプラント治療</a></li>
					<li><a href="<?php echo _ROOT_DIRECTORY_; ?>/cosmetic/">審美歯科</a></li>
					<li><a href="<?php echo _ROOT_DIRECTORY_; ?>/whitening/">ホワイトニング</a></li>
					<li><a href="<?php echo _ROOT_DIRECTORY_; ?>/oral/">口腔外科</a></li>
				</ul>
				<ul class="onlyPC">
					<li><a href="<?php echo _ROOT_DIRECTORY_; ?>/price/">治療費について</a></li>
					<li><a href="<?php echo _ROOT_DIRECTORY_; ?>/cases/">治療症例集</a></li>
					<li><a href="<?php echo _ROOT_DIRECTORY_; ?>/news/">お知らせ</a></li>
					<li><a href="<?php echo _ROOT_DIRECTORY_; ?>/blog/">スタッフブログ</a></li>
				</ul>
			</div>
			<p class="copyright onlySP">Copyright &copy; ◯◯ DENTAL CLINIC All rights reserved.</p>
		</div>
	</div>
</footer>

<div id="fixed">
	<a href="#" target="_blank" rel="noopener" class="onlySP">
		<picture>
			<source media="(min-width: 751px)" srcset="//:0">
			<img src="<?php echo _ROOT_DIRECTORY_; ?>/common/img/btn_reserve_bottomfixed.png" alt="">
		</picture>
	</a>
	<a href="<?php echo _ROOT_DIRECTORY_; ?>/contact/" class="onlySP">
		<picture>
			<source media="(min-width: 751px)" srcset="//:0">
			<img src="<?php echo _ROOT_DIRECTORY_; ?>/common/img/btn_mail_bottomfixed.png" alt="">
		</picture>
	</a>
	<a href="tel:00000000000" class="onlySP">
		<picture>
			<source media="(min-width: 751px)" srcset="//:0">
			<img src="<?php echo _ROOT_DIRECTORY_; ?>/common/img/btn_tel_bottomfixed.png" alt="">
		</picture>
	</a>
	<a href="#" id="scrollUp" class="smoothScroll">
		<picture>
			<source media="(max-width: 750px)" srcset="<?php echo _ROOT_DIRECTORY_; ?>/common/img/btn_scroll_up.png">
			<img src="<?php echo _ROOT_DIRECTORY_; ?>/common/img/btn_scroll_up.png" srcset="<?php echo _ROOT_DIRECTORY_; ?>/common/img/btn_scroll_up@2x.png 2x" alt="">
		</picture>
	</a>
</div>
