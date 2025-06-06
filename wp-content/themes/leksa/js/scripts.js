(function ($) {
	"use strict";

	gsap.registerPlugin(Draggable, ScrollTrigger, ScrollToPlugin, InertiaPlugin, ScrollSmoother, Flip);

	// Global Preferences
	var buttonStyle = 'underlined';

	// Global Element Variables
	var html = document.querySelector('html'),
		body = document.querySelector('body');

	var mobileQuery = window.matchMedia('(max-width: 500px)'),
		siteHeader = $('.site-header'),
		matchMedia = gsap.matchMedia(),
		isPhone = '(max-width: 450px)',
		isTablet = '(min-width: 450px) and (max-width: 900px)',
		isDesktop = '(min-width: 900px)';


	var keys = {
		37: 1,
		38: 1,
		39: 1,
		40: 1
	};

	function preventDefault(e) {
		e.preventDefault();
	}

	let wpmlSwicher = document.querySelectorAll('a.wpml-ls-link');

	if (wpmlSwicher) {
		wpmlSwicher.forEach(function($item){
			$item.setAttribute('data-barba-prevent', 'all')
		})
	}

	function preventDefaultForScrollKeys(e) {
		if (keys[e.keyCode]) {
			preventDefault(e);
			return false;
		}
	}

	var supportsPassive = false;
	try {
		window.addEventListener("test", null, Object.defineProperty({}, 'passive', {
			get: function () {
				supportsPassive = true;
			}
		}));
	} catch (e) { }

	var wheelOpt = supportsPassive ? {
		passive: false
	} : false;
	var wheelEvent = 'onwheel' in document.createElement('div') ? 'wheel' : 'mousewheel';


	function disableScroll() {
		if (leksaLenis) {
			leksaLenis.stop()
		} else {
			// Add event listeners
			window.addEventListener('DOMMouseScroll', preventDefault, false); // Older Firefox
			window.addEventListener(wheelEvent, preventDefault, wheelOpt);    // Modern desktop
			window.addEventListener('touchmove', preventDefault, wheelOpt);   // Mobile
			window.addEventListener('keydown', preventDefaultForScrollKeys, false);
		}
	}

	function enableScroll() {
		if (leksaLenis) {
			leksaLenis.start()
		} else {
			// Remove event listeners
			window.removeEventListener('DOMMouseScroll', preventDefault, false);
			window.removeEventListener(wheelEvent, preventDefault, wheelOpt);
			window.removeEventListener('touchmove', preventDefault, wheelOpt);
			window.removeEventListener('keydown', preventDefaultForScrollKeys, false);
		}
	}


	function parents(element, selector) {
		const parentsArray = [];
		let currentElement = element.parentElement;

		while (currentElement !== null) {
			if (currentElement.matches(selector)) {
				parentsArray.push(currentElement);
			}
			currentElement = currentElement.parentElement;
		}

		return parentsArray;
	}


	function clearProps(target) {

		gsap.set(target, {
			clearProps: 'all'
		})
	}

	function leksa_ProductPage() {
		var productPage = document.querySelector('.product-page'),
			head = productPage.querySelector('.pe--product-head'),
			gallery = productPage.querySelector('.product-gallery'),
			info = productPage.querySelector('.product-info'),
			endo = gallery.offsetHeight - info.offsetHeight;

		if (gallery && !head.classList.contains('gal-static')) {
			ScrollTrigger.create({
				trigger: gallery,
				pin: info,
				start: 'top top',
				end: endo,
				id: 'pGalleryScroll',
			});
		}

		if (head.classList.contains('img-masonry')) {
			var msnry = new Masonry('.product-gallery-wrap', {
				itemSelector: '.product-gallery-image',
				columnWidth: '.grid-sizer',
				percentPosition: true,
				gutter: '.grid-gutter'
			});

			matchMedia.add({
				isMobile: "(max-width: 450px)"
			}, (context) => {
				let { isMobile } = context.conditions;
				msnry.destroy();
				return () => { };
			});
		}

		function productDetailTabs() {
			let tabs = document.querySelector('.tab-titles-wrap'),
				titles = tabs.querySelectorAll('.tab-title'),
				contents = document.querySelectorAll('.product-detail-tabs .tab-content');

			titles[0].classList.add('active');
			contents[0].classList.add('active');

			titles.forEach((title) => {
				title.addEventListener('click', function () {
					let findContent = '.tab_' + this.getAttribute('data-tab');
					document.querySelectorAll('.tab-content').forEach((content) => {
						content.classList.remove('active');
					});
					document.querySelectorAll('.tab-title').forEach((title) => {
						title.classList.remove('active');
					});
					document.querySelector(findContent).classList.add('active');
					this.classList.add('active');
				});
			});
		}
		productDetailTabs();

		function leksa_UpdateCart() {
			var quantity = document.querySelectorAll('.product-add-to-cart, .leksa_add_to_cart');

			quantity.forEach((q) => {
				var button = q.querySelector('.single_add_to_cart_button');

				button.addEventListener('mouseenter', function () {
					q.classList.add('hovered');
				});

				button.addEventListener('mouseleave', function () {
					q.classList.remove('hovered');
				});

				var input = q.querySelector('.qty'),
					incrs = q.querySelector('.incrs'),
					dcrs = q.querySelector('.dcrs');

				let clicks = 0;

				incrs.addEventListener('click', function () {
					document.querySelectorAll('.update_cart').forEach((btn) => btn.removeAttribute('disabled'));
					clicks++;
					if (clicks < 1) clicks = 1;
					var currentVal = parseInt(input.value);
					if (!isNaN(currentVal)) input.value = clicks;
				});

				dcrs.addEventListener('click', function () {
					clicks--;
					if (clicks < 1) clicks = 1;
					document.querySelectorAll('.update_cart').forEach((btn) => btn.removeAttribute('disabled'));
					var currentVal = parseInt(input.value);
					if (!isNaN(currentVal) && currentVal > 0) input.value = clicks;
				});
			});
		}
		leksa_UpdateCart();

		matchMedia.add({
			isMobile: "(max-width: 450px)"
		}, (context) => {
			let { isMobile } = context.conditions;
			let galScroll = ScrollTrigger.getById('pGalleryScroll');

			if (galScroll != null) {
				galScroll.kill();
			}

			var max = document.querySelector('.product-gallery-wrap').offsetWidth - 375;

			Draggable.create(gallery.querySelector('.product-gallery-wrap'), {
				type: 'x',
				bounds: {
					minX: 0,
					maxX: max * -1,
				},
				lockAxis: true,
				dragResistance: 0.5,
				inertia: true,
				zIndexBoost: false,
			});

			return () => { };
		});
	}


	function leksa_ArchiveProducts() {

		var archive = document.querySelector('.archive-products-section');

		if (archive) {

			var filterWrap = archive.querySelector('.np-filters'),
				wrapRect = filterWrap.getBoundingClientRect(),
				filters = archive.querySelectorAll('.pe--products-filtering li'),
				grid = archive.querySelector('.pe--products-grid'),
				products = grid.querySelectorAll('.pe-single-product'),
				layoutSwitch = archive.querySelector('.npg-switch');

			filters.forEach(function (filter) {

				let rect = filter.getBoundingClientRect();

				if (filter.classList.contains('all')) {
					gsap.set(filterWrap, {
						'--left': (rect.left - wrapRect.left) + 'px',
						'--width': rect.width + 'px'
					})
				}


				filter.addEventListener('click', function () {
					gsap.set(filterWrap, {
						'--left': (rect.left - wrapRect.left) + 'px',
						'--width': rect.width + 'px'
					})
					if (!filter.classList.contains('all')) {

						var findCat = '.product_cat-' + filter.dataset.cat;


						filters.forEach(function (f) {
							f.classList.remove('active');
						});
						filter.classList.add('active');

						var state = Flip.getState(Array.from(products));

						grid.classList.add('filtered');
						products.forEach(function (p) {
							p.style.display = 'none';
						});
						grid.querySelectorAll(findCat).forEach(function (p) {
							p.style.display = 'block';
						});

						Flip.from(state, {
							duration: 1,
							scale: false,
							ease: 'power3.out',
							stagger: 0,
							absolute: true,
							absoluteOnLeave: true,
							onEnter: function (elements) {
								gsap.fromTo(elements, {
									clipPath: 'inset(100% 100% 100% 100% round 50px)'
								}, {
									opacity: 1,
									clipPath: 'inset(0% 0% 0% 0% round 50px)',
									duration: 1,
									ease: 'power3.out',
									stagger: 0.1
								});
							},
							onLeave: function (elements) {
								gsap.to(elements, {
									clipPath: 'inset(100% 100% 100% 100% round 50px)',
									duration: 1,
									ease: 'power3.out',
									stagger: 0.1
								});
							}
						});
					}
				});

			});

			archive.querySelector('.all').addEventListener('click', function () {
				var state = Flip.getState(Array.from(products));

				filters.forEach(function (f) {
					f.classList.remove('active');
				});
				this.classList.add('active');

				grid.classList.remove('filtered');
				products.forEach(function (p) {
					p.style.display = 'block';
				});

				Flip.from(state, {
					duration: 1,
					scale: false,
					ease: "expo.out",
					stagger: 0,
					absolute: true,
					absoluteOnLeave: true,
					onEnter: function (elements) {
						gsap.fromTo(elements, {
							clipPath: 'inset(100% 100% 100% 100% round 50px)'
						}, {
							opacity: 1,
							clipPath: 'inset(0% 0% 0% 0% round 50px)',
							duration: 1,
							ease: 'power3.out',
							stagger: 0.1
						});
					},
					onLeave: function (elements) {
						gsap.to(elements, {
							clipPath: 'inset(100% 100% 100% 100% round 50px)',
							duration: 1,
							ease: 'power3.out',
							stagger: 0.1
						});
					}
				});
			});

			if (layoutSwitch) {
				var swDefault = layoutSwitch.querySelector('.switch-def'),
					sw2 = layoutSwitch.querySelector('.switch-2'),
					defRect = swDefault.getBoundingClientRect();

				gsap.set(layoutSwitch, {
					'--left': defRect.left - layoutSwitch.getBoundingClientRect().left + 'px',
					'--width': defRect.width + 'px'
				})



				grid.classList.add('grid-default');

				sw2.addEventListener('click', function () {
					if (grid.classList.contains('grid-default')) {
						swDefault.classList.remove('active');
						sw2.classList.add('active');

						gsap.set(layoutSwitch, {
							'--left': sw2.getBoundingClientRect().left - layoutSwitch.getBoundingClientRect().left + 'px',
							'--width': sw2.getBoundingClientRect().width + 'px'
						})


						var state = Flip.getState(Array.from(products));

						grid.classList.remove('grid-default');
						grid.classList.add('grid-2');

						Flip.from(state, {
							duration: 1,
							scale: false,
							ease: 'power3.out',
							stagger: 0,
							absolute: true,
							absoluteOnLeave: true,
						});
					}
				});

				swDefault.addEventListener('click', function () {
					swDefault.classList.add('active');
					sw2.classList.remove('active');

					if (grid.classList.contains('grid-2')) {
						var state = Flip.getState(Array.from(products));

						grid.classList.remove('grid-2');
						grid.classList.add('grid-default');

						gsap.set(layoutSwitch, {
							'--left': swDefault.getBoundingClientRect().left - layoutSwitch.getBoundingClientRect().left + 'px',
							'--width': swDefault.getBoundingClientRect().width + 'px'
						})

						Flip.from(state, {
							duration: 1,
							scale: false,
							ease: 'power3.out',
							stagger: 0,
							absolute: true,
							absoluteOnLeave: true,
						});
					}
				});
			}


		}

	}

	function leksa_CartPage() {

		function quanto() {

			let quantity = $('.leksa-cart-section').find('.product-quantity');

			quantity.each(function () {

				let $this = $(this),
					input = $this.find('.qty'),
					incrs = $this.find('.incrs'),
					dcrs = $this.find('.dcrs');

				let clicks = 0;

				incrs.on('click', function () {

					$('.update_cart').removeAttr('disabled');

					clicks++


					var currentVal = parseInt(input.val());

					if (!isNaN(currentVal)) {
						input.val(currentVal + 1);
					}

				});
				dcrs.on('click', function () {

					clicks--

					$('.update_cart').removeAttr('disabled')

					var currentVal = parseInt(input.val());
					if (!isNaN(currentVal) && currentVal > 0) {
						input.val(currentVal - 1);
					}
				});

			})
		}

		quanto();

		$(document).on('click', 'button[name="update_cart"]', function () {
			var totalQuantity = 0;

			var cartItems = $('.cart_item');

			cartItems.each(function () {
				var quantityInput = $(this).find('.quantity input');
				var quanto = parseInt(quantityInput.val());
				totalQuantity += quanto;
			});

			$('.cart-count > span').html(totalQuantity);

			setTimeout(function () {

				quanto();

			}, 2000)

		});

	}

	function shopScripts() {

		document.querySelector('.product-page') ? leksa_ProductPage() : '';
		leksa_ArchiveProducts()
		leksa_CartPage();

		$(document).on('click', '.product-acts a.button', function (e) {


			var $thisbutton = $(this);


			if (!$thisbutton.parents('.product-type-variable').length) {

				e.preventDefault();

				let $form = $thisbutton.closest('form.cart'),
					id = $(this).data('product-id'),
					product_qty = 1,
					product_id = $(this).data('product-id'),
					variation_id = $(this).data('product-id');

				var data = {
					action: 'woocommerce_ajax_add_to_cart',
					product_id: product_id,
					product_sku: '',
					quantity: product_qty,

				};


				$(document.body).trigger('adding_to_cart', [$thisbutton, data]);

				$.ajax({
					type: 'post',
					url: wc_add_to_cart_params.ajax_url,
					data: data,
					beforeSend: function (response) {
						$thisbutton.removeClass('added').addClass('loading');
					},
					complete: function (response) {
						$thisbutton.addClass('added').removeClass('loading');


						let curr = $('.cart-count > span').html(),
							rs = parseInt(curr);

						$('.cart-count > span').html(rs + 1);


					},
					success: function (response) {

						if (response.error && response.product_url) {

							return;
						} else {
							$(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);


						}
					},
				});

			}



		});

		$(document).on('click', '.single_add_to_cart_button', function (e) {
			e.preventDefault();

			var $thisbutton = $(this),
				$form = $thisbutton.closest('form.cart'),
				id = $thisbutton.val(),
				product_qty = $form.find('input[name=quantity]').val() || 1,
				product_id = $form.find('input[name=product_id]').val() || id,
				variation_id = $form.find('input[name=variation_id]').val() || 0;



			var data = {
				action: 'woocommerce_ajax_add_to_cart',
				product_id: product_id,
				product_sku: '',
				quantity: product_qty,
				variation_id: variation_id,
			};

			$(document.body).trigger('adding_to_cart', [$thisbutton, data]);

			$.ajax({
				type: 'post',
				url: wc_add_to_cart_params.ajax_url,
				data: data,
				beforeSend: function (response) {
					$thisbutton.removeClass('added').addClass('loading');
				},
				complete: function (response) {
					$thisbutton.addClass('added').removeClass('loading');


					let curr = $('.cart-count > span').html(),
						rs = parseInt(curr),
						qty = parseInt(product_qty);

					$('.cart-count > span').html(rs + qty);

				},
				success: function (response) {

					if (response.error && response.product_url) {
						window.location = response.product_url;
						return;
					} else {
						$(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);
					}
				},
			});

			return false;
		});

	}



	function leksaPageLoader() {

		var container = document.body,
			imgLoad = imagesLoaded(container),
			totalImages = imgLoad.images.length,
			loadedCount = 0,
			pageLoader = document.querySelector('.pe--page--loader'),
			numbersWrap = pageLoader.querySelector('.numbers--wrap'),
			numbers = pageLoader.querySelectorAll('.number'),
			logo = pageLoader.querySelector('.page--loader--logo'),
			duration = parseInt(pageLoader.dataset.duration) / 1000,
			type = pageLoader.dataset.type,
			size = 200;

			if (mobileQuery.matches) {
				size = 100;
			}

		numbers.forEach(number => {

			let digits = number.querySelectorAll('span');

			digits.forEach((digit, i) => {
				digit.classList.add('digit_' + i);
				digit.setAttribute('data-top', digit.getBoundingClientRect().top - numbersWrap.getBoundingClientRect().top)

			})
		})

		var tl = gsap.timeline({
			id: 'pageLoader',
			paused: true,
			onStart: () => {
				disableScroll();
				pageLoader.classList.add('running');
				html.classList.add('loading');

				if (type === 'slide') {
					gsap.set('.site-header', {
						yPercent: -100
					})
				}

			},
		});

		if (logo) {
			tl.to('.op', {
				clipPath: 'inset(0% 0% 0% 0%)',
				duration: duration,
				ease: 'expo.inOut',
			}, 0)

		}

		tl.to('.number__1', {
			y: -size,
			duration: duration,
			ease: 'expo.inOut',

		}, .5)

		tl.to('.number__2', {
			y: -size * 10,
			duration: duration,
			ease: 'expo.inOut'
		}, 0)

		tl.to('.number__3', {
			y: -size * 10,
			duration: duration,
			ease: 'expo.inOut'

		}, .25)

		imgLoad.on('progress', function (instance, image) {
			loadedCount++;
			var percent = (loadedCount / totalImages) * 100;

			if (!pageLoader.classList.contains('running')) {
				tl.play()
			}

			let tlProg = tl.progress() * 100;

			if (percent < tlProg) {
				tl.pause();
			} else {
				tl.play();
			}

		});

	}

	function leksaLoaderOut(behavior) {

		let loader = document.querySelector('.pe--page--loader'),
			direction = loader.dataset.direction;

		if (behavior === 'slide') {

			// gsap.set('main', {
			// 	x: direction === 'left' ? '100vw' : direction === 'right' ? '-100vw' : 0,
			// 	y: direction === 'up' ? '100vh' : direction === 'down' ? '-100vh' : '0vh',
			// 	zIndex: direction === 'up' ? 999 : direction === 'down' ? 0 : 999,
			// 	position: 'relative',

			// })

			gsap.to('.page--loader--ov', {
				opacity: .75,
				duration: 1,
				ease: 'expo.inOut',
				delay: .1
			})

			gsap.to('.pe--page--loader', {
				y: direction === 'up' ? -300 : direction === 'down' ? '100vh' : 0,
				x: direction === 'left' ? -500 : direction === 'right' ? 500 : 0,
				duration: 1,
				ease: 'expo.inOut',
				delay: .1
			})

			gsap.to('.site-header', {
				yPercent: 0,
				duration: 1,
				onStart: () => {

					gsap.set('.site-header', {
						visibility: 'visible',
					})
				},
				ease: 'power3.out'
			})

			gsap.to('main', {
				y: 0,
				x: 0,
				duration: 1,
				ease: 'expo.inOut',
				delay: .1,
				id: 'loaderOut',
				onUpdate: () => {
					ScrollTrigger.refresh();
				},
				onComplete: () => {

					document.querySelector('.pe--page--loader').remove();
					clearProps('main')

					html.classList.remove('loading');
					html.classList.remove('first--load');

					ScrollTrigger.update(true)
					ScrollTrigger.refresh(true)

				}
			})

		}

		if (behavior === 'fade') {

			let tl = gsap.timeline({
			})
			tl.to('.page--loader--ov', {
				opacity: 1,
				duration: .4,
				ease: 'expo.out'
			})

			tl.to(loader, {
				opacity: 0,
				duration: .4,
				ease: 'expo.out',
				onStart: () => {
					html.classList.remove('loading')
					html.classList.remove('first--load');

					ScrollTrigger.update(true)
					ScrollTrigger.refresh(true)
				},
				onComplete: () => {
					document.querySelector('.pe--page--loader').remove();
				}
			})
		}

		if (behavior === 'overlay') {


			gsap.to(loader, {
				height: direction === 'up' ? 0 : direction === 'down' ? 0 : '100vh',
				width: direction === 'left' ? 0 : direction === 'right' ? 0 : '100vw',
				duration: 1,
				ease: 'expo.inOut',
				onComplete: () => {
					document.querySelector('.pe--page--loader').remove();
					html.classList.remove('loading')
					html.classList.remove('first--load');

					ScrollTrigger.update(true)
					ScrollTrigger.refresh(true)
				}
			})

		}

	}

	function leksamouseCursor() {
		var mouseCursor = document.getElementById('mouseCursor');

		if (mouseCursor) {
			gsap.set(mouseCursor, {
				xPercent: -50,
				yPercent: -50
			});

			let xTo = gsap.quickTo(mouseCursor, "x", {
				duration: 0.6,
				ease: "power3"
			}),
				yTo = gsap.quickTo(mouseCursor, "y", {
					duration: 0.6,
					ease: "power3"
				});

			function icko(e) {
				xTo(e.clientX);
				yTo(e.clientY);
			}

			window.addEventListener('mousemove', (e) => {
				icko(e);
			});
		}
	}

	var cursor = document.getElementById('mouseCursor') ? document.getElementById('mouseCursor') : false,
		cursorText = cursor ? cursor.querySelector('.cursor-text') : false,
		cursorIcon = cursor ? cursor.querySelector('.cursor-icon') : false;

	function resetCursor() { 

		cursor.classList.remove('cursor--default')
		cursor.classList.remove('cursor--text');
		cursor.classList.remove('cursor--icon');
		cursor.classList.remove('dragging--right');
		cursor.classList.remove('dragging--left');
		cursorText.innerHTML = '';
		cursorIcon.innerHTML = '';

	}

	function leksaHeader() {

		var header = document.querySelector('.site-header'),
			headerHeight = header.getBoundingClientRect().height,
			headerElements = header.querySelectorAll('[data-element_type="widget"]'),
			start = 0;


		setTimeout(function () {

			let scrolltriggers = ScrollTrigger.getAll();

			scrolltriggers.forEach(function (st) {

				if ((st.pin != null) && (st.start <= window.innerHeight)) {

					start = st.end;


				}

			})


			function animateElements(play) {


				var state = Flip.getState(headerElements, {
					props: ['opacity , display']
				});

				headerElements.forEach(elem => {

					if (play) {
						header.classList.add('header--move');

						if (elem.classList.contains('wd--show--on--top')) {

							gsap.set(elem, {
								display: 'none',
							})

						} else if (elem.classList.contains('wd--show--sticky')) {

							gsap.set(elem, {
								display: 'block',
							})

						}

					} else {

						header.classList.remove('header--move');

						gsap.set(elem, {
							clearProps: 'all'
						})
					}

				})

				Flip.from(state, {
					duration: .75,
					ease: "power3.inOut",
					absolute: true,
					fade: true,
					onEnter: (elements) =>
						gsap.fromTo(
							elements,
							{
								opacity: 0,
								y: play ? 100 : -100,
							},
							{
								opacity: 1,
								duration: .75,
								y: 0,
								delay: 0,
								ease: "power3.inOut",
							}
						),
					onLeave: (elements) =>
						gsap.to(elements, {
							opacity: 0,
							y: play ? -100 : 100,
							duration: .75,
							ease: "power3.inOut",
						})
				});

			}


			function fixedHeader() {

				let sc = ScrollTrigger.create({
					trigger: 'body',
					start: 'top+=' + start + ' top',
					id: 'fixedHeader',
					end: 'bottom bottom',
					onEnter: () => {
						animateElements(true)
					},
					onLeaveBack: () => {
						animateElements(false);
					}
				})
			}

			barba.hooks.after(() => {

				setTimeout(() => {
					let scrolltriggers = ScrollTrigger.getAll(),
						newStart;

					scrolltriggers.forEach(function (st) {

						if ((st.pin != null) && (st.start <= window.innerHeight)) {

							newStart = st.end;


						}

					})

					let fixedHeader = ScrollTrigger.getById('fixedHeader');

					if (fixedHeader) {
						fixedHeader.kill();

						let sc = ScrollTrigger.create({
							trigger: 'body',
							start: 'top+=' + newStart + ' top',
							id: 'fixedHeader',
							end: 'bottom bottom',
							onEnter: () => {

								animateElements(true)

							},
							onLeaveBack: () => {
								animateElements(false);

							}
						})



					}


				})
			}, 100);

			header.classList.contains('header--fixed') ? fixedHeader() : header.classList.contains('header--sticky') ? fixedHeader() : '';

		}, 5)



		function leksaFullscreenSubmenu() {

			let submenus = document.querySelectorAll('.leksa-sub-menu-wrap'),
				menuItem = document.querySelectorAll('.menu-item'),
				transformY = 0;

			menuItem.forEach(function (item, i) {

				if (parents(item, '.menu--horizontal').length) {

					item.addEventListener('mouseenter', function () {

						if (item.classList.contains('leksa-has-children')) {
							let classList = item.className.split(' '),
								subIDClass = classList.find(cls => cls.startsWith('sub_id')),
								id = subIDClass ? subIDClass.substring("sub_id'".length) : ''
							disableScroll();
							document.querySelector('.sub_' + id).classList.add('active')
							transformY = 0

							gsap.to(document.querySelector('.sub_' + id), {
								y: '0',
								duration: 1.25,
								ease: 'expo.out'
							})

						} else {
							gsap.to(document.querySelectorAll('.leksa-sub-menu-wrap'), {
								y: '-100%',
								duration: 1.5,
								ease: 'expo.out'
							})

						}

					})
				}

			})

			submenus.forEach(function (submenu, i) {

				submenu.addEventListener('mouseleave', function () {
					enableScroll();
					gsap.to(submenu, {
						y: '-120%',
						duration: 1.1,
						ease: 'expo.out',
						onComplete: () => {
							submenu.classList.remove('active')
						}
					})
				})
			});




		}
		matchMedia.add({
			isDesktop: "(min-width: 450px)"

		}, (context) => {
			let {
				isDesktop
			} = context.conditions;
			leksaFullscreenSubmenu();
		});

	}

	function leksaFooter() {

		var footer = document.querySelector('.site-footer'),
			height = footer.offsetHeight;

		if (footer.classList.contains('footer--fixed')) {

			gsap.to(footer, {
				yPercent: 0,
				y: 0,
				'--opacity': 0,
				ease: 'none',
				scrollTrigger: {
					trigger: footer,
					scrub: true,
					start: 'bottom bottom',
					end: 'bottom+=' + (height + 5) + ' top'
				}
			})

		}


	}

	function leksaArchivePosts() {

		var archiveGrid = document.querySelector('.pe-archive-grid');

		if (archiveGrid) {

			var items = [...archiveGrid.querySelectorAll('.pe-archive-post')],
				msnry = new Masonry(archiveGrid, {
					itemSelector: '.pe-archive-post',
					columnWidth: '.pe-archive-grid-sizer',
					gutter: '.pe-archive-grid-gutter',

				});


			function archivePostsNavigation() {

				let postsNav = document.querySelector('.pe-theme-posts-nav'),
					pages = postsNav.getAttribute('data-max-pages');

				postsNav.querySelector('a').classList.add(buttonStyle);

				if (postsNav !== null) {

					if (postsNav.classList.contains('type_button')) {

						var button = postsNav.querySelector('.pe_load_more > a');

						button.addEventListener("click", function (e) {

							e.preventDefault();

							let targetUrl = button.getAttribute('href');

							$.ajax({
								type: 'GET',
								url: targetUrl,
								beforeSend: function () {

									html.classList.add('loading');
									postsNav.classList.add('ajax_loading');

								},
								success: function (response) {

									setTimeout(function () {

										var newPosts = $(response).find('.pe-archive-post'),
											newLink = $(response).find('.pe_load_more > a').attr('href'),
											paged = $(response).find('.pe-theme-posts-nav').data('paged');

										newPosts.appendTo(archiveGrid);
										msnry.appended(newPosts);

										postsNav.setAttribute('data-paged', paged)
										button.setAttribute('href', newLink);

										if (paged == pages) {

											postsNav.classList.add('op-hidden')

										}

										html.classList.remove('loading');
										postsNav.classList.remove('ajax_loading');

									}, 1000)

								},
								error: function (error) {

									html.classList.remove('loading');
									postsNav.classList.remove('ajax_loading');

								}
							});

						}, false);

					}

				}



			}
			document.querySelector('.pe-theme-posts-nav') ? archivePostsNavigation() : '';


		}
	}

	function leksaSinglePostPage() {

		var singlePostPage = document.querySelector('.single-post');

		if (singlePostPage) {

			var metas = singlePostPage.querySelector('.entry-meta'),
				content = singlePostPage.querySelector('.entry-content'),
				cats = metas.querySelectorAll('.post-cats a');

			for (var i = 0; i < cats.length; ++i) {
				cats[i].classList.add('underlined');
				document.querySelector()
			}

			ScrollTrigger.create({
				trigger: content,
				pin: metas,
				start: 'top top+=100',
				end: 'bottom top+=' + (metas.offsetHeight + 100) + ''
			})
		}


	}

	function leksaSmoothscroll() {


		if (document.body.classList.contains('smooth-scroll')) {

			const lenis = new Lenis({

			});

			lenis.on('scroll', ScrollTrigger.update);

			gsap.ticker.add((time) => {
				lenis.raf(time * 1000);
			});

			gsap.ticker.lagSmoothing(0);
			window.leksaLenis = lenis;
		} else {
			window.leksaLenis = false
		}

	}

	leksaSmoothscroll()

	function leksaPageTransitions(tl, cycle, trigger = false) {

		var transitions = document.querySelector('.page--transitions'),
			wrapper = transitions.querySelector('.pt--wrapper'),
			type = transitions.dataset.type,
			direction = transitions.dataset.direction;

		cycle === 'leave' ? transitions.classList.add('running') : '';

		if (trigger && trigger.trigger !== 'back' && trigger.trigger !== 'popstate') {


			if (parents(trigger.trigger, '.nav--popup').length) {
				let menu = parents(trigger.trigger, '.nav--popup')[0];
				menu.querySelector('.menu--toggle').click();
			}
		}

		if (type === 'overlay') {

			let overlay = wrapper.querySelector('.pt--overlay'),
				curved = overlay.dataset.curved,
				curve = {};

			if (curved) {
				curve = {
					borderTopLeftRadius: direction === 'down' ? '50%' : '0%',
					borderTopRightRadius: direction === 'down' ? '50%' : '0%',
					borderBottomLeftRadius: direction === 'up' ? '50%' : '0%',
					borderBottomRightRadius: direction === 'up' ? '50%' : '0%',
				};

			}

			if (cycle === 'leave') {

				tl.to(overlay, {
					width: '100%',
					height: '100%',
					borderRadius: 0,
					duration: .75,
					ease: 'power3.inOut'
				})

			}

			if (cycle === 'beforeEnter') {

				tl.to(overlay, {
					width: '100%',
					height: '0%',
					duration: .75,
					...curve,
					ease: 'power3.inOut',
					onStart: () => {

						gsap.set(overlay, {
							top: direction === 'up' ? 0 : 'unset',
							bottom: direction === 'up' ? 'unset' : 0,
						})

					},
					onComplete: () => {

						transitions.classList.remove('running')

						gsap.set(overlay, {
							clearProps: 'all'
						})
					}
				})

			}

		}

		if (type === 'slide') {

			if (document.querySelector('.is-pinning')) {

				gsap.set(document.querySelector('.is-pinning'), {
					top: window.scrollY
				})
			}

			if (cycle === 'leave') {

				tl.to('main', {
					duration: 1,
					y: -300,
					ease: 'expo.inOut'
				}, 0)

				tl.to('.slide--op', {
					duration: 1,
					opacity: .6,
					visibility: 'visible',
					ease: 'expo.inOut',
					onComplete: () => {
						clearProps(document.querySelector('.slide--op'))
					}
				}, 0)

				tl.to(wrapper, {
					y: 0,
					duration: 1,
					visibility: 'visible',
					ease: 'expo.inOut',
					borderRadius: 0
				}, 0)
			}

			if (cycle === 'beforeEnter') {

				tl.to('main', {
					duration: .1
				})

				let mains = document.querySelectorAll('main');
				mains[0].remove();

			}

			if (cycle === 'afterEnter') {

				gsap.set('main', {
					y: '100vh'
				})

				tl.to(wrapper, {
					y: '-100%',
					duration: 1.25,
					visibility: 'visible',
					ease: 'expo.inOut',
					borderRadius: 50
				}, 0.1)

				tl.to('main', {
					y: 0,
					duration: 1.25,
					visibility: 'visible',
					ease: 'expo.inOut'
				}, 0.1)

				tl.to('.pt--overlay', {
					duration: 1.25,
					opacity: .6,
					visibility: 'visible',
					ease: 'expo.inOut',
					onComplete: () => {
						clearProps(['.slide--op', 'main', wrapper, '.pt--overlay'])
					}
				}, 0.1)

			}

		}

	}

	function elementHandle(element, tl) {

		if (document.querySelector('.showcase-table')) {
			tl.to(element, {
				rotate: 0,
				duration: .75,
				ease: 'expo.out'
			})
		}

		if (document.querySelector('.leksa-showcase-carousel')) {

			tl.to(element[0].querySelector('img'), {
				x: 0,
				width: '100%',
				duration: 1.25,
				ease: 'expo.inOut'
			}, 0)

			tl.to(element[0].querySelector('.parallax--wrap'), {
				x: 0,
				y: 0,
				scale: 1,
				width: '100%',
				height: '100%',
				duration: 1.25,
				ease: 'expo.inOut'
			}, 0)
		}

		if (document.querySelector('.leksa-showcase-rotate')) {

			tl.to(element[0], {
				duration: 1.25,
				onStart: () => {
					element[0].click();
				}

			}, 0)


		}


	}

	function leksaProjectTransitions(tl, image, behavior, target) {

		let rect = image.getBoundingClientRect(),
			styles = window.getComputedStyle(image),
			transitionMedia = image.cloneNode(true);

		var handleScroll = 0;

		if (ScrollSmoother.get()) {
			let scrollSmoother = ScrollSmoother.get();
			handleScroll = scrollSmoother.scrollTop();
		}

		if (behavior === 'beforeLeave') {

			if (parents(image, '.needs--handle').length) {

				let element = parents(image, '.needs--handle');

				elementHandle(element, tl);
			} else {
				tl.to(image, {
					duration: .1
				})
			}


		}

		if (behavior === 'leave') {

			for (var i = 0; i < styles.length; i++) {
				var prop = styles[i];
				transitionMedia.style[prop] = styles.getPropertyValue(prop);
			}

			transitionMedia.classList.add('transition--media');
			transitionMedia.querySelector('.pe-video') ? transitionMedia.classList.add('tm--video') : '';

			document.body.appendChild(transitionMedia);

			gsap.set(transitionMedia, {
				position: 'fixed',
				top: rect.y,
				left: rect.x,
				width: rect.width,
				height: rect.height,
				zIndex: 99999
			});

			tl.to(transitionMedia, {
				duration: transitionMedia.querySelector('.pe-video') ? 2 : .5,
			}, 0)


			if (transitionMedia.querySelector('.pe-video')) {
				tl.to(transitionMedia.querySelector('iframe'), {
					opacity: 1,
					duration: .1
				}, 2)

			}

		}

		if (behavior === 'enter') {

			gsap.to('main', {
				opacity: 0,
				duration: .3,
				ease: 'power3.in',
				onComplete: () => {

					if (ScrollSmoother.get()) {
						let scrollSmoother = ScrollSmoother.get();
						scrollSmoother.scrollTo(0, false);


					} else {
						window.scrollTo(0, 0);
					}

					document.querySelector('main').remove();


					let transitionMedia = document.querySelector('.transition--media');


					if (transitionMedia.querySelector('.pe-video') || !target) {

						tl.to(transitionMedia, {
							clipPath: 'inset(0% 0% 100% 0% round 35px)',
							duration: 1,
							ease: 'expo.inOut'
						})

						tl.play();

					} else {

						let state = Flip.getState(transitionMedia, {
							props: 'borderRadius',
						}),
							targetRect = target.getBoundingClientRect(),
							targetStyles = window.getComputedStyle(target);

						for (var i = 0; i < targetStyles.length; i++) {
							var prop = targetStyles[i];
							transitionMedia.style[prop] = targetStyles.getPropertyValue(prop);
						}

						gsap.set(transitionMedia, {
							position: 'fixed',
							top: targetRect.y + handleScroll,
							left: targetRect.x,
							width: targetRect.width,
							height: targetRect.height
						});


						let flip = Flip.from(state, {
							duration: 1,
							ease: 'expo.inOut',
						})

						tl.add(flip);
						tl.play();

					}

				}
			})

		}

	}

	if (document.querySelector('.page--transitions')) {

		barba.init({
			timeout: 10000,
			debug: false,
			transitions: [
				{
					name: 'default-transition',
					leave(trigger) {

						return new Promise(function (resolve, reject) {

							let tl = gsap.timeline({
								onComplete: () => {

									resolve();

								}
							})

							leksaPageTransitions(tl, 'leave', trigger)

						})

					},
					beforeEnter(data) {

						return new Promise(function (resolve, reject) {

							let tl = gsap.timeline({
								onStart: () => {

									resolve();

								},
							})

							leksaPageTransitions(tl, 'beforeEnter')

						})
					},
					afterEnter(data) {

						return new Promise(function (resolve, reject) {

							let tl = gsap.timeline({
								onStart: () => {
									resolve();
								},
								onUpdate: () => {
									ScrollTrigger.refresh();
								}
							})

							leksaPageTransitions(tl, 'afterEnter')

						})
					},
				}, {
					name: 'project-transition',
					from: {
						custom: ({
							trigger
						}) => {
							return trigger.classList && trigger.classList.contains('barba--trigger');
						},
					},
					beforeLeave(trigger) {

						return new Promise(function (resolve, reject) {

							let id = trigger.trigger.dataset.id,
								image = document.querySelector('.project__image__' + id),
								tl = gsap.timeline({
									onComplete: () => {
										resolve();

									}
								})

							leksaProjectTransitions(tl, image, 'beforeLeave', false);

						})

					},
					leave(trigger) {

						return new Promise(function (resolve, reject) {

							let id = trigger.trigger.dataset.id,
								image = document.querySelector('.project__image__' + id),
								tl = gsap.timeline({
									onComplete: () => {
										resolve();

									}
								})

							leksaProjectTransitions(tl, image, 'leave', false);

						})

					},
					enter(trigger) {
						return new Promise(function (resolve, reject) {

							let id = trigger.trigger.dataset.id,
								image = document.querySelector('.project__image__' + id),
								targetImage = document.querySelector('.featured__' + id),
								tl = gsap.timeline({
									paused: true,
									onComplete: () => {
										resolve();
										document.querySelector('.transition--media').remove();
										gsap.set('main', {
											opacity: 1
										})

									}
								});



							leksaProjectTransitions(tl, image, 'enter', targetImage);


						})
					}
				},
			]

		})

		function barbaPrevents() {

			var prevents = $('.pe-load-more, .elementor-image-gallery a, .lang-item, .lang-item a, .elementor-gallery__container a, .elementor-image-gallery, #wpadminbar, .elementor-editor-wp-page, .woocommerce-cart-form, .portfolio--pagination');

			prevents.attr('data-barba-prevent', 'all')
		}

		barbaPrevents();

		if (history.scrollRestoration) {
			history.scrollRestoration = "manual";
		}

		ScrollTrigger.clearScrollMemory('manual');

		barba.hooks.before((data) => {

			html.classList.remove('ajax--first')
			document.documentElement.classList.add('loading');
			document.documentElement.classList.add('barba--running');
			disableScroll();

		})

		barba.hooks.enter((data) => {

			const parser = new DOMParser();
			const newDoc = parser.parseFromString(data.next.html, "text/html");
			const currentDoc = parser.parseFromString(data.current.html, "text/html");
			const bodyClasses = newDoc.querySelector('body').classList;
			const newBodyHasClass = newDoc.querySelector('body').classList.contains('layout--switched');
			const currentBodyHasClass = currentDoc.querySelector('body').classList.contains('layout--switched');
			const headerClasses = newDoc.querySelector('.site-header').classList;
			const currentHeaderClasses = currentDoc.querySelector('.site-header').classList;

			document.querySelector('.site-header').classList = headerClasses;

			if (newBodyHasClass !== currentBodyHasClass) {

				if (document.querySelector('.pe-layout-switcher')) {

					document.querySelector('.pe-layout-switcher').click();

					setTimeout(() => {

						document.body.classList = bodyClasses;

					}, 1000);
				}

			} else {
				document.body.classList = bodyClasses;
			}

			const elementorTags = [
				'link[id*="elementor"]',
				'link[id*="eael"]',
				'style[id*="elementor"]',
				'style[id*="eael"]',
				'style[id*="elementor-frontend-inline"]',
				'style[id*="elementor-post"]',
				'link[id*="elementor-post"]',
			].join(',');

			const headTags = [
				'meta[name="keywords"]',
				'meta[name="description"]',
				'meta[property^="og"]',
				'meta[name^="twitter"]',
				'meta[itemprop]',
				'link[itemprop]',
				'link[rel="prev"]',
				'link[rel="next"]',
				'link[rel="canonical"]',
				'link[rel="alternate"]',
				'link[rel="shortlink"]',
				'link[id*="google-fonts"]',
				'style[id*="leksa_-body-styles"]'
			].join(',');

			const newElements = newDoc.querySelectorAll(`${elementorTags}, ${headTags}`);

			const currentElements = document.querySelectorAll(`${elementorTags}, ${headTags}`);

			const existsInCurrentDOM = (newElement) => {
				return Array.from(currentElements).some(currentElement =>
					currentElement.tagName.toLowerCase() === newElement.tagName.toLowerCase() &&
					currentElement.id === newElement.id);
			};

			newElements.forEach(element => {
				if (!existsInCurrentDOM(element)) {
					document.head.appendChild(element.cloneNode(true));
				}
			});

		});

		barba.hooks.afterEnter(() => {

			if (!html.classList.contains('ajax--first')) {

				if (ScrollSmoother.get()) {
					let scrollSmoother = ScrollSmoother.get();
					scrollSmoother.scrollTo(0, false);

				} else {
					window.scrollTo(0, 0);
				}


				let scrolltriggers = ScrollTrigger.getAll();

				scrolltriggers.forEach(function (st) {

					if (st.vars.id !== 'fixedHeader') {

						st.kill();
					}
				})

				if (typeof window.elementorFrontend !== 'undefined') {

					window.elementorFrontend.init();

				}
				if (typeof pageScripts === 'function') {
					pageScripts();
				}

			}

		});

		barba.hooks.after((data) => {

			if (ScrollSmoother.get()) {
				let scrollSmoother = ScrollSmoother.get();
				scrollSmoother.scrollTo(0, false);


			} else {
				window.scrollTo(0, 0);
			}


			setTimeout(() => {

				document.documentElement.classList.remove('loading');
				document.documentElement.classList.remove('barba--running');
				enableScroll();

				ScrollTrigger.update(true)
				ScrollTrigger.refresh(true)
			}, 100);

		});
	}


	if ((!document.body.classList.contains('e-preview--show-hidden-elements')) && document.querySelector('.pe--page--loader')) {
		leksaPageLoader()
	}


	var loader = gsap.getById('pageLoader');

	if (loader) {

		loader.eventCallback('onComplete', () => {
			enableScroll();
			leksaLoaderOut(document.querySelector('.pe--page--loader').dataset.type);
			pageScripts();
		})

	} else {
		html.classList.remove('loading');
		html.classList.remove('first--load');

		window.addEventListener("load", function () {
			pageScripts();
		});
	}

	leksamouseCursor();

	function pageScripts() {
		leksaArchivePosts();
		//	leksaSinglePostPage();
		leksaHeader();
		leksaFooter();
		shopScripts();
	}

	window.addEventListener("load", function () {

		ScrollTrigger.refresh(true);
		ScrollTrigger.update(true);


	});




}(jQuery));
