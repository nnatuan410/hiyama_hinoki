/* ==========================================
 Global
========================================== */

/* modal
------------------------------------------ */

/* HTML
<ul class="tablist" role="tablist">
	<li>
		<a href="#" role="tab">...</a>
	</li>
	...
</ul>
...
<div class="tabpanellist">
	<div role="tabpanel">...</div>
	...
</div>
*/

class UiTab {
	constructor(tablist, tabpanellist, option) {
		if (!tablist) tablist = document.querySelector('.tablist');
		if (!tabpanellist) tabpanellist = document.querySelector('.tabpanellist');
		if (!option) option = {};
		this.param = {
			duration: 400, // アニメーションスピード
			classLeave: 'leave', // 非表示アニメーション中のクラス
			classEnter: 'enter', // 表示アニメーション中のクラス
			indexAttr: 'data-tab-index',
			loop: false,
			btnPrev: false,
			btnNext: false,
			triggerSelector: '[role="tab"]',
			targetSelector: '[role="tabpanel"]',
		};
		this.param = {...this.param, ...option};

		if (typeof tablist === 'string') {
			this.tablist = document.querySelector(tablist);
		} else {
			this.tablist = tablist;
		}
		if (this.tablist) {
			this.trigger = this.tablist.querySelectorAll(this.param.triggerSelector);
		}

		if (typeof tabpanellist === 'string') {
			this.tabpanellist = document.querySelector(tabpanellist);
		} else {
			this.tabpanellist = tabpanellist;
		}
		this.target = this.tabpanellist.querySelectorAll(this.param.targetSelector);

		if (this.param.btnPrev) {
			const btnPrev = document.createElement('a');
			btnPrev.href = '#';
			btnPrev.classList.add('tabprev');
			btnPrev.setAttribute('aria-label', '前へ');
			btnPrev.addEventListener('click', (e) => {
				e.preventDefault();
				e.stopPropagation();
				this.tabPrev();
			});
			this.tabpanellist.insertAdjacentElement('beforeend', btnPrev);
		}
		if (this.param.btnNext) {
			const btnNext = document.createElement('a');
			btnNext.href = '#';
			btnNext.classList.add('tabnext');
			btnNext.setAttribute('aria-label', '次へ');
			btnNext.addEventListener('click', (e) => {
				e.preventDefault();
				e.stopPropagation();
				this.tabNext();
			});
			this.tabpanellist.insertAdjacentElement('beforeend', btnNext);
		}

		this.currentIndex = -1;
		this.prevIndex = -1;

		this.init();
	}

	init(callback) {
		for (let i = 0; i < this.target.length; i++) {
			if (this.tablist) {
				this.trigger[i].setAttribute('aria-selected', false);
				this.trigger[i].addEventListener('click', (e) => {
					e.preventDefault();
					if (i !== this.currentIndex) {
						this.tabChange(i);
					}
				});
			}
			this.target[i].setAttribute('aria-hidden', true);
			this.tabChange(0);
			this.target[i].addEventListener('click', (e) => {
				e.stopPropagation();
			});
		}

		if (this.tablist) this.tablist.setAttribute(this.param.indexAttr, this.currentIndex);
		this.tabpanellist.setAttribute(this.param.indexAttr, this.currentIndex);
		if (typeof callback === 'function') callback();
	}

	tabChange(index, callback) {
		if (this.currentIndex !== index && index >= -1 && index < this.target.length) {
			this.prevIndex = this.currentIndex;
			this.currentIndex = index;

			for (let j = 0; j < this.target.length; j++) {
				if (this.tablist) {
					this.trigger[j].setAttribute('aria-selected', false);
					this.trigger[j].style.pointerEvents = 'none';
				}
				if (j !== this.prevIndex) {
					this.target[j].setAttribute('aria-hidden', true);
				}
			}

			if (this.prevIndex >= 0) this.target[this.prevIndex].classList.add(this.param.classLeave);
			if (this.tablist) {
				if (this.currentIndex >= 0) this.trigger[this.currentIndex].setAttribute('aria-selected', true);
				this.tablist.setAttribute(this.param.indexAttr, this.currentIndex);
			}
			this.tabpanellist.setAttribute(this.param.indexAttr, this.currentIndex);

			setTimeout(() => {
				if (this.prevIndex >= 0) {
					this.target[this.prevIndex].setAttribute('aria-hidden', true);
					this.target[this.prevIndex].classList.remove(this.param.classLeave);
				}
				if (this.currentIndex >= 0) {
					this.target[this.currentIndex].classList.add(this.param.classEnter);
					requestAnimationFrame(() => {
						this.target[this.currentIndex].setAttribute('aria-hidden', false);
						requestAnimationFrame(() => {
							this.target[this.currentIndex].classList.remove(this.param.classEnter);
						});
					});
				}
				if (this.tablist) {
					for (let j = 0; j < this.trigger.length; j++) {
						this.trigger[j].style.pointerEvents = 'auto';
					}
				}
			}, this.param.duration);
		}
		if (typeof callback === 'function') callback();
	}

