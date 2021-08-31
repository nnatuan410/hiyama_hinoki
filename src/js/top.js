/* Loading
-------------------------------------------------------------------------------------------------------------------- */
{
	var loader = document.getElementById('loading');
	window.addEventListener('load', function moveTop() {
		loader.querySelector('logo').classList.add('loadingOver');
	});
}

let fadeLoad = Array.from(document.querySelectorAll('.fadeLoad'));
window.addEventListener('scroll', scanElements);
function scanElements(e) {
	fadeLoad.forEach((element) => {
		if (isVisible(element)) {
			element.classList.add('current');
		} else {
			// element.classList.remove('current');
		}
	});
}
function isVisible(element) {
	const elementDiv = element.getBoundingClientRect();
	let distanceFromTop = -50;
	return elementDiv.top - window.innerHeight < distanceFromTop ? true : false;
}

/* Main Visual (ex jQuery)
-------------------------------------------------------------------------------------------------------------------- */
{
	const loading = document.getElementById('loading');
	const mv = document.getElementById('mainVisual');
	const bg = document.querySelector('.bg');
	const pic = document.querySelector('.slide>li');
	const mvBg = mv.querySelectorAll('.bg>span');
	const mvDeco = mv.querySelectorAll('.deco>span');
	const mvSlide = mv.querySelectorAll('.pic>.slide');
	const mvTitle = mv.querySelectorAll('.title>span');
	const scrollDown = mv.querySelector('#scrollDown');

	window.addEventListener(
		'load',
		() => {
			anime
				.timeline({
					easing: 'easeOutSine',
				})
				.add(
					{
						targets: loading,
						opacity: [1, 0],
						duration: 600,
						begin: () => {
							loading.style.pointerEvents = 'none';
						},
						complete: () => {
							loading.style.display = 'none';
							logo.style.classList.add('logoStart');
						},
					},
					0
				);
			// .add(
			// 	{
			// 		targets: mvBg,
			// 		translateX: [-200, 0],
			// 		translateY: (el, i) => {
			// 			switch (i) {
			// 				case 0:
			// 					return [64, 0];
			// 					break;
			// 				case 1:
			// 					return [-64, 0];
			// 					break;
			// 			}
			// 		},
			// 		delay: (el, i) => {
			// 			return 400 * i;
			// 		},
			// 		duration: 800,
			// 	},
			// 	0
			// )
			// .add(
			// 	{
			// 		targets: mvDeco,
			// 		translateX: [-300, 0],
			// 		translateY: (el, i) => {
			// 			switch (i) {
			// 				case 0:
			// 					return [96, 0];
			// 					break;
			// 				case 1:
			// 					return [-96, 0];
			// 					break;
			// 			}
			// 		},
			// 		delay: (el, i) => {
			// 			return 400 * i;
			// 		},
			// 		opacity: 1,
			// 		duration: 800,
			// 	},
			// 	100
			// )
			// .add(
			// 	{
			// 		targets: null,
			// 		begin: () => {
			// 			const fadeSpeed = 800;
			// 			const switchDelay = 400;
			// 			const switchDuretion = 7000;
			// 			const slideLen = mvSlide.length;
			// 			let current = 0;

			// 			// init
			// 			mvSlide[0].style.zIndex = 1;
			// 			mvSlide[0].classList.add('current');
			// 			anime({
			// 				targets: mvSlide[0].children,
			// 				begin: () => {
			// 					for (let i = 0; i < mvSlide[0].children.length; i++) {
			// 						mvSlide[0].children[i].style.maxWidth = '580px';
			// 					}
			// 				},
			// 				translateX: [-100, 0],
			// 				translateY: (el, i) => {
			// 					switch (i) {
			// 						case 0:
			// 							return [32, 0];
			// 							break;
			// 						case 1:
			// 							return [-32, 0];
			// 							break;
			// 					}
			// 				},
			// 				delay: (el, i) => {
			// 					return 400 * i;
			// 				},
			// 				opacity: [0, 1],
			// 				duration: 800,
			// 				easing: 'easeOutSine',
			// 			});

			// 			if (slideLen >= 2) {
			// 				const mvTimer = anime({
			// 					targets: null,
			// 					duration: switchDuretion,
			// 					loop: true,
			// 					loopComplete: () => {
			// 						changeSlide(current + 1);
			// 					},
			// 					autoplay: false,
			// 				});

			// 				mvTimer.play();

			// 				const changeSlide = (n) => {
			// 					if (n % slideLen === current) {
			// 						return;
			// 					}

			// 					var prevSlide = mvSlide[current];
			// 					prevSlide.classList.remove('current');
			// 					current = n % slideLen;

			// 					var newSlide = mvSlide[current];
			// 					newSlide.classList.add('current');
			// 					newSlide.style.zIndex = 1;

			// 					anime({
			// 						targets: newSlide.children,
			// 						maxWidth: [0, 580],
			// 						delay: (el, i) => {
			// 							return switchDelay * i;
			// 						},
			// 						easing: 'easeOutSine',
			// 						duration: fadeSpeed,
			// 						complete: () => {
			// 							for (let i = 0; i < prevSlide.children.length; i++) {
			// 								prevSlide.children[i].style.maxWidth = 0;
			// 							}
			// 							newSlide.style.zIndex = 0;
			// 						},
			// 					});
			// 				};
			// 			}
			// 		},
			// 	},
			// 	400
			// )
			// .add(
			// 	{
			// 		targets: mvTitle,
			// 		maxWidth: [0, 530],
			// 		duration: 600,
			// 		delay: (el, i) => {
			// 			return 300 * i;
			// 		},
			// 		easing: 'linear',
			// 	},
			// 	1000
			// )
			// .add(
			// 	{
			// 		targets: scrollDown,
			// 		opacity: [0, 1],
			// 		translateY: [-20, 0],
			// 		duration: 1000,
			// 		easing: 'linear',
			// 	},
			// 	'-=600'
			// );
		},
		false
	);
}

