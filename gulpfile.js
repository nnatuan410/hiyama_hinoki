const gulp = require('gulp');
const fs = require('fs');
const browsersync = require('browser-sync').create(); // ライブリロード
const sass = require('gulp-sass'); // sass変換
const gcmq = require('gulp-group-css-media-queries'); // メディアクエリをまとめる
const cleancss = require('gulp-clean-css'); // css圧縮
const rename = require('gulp-rename'); // 出力ファイル名変更
const autoprefixer = require('gulp-autoprefixer'); // cssプレフィックス追加
const babel = require('gulp-babel'); // es2015に変換
const uglify = require('gulp-uglify'); // js圧縮
const imagemin = require('gulp-imagemin'); // 画像圧縮
const pngquant = require('imagemin-pngquant'); // png圧縮
const mozjpeg = require('imagemin-mozjpeg'); // jpg圧縮
const svgo = require('imagemin-svgo'); // svg圧縮
const webp = require('imagemin-webp'); // webp生成
const favicons = require('favicons').stream;
const del = require('del'); // ファイル・フォルダ削除
const changed = require('gulp-changed'); // ファイルに変更があったか確認する
const debug = require('gulp-debug'); // デバッグ

// 設定ファイルを取得
const config = JSON.parse(fs.readFileSync('./package.json', 'utf8')).config;
let env = {};
try {
	env = JSON.parse(fs.readFileSync('./env.json', 'utf8'));
} catch (err) {
	if (err.code === 'ENOENT') {
	}
}

const dir = {
	src: './' + config.dir.src, // 作業ディレクトリ
	dist: './' + config.dir.dist, // 出力先ディレクトリ
};

// ライブリロードのURLを設定（env.jsonがあればそこから設定）
let devEnv = {
	proxy: 'localhost' + '/' + config.dir.site + config.dir.git + config.dir.dist, // ローカル環境のURL
};
if (env.browserSync) {
	if (env.browserSync.host) {
		if (env.browserSync.path) {
			devEnv.proxy = env.browserSync.host + env.browserSync.path;
		} else {
			devEnv.proxy = env.browserSync.host + '/' + config.dir.site + config.dir.git + config.dir.dist;
		}
	}
	if (env.browserSync.port) {
		devEnv.port = env.browserSync.port;
	}
}

// prettier-ignore
let glob = {
	scss: [
		dir.src + '**/[^_]*.scss',
		'!' + dir.src + 'lib/**/*.scss',
	],
	scss_module: [
		dir.src + '**/_*.scss',
		'!' + dir.src + 'lib/**/*.scss',
	],
	css: [
		dir.src + '**/[^_]*.css',
		'!' + dir.src + '**/*.min.css',
		'!' + dir.src + 'lib/**/*.css',
	],
	js: [
		dir.src + '**/[^_]*.js',
		'!' + dir.src + '**/*.min.js',
		'!' + dir.src + 'lib/**/*.js',
	],
	img: [
		dir.src + '**/*.{jpeg,jpg,png,svg}',
		'!' + dir.src + 'favicon.{png,svg}',
		'!' + dir.src + 'apple-touch-icon*',
	],
	raster: [
		dir.src + '**/*.{jpeg,jpg,png}',
		'!' + dir.src + 'favicon*',
		'!' + dir.src + 'apple-touch-icon*',
	],
	other: [
		dir.src + '**/*',
		'!' + dir.src + '**/*.{scss,css,js,jpeg,jpg,png,svg}',
		dir.src + '**/*.min.{css,js}',
		dir.src + 'lib/**',
	],
	clean: [
		dir.dist + '*',
		'!' + dir.dist + '.*',
		'!' + dir.dist + 'google*.html',
		'!' + dir.dist + 'sitemap*.xml',
		'!' + dir.dist + 'favicon*',
		'!' + dir.dist + 'apple-touch-icon*',
		'!' + dir.dist + config.dir.cms + '**',
		dir.dist + config.dir.cms + 'wp-content/themes',
	]
}

// browser-sync初期化
gulp.task('bs:init', (done) => {
	browsersync.init(devEnv);
	done();
});

// SCSSの処理 ( CSS変換 プレフィックス付与 > 圧縮 > ファイル名に .min を追加 > ブラウザの更新)
gulp.task('scss', () => {
	return gulp
		.src(glob.scss, {
			base: dir.src,
		})
		.pipe(
			changed(dir.dist, {
				extension: '.css',
			})
		)
		.pipe(sass())
		.pipe(gcmq())
		.pipe(autoprefixer({grid: true}))
		.pipe(gulp.dest(dir.dist))
		.pipe(
			cleancss({
				level: 2,
			})
		)
		.pipe(
			rename({
				suffix: '.min',
			})
		)
		.pipe(gulp.dest(dir.dist))
		.pipe(browsersync.stream());
});
gulp.task('scss:all', () => {
	return gulp
		.src(glob.scss, {
			base: dir.src,
		})
		.pipe(sass())
		.pipe(gcmq())
		.pipe(autoprefixer({grid: true}))
		.pipe(gulp.dest(dir.dist))
		.pipe(
			cleancss({
				level: 2,
			})
		)
		.pipe(
			rename({
				suffix: '.min',
			})
		)
		.pipe(gulp.dest(dir.dist))
		.pipe(browsersync.stream());
});