	getCurrentIndex(callback) {
		if (typeof callback === 'function') callback();
		return this.currentIndex;
	}

	tabNext(callback) {
		const mod = (a, b) => {
			return ((a % b) + b) % b;
		};
		if (this.currentIndex + 1 < this.target.length || this.param.loop) {
			this.tabChange(mod(this.currentIndex + 1, this.target.length));
		}
		if (typeof callback === 'function') callback();
	}

	tabPrev(callback) {
		const mod = (a, b) => {
			return ((a % b) + b) % b;
		};
		if (this.currentIndex - 1 >= 0 || this.param.loop) {
			this.tabChange(mod(this.currentIndex - 1, this.target.length));
		}
		if (typeof callback === 'function') callback();
	}
}
class UiModal {
	constructor(tablist, tabpanellist, option) {
		this.param = {
			type: 'modal', // modal, gallery
			duration: 400, // アニメーションスピード
			classLeave: 'leave', // 非表示アニメーション中のクラス
			classEnter: 'enter', // 表示アニメーション中のクラス
			indexAttr: 'data-tab-index',
			loop: true,
			btnClose: true,
			btnPrev: true,
			btnNext: true,
			triggerSelector: '[role="tab"]',
			targetSelector: '[role="tabpanel"]',
		};
		this.param = {...this.param, ...option};

		if (!tablist) tablist = document.querySelector('.tablist');
		if (!tabpanellist) tabpanellist = document.querySelector('.tabpanellist');
		if (!option) option = {};
		if (typeof tablist === 'string') {
			this.tablist = document.querySelector(tablist);
		} else {
			this.tablist = tablist;
		}
		this.trigger = this.tablist.querySelectorAll(this.param.triggerSelector);

		if (this.param.type === 'gallery') {
			this.tabpanellist = document.createElement('div');
			this.tabpanellist.classList.add('tabpanellist');
			for (let i = 0; i < this.trigger.length; i++) {
				this.tabpanellist.insertAdjacentHTML('beforeend', '<div role="tabpanel"><img src="' + this.trigger[i].href + '"></div>');
			}
		} else {
			if (typeof tabpanellist === 'string') {
				this.tabpanellist = document.querySelector(tabpanellist);
			} else {
				this.tabpanellist = tabpanellist;
			}
		}
		if (this.param.btnClose) {
			const btnClose = document.createElement('a');
			btnClose.href = '#';
			btnClose.classList.add('modalclose');
			btnClose.setAttribute('aria-label', '閉じる');
			btnClose.addEventListener('click', (e) => {
				e.preventDefault();
				e.stopPropagation();
				this.modalClose();
			});
			this.tabpanellist.insertAdjacentElement('beforeend', btnClose);
		}
		if (this.param.btnPrev) {
			const btnPrev = document.createElement('a');
			btnPrev.href = '#';
			btnPrev.classList.add('tabprev');
			btnPrev.setAttribute('aria-label', '前へ');
			btnPrev.addEventListener('click', (e) => {
				e.preventDefault();
				e.stopPropagation();
				this.tabPrev();
			});
			this.tabpanellist.insertAdjacentElement('beforeend', btnPrev);
		}
		if (this.param.btnNext) {
			const btnNext = document.createElement('a');
			btnNext.href = '#';
			btnNext.classList.add('tabnext');
			btnNext.setAttribute('aria-label', '次へ');
			btnNext.addEventListener('click', (e) => {
				e.preventDefault();
				e.stopPropagation();
				this.tabNext();
			});
			this.tabpanellist.insertAdjacentElement('beforeend', btnNext);
		}
		document.body.insertAdjacentElement('beforeend', this.tabpanellist);
		this.target = this.tabpanellist.querySelectorAll(this.param.targetSelector);
		this.modal = this.tabpanellist;
		this.currentIndex = -1;
		this.prevIndex = -1;
		this.modalIsOpen = false;

		this.init();
	}

