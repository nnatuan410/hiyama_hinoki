const exec = require('child_process').execSync;
const rls = require('readline-sync');
const fs = require('fs');
const path = require('path');
const config = JSON.parse(fs.readFileSync('./package.json', 'utf8')).config;
const color = {
	red: '\u001b[31m',
	green: '\u001b[32m',
	yellow: '\u001b[33m',
	reset: '\u001b[0m',
};

let cmd_rsync = 'rsync'; // 実行するrsyncコマンドを入れる変数
let sync_host = ''; // 接続先サーバのURL
let sync_type = ''; // 実行するかどうかのフラグ [yes/dry/no]
let sync_exclude = ''; // 除外設定のフラグ [update/all/system/cancel]
const default_branch = config.branch.default; // デフォルトのブランチ（基本的にmaster）
const production_branch = config.branch.production; // 本番環境と同期するブランチ（一つ）
const autodeploy_branchs = config.branch.autodeploy; // プッシュ時に自動デプロイするブランチ（複数可、前方一致）
const exclude_branchs = []; // rsyncを実行しないブランチ（複数可、前方一致）
let errors = []; // エラー種類を追加する配列
let is_autodeploy_branch = false; // 自動デプロイを行うブランチかどうか

// ブランチ名を取得
const branch = exec('git rev-parse --abbrev-ref HEAD').toString().replace(/\r?\n/g, '');
if (!branch) {
	errors.push('branch');
}

//自動デプロイするブランチか確認
autodeploy_branchs.forEach(function (autodeploy_branch) {
	if (branch.startsWith(autodeploy_branch)) {
		is_autodeploy_branch = true;
	}
});
if (process.argv[4] === 'auto' && !is_autodeploy_branch) {
	errors.push('notauto');
}

// package.jsonのサイトディレクトリとgitディレクトリがローカル環境のディレクトリ名と一致するか確認
if (!(path.resolve(__dirname) + '/').endsWith(config.dir.site + config.dir.git)) {
	errors.push('dirname');
}

// 実行しないブランチか確認
exclude_branchs.forEach(function (exclude_branch) {
	if (branch.startsWith(exclude_branch)) {
		errors.push('exbranch');
	}
});

if (errors.length === 0) {
	// ブランチによって接続先サーバURLを設定
	if (config.server.hasOwnProperty(branch)) {
		sync_host = config.server[branch];
	} else {
		sync_host = config.server.test + config.dir.site + branch + '/' + config.dir.dist;
		if (!is_autodeploy_branch) {
			let sync_dir = rls.question(branch + 'ディレクトリに同期しますか？ [yes/main/no] ? ');
			if (sync_dir === 'yes' || sync_dir === 'y') {
				// ブランチ名のディレクトリのまま
			} else if (sync_dir === 'main' || sync_dir === 'm') {
				sync_host = config.server.test + config.dir.site + default_branch + '/' + config.dir.dist;
			} else {
				console.log('同期キャンセルしました');
				return false;
			}
		}
	}

	// 実行かドライランかでコマンドのオプションを設定
	console.log(color.green + 'BRANCH' + color.reset + ': ' + branch);
	console.log(color.green + 'SERVER' + color.reset + ': ' + sync_host);
	if (process.argv.length >= 3) {
		sync_type = process.argv[2];
		console.log('上記サーバーと同期しますか [yes/dry/no] ? ' + sync_type);
	} else {
		sync_type = rls.question('上記サーバーと同期しますか [yes/dry/no] ? ');
	}
	if (sync_type === 'yes' || sync_type === 'y') {
		cmd_rsync += ' -av';
	} else if (sync_type === 'dry' || sync_type === 'd') {
		cmd_rsync += ' -avn';
	} else {
		console.log('同期キャンセルしました');
		return false;
	}

	// 同期ファイルを選択してコマンドを変更
	if (process.argv.length >= 4) {
		sync_exclude = process.argv[3];
		console.log('同期の除外設定を選択 [update/all/system/cancel] ? ' + sync_exclude);
	} else {
		sync_exclude = rls.question('同期の除外設定を選択 [update/all/system/cancel] ? ');
	}
	if (branch === production_branch) {
		cmd_rsync += ' --exclude="sub/*"';
	}
	if (sync_exclude === 'update' || sync_exclude === 'u') {
		cmd_rsync += ' --exclude-from="rsync-update.txt" ./' + config.dir.dist + ' ' + sync_host;
	} else if (sync_exclude === 'all' || sync_exclude === 'a') {
		cmd_rsync += ' --delete --exclude-from="rsync-all.txt" ./' + config.dir.dist + ' ' + sync_host;
	} else if (sync_exclude === 'system' || sync_exclude === 's') {
		cmd_rsync += ' --exclude-from="rsync-system.txt" ' + sync_host + ' ./' + config.dir.dist;
	} else {
		console.log('同期キャンセルしました');
		return false;
	}

	// rsync実行
	console.log(color.green + 'COMMAND' + color.reset + ': ' + cmd_rsync);
	let rsync_result = exec(cmd_rsync);
	console.log(rsync_result.toString());
} else {
	if (errors.indexOf('branch') >= 0) {
		console.log(color.red + 'ERROR' + color.reset + ': 現在のブランチ名が取得できません');
	}
	if (errors.indexOf('notauto') >= 0) {
		console.log(color.red + 'ERROR' + color.reset + ': ' + branch + ' は自動デプロイ対象のブランチではありません');
	}
	if (errors.indexOf('dirname') >= 0) {
		console.log(color.red + 'ERROR' + color.reset + ': ローカル環境とpackage.jsonのサイト・gitディレクトリ名が一致しません');
	}
	if (errors.indexOf('exbranch') >= 0) {
		console.log(color.red + 'ERROR' + color.reset + ': ' + branch + ' は同期対象のブランチではありません');
	}
}
