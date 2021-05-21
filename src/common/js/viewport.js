/* ========================================== Reponsive functions ========================================== */
let windowWidth = window.innerWidth; // Included scrollbar
let windowHeight = window.innerHeight;
let clientWidth = document.documentElement.clientWidth; // Not included scrollbar
const dom_body = document.body;
const dom_viewport = document.querySelector('meta[name="viewport"]');
let isSP = windowWidth <= 750;
let passiveSupport = false;
try {
	window.addEventListener(
		'test',
		null,
		Object.defineProperty({}, 'passive', {
			get: function () {
				passiveSupport = true;
			},
		})
	);
} catch (err) {}
const sp2pc = document.createEvent('CustomEvent');
sp2pc.initCustomEvent('sp2pc', true, true, null);
const pc2sp = document.createEvent('CustomEvent');
pc2sp.initCustomEvent('pc2sp', true, true, null);
const scroll = document.createEvent('HTMLEvents');
scroll.initEvent('scroll', true, true);
const resize = document.createEvent('HTMLEvents');
resize.initEvent('resize', true, true);

function responsive() {
	windowWidth = window.innerWidth; // Included scrollbar
	windowHeight = window.innerHeight;
	clientWidth = document.documentElement.clientWidth; // Not included scrollbar

	if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
		// Smartphone
		dom_body.style.width = 'auto';
		dom_body.style.zoom = '';
		if (windowWidth < windowHeight) {
			dom_viewport.setAttribute('content', 'width=750'); // Landscape Mode
			if (!isSP) {
				isSP = true;
				window.dispatchEvent(pc2sp);
			}
		} else {
			dom_viewport.setAttribute('content', 'width=1300'); // Portrait Mode
			if (isSP) {
				isSP = false;
				window.dispatchEvent(sp2pc);
			}
		}
	} else {
		// Desktop
		if (windowWidth <= 750) {
			dom_viewport.setAttribute('content', 'width=750');
			dom_body.style.width = '750px';
			dom_body.style.zoom = clientWidth / 750;
			if (!isSP) {
				isSP = true;
				window.dispatchEvent(pc2sp);
			}
		} else {
			dom_viewport.setAttribute('content', 'width=1300');
			dom_body.style.width = 'auto';
			dom_body.style.zoom = '';
			if (isSP) {
				isSP = false;
				window.dispatchEvent(sp2pc);
			}
		}
	}
}

{
	responsive();
	let ticking = false;
	window.addEventListener(
		'resize',
		function () {
			if (!ticking) {
				ticking = true;
				requestAnimationFrame(() => {
					if (window.innerWidth != windowWidth) {
						responsive();
					}
					ticking = false;
				});
			}
		},
		passiveSupport ? {passive: true} : false
	);
}