	init(callback) {
		this.modal.addEventListener('click', (e) => {
			e.preventDefault();
			if (this.modalIsOpen) {
				this.modalClose();
			}
		});

		for (let i = 0; i < this.trigger.length; i++) {
			this.trigger[i].setAttribute('aria-selected', false);
			this.target[i].setAttribute('aria-hidden', true);
			this.trigger[i].addEventListener('click', (e) => {
				e.preventDefault();
				if (i !== this.currentIndex) {
					this.tabChange(i);
					if (!this.modalIsOpen) this.modalOpen();
				} else {
					if (this.modalIsOpen) this.modalClose();
				}
			});
			this.target[i].addEventListener('click', (e) => {
				e.stopPropagation();
			});
		}

		this.modal.setAttribute('aria-hidden', true);

		this.tablist.setAttribute(this.param.indexAttr, this.currentIndex);
		this.tabpanellist.setAttribute(this.param.indexAttr, this.currentIndex);

		let ticking = false;
		window.addEventListener(
			'scroll',
			() => {
				if (ticking === false) {
					requestAnimationFrame(() => {
						if (this.modalIsOpen) {
							this.modalClose();
						}
						ticking = false;
					});
				}
				ticking = true;
			},
			false
		);

		if (this.param.type === 'gallery') {
			this.modal.addEventListener(
				'mousedown',
				(e) => {
					e.preventDefault();
					const downPosX = e.pageX;

					const getSwipeX = (e) => {
						this.swipeMove(e.pageX - downPosX);
					};

					const changeSlide = (e) => {
						if (e.pageX - downPosX < -window.innerWidth * 0.5) {
							this.tabNext();
						} else if (e.pageX - downPosX > window.innerWidth * 0.5) {
							this.tabPrev();
						} else {
							this.swipeMove(0);
						}
						this.modal.removeEventListener('mousemove', getSwipeX);
						this.modal.removeEventListener('mouseup', changeSlide);
					};

					this.modal.addEventListener('mousemove', getSwipeX, false);
					this.modal.addEventListener('mouseup', changeSlide, false);
				},
				false
			);
		}
		if (typeof callback === 'function') callback();
	}

	modalOpen(callback) {
		this.modal.setAttribute('aria-hidden', false);
		this.modalIsOpen = true;
		if (typeof callback === 'function') callback();
	}

	modalClose(callback) {
		this.modal.setAttribute('aria-hidden', true);
		this.modalIsOpen = false;
		this.tabChange(-1);
		if (typeof callback === 'function') callback();
	}

	tabChange(index, callback) {
		if (this.currentIndex !== index && index >= -1 && index < this.target.length) {
			this.prevIndex = this.currentIndex;
			this.currentIndex = index;

			for (let j = 0; j < this.trigger.length; j++) {
				this.trigger[j].setAttribute('aria-selected', false);
				this.trigger[j].style.pointerEvents = 'none';
				if (j !== this.prevIndex) {
					this.target[j].setAttribute('aria-hidden', true);
				}
			}

			if (this.prevIndex >= 0) this.target[this.prevIndex].classList.add(this.param.classLeave);
			if (this.currentIndex >= 0) this.trigger[this.currentIndex].setAttribute('aria-selected', true);
			this.tablist.setAttribute(this.param.indexAttr, this.currentIndex);
			this.tabpanellist.setAttribute(this.param.indexAttr, this.currentIndex);

			setTimeout(() => {
				if (this.prevIndex >= 0) {
					this.target[this.prevIndex].setAttribute('aria-hidden', true);
					this.target[this.prevIndex].classList.remove(this.param.classLeave);
					this.swipeMove(0, this.prevIndex);
				}
				if (this.currentIndex >= 0) {
					this.target[this.currentIndex].classList.add(this.param.classEnter);
					requestAnimationFrame(() => {
						this.target[this.currentIndex].setAttribute('aria-hidden', false);
						requestAnimationFrame(() => {
							this.target[this.currentIndex].classList.remove(this.param.classEnter);
						});
					});
				}
				for (let j = 0; j < this.trigger.length; j++) {
					this.trigger[j].style.pointerEvents = 'auto';
				}
			}, this.param.duration);
		}
		if (typeof callback === 'function') callback();
	}

