{
	/* クリップボードにコピーする関数 */
	const execCopy = (string) => {
		// 空div 生成
		let tmp = document.createElement('div');
		// 選択用のタグ生成
		let pre = document.createElement('pre');

		// 親要素のCSSで user-select: none だとコピーできないので書き換える
		pre.style.webkitUserSelect = 'auto';
		pre.style.userSelect = 'auto';

		// インデント削除
		string = string.replace(/([ ]{4,}|[\t]{1,})/g, '');

		tmp.appendChild(pre).textContent = string;

		// 要素を画面外へ
		let s = tmp.style;
		s.position = 'fixed';
		s.right = '200%';

		// body に追加
		document.body.appendChild(tmp);
		// 要素を選択
		document.getSelection().selectAllChildren(tmp);

		// クリップボードにコピー
		let result = document.execCommand('copy');

		// 要素削除
		document.body.removeChild(tmp);

		return result;
	};

	// let container = document.querySelectorAll('.uim_container');
	// let all = document.body.querySelectorAll('*');
	// let modules = [];
	// for (let i = 0; i < all.length; i++) {
	// 	all[i].classList.forEach((str) => {
	// 		if (str.indexOf('ui_') === 0) {
	// 			modules.push(all[i]);
	// 		}
	// 	});
	// }
	// for (let i = 0; i < modules.length; i++) {
	// 	modules[i].classList.add('uim');
	// }

	// const modeControl = document.createElement('div');
	// modeControl.setAttribute('id', 'uim_mode');
	// modeControl.setAttribute('data-mode', 'normal');

	// const btnNormal = document.createElement('a');
	// btnNormal.classList.add('normal');
	// btnNormal.innerText = '通常';
	// btnNormal.addEventListener(
	// 	'click',
	// 	(e) => {
	// 		document.body.contentEditable = false;
	// 		modeControl.setAttribute('data-mode', 'normal');
	// 	},
	// 	false
	// );

	// const btnEditable = document.createElement('a');
	// btnEditable.classList.add('editable');
	// btnEditable.innerText = '編集';
	// btnEditable.addEventListener(
	// 	'click',
	// 	(e) => {
	// 		document.body.contentEditable = true;
	// 		modeControl.setAttribute('data-mode', 'editable');
	// 	},
	// 	false
	// );

	// modeControl.insertAdjacentElement('beforeend', btnNormal);
	// modeControl.insertAdjacentElement('beforeend', btnEditable);
	// document.body.insertAdjacentElement('beforeend', modeControl);

	// for(let i=0; i<container.length; i++){
	// 	console.log(container[i]);
	// 	Sortable.create(container[i], {
	// 		group: 'hoge',
	// 		fallbackOnBody: true,
	// 		swapThreshold: 0.65,
	// 		animation: 100
	// 	});
	// }
}

{
	let myContextMenu = document.createElement('div');
	myContextMenu.setAttribute('id', 'uim_contextmenu');
	document.body.insertAdjacentElement('beforeend', myContextMenu);
	document.body.addEventListener(
		'contextmenu',
		function (e) {
			let posX = e.pageX;
			let posY = e.pageY - window.pageYOffset;
			myContextMenu.classList.remove('show');
			myContextMenu.textContent = '';

			let clickEl = document.elementFromPoint(posX, posY);
			let clickModules = [];
			let closestModule = clickEl.closest('h2, h3, h4, h5, h6, h2 span, h3 span, h4 span, h5 span, h6 span, p, li, th, td, dt, dd');
			// while (closestModule) {
			// 	clickModules.push(closestModule);
			// 	closestModule = closestModule.parentNode.closest('h2, h3, h4, h5, h6, p, li, th, td, dt, dd');
			// }
			if (closestModule) {
				e.preventDefault();
				let menuList = document.createElement('div');

				// let className;
				// for (let j = 0; j < el.classList.length; j++) {
				// 	if (clickModules[i].classList[j].indexOf('ui_') === 0) {
				// 		className = el.classList[j];
				// 		break;
				// 	}
				// }
				let elStr = closestModule.tagName.toLowerCase();
				if (elStr === 'span') {
					elStr = closestModule.closest('h2, h3, h4, h5, h6').tagName.toLowerCase() + '>' + elStr;
				}
				if (closestModule.classList) {
					let cls = closestModule.classList;
					for (let i = 0; i < cls.length; i++) {
						if (cls[i] !== 'uim') {
							elStr += '.' + cls[i];
						}
					}
				}
				menuList.insertAdjacentHTML('beforeend', '<span>' + elStr + '</span>');

				let btn_copy = document.createElement('a');
				btn_copy.textContent = 'HTMLをコピー';
				btn_copy.addEventListener(
					'click',
					() => {
						execCopy(closestModule.innerHTML);
					},
					false
				);
				menuList.insertAdjacentElement('beforeend', btn_copy);

				myContextMenu.insertAdjacentElement('beforeend', menuList);
			}

			myContextMenu.style.left = posX + 'px';
			myContextMenu.style.top = posY + 'px';
			myContextMenu.classList.add('show');
		},
		false
	);

	document.body.addEventListener(
		'click',
		function () {
			if (myContextMenu.classList.contains('show')) {
				myContextMenu.classList.remove('show');
			}
		},
		false
	);
}