// CSSの処理 ( CSS変換 プレフィックス付与 > 圧縮 > ファイル名に .min を追加 > ブラウザの更新)
gulp.task('css', () => {
	return gulp
		.src(glob.css, {
			base: dir.src,
		})
		.pipe(changed(dir.dist))
		.pipe(gcmq())
		.pipe(autoprefixer({grid: true}))
		.pipe(gulp.dest(dir.dist))
		.pipe(
			cleancss({
				level: 2,
			})
		)
		.pipe(
			rename({
				suffix: '.min',
			})
		)
		.pipe(gulp.dest(dir.dist))
		.pipe(browsersync.stream());
});

// javascriptの処理 ( 圧縮 > ファイル名に .min を追加)
gulp.task('js', () => {
	return gulp
		.src(glob.js, {
			base: dir.src,
		})
		.pipe(changed(dir.dist))
		.pipe(
			babel({
				// sourceType: 'script',    // 'use strict' を出力しない設定
				presets: [
					[
						'@babel/preset-env',
						{
							targets: {
								ie: '11',
							},
						},
					],
				],
			})
		)
		.pipe(gulp.dest(dir.dist))
		.pipe(uglify())
		.pipe(
			rename({
				suffix: '.min',
			})
		)
		.pipe(gulp.dest(dir.dist));
});

// jpgの圧縮
gulp.task('imgmin', () => {
	return gulp
		.src(glob.img, {
			base: dir.src,
		})
		.pipe(changed(dir.dist))
		.pipe(
			imagemin([
				pngquant({
					quality: [0.7, 0.9],
				}),
				mozjpeg({
					quality: 85,
				}),
				svgo({
					plugins: [
						{
							removeViewBox: false,
						},
						{
							mergePaths: false,
						},
						{
							removeAttrs: {attrs: 'data-name'},
						},
					],
				}),
			])
		)
		.pipe(gulp.dest(dir.dist));
});

// webP変換
gulp.task('webp', () => {
	return gulp
		.src(glob.raster, {
			base: dir.src,
		})
		.pipe(changed(dir.dist))
		.pipe(
			imagemin([
				webp({
					quality: 90,
					metadata: 'icc',
				}),
			])
		)
		.pipe(
			rename((path) => {
				path.extname += '.webp';
			})
		)
		.pipe(gulp.dest(dir.dist));
});

// 画像圧縮とwebp生成
gulp.task('img', gulp.parallel('imgmin', 'webp'));

// ファビコン生成
gulp.task('favicon', () => {
	return gulp
		.src(dir.src + 'favicon.svg')
		.pipe(
			favicons({
				icons: {
					android: false,
					appleIcon: true,
					appleStartup: false,
					coast: false,
					favicons: true,
					firefox: false,
					windows: false,
					yandex: false,
				},
			})
		)
		.pipe(gulp.dest(dir.dist));
});

// copy
gulp.task('copy', () => {
	return gulp
		.src(glob.other, {
			base: dir.src,
			allowEmpty: true,
		})
		.pipe(changed(dir.dist))
		.pipe(gulp.dest(dir.dist));
});

// clean
gulp.task('clean', () => {
	return del(glob.clean);
});

// clean dryRun
gulp.task('clean:dry', () => {
	return del(glob.clean, {dryRun: true}).then((paths) => {
		console.log('下記ディレクトリ・ファイルを削除します\n' + paths.join('\n').replace(new RegExp(__dirname + '/', 'g'), ''));
	});
});

// delete min file
gulp.task('src:del:min', () => {
	return del([dir.src + '**/*.min.{css,js}', '!' + dir.src + 'lib/**/*.{css,js}']);
});

// convert css to scss
gulp.task(
	'src:conv:css',
	gulp.series(
		() => {
			return gulp
				.src([dir.src + '**/*.css', '!' + dir.src + 'lib/**/*.css'], {
					base: dir.src,
				})
				.pipe(
					rename((path) => {
						path.extname = '.scss';
					})
				)
				.pipe(gulp.dest(dir.src));
		},
		() => {
			return del([dir.src + '**/*.css', '!' + dir.src + 'lib/**/*.css']);
		}
	)
);

// delete webp
gulp.task('src:del:webp', () => {
	return del([dir.src + '**/*.webp', '!' + dir.src + 'lib/**/*.webp']);
});

// build
gulp.task('build', gulp.parallel('scss', 'css', 'js', 'img', 'copy'));

// 画像以外build
gulp.task('build:doc', gulp.parallel('scss', 'css', 'js', 'copy'));

// rebuild
gulp.task('rebuild', gulp.series('clean', gulp.parallel('scss', 'css', 'js', 'img', 'copy')));

// ライブリロードとcss, js圧縮
gulp.task(
	'default',
	gulp.series('bs:init', () => {
		// ブラウザリロード
		const reload = (done) => {
			browsersync.reload();
			done();
		};

		gulp.watch(glob.scss, gulp.task('scss'));
		gulp.watch(glob.scss_module, gulp.task('scss:all'));
		gulp.watch(glob.css, gulp.task('css'));
		gulp.watch(glob.js, gulp.series('js', reload));
		gulp.watch(glob.img, gulp.series('img', reload));
		gulp.watch(glob.other, gulp.series('copy', reload));
	})
);