	getCurrentIndex(callback) {
		if (typeof callback === 'function') callback();
		return this.currentIndex;
	}

	tabNext(callback) {
		const mod = (a, b) => {
			return ((a % b) + b) % b;
		};
		if (this.currentIndex + 1 < this.target.length || this.param.loop) {
			this.tabChange(mod(this.currentIndex + 1, this.target.length));
		}
		if (typeof callback === 'function') callback();
	}

	tabPrev(callback) {
		const mod = (a, b) => {
			return ((a % b) + b) % b;
		};
		if (this.currentIndex - 1 >= 0 || this.param.loop) {
			this.tabChange(mod(this.currentIndex - 1, this.target.length));
		}
		if (typeof callback === 'function') callback();
	}

	swipeMove(x, index) {
		if (typeof index !== 'number') {
			index = this.currentIndex;
		}
		if (x === 0) {
			this.target[index].style.transform = '';
		} else {
			this.target[index].style.transform = 'translateX(' + x + 'px)';
		}
	}
}

/* ==========================================
 Site common
========================================== */

/* Fixed Header
------------------------------------------ */
{
	const gNaviFixed = document.getElementById('gNaviFixed');

	window.addEventListener(
		'load',
		() => {
			const showFixed = () => {
				gNaviFixed.classList.add('show');
			};
			const hideFixed = () => {
				gNaviFixed.classList.remove('show');
			};

			if (window.pageYOffset > window.innerHeight) {
				showFixed();
			}

			let ticking = false;
			window.addEventListener(
				'scroll',
				() => {
					if (!ticking) {
						ticking = true;
						requestAnimationFrame(() => {
							ticking = false;
							if (window.pageYOffset > window.innerHeight) {
								showFixed();
							} else {
								hideFixed();
							}
						});
					}
				},
				passiveSupport ? {passive: true} : false
			);

			window.addEventListener(
				'sp2pc',
				() => {
					if (window.pageYOffset > window.innerHeight) {
						showFixed();
					} else {
						hideFixed();
					}
				},
				false
			);
		},
		false
	);
}

/* Add Menu Current
------------------------------------------ */
{
	window.addEventListener(
		'load',
		() => {
			const path = location.pathname;
			const button = document.querySelectorAll('.nav a');
			for (let i = 0; i < button.length; i++) {
				const hrefpath = button[i].getAttribute('href');
				if (hrefpath === path) {
					button[i].classList.add('current');
				}
			}
		},
		false
	);
}

/* tel button
------------------------------------------ */
{
	{
		const button = document.querySelectorAll('a[href^="tel:"]');
		for (let i = 0; i < button.length; i++) {
			button[i].addEventListener(
				'click',
				(e) => {
					if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
						if (typeof gtag === 'function' && button[i].dataset.gtag) {
							gtag('event', 'click', {
								event_category: 'sp_tel_btn',
								event_label: button[i].dataset.gtag,
								value: '0',
							});
						}
					} else {
						e.preventDefault();
					}
				},
				false
			);
		}
	}
}

/* smooth scroll
------------------------------------------ */
{
	const button = document.querySelectorAll('a.smoothScroll');
	for (let i = 0; i < button.length; i++) {
		let targetName = button[i].getAttribute('href'),
			targetPos = 0,
			offset = 0;

		button[i].addEventListener('click', (e) => {
			e.preventDefault();
			if (targetName !== '#') {
				offset = isSP ? 160 : 100;
				targetPos = document.getElementById(targetName.slice(1)).getBoundingClientRect().top + window.pageYOffset;
			}
			anime({
				targets: 'html, body',
				scrollTop: targetPos - offset,
				duration: 500,
				easing: 'easeOutSine',
			});
		});
	}
}