/* message acordion (ex jQuery)
-------------------------------------------------------------------------------------------------------------------- */
{
	const aco = document.querySelectorAll('#message .txt');
	for (let i = 0; i < aco.length; i++) {
		const btn = aco[i].querySelector('.btnMore');
		const cnt = aco[i].querySelector('.acordion');
		btn.addEventListener(
			'click',
			(e) => {
				e.preventDefault();
				if (isSP) {
					e.preventDefault();
					if (cnt.hasClass('open')) {
						cnt.classList.remove('open');
						btn.classList.remove('open');
					} else {
						cnt.classList.add('open');
						btn.classList.add('open');
					}
				}
			},
			false
		);
	}

	window.addEventListener(
		'sp2pc',
		() => {
			for (let i = 0; i < aco.length; i++) {
				const btn = aco[i].querySelectorAll('.btnMore').classList.remove('open');
				const cnt = aco[i].querySelectorAll('.acordion').classList.remove('open');
			}
		},
		false
	);
}

/* flow slider
-------------------------------------------------------------------------------------------------------------------- */
{
	const flowSwiper = new Swiper('#flow .swiper-container', {
		slidesPerView: 'auto',
		navigation: {
			nextEl: '#flow .swiper-button-next',
			prevEl: '#flow .swiper-button-prev',
		},
		autoplay: {
			delay: 6000,
		},
	});
}

/* custom scrollbar (ex jQuery)
-------------------------------------------------------------------------------------------------------------------- */
{
	OverlayScrollbars(document.querySelectorAll('#info .main .feed'), {});
}

/* tab (ex jQuery)
-------------------------------------------------------------------------------------------------------------------- */
{
	const tab = new UiTab('#info .calendar .listTab', '#info .calendar .calendarIn', {
		triggerSelector: '.tab>a',
		targetSelector: '.boxContents',
	});
}

/* ==========================================
 Instagram feed
========================================== */
{
	const instagram = document.getElementById('instagram');
	const instagramFeed = instagram.querySelector('.feed');
	let isInit = false;

	window.addEventListener('scroll', () => {
		if (instagram.getBoundingClientRect().top < window.innerHeight && !isInit) {
			isInit = true;
			superagent.get('common/inc/feed_insta.php').end((err, res) => {
				const post = res.body.business_discovery.media.data;
				if (post) {
					let list = document.createElement('ul');
					let imgNum = 0;
					for (let i = 0; i < post.length; i++) {
						if (post[i].media_type === 'VIDEO') {
							continue;
						}
						imgNum++;
						let img = document.createElement('li');
						img.insertAdjacentHTML('beforeend', `<a href="${post[i].permalink}" target="_blank" rel="noopener" style="background-image:url(${post[i].media_url})"></a>`);
						if (imgNum >= 10) {
							img.classList.add('onlyPC');
						}
						list.insertAdjacentElement('beforeend', img);
						if (imgNum >= 10) {
							break;
						}
					}
					instagramFeed.insertAdjacentElement('beforeend', list);
				} else {
					instagramFeed.insertAdjacentHTML('beforeend', '<p>取得できませんでした</p>');
				}
			});
		}
	});
}