/* sp gnavi
------------------------------------------ */
{
	const menuBtn = document.getElementById('menuBtn');
	const html = document.documentElement;
	const wrapper = document.getElementById('wrapper');
	const gNavi = document.getElementById('gNavi');
	const acordionBtn = gNavi.querySelectorAll('.acordionBtn');
	const closeBtn = gNavi.querySelector('.close');
	let openedPos = 0;

	const disableScroll = () => {
		openedPos = window.pageYOffset;
		html.classList.add('disableScroll');
		wrapper.style.top = -openedPos + 'px';
	};

	const enableScroll = () => {
		html.classList.remove('disableScroll');
		wrapper.style.top = '';
		window.scrollTo(0, openedPos);
	};

	const openModal = () => {
		menuBtn.classList.add('open');
		gNavi.classList.add('open');
	};

	const closeModal = () => {
		menuBtn.classList.remove('open');
		gNavi.classList.remove('open');
	};

	window.addEventListener('load', () => {
		menuBtn.addEventListener(
			'click',
			(e) => {
				e.preventDefault();
				if (menuBtn.classList.contains('open')) {
					if (isSP) {
						closeModal();
						enableScroll();
					}
				} else {
					if (isSP) {
						openModal();
						disableScroll();
					}
				}
			},
			false
		);

		closeBtn.addEventListener(
			'click',
			(e) => {
				e.preventDefault();
				closeModal();
			},
			false
		);

		for (let i = 0; i < acordionBtn.length; i++) {
			acordionBtn[i].addEventListener(
				'click',
				(e) => {
					e.preventDefault();
					if (isSP) {
						if (acordionBtn[i].classList.contains('open')) {
							acordionBtn[i].classList.remove('open');
						} else {
							acordionBtn[i].classList.add('open');
						}
					}
				},
				false
			);
		}

		window.addEventListener(
			'sp2pc',
			() => {
				if (gNavi.classList.contains('open')) {
					closeModal();
					enableScroll();
				}
			},
			false
		);

		window.addEventListener(
			'pc2sp',
			() => {
				if (gNavi.classList.contains('open')) {
					closeModal();
				}
			},
			false
		);
	});
}

/* scroll effect (polyfill: intersection-observer)
------------------------------------------ */
{
	const showContent = (target) => {
		target.classList.add('show');
		observer.unobserve(target);
	};

	const observer = new IntersectionObserver(
		function (entries) {
			for (let i = 0; i < entries.length; i++) {
				if (entries[i].isIntersecting) {
					if (entries[i].target.classList.contains('scrollEffect')) {
						showContent(entries[i].target);
					} else if (entries[i].target.classList.contains('scrollEffectParent')) {
						if (!isSP) {
							showContent(entries[i].target);
						}
					} else {
						if (isSP) {
							showContent(entries[i].target);
						}
					}
				} else {
					if (entries[i].boundingClientRect.top + window.pageYOffset < window.innerHeight * 0.2 || entries[i].boundingClientRect.bottom + window.pageYOffset > document.body.clientHeight - window.innerHeight * 0.2) {
						showContent(entries[i].target);
					}
				}
			}
		},
		{
			root: null,
			rootMargin: '-20% 0px',
			threshold: 0,
		}
	);

	const content = document.querySelectorAll('.scrollEffect');
	const contentParent = document.querySelectorAll('.scrollEffectParent');
	for (let i = 0; i < content.length; i++) {
		observer.observe(content[i]);
	}
	for (let i = 0; i < contentParent.length; i++) {
		observer.observe(contentParent[i]);
		for (let j = 0; j < contentParent[i].children.length; j++) {
			observer.observe(contentParent[i].children[j]);
		}
	}
}

/* lazyloaded effect (lib: lazysizes)
------------------------------------------ */
{
	const content = document.querySelectorAll('.lazyEffect');
	for (let i = 0; i < content.length; i++) {
		const lazyImages = content[i].querySelectorAll('img.lazyload');
		let loadedImages = 0;
		if (lazyImages.length === 0) {
			content[i].classList.add('loaded');
		} else {
			for (let j = 0; j < lazyImages.length; j++) {
				lazyImages[j].addEventListener(
					'lazyloaded',
					() => {
						loadedImages++;
						if (loadedImages >= lazyImages.length) content[i].classList.add('loaded');
					},
					false
				);
			}
		}
	}
}

/* scrollUp
------------------------------------------ */
{
	const scrollUp = document.getElementById('scrollUp');

	const showTimer = anime({
		target: null,
		duration: 1000,
		easing: 'linear',
		complete: () => {
			if (window.pageYOffset >= window.innerHeight) {
				scrollUp.classList.add('show');
			}
		},
	});

	let ticking = false;
	window.addEventListener(
		'scroll',
		() => {
			if (ticking === false) {
				requestAnimationFrame(() => {
					scrollUp.classList.remove('show');
					showTimer.restart();
					ticking = false;
				});
			}
			ticking = true;
		},
		passiveSupport ? {passive: true} : false
	);
}

/* sticky
-------------------------------------------------------------------------------------------------------------------- */
{
	const sticky = document.querySelectorAll('.sticky');
	const offsetTop = 50;

	if (sticky) {
		let tickerScroll = false;
		window.addEventListener(
			'scroll',
			() => {
				if (!tickerScroll) {
					tickerScroll = true;
					requestAnimationFrame(() => {
						for (let i = 0; i < sticky.length; i++) {
							const stickyRect = sticky[i].getBoundingClientRect();
							const parentRect = sticky[i].parentNode.getBoundingClientRect();
							if (!isSP && parentRect.height > stickyRect.height + offsetTop) {
								if (parentRect.top > offsetTop) {
									sticky[i].style.position = 'absolute';
									sticky[i].style.top = '0px';
									sticky[i].style.bottom = 'auto';
									sticky[i].style.width = '100%';
								} else if (parentRect.bottom < stickyRect.height + offsetTop) {
									sticky[i].style.position = 'absolute';
									sticky[i].style.top = 'auto';
									sticky[i].style.bottom = '0px';
									sticky[i].style.width = '100%';
								} else {
									sticky[i].style.position = 'fixed';
									sticky[i].style.top = offsetTop + 'px';
									sticky[i].style.bottom = 'auto';
									sticky[i].style.width = parentRect.width + 'px';
								}
							} else {
								sticky[i].style.width = '';
								sticky[i].style.position = '';
								sticky[i].style.top = '';
								sticky[i].style.bottom = '';
							}
						}
						tickerScroll = false;
					});
				}
			},
			passiveSupport ? {passive: true} : false
		);

		window.addEventListener(
			'pc2sp',
			() => {
				sticky[i].style.width = '';
				sticky[i].style.position = '';
				sticky[i].style.top = '';
				sticky[i].style.bottom = '';
			},
			false
		);
	}
}

/* ui_list_faq01
------------------------------------------ */
{
	const listFaq = document.querySelectorAll('.ui_list_faq01>li');

	if (listFaq) {
		for (let i = 0; i < listFaq.length; i++) {
			const question = listFaq[i].querySelector('.question');
			const answer = listFaq[i].querySelector('.answer');

			window.addEventListener(
				'load',
				() => {
					listFaq[i].style.height = question.clientHeight + 'px';
					question.addEventListener(
						'click',
						(e) => {
							e.preventDefault();
							if (listFaq[i].classList.contains('open')) {
								listFaq[i].classList.remove('open');
								listFaq[i].style.height = question.clientHeight + 'px';
							} else {
								listFaq[i].classList.add('open');
								listFaq[i].style.height = question.clientHeight + answer.clientHeight + 'px';
							}
						},
						false
					);

					let ticking = false;
					window.addEventListener('resize', () => {
						if (!ticking) {
							ticking = true;
							requestAnimationFrame(() => {
								if (listFaq[i].classList.contains('open')) {
									listFaq[i].style.height = question.clientHeight + answer.clientHeight + 'px';
								} else {
									listFaq[i].style.height = question.clientHeight + 'px';
								}
								ticking = false;
							});
						}
					});
				},
				passiveSupport ? {passive: true} : false
			);
		}
	}
}
