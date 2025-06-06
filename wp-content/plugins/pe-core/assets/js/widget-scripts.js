(function ($) {
    "use strict";

    gsap.registerPlugin(Draggable, ScrollTrigger, ScrollToPlugin, InertiaPlugin, ScrollSmoother, Flip);

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

    var mobileQuery = window.matchMedia('(max-width: 450px)'),
        siteHeader = $('.site-header'),
        matchMedia = gsap.matchMedia(),
        isPhone = '(max-width: 450px)',
        isTablet = '(min-width: 450px) and (max-width: 900px)',
        isDesktop = '(min-width: 900px)';



    var cursor = document.getElementById('mouseCursor') ? document.getElementById('mouseCursor') : false,
        cursorText = cursor ? cursor.querySelector('.cursor-text') : false,
        cursorIcon = cursor ? cursor.querySelector('.cursor-icon') : false;


    var keys = {
        37: 1,
        38: 1,
        39: 1,
        40: 1
    };

    function preventDefault(e) {
        e.preventDefault();
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

    // call this to Disable
    function disableScroll() {

        if (leksaLenis) {
			leksaLenis.stop()
		} else {

            window.addEventListener('DOMMouseScroll', preventDefault, false); // older FF
            window.addEventListener(wheelEvent, preventDefault, wheelOpt); // modern desktop
            window.addEventListener('touchmove', preventDefault, wheelOpt); // mobile
            window.addEventListener('keydown', preventDefaultForScrollKeys, false);
        }

    }

    // call this to Enable
    function enableScroll() {

        if (leksaLenis) {
			leksaLenis.start()
		} else {
            window.removeEventListener('DOMMouseScroll', preventDefault, false);
            window.removeEventListener(wheelEvent, preventDefault, wheelOpt);
            window.removeEventListener('touchmove', preventDefault, wheelOpt);
            window.removeEventListener('keydown', preventDefaultForScrollKeys, false);
        }

    }


    /////////////////////////
    //   Global Scripts   //
    /////////////////////////


    function peScrollButton(button) {

        var target = button.dataset.scrollTo,
            duration = button.dataset.scrollDuration;

        button.addEventListener('click', () => {

            gsap.to(window, {
                duration: duration,
                scrollTo: isNaN(target) ? $(target).offset().top : target,
                ease: 'expo.inOut',
            });

        })

    }

    function resetCursor() {

        cursor.classList.remove('cursor--default')
        cursor.classList.remove('cursor--text');
        cursor.classList.remove('cursor--icon');
        cursor.classList.remove('dragging--right');
        cursor.classList.remove('dragging--left');
        cursorText.innerHTML = '';
        cursorIcon.innerHTML = '';

    }

    barba.hooks.before(() => {

        resetCursor();
    });


    function peCursorInteraction(target) {

        // Types: default/text/icon

        var type = target.dataset.cursorType,
            text = target.dataset.cursorText,
            icon = target.dataset.cursorIcon;

        target.addEventListener('mouseenter', () => {

            if (!target.classList.contains('cursor--disabled')) {


                if (type === 'default') {

                    cursor.classList.add('cursor--default')
                }

                if (type === 'text') {

                    cursor.classList.add('cursor--text');
                    cursorText.innerHTML = text;

                }

                if (type === 'icon') {

                    cursor.classList.add('cursor--icon');
                    cursorIcon.innerHTML = icon;

                }
            }
        });

        target.addEventListener('mouseleave', () => resetCursor());

    }


    function peCursorDrag(target, init = true) {
        resetCursor()

        let width = target.clientWidth;

        function init() {

            cursor.classList.add('cursor--icon');
            cursor.classList.add('cursor--drag');

            cursorIcon.innerHTML = '<i aria-hidden="true" class="material-icons-sharp md-arrow_forward" data-md-icon="arrow_backward"></i>';

        }


        target.addEventListener('mousemove', e => {

            if (e.clientX < width / 2) {

                cursor.classList.remove('dragging--right');
                cursor.classList.add('dragging--left');


            } else if (e.clientX > e.clientX < width / 2) {

                cursor.classList.remove('dragging--left');
                cursor.classList.add('dragging--right');
            }


        })

        target.addEventListener('mouseleave', () => resetCursor());
        target.addEventListener('mouseenter', () => init());

    }

    function peCustomSelect(target) {

        var x, i, j, l, ll, selElmnt, a, b, c;
        /*look for any elements with the class "custom-select":*/
        x = target;
        l = x.length;
        for (i = 0; i < l; i++) {
            selElmnt = x[i].getElementsByTagName("select")[0];
            ll = selElmnt.length;
            /*for each element, create a new DIV that will act as the selected item:*/
            a = document.createElement("DIV");
            a.setAttribute("class", "select-selected");
            a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
            a.setAttribute('data-select', selElmnt.options[selElmnt.selectedIndex].innerHTML);
            x[i].appendChild(a);
            /*for each element, create a new DIV that will contain the option list:*/
            b = document.createElement("DIV");
            b.setAttribute("class", "select-items select-hide");
            for (j = 1; j < ll; j++) {
                /*for each option in the original select element,
                create a new DIV that will act as an option item:*/
                c = document.createElement("DIV");
                c.innerHTML = selElmnt.options[j].innerHTML;
                c.addEventListener("click", function (e) {
                    /*when an item is clicked, update the original select box,
                    and the selected item:*/
                    var y, i, k, s, h, sl, yl;
                    s = this.parentNode.parentNode.getElementsByTagName("select")[0];
                    sl = s.length;
                    h = this.parentNode.previousSibling;
                    for (i = 0; i < sl; i++) {
                        if (s.options[i].innerHTML == this.innerHTML) {
                            s.selectedIndex = i;
                            h.setAttribute('data-select', this.innerHTML);
                            y = this.parentNode.getElementsByClassName("same-as-selected");
                            yl = y.length;
                            for (k = 0; k < yl; k++) {
                                y[k].removeAttribute("class");
                            }
                            this.setAttribute("class", "same-as-selected");
                            break;
                        }
                    }
                    h.click();
                });
                b.appendChild(c);
            }
            x[i].appendChild(b);
            a.addEventListener("click", function (e) {
                /*when the select box is clicked, close any other select boxes,
                and open/close the current select box:*/
                e.stopPropagation();
                closeAllSelect(this);
                this.nextSibling.classList.toggle("select-hide");
                this.classList.toggle("select-arrow-active");
            });
        }

        function closeAllSelect(elmnt) {
            /*a function that will close all select boxes in the document,
            except the current select box:*/
            var x, y, i, xl, yl, arrNo = [];
            x = document.getElementsByClassName("select-items");
            y = document.getElementsByClassName("select-selected");
            xl = x.length;
            yl = y.length;
            for (i = 0; i < yl; i++) {
                if (elmnt == y[i]) {
                    arrNo.push(i)
                } else {
                    y[i].classList.remove("select-arrow-active");
                }
            }
            for (i = 0; i < xl; i++) {
                if (arrNo.indexOf(i)) {
                    x[i].classList.add("select-hide");
                }
            }
        }
        /*if the user clicks anywhere outside the select box,
        then close all select boxes:*/
        document.addEventListener("click", closeAllSelect);

    }

    function isPinnng(trigger, add) {

        if (!mobileQuery.matches) {
            if (add) {
                if (document.querySelector(trigger)) {
                    document.querySelector(trigger).classList.add('is-pinning')
                }

            } else {
                if (document.querySelector(trigger)) {
                    document.querySelector(trigger).classList.remove('is-pinning')
                }
            }

        }

    }


    window.addEventListener('elementor/frontend/init', function () {

        if (document.body.classList.contains('e-preview--show-hidden-elements')) {

            document.body.setAttribute('data-barba-prevent', 'all');
        }

        elementorFrontend.hooks.addAction('frontend/element_ready/global', function ($scope, $) {

            var jsScopeArray = $scope.toArray();
            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    id = scope.dataset.id;

                var containerBg = document.querySelector('.bg--for--' + id);
                containerBg ? scope.prepend(containerBg) : '';

                if (scope.querySelector('.container--bg')) {

                    //                    let video = scope.querySelector('.container--bg').querySelector('.pe-video');
                    //                    video ? pe_coreVideo(video) : '';
                }

                if (scope.classList.contains('animate--radius')) {

                    setTimeout(() => {

                        let radius = window.getComputedStyle(scope).borderRadius.split(' '),
                            width = scope.getBoundingClientRect().width,
                            padding = getComputedStyle(scope).getPropertyValue('--container-default-padding-left');

                        gsap.to(scope, {
                            borderRadius: '0px',
                            width: scope.classList.contains('integared--width') && !mobileQuery.matches ? '100%' : '--width',
                            padding: padding,
                            ease: 'none',
                            scrollTrigger: {
                                trigger: scope,
                                start: 'top bottom',
                                end: 'top top',
                                scrub: true
                            }
                        })

                        gsap.fromTo(scope, {
                            borderRadius: '0px 0px 0px 0px',
                            padding: padding,
                        }, {
                            borderRadius: radius,
                            width: width,
                            padding: 0,
                            ease: 'none',
                            immediateRender: false,
                            scrollTrigger: {
                                trigger: scope,
                                start: 'bottom  bottom',
                                end: 'bottom center',
                                scrub: true
                            }
                        })

                    }, 1);

                }


                //Animations
                setTimeout(() => {

                    if (scope.hasAttribute('data-anim-general')) {

                        new peGeneralAnimation(scope);

                    }

                    if (scope.classList.contains('will__animated') && scope.querySelector('.container--anim--hold')) {

                        console.log('caaa')

                        let hold = scope.querySelector('.container--anim--hold'),
                            anim = hold.dataset.animation,
                            sett = hold.dataset.settings;

                        scope.setAttribute('data-animation', anim);
                        scope.setAttribute('data-settings', sett);

                        new peGeneralAnimation(scope);

                    }

                }, 10);

                if (scope.classList.contains('convert--carousel')) {

                    let width = scope.offsetWidth,
                        classList = scope.className,
                        classes = classList.split(' '),
                        carouselIdClass = classes.find(cls => cls.startsWith('carousel_id')),
                        carouselTriggerClass = classes.find(cls => cls.startsWith('carousel_trigger')),
                        trigger = carouselTriggerClass ? carouselTriggerClass.substring("carousel_trigger_".length) : '.' + scope.classList[0],
                        id = carouselIdClass ? carouselIdClass.substring("carousel_id_".length) : scope.dataset.id,
                        items = scope.children;

                    for (var i = 0; i < items.length; i++) {

                        items[i].classList.contains('e-con') ? items[i].classList.add('cr--item') : '';
                        items[i].setAttribute('data-cr', i + 1);

                    }

                    scope.setAttribute('data-total', scope.querySelectorAll('.cr--item').length);

                    if (scope.classList.contains('cr--drag')) {

                        Draggable.create(scope, {
                            id: id,
                            type: 'x',
                            bounds: {
                                minX: 0,
                                maxX: -width + document.body.clientWidth
                            },
                            lockAxis: true,
                            dragResistance: 0.5,
                            inertia: true,
                        });

                        scope.classList.contains('cursor_drag') ? peCursorDrag(scope) : '';


                    } else if (scope.classList.contains('cr--scroll')) {

                        gsap.to(scope, {
                            x: (-1 * width) + document.body.clientWidth,
                            scrollTrigger: {
                                id: id,
                                trigger: trigger,
                                scrub: true,
                                pin: trigger,
                                ease: "elastic.out(1, 0.3)",
                                start: 'center center',
                                end: 'bottom+=6000 bottom'
                            }
                        })

                    }

                }

                if (scope.classList.contains('convert--layered')) {

                    let items = scope.children,
                        classList = scope.className,
                        classes = classList.split(' '),
                        speedClass = classes.find(cls => cls.startsWith('layered_speed')),
                        speed = speedClass ? speedClass.substring("layered_speed_".length) : '.' + scope.classList[0],
                        triggerClass = classes.find(cls => cls.startsWith('layered_target')),
                        trigger = triggerClass ? triggerClass.substring("layered_target_".length) : scope;

                    let tl = gsap.timeline({
						id: scope.dataset.id,
                        scrollTrigger: {
                            trigger: trigger,
                            start: 'top top',
                            end: 'bottom+=' + speed + ' top',
                            pin: trigger,
                            scrub: true
                        }
                    });

                    for (var i = 0; i < items.length; i++) {

                        if (items[i].classList.contains('e-con')) {

                            if (i != 0) {
                                tl.to(items[i], {
                                    yPercent: 0,
                                    y: 0,
                                    ease: 'none'
                                }, 'label_' + i)

                                if (window.screen.height < items[i].getBoundingClientRect().height) {

                                    tl.to(items[i], {
                                        y: window.screen.height - items[i].getBoundingClientRect().height,
                                        ease: 'none'
                                    }, 'label_' + i)

                                }

                                tl.to(items[i - 1], {
                                    opacity: 0,
                                    scale: 0.9,
                                    '--op': 1,
                                    ease: 'none'
                                }, 'label_' + i)

                            }
                        }
                    }

                    if (scope.classList.contains('only__desktop')) {
                        matchMedia.add({
                            isMobile: "(max-width: 550px)"
    
                        }, (context) => {
    
                            let {
                                isMobile
                            } = context.conditions;
    
                            gsap.getById(scope.dataset.id) ? gsap.getById(scope.dataset.id).scrollTrigger.kill(true) : '';
    
                        });

                    }

                }

                if (scope.classList.contains('convert--tabs')) {
                    let id = scope.dataset.id,
                        innerContent = scope.innerHTML,
                        titles;

                    scope.innerHTML = '<div class="tabs--wrapper">' + innerContent + '</div>';

                    let wrapper = scope.querySelector('.tabs--wrapper'),
                        econs = Array.from(wrapper.children).filter(child => child.classList.contains('e-con'));

                    if (scope.querySelector('.container--tab--titles--wrap')) {
                        titles = scope.querySelector('.container--tab--titles--wrap');
                        scope.insertBefore(titles, scope.firstChild);

                    } else {
                        titles = document.querySelector('.container--tab--titles__' + id);
                        scope.insertBefore(titles, scope.firstChild);

                    }

                    for (let i = 0; i <= econs.length; i++) {
                        let tab = econs[i];

                        if (tab && tab.nodeName === 'DIV' && tab.classList.contains('e-con')) {
                            tab.classList.add('container--tab--item');
                        }
                    }

                    let tabItems = scope.querySelectorAll('.container--tab--item');

                    tabItems.forEach((tabItem, i) => {
                        i++
                        tabItem.classList.add('tab--item__' + i);
                        if (i == 1) {
                            tabItem.classList.add('active');
                        }
                    });

                    gsap.set(wrapper, {
                        height: scope.querySelector('.container--tab--item.active').offsetHeight
                    })

                    titles.querySelectorAll('.container--tab--title').forEach(title => {

                        title.addEventListener('click', () => {

                            scope.querySelector('.container--tab--title.active').classList.remove('active');
                            title.classList.add('active');

                            let findCont = scope.querySelector('.tab--item__' + title.dataset.index),
                                state = Flip.getState(tabItems);

                            gsap.set(tabItems, {
                                display: 'none',
                            })

                            gsap.set(findCont, {
                                display: 'block',
                            });

                            Flip.from(state, {
                                duration: .75,
                                ease: "power3.inOut",
                                absolute: true,
                                fade: true,
                                onStart: () => {

                                    gsap.to(wrapper, {
                                        height: findCont.offsetHeight,
                                        duration: .75,
                                        ease: "power3.inOut",
                                    })

                                },
                                onComplete: () => {
                                    ScrollTrigger.refresh();
                                },
                                onEnter: (elements) =>
                                    gsap.fromTo(
                                        elements,
                                        {
                                            opacity: 0,
                                            yPercent: 100,
                                        },
                                        {
                                            opacity: 1,
                                            duration: .75,
                                            yPercent: 0,
                                            delay: 0,
                                            ease: "power3.inOut",
                                        }
                                    ),
                                onLeave: (elements) =>
                                    gsap.to(elements, {
                                        opacity: 0,
                                        scale: .9,
                                        duration: .75,
                                        ease: "power3.inOut",
                                    })
                            });

                        })

                    })

                }
                if (scope.dataset.title && parents(scope, '.convert--accordion').length) {

                    scope.classList.add('container--accordion--item');
                    scope.classList.add('acc--item__' + scope.dataset.id);
                }

                if (scope.querySelector('.container--accordion--title') && (!scope.classList.contains('convert--accordion')) && (!scope.classList.contains('convert--tabs'))) {

                    let title = scope.querySelector('.container--accordion--title');

                    title.setAttribute('data-id', scope.dataset.id)

                    scope.classList.add('container--accordion--item');
                    scope.classList.add('acc--item__' + scope.dataset.id);

                    scope.parentNode.insertBefore(title, scope);


                }


                setTimeout(() => {
                    if (scope.classList.contains('convert--accordion')) {

                        let titles = scope.querySelectorAll('.container--accordion--title'),
                            contents = scope.querySelectorAll('.container--accordion--item');


                        if (scope.classList.contains('active--first')) {
                            contents[0].classList.add('cont--acc--active')
                        }

                        titles.forEach((title, i) => {
                            i++
                            title.querySelector('.ac-order').innerHTML = '(0' + i + ')';

                            title.addEventListener('click', () => {

                                let id = title.dataset.id,
                                    content = scope.querySelector('.acc--item__' + id);

                                if (content.classList.contains('cont--acc--active')) {

                                    title.classList.remove('active')

                                    var contentState = Flip.getState(content);
                                    content.classList.remove('cont--acc--active');

                                    Flip.from(contentState, {
                                        duration: .75,
                                        ease: 'expo.inOut',
                                        absolute: false,
                                        absoluteOnLeave: false,
                                        onComplete: () => {
                                            ScrollTrigger.refresh();
                                        },
                                    })

                                } else {

                                    var currentActive = scope.querySelector('.cont--acc--active');

                                    if (currentActive) {
                                        let currentTitle = scope.querySelector('.container--accordion--title.active');

                                        currentTitle.classList.remove('active');

                                        let currentContentState = Flip.getState(currentActive);

                                        currentActive.classList.remove('cont--acc--active');

                                        Flip.from(currentContentState, {
                                            duration: .75,
                                            ease: 'expo.inOut',
                                            absolute: false,
                                            absoluteOnLeave: false,
                                            onComplete: () => {
                                                ScrollTrigger.refresh();
                                            },
                                        })

                                    }

                                    //Open
                                    var contentState = Flip.getState(content);
                                    content.classList.add('cont--acc--active');
                                    title.classList.add('active')
                                    Flip.from(contentState, {
                                        duration: .75,
                                        ease: 'expo.inOut',
                                        absolute: false,
                                        absoluteOnLeave: false,
                                        onComplete: () => {
                                            ScrollTrigger.refresh();
                                        },
                                    })
                                }
                            })
                        })
                    }
                }, 10);

                if (scope.classList.contains('switch_on_enter')) {

                    function switcherClick() {
                        let switcher = document.querySelector('.pe-layout-switcher');

                        if (switcher) {
                            switcher.click();
                        }

                    }
                    ScrollTrigger.create({
                        trigger: scope,
                        start: 'top center',
                        end: 'bottom center',
                        onEnter: () => switcherClick(),
                        onLeave: () => switcherClick(),
                        onEnterBack: () => switcherClick(),
                        onLeaveBack: () => switcherClick(),
                    })

                }

                if (scope.classList.contains('pinned_true')) {

                    let items = scope.children,
                        classList = scope.className,
                        classes = classList.split(' '),
                        targetClass = classes.find(cls => cls.startsWith('pin_container')),
                        target = targetClass ? targetClass.substring("pin_container_".length) : '.' + scope.classList[0];

                    let pinnedScroll = ScrollTrigger.create({
                        trigger: document.querySelector(target),
                        pin: scope,
                        pinSpacing: true,
                        start: 'top top',
                        end: 'bottom top+=' + scope.offsetHeight + '',
                    })

                    matchMedia.add({
                        isMobile: "(max-width: 550px)"

                    }, (context) => {

                        let {
                            isMobile
                        } = context.conditions;

                        pinnedScroll.kill();

                    });

                }

                setTimeout(() => {
                    if (scope.classList.contains('curved_true')) {

                        let rhTop = document.querySelector('.rh--top.reverse__' + scope.dataset.id);
                        let rhBottom = document.querySelector('.rh--bottom.reverse__' + scope.dataset.id);

                        if (rhTop) {
                            gsap.set(rhTop, {
                                '--mainBackground': window.getComputedStyle(scope).backgroundColor
                            })
                        }
                        if (rhBottom) {
                            gsap.set(rhBottom, {
                                '--mainBackground': window.getComputedStyle(scope).backgroundColor
                            })

                        }
                    }

                }, 50);



                if (scope.classList.contains('e-parent')) {

                    var scopeBg = getComputedStyle(scope).getPropertyValue('background-color');

                    if (scopeBg !== 'rgba(0, 0, 0, 0)') {

                        function integrateColors() {

                            let headerColor = getComputedStyle(document.querySelector('.site-header')).getPropertyValue('--intColor'),
                                headerBrightness = gsap.utils.splitColor(headerColor, true)[2],
                                scopeBg = getComputedStyle(scope).getPropertyValue('background-color'),
                                scopeBrightness = gsap.utils.splitColor(scopeBg, true)[2];

                            if ((scopeBrightness < 50 && headerBrightness < 50) || (scopeBrightness > 50 && headerBrightness > 50)) {
                                document.querySelector('.site-header').classList.add('header--switched')

                            }
                        }

                        setTimeout(() => {

                            ScrollTrigger.create({
                                trigger: scope,
                                start: 'top top+=50',
                                end: 'bottom top+=50',
                                onEnter: () => {
                                    integrateColors()
                                },
                                onEnterBack: () => {
                                    integrateColors()
                                },
                                onLeave: () => {
                                    document.querySelector('.site-header').classList.remove('header--switched')
                                },
                                onLeaveBack: () => {
                                    document.querySelector('.site-header').classList.remove('header--switched')
                                },
                            })


                        }, 50);

                    }

                }

                // if (scope.classList.contains('fixed__content')) {
                // 	var childDivs = Array.from(scope.childNodes).filter(child => child.nodeName.toLowerCase() === 'div')

                // 	gsap.fromTo(childDivs , {
                // 		y: scope.getBoundingClientRect().height * -1
                // 	} , {
                // 		y: 0,
                // 		ease: 'none',
                // 		stagger: 1,
                // 		scrollTrigger: {
                // 			trigger: scope,
                // 			scrub: true,
                // 			start: 'top bottom',
                // 			end: 'bottom bottom'
                // 		}
                // 	})
                // }

            }

        })

        elementorFrontend.hooks.addAction('frontend/element_ready/widget', function ($scope, $) {

            var jsScopeArray = $scope.toArray();
            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i];

                // Scroll Buttons
                scope.querySelector('.pe--scroll--button') ? peScrollButton(scope.querySelector('.pe--scroll--button')) : '';
                // Scroll Buttons

                if (scope.querySelector('.pe--browser--back')) {

                    scope.querySelector('.pe--browser--back').addEventListener('click', () => {

                        window.history.back();
                    })
                }

                //Animations
                setTimeout(() => {

                    if (scope.querySelector('[data-anim-general="true"]')) {

                        var hasAnim = scope.querySelectorAll('[data-anim-general="true"]');

                        hasAnim.forEach(element => {

                            if (!scope.querySelector('div[data-elementor-type="pe-menu"]')) {

                                new peGeneralAnimation(element)

                            }
                        })

                    }

                }, 10);


                if (scope.querySelector('[data-anim-image="true"]')) {

                    var hasAnim = scope.querySelectorAll('[data-anim-image="true"]');

                    hasAnim.forEach(element => {

                        if (!scope.querySelector('div[data-elementor-type="pe-menu"]')) {

                            new peImageAnimation(element)
                        }

                    })

                }

                if (scope.querySelector('[data-cursor="true"]')) {

                    var targets = scope.querySelectorAll('[data-cursor="true"]');

                    targets.forEach(target => {

                        peCursorInteraction(target);

                    })

                }

                if (scope.querySelector('[data-animate="true"]')) {

                    scope.querySelectorAll('[data-animate="true"]').forEach(text => {
                        if (!scope.querySelector('div[data-elementor-type="pe-menu"]')) {

                            document.fonts.ready.then((fontFaceSet) => {

                                new peTextAnimation(text);

                            });

                        }
                    })
                }

                if (scope.querySelector('.pe-video')) {

                    let videos = scope.querySelectorAll('.pe-video')

                    for (var i = 0; i < videos.length; i++) {
                        new peVideoPlayer(videos[i]);
                    }

                }



            }

        })

        elementorFrontend.hooks.addAction('frontend/element_ready/pe-slider.default', function ($scope, $) {

            peSlider();

            function peSlider() {

                var main = $scope.find('.pe-slider');

                main.each(function () {
                    let $this = $(this),
                        wrapper = $this.find('.slider-wrapper'),
                        slide = $this.find('.pe-slide'),
                        itemWidth = slide.outerWidth(true),
                        itemHeight = slide.outerHeight(true),
                        navButton = $this.find('.navigate-button'),
                        pinTarget = $this.data('pin-target'),
                        speed = $this.data('speed'),
                        next = $this.find('.next'),
                        prev = $this.find('.prev'),
                        fraction = $this.find('.pe-fraction'),
                        activeEl = fraction.find('.active'),
                        total = fraction.find('.total'),
                        trigger = pinTarget ? pinTarget : $this;

                    total.html(slide.length)

                    if (!pinTarget) {
                        pinTarget = true
                    }

                    slide.each(function (i) {
                        i++;

                        let item = $(this)

                        item.attr('data-index', i);
                        item.addClass('data-index_' + i)

                        item.find('.item-wrap').css('width', parseInt(itemWidth))
                        item.find('.item-wrap').css('height', parseInt(itemHeight))

                        item.find('.slide-image').css('width', parseInt(itemWidth))
                        item.find('.slide-image').css('height', parseInt(itemHeight))

                    })


                    if ($this.hasClass('nav_scroll')) {


                        let tl = gsap.timeline({
                            scrollTrigger: {
                                trigger: trigger,
                                start: 'top top',
                                end: 'bottom bottom',
                                pin: $this,
                                scrub: true,
                                onUpdate: (self) => {
                                    let prog = self.progress * slide.length;

                                    if (prog > 1) {
                                        activeEl.html(Math.floor(prog))
                                    }
                                }
                            }
                        })

                        slide.each(function (i) {
                            let item = $(this);

                            if ($this.hasClass('vertical')) {

                                tl.to($(this), {
                                    ease: 'none',
                                    height: '100%'
                                })

                                slide.first().nextAll().css('height', 0)

                            } else {

                                tl.to($(this), {
                                    ease: 'none',
                                    width: '100%'
                                })

                                slide.first().nextAll().css('width', 0)

                            }

                        })

                    } else if ($this.hasClass('nav_button')) {

                        var x;
                        x = 1


                        navButton.on('click', function (e) {

                            if ($(this).hasClass('prev')) {
                                x--;

                            } else if ($(this).hasClass('next')) {
                                x++;
                            }

                            if (x <= 1) {
                                x = 1

                                gsap.to(prev, {
                                    opacity: 0.2
                                })

                                gsap.to(next, {
                                    opacity: 1
                                })

                            } else if (x >= slide.length) {
                                x = slide.length

                                gsap.to(next, {
                                    opacity: 0.2
                                })

                                gsap.to(prev, {
                                    opacity: 1
                                })


                            } else if (1 < x < slide.length) {

                                gsap.to(next, {
                                    opacity: 1
                                })

                                gsap.to(prev, {
                                    opacity: 1
                                })

                            }

                            if ($(this).hasClass('prev')) {

                                if ($this.hasClass('vertical')) {

                                    gsap.to($this.find('.data-index_' + (x + 1)), {
                                        height: '0%',
                                        duration: 0.1
                                    })

                                } else {

                                    gsap.to($this.find('.data-index_' + (x + 1)), {
                                        width: '0%',
                                        duration: 0.1
                                    })

                                }

                                activeEl.html(x)

                            } else if ($(this).hasClass('next')) {

                                gsap.to($this.find('.data-index_' + x), {
                                    width: '100%',
                                    height: '100%',
                                    duration: 0.1
                                })

                                activeEl.html(x)

                            }



                        })

                    }



                })

            }



        });

        elementorFrontend.hooks.addAction('frontend/element_ready/petable.default', function ($scope, $) {

            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    rows = scope.querySelectorAll('.pe--table--row');

                rows.forEach(row => {

                    let image = row.querySelector('.pe--table--row--image');

                    row.addEventListener("mouseenter", (e) => {
                        if (image) {
                            gsap.set(image, {
                                x: e.layerX,
                                y: e.layerY
                            })
                        }


                    });
                    row.addEventListener("mousemove", (e) => {
                        if (image) {
                            gsap.to(image, {
                                x: e.layerX + 10,
                                y: e.layerY + 10,
                                rotate: e.movementX / 2
                            })
                        }

                    });

                })


            }

        });

        elementorFrontend.hooks.addAction('frontend/element_ready/pegooglemaps.default', function ($scope, $) {

            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i];

                function initMap(latitude, longitude, zoomLevel, mapStyles, markerIcon) {

                    var mapOptions = {
                        zoom: zoomLevel,
                        center: { lat: parseFloat(latitude), lng: parseFloat(longitude) },
                        styles: mapStyles,
                        disableDefaultUI: true,
                        mapTypeControl: false,
                        fullscreenControl: false,
                        zoomControl: false,
                        streetViewControl: false,
                        rotateControl: false,
                        scaleControl: false
                    };

                    var map = new google.maps.Map(document.getElementById('pe--google--map'), mapOptions);

                    var markerOptions = {
                        position: mapOptions.center,
                        map: map,
                        icon: {
                            url: markerIcon,
                            scaledSize: new google.maps.Size(60, 60)
                        }
                    };

                    var marker = new google.maps.Marker(markerOptions);
                }

                var mapElement = document.getElementById('pe--google--map');

                if (mapElement) {

                    var latitude = mapElement.getAttribute('data-latitude');
                    var longitude = mapElement.getAttribute('data-longitude');
                    var zoomLevel = parseInt(mapElement.getAttribute('data-zoom-level'));
                    var mapStyles = JSON.parse(mapElement.getAttribute('data-map-styles'));
                    var markerIcon = mapElement.getAttribute('data-marker-icon');

                    initMap(latitude, longitude, zoomLevel, mapStyles, markerIcon);

                }

            }

        });

        elementorFrontend.hooks.addAction('frontend/element_ready/petestimonials.default', function ($scope, $) {

            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    testimonials = scope.querySelector('.pe--testimonials'),
                    wrapper = testimonials.querySelector('.pe--testimonials--wrapper'),
                    gap = window.getComputedStyle(wrapper).getPropertyValue('gap'),
                    wrapperHeight = wrapper.clientHeight,
                    wrapperWidth = wrapper.clientWidth,
                    items = wrapper.querySelectorAll('.pe-testimonial');

                let maxX = document.body.clientWidth * 0.75,
                    yVals = [];

                items.forEach((item, i) => {

                    let itemX = item.getBoundingClientRect().x - testimonials.getBoundingClientRect().x,
                        itemWidth = item.getBoundingClientRect().width,
                        randX = gsap.utils.random((-maxX / 2), (maxX / 2)),
                        randY = gsap.utils.random(0, 400),
                        randR = gsap.utils.random(-15, 15);


                    if (itemX > maxX) {

                        gsap.set(item, {
                            x: (-itemX + (maxX / 2) - (itemWidth / 2) + (parseFloat(gap) * 3)) + randX,
                            y: randY,
                            rotate: randR
                        })

                    } else if (itemX < (maxX / 2)) {

                        gsap.set(item, {
                            x: gsap.utils.random(-250, -100),
                            y: gsap.utils.random(100, 300),
                            rotate: randR
                        })

                    } else if (itemX > (maxX / 2)) {

                        gsap.set(item, {
                            x: gsap.utils.random(100, (maxX / 3)),
                            y: gsap.utils.random(100, 300),
                            rotate: randR
                        })

                    }

                    yVals.push(randY)

                })

                wrapper.style.height = (100 + wrapperHeight + Math.max(...yVals)) + 'px';

                Draggable.create(wrapper, {
                    type: 'x',
                    bounds: {
                        minX: 0,
                        maxX: -wrapperWidth + document.body.clientWidth - 50
                    },
                    lockAxis: true,
                    dragResistance: 0.5,
                    inertia: true,
                });

                var drag = Draggable.get(wrapper);
                drag.disable();

                wrapper.addEventListener('click', () => {

                    var state = Flip.getState(items);

                    testimonials.classList.add('pt--carousel')

                    gsap.set(items, {
                        clearProps: 'all'
                    })

                    Flip.from(state, {
                        duration: 1,
                        ease: "power3.inOut",
                        absolute: true,
                        absoluteOnLeave: true,
                        stagger: -0.05
                    });

                    drag.enable();
                    peCursorDrag(scope);
                    wrapper.classList.add('cursor--disabled');

                })


                matchMedia.add({
                    isMobile: "(max-width: 570px)"
                }, (context) => {

                    let {
                        isMobile
                    } = context.conditions;

                    wrapper.click();
                    gsap.set(wrapper, {
                        height: 'auto'
                    })

                });

            }
        });

        elementorFrontend.hooks.addAction('frontend/element_ready/pesitenavigation.default', function ($scope, $) {

            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    nav = scope.querySelector('.site--nav'),
                    toggle = scope.querySelector('.menu--toggle'),
                    menu = scope.querySelector('.site--menu'),
                    clicks = 0,
                    menuTimeline = gsap.timeline({
                        paused: true,
                    })


                toggle.addEventListener('click', () => {
                    clicks++

                    if (clicks % 2 == 0) {
                        // Close
                        toggle.classList.remove('active');
                        enableScroll();

                        if (nav.classList.contains('nav--popup')) {

                            popUpNav(false);

                        } else if (nav.classList.contains('nav--fullscreen')) {

                            fullscreenNav(false);

                        }

                    } else {
                        // Open
                        toggle.classList.add('active');
                        disableScroll();

                        if (nav.classList.contains('nav--popup')) {

                            popUpNav(true)
                            menuTimeline.play();


                        } else if (nav.classList.contains('nav--fullscreen')) {


                            fullscreenNav(true);
                            menuTimeline.restart();

                        }

                    }

                })

                // Popup Navigation 

                function popUpNav(open) {

                    if (open) {

                        gsap.to(menu, {
                            xPercent: 0,
                            x: 0,
                            duration: 1.4,
                            ease: 'expo.inOut',
                            onStart: () => {
                                menu.classList.add('active')
                            }
                        })


                    } else {

                        gsap.to(menu, {
                            xPercent: 100,
                            duration: 1.4,
                            ease: 'expo.inOut',
                            onComplete: () => {
                                menu.classList.remove('active')
                            }
                        })
                    }

                }

                // Popup Navigation 

                // Fullscreen Navigation 
                function fullscreenNav(open) {

                    if (open) {

                        gsap.to(menu, {
                            height: '100vh',
                            duration: .8,
                            ease: 'power4.inOut'
                        })

                        gsap.to('#primary', {
                            y: '50vh',
                            duration: .8,
                            ease: 'power4.inOut'
                        })


                    } else {

                        gsap.to(menu, {
                            height: '0vh',
                            duration: .8,
                            ease: 'power4.inOut'
                        })
                        gsap.to('#primary', {
                            y: '0vh',
                            duration: .8,
                            ease: 'power4.inOut'
                        })

                    }

                }


                // Fullscreen Navigation 




            }
        });

        elementorFrontend.hooks.addAction('frontend/element_ready/penavmenu.default', function ($scope, $) {
            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    nav = scope.querySelector('#site-navigation'),
                    menus = scope.querySelectorAll('ul'),
                    parentMenu = scope.querySelector('ul.main-menu'),
                    items = nav.querySelectorAll('.menu-item'),
                    toggleHTML = nav.dataset.subToggle,
                    toggle = document.createElement('div');

                items.forEach(item => {

                    item.querySelector('a').classList.add('menu--link')

                    const link = item.querySelector('a')
                    
                    if (link && parents(link, '.nav--fullscreen').length) {
                        link.addEventListener('click', (event) => {
                            const hrefValue = link.getAttribute('href');

                            if (hrefValue && hrefValue.startsWith('#')) {
                                event.preventDefault();
                                const menuToggle = parents(link, '.nav--fullscreen')[0].querySelector('.menu--toggle')
                                if (menuToggle) {
                                    menuToggle.click()
                                }
                                setTimeout(() => {
                                    gsap.to(window, {
                                        duration: 0.75,
                                        scrollTo: hrefValue,
                                        ease: 'expo.out'
                                    })
                                }, 300)
                            }
                        })
                    }

                })

                if (!scope.classList.contains('nav--init')) {

                    scope.classList.add('nav--init');

                    toggle.classList.add('st--wrap');
                    toggle.innerHTML = toggleHTML;

                    var childrens = [];
                    var childNodes = parentMenu.childNodes;

                    for (var i = 0; i < childNodes.length; i++) {

                        if (childNodes[i].nodeType === 1 && childNodes[i].tagName.toLowerCase() === "li") {

                            childrens.push(childNodes[i]);
                        }
                    }

                    if (!parentMenu.classList.contains('menu--horizontal')) {

                        parentMenu.querySelectorAll('.leksa-sub-menu-wrap').forEach((sub) => {
                            sub.remove();
                        });

                    }

                    childrens.forEach((item, i) => {

                        i++
                        item.setAttribute('data-index', i);

                        if (item.classList.contains('menu-item-has-children') || item.classList.contains('leksa-has-children')) {

                            let sub = item.querySelector('.sub-menu'),
                                a = item.childNodes[0];

                            item.insertBefore(toggle.cloneNode(true), sub);

                            item.querySelector('.st--wrap').addEventListener('click', () => {

                                if (item.classList.contains('sub--active')) {

                                    let subState = Flip.getState(sub, {
                                        props: ['padding']
                                    });
                                    item.classList.remove('sub--active');

                                    Flip.from(subState, {
                                        duration: .75,
                                        ease: 'expo.inOut',
                                        absolute: false,
                                        absoluteOnLeave: false,
                                    })

                                } else {

                                    nav.querySelector('.sub--active') ? nav.querySelector('.sub--active > .st--wrap').click() : '';

                                    let subState = Flip.getState(sub, {
                                        props: ['padding']
                                    });

                                    item.classList.add('sub--active');

                                    Flip.from(subState, {
                                        duration: .75,
                                        ease: 'expo.inOut',
                                        absolute: false,
                                        absoluteOnLeave: false,
                                    })
                                }

                            });

                            if (!nav.classList.contains('st--only')) {

                                a.addEventListener('click', (e) => {

                                    e.preventDefault();
                                    item.querySelector('.st--wrap').click();

                                })

                            }

                        }
                        // Has Children

                    })

                }

            }
        });

        elementorFrontend.hooks.addAction('frontend/element_ready/petextwrapper.default', function ($scope, $) {

            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    wrapper = scope.querySelector('.text-wrapper');


                document.fonts.ready.then((fontFaceSet) => {


                    // Editor markers handle.
                    //                    if (wrapper.classList.contains('markers-on')) {
                    //
                    //                        var elements = document.querySelectorAll('[class^="gsap-marker"]');
                    //
                    //                        elements.forEach(function (element) {
                    //
                    //                            if (elements.length > 4) {
                    //
                    //                                var startIndex = elements.length - 4;
                    //                                for (var i = startIndex; i < elements.length; i++) {
                    //                                    elements[i].remove();
                    //                                }
                    //                            }
                    //                        });
                    //
                    //                    } else {
                    //
                    //                        var elements = document.querySelectorAll('[class^="gsap-marker"]');
                    //
                    //                        elements.forEach(function (element) {
                    //
                    //                            element.remove();
                    //
                    //                        });
                    //
                    //                    }
                    // Editor markers handle.

                    //Inner Elements
                    var innerElements = wrapper.querySelectorAll('[class^="inner--"]');

                    innerElements.forEach((element) => {

                        let classes = element.classList,
                            hasMotion = Array.from(classes).some(className => className.startsWith('me--'));

                        // Motion Effects
                        if (hasMotion) {

                            let motion = hasMotion ? Array.from(classes).find(className => className.startsWith('me--')) : null,
                                duration = element.dataset.duration,
                                delay = element.dataset.delay,
                                ease = motion === 'me--flip-x' ? 'none' : motion === 'me--flip-y' ? 'none' : motion === 'me--hearthbeat-x' ? 'power4.inOut' : motion === 'me--slide-left' ? 'power3.in' : motion === 'me--slide-right' ? 'power3.in' : 'expo.out',
                                tl = gsap.timeline({
                                    repeat: -1,
                                    repeatDelay: parseInt(delay, 10)
                                }),
                                target = element;


                            if (motion === 'me--slide-left' || motion === 'me--slide-right') {

                                target = element.firstElementChild;
                            }

                            tl.fromTo(target, {
                                xPercent: 0,
                                scale: motion === 'me--hearth-beat' ? 0.6 : 1
                            }, {

                                scale: 1,
                                rotate: motion === 'me--rotate' ? -360 : 0,
                                rotateX: motion === 'me--flip-x' ? -360 : 0,
                                rotateY: motion === 'me--flip-y' ? -360 : 0,
                                xPercent: motion === 'me--slide-left' ? -100 : motion === 'me--slide-right' ? 100 : 0,
                                duration: duration,
                                ease: ease,

                            })

                            if (motion === 'me--slide-left' || motion === 'me--slide-right') {

                                tl.fromTo(target, {
                                    xPercent: motion === 'me--slide-left' ? 100 : motion === 'me--slide-right' ? -100 : 0
                                }, {
                                    xPercent: 0,
                                    duration: duration,
                                    ease: 'power3.out',
                                })
                            }

                            if (motion === 'me--hearth-beat') {

                                tl.to(target, {
                                    scale: 0.6,
                                    duration: duration
                                })
                            }

                        }

                    })
                    //Inner Elements

                    //Dyanmic words
                    function dynamicWordAnimation() {

                        let dynamicWords = wrapper.querySelectorAll('.pe-dynamic-words');

                        dynamicWords.forEach((dynamic) => {

                            let innerWrap = dynamic.firstElementChild,
                                words = innerWrap.querySelectorAll('span'),
                                duration = parseFloat(dynamic.dataset.duration),
                                delay = parseFloat(dynamic.dataset.delay),
                                pin = dynamic.dataset.pin,
                                scrub = dynamic.dataset.scrub,
                                scroll = false;

                            if (pin === 'true' || scrub === 'true') {

                                scroll = {
                                    trigger: scope,
                                    pin: pin === 'true' ? scope : false,
                                    scrub: 1,
                                    start: pin === 'true' ? 'center center' : 'top bottom',
                                    end: pin === 'true' ? 'bottom+=500 top' : 'bottom top',
                                    markers: true
                                };

                            }

                            let tl = gsap.timeline({
                                repeat: pin === 'true' ? 0 : scrub === 'true' ? 0 : -1,
                                scrollTrigger: scroll
                            });

                            dynamic.style.width = Math.ceil(words[0].getBoundingClientRect().width) + 'px';

                            words.forEach((word, i) => {

                                tl.to(innerWrap, {
                                    yPercent: -100 / words.length * i,
                                    duration: duration,
                                    delay: i == 0 ? 0 : delay,
                                    ease: scroll ? 'none' : 'expo.inOut'
                                }, 'label_' + i)

                                tl.to(dynamic, {
                                    width: Math.ceil(word.getBoundingClientRect().width),
                                    duration: duration,
                                    delay: delay,
                                    ease: scroll ? 'none' : 'expo.inOut'
                                }, 'label_' + i)


                            })

                        })

                    }
                    //Dyanmic words


                });

            }

        });

        elementorFrontend.hooks.addAction('frontend/element_ready/pevideo.default', function ($scope, $) {

            var jsScopeArray = $scope.toArray();
            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i];

                // new peVideoPlayer(scope.querySelector('.pe-video'));


            }

        });

        elementorFrontend.hooks.addAction('frontend/element_ready/pecircletext.default', function ($scope, $) {

            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i];

                if (scope) {
                    var circularText = scope.querySelectorAll('.pe-circular-text');


                    circularText.forEach(function ($this) {
                        var textWrap = $this.querySelector('.circular-text-wrap'),
                            circularContent = $this.querySelector(".circular-text-content"),
                            dataHeight = $this.dataset.height,
                            dataDuration = $this.dataset.duration,
                            dataTarget = $this.dataset.target,
                            circleSplit = new SplitText($this.querySelector('.circle-text'), {
                                type: "words, chars",
                                charsClass: "circle-char",
                                wordsClass: "circle-word",
                                position: "absolute"
                            }),
                            fontSize = parseInt(window.getComputedStyle($this.querySelector('.circle-char')).fontSize),
                            charLength = $this.querySelectorAll('.circle-char').length,
                            textLength = (dataHeight / charLength) / (fontSize / 1.75),
                            circleChar = $this.querySelectorAll('.circle-char'),
                            circleWord = $this.querySelectorAll('.circle-word'),
                            snap = gsap.utils.snap(1),
                            dataIcon = $this.dataset.icon;

                        for (var i = 2; i <= snap(textLength); i++) {
                            var clonedContent = circularContent.cloneNode(true);
                            textWrap.appendChild(clonedContent);
                        }
                        circularContent = $this.querySelectorAll(".circular-text-content");

                        gsap.set(circularContent, {
                            width: dataHeight,
                            height: dataHeight
                        })

                        var circleWordElements = $this.querySelectorAll('.circle-word');

                        circleWordElements.forEach(function (circleWordElement) {
                            var circleCharElement = document.createElement('span');
                            circleCharElement.className = 'circle-char';
                            circleWordElement.appendChild(circleCharElement);
                        });

                        $this.querySelectorAll('.circle-word').forEach(function (circleWordElement) {
                            gsap.set(circleWordElement, {
                                left: '50%',
                                top: 0,
                                height: "100%",
                                xPercent: -50
                            })
                        });

                        var charElements = $this.querySelectorAll('.circle-char'),
                            rotateMultiplier = 360 / charElements.length;

                        charElements.forEach(function (charElement, index) {

                            gsap.set(charElement, {
                                rotate: rotateMultiplier * index,
                                left: '50%',
                                xPercent: -50,
                                top: 0,
                                height: "50%"
                            })
                        });

                        var tl = gsap.timeline();

                        gsap.set(textWrap, {
                            width: dataHeight,
                            height: dataHeight
                        });

                        if ($this.classList.contains('counter-clockwise')) {
                            tl.to(textWrap, {
                                rotation: -360,
                                duration: dataDuration,
                                ease: "none",
                                repeat: -1
                            });
                        } else {
                            tl.to(textWrap, {
                                rotation: 360,
                                duration: dataDuration,
                                ease: "none",
                                repeat: -1
                            });
                        }

                        let whaler = Hamster(document.querySelector('body')),
                            wheelDeltaY, currentDeltaY;

                        function createWheelStopListener(element, callback, timeout) {
                            var handle = null;
                            var onScroll = function () {
                                if (handle) {
                                    clearTimeout(handle);
                                }
                                handle = setTimeout(callback, timeout || 200); // 
                            };
                            element.addEventListener('wheel', onScroll);
                            return function () {
                                element.removeEventListener('wheel', onScroll);
                            };
                        }

                        whaler.wheel(function (event, delta, deltaX, deltaY) {

                            wheelDeltaY = event.deltaY;

                            event.deltaY < 0 ? wheelDeltaY = -1 * event.deltaY : '';

                            tl.timeScale(1 + (wheelDeltaY * 2))

                        });

                        createWheelStopListener(window, function () {

                            tl.timeScale(1)

                        });

                        $this.addEventListener('click', function () {
                            window.scrollTo({
                                top: document.querySelector(dataTarget).offsetTop,
                                behavior: "smooth"
                            });
                        });


                    })

                }





            }
        });

        elementorFrontend.hooks.addAction('frontend/element_ready/pesccontrols.default', function ($scope, $) {

            setTimeout(function () {

                var jsScopeArray = $scope.toArray();

                for (var i = 0; i < jsScopeArray.length; i++) {

                    var scope = jsScopeArray[i],
                        control = scope.querySelector('.pe--sc--controls'),
                        id = control.dataset.id,
                        target = document.querySelector('.' + id),
                        items = target.querySelectorAll('.cr--item'),
                        vars = {
                            progress: '',
                            current: '',
                            total: target.dataset.total,
                            width: items[0].offsetWidth
                        };



                    if (scope.querySelector('.sc--fraction')) {


                        scope.querySelector('.sc--total').innerHTML = vars.total;
                    }

                    function getCurrentItem() {

                        let crValues = [];

                        items.forEach(item => {

                            if (item.getBoundingClientRect().x < (document.body.clientWidth * 0.75)) {

                                crValues.push(parseInt(item.dataset.cr, 10));
                            }

                        });

                        if (crValues.length > 0) {
                            let maxCrValue = Math.max(...crValues);
                            vars.current = maxCrValue;

                        }

                        scope.querySelector('.sc--current') ? scope.querySelector('.sc--current').innerHTML = vars.current : '';

                    }

                    getCurrentItem()

                    if (target.classList.contains('cr--scroll')) {

                        let tween = gsap.getById(id);

                        tween.eventCallback('onUpdate', self => {

                            vars.progress = tween.progress() * 100;


                            let crValues = [];

                            items.forEach(item => {

                                if (item.getBoundingClientRect().x < (document.body.clientWidth * 0.75)) {

                                    crValues.push(parseInt(item.dataset.cr, 10));
                                }

                            });

                            if (crValues.length > 0) {
                                let maxCrValue = Math.max(...crValues);
                                vars.current = maxCrValue;

                            }


                            if (scope.querySelector('.sc--fraction')) {

                                let current = scope.querySelector('.sc--current'),
                                    total = scope.querySelector('.sc--total');

                                current.innerHTML = vars.current;
                                total.innerHTML = vars.total;


                            }

                            if (scope.querySelector('.sc--progressbar')) {

                                let prog = scope.querySelector('.sc--prog');

                                gsap.to(prog, {
                                    width: vars.progress + '%'
                                })

                            }

                        })


                    }

                    if (target.classList.contains('cr--drag')) {

                        let draggable = Draggable.get(target);

                        if (draggable) {

                            draggable.addEventListener('drag', () => {

                                vars.progress = draggable.x / draggable.minX * 100;



                                if (scope.querySelector('.sc--fraction')) {

                                    let current = scope.querySelector('.sc--current'),
                                        total = scope.querySelector('.sc--total');

                                    getCurrentItem()

                                    current.innerHTML = vars.current;
                                    total.innerHTML = vars.total;


                                }

                                if (scope.querySelector('.sc--progressbar')) {

                                    let prog = scope.querySelector('.sc--prog');

                                    gsap.to(prog, {
                                        width: vars.progress + '%'
                                    })

                                }

                            });


                            if (scope.querySelector('.sc--navigation')) {

                                let next = scope.querySelector('.sc--next'),
                                    prev = scope.querySelector('.sc--prev'),
                                    xVal = 0;

                                next.addEventListener('click', () => {

                                    xVal = draggable.x;
                                    xVal -= vars.width;

                                    gsap.to(target, {
                                        x: xVal,
                                        onUpdate: () => {
                                            draggable.update(true);
                                        }
                                    })

                                })

                                prev.addEventListener('click', () => {

                                    xVal = draggable.x;
                                    xVal += vars.width;

                                    gsap.to(target, {
                                        x: xVal,
                                        onUpdate: () => {
                                            draggable.update(true);
                                        }
                                    })


                                })

                            }

                        }

                    }

                }

            }, 10)
        })

        elementorFrontend.hooks.addAction('frontend/element_ready/pecarousel.default', function ($scope, $) {

            var jsScopeArray = $scope.toArray();
            for (var i = 0; i < jsScopeArray.length; i++) {

                var scope = jsScopeArray[i],
                    carousel = scope.querySelector('.pe--carousel'),
                    wrapper = carousel.querySelector('.carousel--wrapper'),
                    id = carousel.dataset.id ? carousel.dataset.id : scope.dataset.id,
                    items = carousel.querySelectorAll('.carousel--item'),
                    length = items.length,
                    wrapperWidth = wrapper.offsetWidth,
                    carouselWidth = carousel.offsetWidth,
                    trigger = carousel.dataset.trigger ? carousel.dataset.trigger : '.' + carousel.classList[0];

                document.querySelector(trigger) ? document.querySelector(trigger).classList.add('pin--trigger') : '';

                items.forEach(item => {
                    var index = parseInt(item.dataset.index);
                });

                function carouselScroll() {

                    gsap.to(wrapper, {
                        x: (-1 * wrapperWidth) + carouselWidth,
                        scrollTrigger: {
                            trigger: trigger,
                            scrub: true,
                            pin: trigger,
                            ease: "elastic.out(1, 0.3)",
                            start: 'center center',
                            end: 'bottom+=' + carousel.dataset.speed + ' bottom',
                            pinSpacing: 'padding',
                            onEnter: () => isPinnng(trigger, true),
                            onEnterBack: () => isPinnng(trigger, true),
                            onLeave: () => isPinnng(trigger, false),
                            onLeaveBack: () => isPinnng(trigger, false),
                        }
                    })

                }

                function carouselDrag() {

                    Draggable.create(wrapper, {
                        type: 'x',
                        bounds: {
                            minX: 0,
                            maxX: -wrapperWidth + document.body.clientWidth - 50
                        },
                        lockAxis: true,
                        dragResistance: 0.5,
                        inertia: true,
                    });


                }

                carousel.classList.contains('cr--scroll') ? carouselScroll() : carouselDrag();

            }

        });

        elementorFrontend.hooks.addAction('frontend/element_ready/peicon.default', function ($scope, $) {


            var jsScopeArray = $scope.toArray();
            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    animated = scope.querySelectorAll('.icon--motion');

                animated.forEach((element) => {

                    let classes = element.classList,
                        hasMotion = Array.from(classes).some(className => className.startsWith('me--'));

                    // Motion Effects
                    if (hasMotion) {

                        let motion = hasMotion ? Array.from(classes).find(className => className.startsWith('me--')) : null,
                            duration = element.dataset.duration,
                            delay = element.dataset.delay,
                            ease = motion === 'me--flip-x' ? 'none' : motion === 'me--flip-y' ? 'none' : motion === 'me--hearthbeat-x' ? 'power4.inOut' : motion === 'me--slide-left' ? 'power3.in' : motion === 'me--slide-right' ? 'power3.in' : motion === 'me--slide-down' ? 'expo.in' : motion === 'me--slide-up' ? 'expo.in' : 'expo.out',
                            tl = gsap.timeline({
                                repeat: -1,
                                repeatDelay: parseInt(delay, 10)
                            }),
                            target = element.querySelector('i, svg');



                        if (motion === 'me--slide-left' || motion === 'me--slide-right') {

                            target = element.firstElementChild;
                        }

                        tl.fromTo(target, {
                            xPercent: 0,
                            yPercent: 0,
                            scale: motion === 'me--hearth-beat' ? 0.6 : 1
                        }, {

                            scale: 1,
                            rotate: motion === 'me--rotate' ? -360 : 0,
                            rotateX: motion === 'me--flip-x' ? -360 : 0,
                            rotateY: motion === 'me--flip-y' ? -360 : 0,
                            xPercent: motion === 'me--slide-left' ? -300 : motion === 'me--slide-right' ? 300 : 0,
                            yPercent: motion === 'me--slide-down' ? 200 : motion === 'me--slide-up' ? -200 : 0,
                            duration: duration,
                            ease: ease,

                        })

                        if (motion === 'me--slide-left' || motion === 'me--slide-right') {

                            tl.fromTo(target, {
                                xPercent: motion === 'me--slide-left' ? 300 : motion === 'me--slide-right' ? -300 : 0
                            }, {
                                xPercent: 0,
                                duration: duration,
                                ease: 'power3.out',
                            })
                        }

                        if (motion === 'me--slide-down' || motion === 'me--slide-up') {

                            tl.fromTo(target, {
                                yPercent: motion === 'me--slide-down' ? -200 : motion === 'me--slide-up' ? 200 : 0
                            }, {
                                yPercent: 0,
                                duration: duration,
                                ease: 'power3.out',
                            })
                        }

                        if (motion === 'me--hearth-beat') {

                            tl.to(target, {
                                scale: 0.6,
                                duration: duration
                            })
                        }

                    }

                })


            }

        });

        elementorFrontend.hooks.addAction('frontend/element_ready/pelayoutswitcher.default', function ($scope, $) {

            var jsScopeArray = $scope.toArray();
            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    switcher = scope.querySelector('.pe-layout-switcher');

                let mainColors = [
                    getComputedStyle(document.documentElement).getPropertyValue('--mainColor'),
                    getComputedStyle(document.documentElement).getPropertyValue('--mainBackground'),
                    getComputedStyle(document.documentElement).getPropertyValue('--secondaryColor'),
                    getComputedStyle(document.documentElement).getPropertyValue('--secondaryBackground'),
                ]

                let switchedColors = [
                    getComputedStyle(document.querySelector('.layout--colors')).getPropertyValue('--mainColor'),
                    getComputedStyle(document.querySelector('.layout--colors')).getPropertyValue('--mainBackground'),
                    getComputedStyle(document.querySelector('.layout--colors')).getPropertyValue('--secondaryColor'),
                    getComputedStyle(document.querySelector('.layout--colors')).getPropertyValue('--secondaryBackground'),
                ]


                switcher.addEventListener('click', () => {

                    if (document.body.classList.contains('layout--switched')) {

                        gsap.fromTo(document.body, {
                            '--mainColor': switchedColors[0],
                            '--mainBackground': switchedColors[1],
                            '--secondaryColor': switchedColors[2],
                            '--secondaryBackground': switchedColors[3],
                        }, {
                            '--mainColor': mainColors[0],
                            '--mainBackground': mainColors[1],
                            '--secondaryColor': mainColors[2],
                            '--secondaryBackground': mainColors[3],
                            duration: 1,
                            ease: 'power3.out',
                            onStart: () => {
                                document.body.classList.remove('layout--switched')
                            }
                        })

                    } else {


                        gsap.fromTo(document.body, {
                            '--mainColor': mainColors[0],
                            '--mainBackground': mainColors[1],
                            '--secondaryColor': mainColors[2],
                            '--secondaryBackground': mainColors[3],
                        }, {
                            '--mainColor': switchedColors[0],
                            '--mainBackground': switchedColors[1],
                            '--secondaryColor': switchedColors[2],
                            '--secondaryBackground': switchedColors[3],
                            duration: 1,
                            ease: 'power3.out',
                            onStart: () => {
                                document.body.classList.add('layout--switched')
                            }
                        })

                    }

                })



            }

        });

        elementorFrontend.hooks.addAction('frontend/element_ready/peteammember.default', function ($scope, $) {

            var jsScopeArray = $scope.toArray();
            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    member = scope.querySelector('.pe--team--member'),
                    toggle = scope.querySelector('.team--member--toggle');

                toggle.addEventListener('click', () => {

                    member.classList.toggle('active');

                })


            }

        })


        elementorFrontend.hooks.addAction('frontend/element_ready/peclients.default', function ($scope, $) {

            var jsScopeArray = $scope.toArray();
            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    clients = scope.querySelector('.pe--clients');

                if (clients.classList.contains('pe--clients--carousel')) {

                    let wrapper = clients.querySelector('.pe--clients--wrapper'),
                        wrapperWidth = wrapper.offsetWidth,
                        duration = 1,
                        windowWidth = document.body.clientWidth,
                        items = wrapper.querySelectorAll('.pe-client');

                    if (items.length > 0) {

                        var tl = gsap.timeline({
                            repeat: -1,
                        });

                        items.forEach(item => {

                            let clone = item.cloneNode(true);
                            wrapper.appendChild(clone);

                        })

                        wrapper.style.width = wrapperWidth * 2


                        let gap = window.getComputedStyle(wrapper).getPropertyValue('gap');


                        tl.to(wrapper, {
                            x: -wrapperWidth - parseFloat(gap),
                            duration: 35,
                            ease: 'none',

                        });

                    }

                    wrapper.addEventListener('mouseenter', () => {
                        tl.pause();
                    })

                    wrapper.addEventListener('mouseleave', () => {
                        tl.play();
                    })
                }

            }


        });

        elementorFrontend.hooks.addAction('frontend/element_ready/peaccordion.default', function ($scope, $) {

            var jsScopeArray = $scope.toArray();
            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    accordion = scope.querySelector('.pe--accordion'),
                    wrapper = accordion.querySelector('.pe--accordion--wrapper'),
                    items = wrapper.querySelectorAll('.pe-accordion-item');

                items.forEach(item => {

                    let title = item.querySelector('.pe-accordion-item-title'),
                        content = item.querySelector('.pe-accordion-item-content');

                    title.addEventListener('click', () => {

                        if (item.classList.contains('accordion--active')) {

                            var contentState = Flip.getState(content);
                            item.classList.remove('accordion--active');

                            Flip.from(contentState, {
                                duration: .75,
                                ease: 'expo.inOut',
                                absolute: false,
                                absoluteOnLeave: false,
                            })


                        } else {


                            if (!accordion.classList.contains('open--multiple')) {

                                var currentActive = accordion.querySelector('.accordion--active');

                                if (currentActive) {

                                    let currentContentState = Flip.getState(currentActive.querySelector('.pe-accordion-item-content'));

                                    currentActive.classList.remove('accordion--active');

                                    Flip.from(currentContentState, {
                                        duration: .75,
                                        ease: 'expo.inOut',
                                        absolute: false,
                                        absoluteOnLeave: false,
                                    })

                                }
                            }
                            //Open

                            var contentState = Flip.getState(content);
                            item.classList.add('accordion--active');

                            Flip.from(contentState, {
                                duration: .75,
                                ease: 'expo.inOut',
                                absolute: false,
                                absoluteOnLeave: false,
                            })

                        }


                    })

                })

            }

        });

        elementorFrontend.hooks.addAction('frontend/element_ready/pesingleimage.default', function ($scope, $) {
            var jsScopeArray = $scope.toArray();
            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    image = scope.querySelector('.single-image');


                imagesLoaded(image, function (instance) {

                    if (image.classList.contains('zoomed--image')) {

                        var before = image.querySelector('.zoomed--before'),
                            center = image.querySelector('.zoomed--center'),
                            after = image.querySelector('.zoomed--after'),
                            centerWidth = center.getBoundingClientRect().width,
                            centerHeight = center.getBoundingClientRect().height;


                        let hold = document.createElement('div');

                        image.insertBefore(hold, after);

                        center.classList.add('zoomed');

                        let tl = gsap.timeline({
                            scrollTrigger: {
                                trigger: scope,
                                start: 'top bottom',
                                end: 'center center',
                                scrub: true
                            }
                        });

                        tl.fromTo(image, {
                            xPercent: -100,

                        }, {
                            xPercent: 0,
                            duration: 20,
                            ease: 'none'
                        }, 0)

                        gsap.to(center, {
                            width: '100%',
                            height: '100%',
                            scrollTrigger: {
                                trigger: scope,
                                scrub: true,
                                pin: scope,
                                start: 'center center',
                                pinSpacing: 'margin'

                            }
                        })

                    }

                    if (image.classList.contains('parallax--image')) {

                        let img = image.querySelectorAll('img');

                        for (var i = 0; i < img.length; i++) {

                            gsap.set(img[i], {
                                scale: 1.2
                            })

                            gsap.fromTo(img[i], {
                                yPercent: -10
                            }, {
                                yPercent: 10,
                                ease: 'none',
                                scrollTrigger: {
                                    trigger: image,
                                    scrub: true,
                                    start: 'top bottom',
                                    end: 'bottom top'
                                }
                            })


                        }




                    }

                });

            }


        });

        elementorFrontend.hooks.addAction('frontend/element_ready/pemarquee.default', function ($scope, $) {

            var jsScopeArray = $scope.toArray();
            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    marquee = scope.querySelectorAll('.pe-marquee');

                marquee.forEach(function (marqueeElement) {


                    var text = marqueeElement.children,
                        dataDuration = marqueeElement.getAttribute('data-duration'),
                        separator = marqueeElement.getAttribute('data-seperator');
                    var wrapperElement = document.createElement("div");
                    wrapperElement.className = "marquee-wrap";

                    while (marqueeElement.firstChild) {
                        wrapperElement.appendChild(marqueeElement.firstChild);
                    }
                    marqueeElement.appendChild(wrapperElement);

                    var infItem = marqueeElement.querySelector('.marquee-wrap');

                    var infWidth = infItem.offsetWidth;

                    if (infWidth > 0) {

                        var infLength = window.innerWidth / infWidth,
                            gap = infItem.getBoundingClientRect().left;
                        if (marqueeElement.classList.contains('icon_font')) {
                            var separators = infItem.querySelectorAll('.seperator');
                            separators.forEach(function (separator) {
                                separator.style.fontSize = window.getComputedStyle(separator.parentNode).getPropertyValue('font-size');
                            });
                        }

                        function infinityOnResize() {
                            for (var i = 2; i < infLength + 2; i++) {
                                var clonedItem = infItem.cloneNode(true);
                                marqueeElement.appendChild(clonedItem);
                            }
                            var infItemLength = marqueeElement.querySelectorAll('.marquee-wrap').length;
                            infWidth = parseInt(infWidth);
                            infItem.style.width = infWidth + 'px';
                            marqueeElement.style.width = (infItemLength * infItem.offsetWidth) + 'px';
                            marqueeElement.style.display = 'flex';

                            var tl = gsap.timeline({
                                repeat: -1
                            });
                            var tl2 = gsap.timeline({
                                repeat: -1
                            });

                            if (marqueeElement.classList.contains('left-to-right')) {
                                tl.fromTo(marqueeElement, {
                                    x: -1 * (infWidth + gap)
                                }, {
                                    x: -1 * gap,
                                    ease: 'none',
                                    duration: infWidth / 1000 * dataDuration
                                });
                            } else {
                                tl.fromTo(marqueeElement, {
                                    x: -1 * gap
                                }, {
                                    x: -1 * (infWidth + gap),
                                    ease: 'none',
                                    duration: infWidth / 1000 * dataDuration
                                });
                            }

                            if (marqueeElement.classList.contains('rotating_seperator')) {
                                var sepDuration = marqueeElement.getAttribute('data-sepduration');
                                var rotateValue = marqueeElement.classList.contains('counter-clockwise') ? -360 : 360;
                                tl2.fromTo(marqueeElement.querySelectorAll('.seperator'), {
                                    rotate: 0
                                }, {
                                    rotate: rotateValue,
                                    duration: sepDuration,
                                    ease: 'none'
                                });
                            }
                        }

                        infinityOnResize();
                    }
                });
            }

        });
        elementorFrontend.hooks.addAction('frontend/element_ready/peblogposts.default', function ($scope, $) {

            var jsScopeArray = $scope.toArray();
            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    grid = scope.querySelector('.pe--posts--grid'),
                    wrapper = scope.querySelector('.grid--posts--wrapper'),
                    posts = wrapper.querySelectorAll('.grid--post--item'),
                    filters = grid.querySelector('.grid--filters');

                if (filters) {

                    let filter = filters.querySelectorAll('.post-filter'),
                        ul = filters.querySelector('.filters-list');

                    filter.forEach(filter => {

                        filter.addEventListener('click', () => {

                            filters.querySelector('.active').classList.remove('active');
                            filter.classList.add('active');


                            gsap.to(ul, {
                                '--activeLeft': filter.offsetLeft + 'px',
                                '--activeWidth': filter.offsetWidth + 'px',
                                duration: .5,
                                ease: 'expo.out'
                            })

                            let cat = filter.dataset.category,
                                findPosts = 'cat_' + cat;

                            let state = Flip.getState(posts);

                            posts.forEach(post => {

                                if (cat !== 'all') {

                                    post.classList.contains(findPosts) ? post.style.display = 'block' : post.style.display = 'none';

                                } else {

                                    post.style.display = 'block'
                                }

                            })

                            Flip.from(state, {
                                duration: 1,
                                absolute: false,
                                absoluteOnLeave: false,
                                ease: "expo.inOut",
                                onEnter: elements => gsap.fromTo(elements, {
                                    opacity: 0,
                                    xPercent: 100
                                }, {
                                    opacity: 1,
                                    xPercent: 0
                                }),
                                onLeave: elements => gsap.fromTo(elements, {
                                    opacity: 1,
                                    xPercent: 0
                                }, {
                                    opacity: 0,
                                    xPercent: -100,
                                    stagger: 0.1
                                }),
                            })

                        })

                    })

                }

                if (grid.querySelector('.pe-load-more')) {

                    let button = grid.querySelector('.pe-load-more'),
                        currentWrapper = wrapper,
                        count = grid.dataset.total,
                        link = button.querySelector('a');

                    link.addEventListener('click', (e) => {

                        let apiUrl = link.getAttribute("href");
                        e.preventDefault();

                        button.classList.add('plm--loading');
                        document.documentElement.classList.add('loading');

                        var xhr = new XMLHttpRequest();
                        xhr.open('GET', apiUrl);
                        xhr.onreadystatechange = function () {

                            if (xhr.readyState === XMLHttpRequest.DONE) {

                                if (xhr.status === 200) {

                                    var response = xhr.responseText;

                                    setTimeout(function () {
                                        var parser = new DOMParser(),
                                            htmlDoc = parser.parseFromString(response, 'text/html'),
                                            newPosts = htmlDoc.querySelectorAll('.pe--posts--grid .grid--post--item'),
                                            newUrl = htmlDoc.querySelector('.pe-load-more a').getAttribute('href');

                                        link.setAttribute("href", newUrl);

                                        if (newPosts.length > 0) {

                                            let tl = gsap.timeline({
                                                onComplete: () => {
                                                    ScrollTrigger.refresh()

                                                }
                                            });

                                            newPosts.forEach(function (post, i) {

                                                let clone = post.cloneNode(true)
                                                currentWrapper.appendChild(clone);

                                                tl.fromTo(clone, {
                                                    opacity: 0,
                                                    yPercent: 100
                                                }, {
                                                    opacity: 1,
                                                    yPercent: 0,
                                                    duration: .75,
                                                    ease: 'expo.out'
                                                }, i * 0.15)

                                            });




                                            if (grid.querySelectorAll('.grid--post--item').length >= count) {
                                                button.classList.add('plm--disabled');
                                            }

                                            button.classList.remove('plm--loading');
                                            document.documentElement.classList.remove('loading');
                                        }

                                    }, 200);
                                } else {
                                    console.error('Request failed. Status: ' + xhr.status);
                                }
                            }
                        };
                        xhr.send();

                    })

                }

            }

        });


        elementorFrontend.hooks.addAction('frontend/element_ready/projectmedia.default', function ($scope, $) {
            var jsScopeArray = $scope.toArray();
            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    gallery = scope.querySelector('.project--image--gallery');

                if (gallery) {

                    let wrapper = gallery.querySelector('.project--image--gallery--wrapper'),
                        images = wrapper.querySelectorAll('.project--gallery--image'),
                        gap = parseInt(window.getComputedStyle(wrapper).getPropertyValue('gap')),
                        val = wrapper.getBoundingClientRect().left + (wrapper.offsetWidth - document.body.clientWidth) + gap,
                        id = wrapper.dataset.id,
                        trigger = gallery.dataset.trigger ? gallery.dataset.trigger : scope,
                        speed = gallery.dataset.speed,
                        integrated = gallery.dataset.integrated;

                    wrapper.classList.add(id);

                    if (scope.classList.contains('cr__scroll')) {

                        wrapper.classList.add('cr__scroll');

                        let crScroll = gsap.to(wrapper, {
                            id: id,
                            x: -val,
                            ease: "sine.inOut",
                            scrollTrigger: {
                                trigger: trigger,
                                pin: trigger,
                                pinSpacing: 'margin',
                                scrub: true,
                                start: 'top top',
                                end: 'bottom+=' + speed + ' top',
                                onEnter: () => isPinnng(trigger, true),
                                onEnterBack: () => isPinnng(trigger, true),
                                onLeave: () => isPinnng(trigger, false),
                                onLeaveBack: () => isPinnng(trigger, false),
                                onUpdate: self => {

                                    if (integrated && !mobileQuery.matches) {

                                        gsap.to(integrated, {
                                            opacity: 1 - (self.progress * 5)
                                        })
                                    }
                                }
                            }
                        })

                        matchMedia.add({
                            isPhone: "(max-width: 550px)"

                        }, (context) => {

                            crScroll.kill();

                            Draggable.create(wrapper, {
                                type: 'x',
                                dragResistance: 0.35,
                                inertia: true,
                                bounds: {
                                    minX: 0,
                                    maxX: -val
                                },
                            })

                        });

                    }

                    if (scope.classList.contains('cr__drag')) {

                        wrapper.classList.add('cr__drag');

                        let drag = Draggable.create(wrapper, {
                            id: id,
                            type: 'x',
                            dragResistance: 0.35,
                            inertia: true,
                            bounds: {
                                minX: 0,
                                maxX: -val
                            },
                            onThrowUpdate: () => {
                                let prog = drag[0].x / drag[0].minX;

                                if (integrated) {

                                    gsap.to(integrated, {
                                        opacity: 1 - (prog * 5)
                                    })
                                }

                            },
                            onMove: () => {

                                let prog = drag[0].x / drag[0].minX;

                                if (integrated) {

                                    gsap.to(integrated, {
                                        opacity: 1 - (prog * 5)
                                    })
                                }


                            },
                            lockAxis: true,
                            dragResistance: 0.5,
                            inertia: true,
                        });

                    }

                }



            }

        });

        elementorFrontend.hooks.addAction('frontend/element_ready/peportfolio.default', function ($scope, $) {

            var jsScopeArray = $scope.toArray();
            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    filters = scope.querySelector('.portfolio--filters'),
                    id = scope.dataset.id,
                    wrapper = scope.querySelector('.portfolio--projects--wrapper'),
                    url = scope.querySelector('input[name="url"]').value,
                    catdata = scope.querySelector('input[name="cat"]'),
                    portfolio = scope.querySelector('.pe--portfolio'),
                    pagination = scope.querySelector('.portfolio--pagination'),
                    switcher = scope.querySelector('.ps--switch'),
                    projects = scope.querySelectorAll('.portfolio--project'),
                    peSwitcher = scope.querySelector('.pe--switcher'),
                    swStyles = window.getComputedStyle(peSwitcher),
                    swPad = swStyles.getPropertyValue('padding');


                if (switcher) {

                    let switchGrid = switcher.querySelector('.ps--grid'),
                        switchList = switcher.querySelector('.ps--list'),
                        follower = switcher.querySelector('.ps--follower'),
                        sgWidth = switchGrid.offsetWidth,
                        slWidth = switchList.offsetWidth,
                        sgLeft = switchGrid.getBoundingClientRect().left,
                        slLeft = switchList.getBoundingClientRect().left,
                        switcherLeft = switcher.getBoundingClientRect().left,
                        psItem = switcher.querySelectorAll('.ps--item');



                    if (portfolio.classList.contains('portfolio--list')) {

                        switchGrid.classList.remove('active')
                        switchList.classList.add('active')


                        follower.style.width = slWidth + 'px'
                        follower.style.left = slLeft - switcherLeft + parseInt(swPad) + 'px'

                    } else {

                        switchGrid.classList.add('active')
                        switchList.classList.remove('active')

                        follower.style.width = sgWidth + 'px'
                        follower.style.left = sgLeft - switcherLeft + 'px'

                    }

                    psItem.forEach(function ($swItem) {

                        $swItem.addEventListener('click', function () {

                            if (this.classList.contains('ps--grid')) {

                                gsap.to(follower, {
                                    width: sgWidth,
                                    left: sgLeft - switcherLeft + parseInt(swPad)
                                })
                            } else {

                                gsap.to(follower, {
                                    width: slWidth,
                                    left: slLeft - switcherLeft + parseInt(swPad)
                                })
                            }

                            let tl = gsap.timeline();

                            tl.to(wrapper, {
                                opacity: 0,
                                duration: .5,
                                onComplete: () => {

                                    if (portfolio.classList.contains('portfolio--list')) {

                                        portfolio.classList.remove('portfolio--list')
                                        portfolio.classList.add('portfolio--grid');

                                        switchGrid.classList.add('active')
                                        switchList.classList.remove('active')


                                    } else {
                                        portfolio.classList.remove('portfolio--grid')
                                        portfolio.classList.add('portfolio--list')

                                        switchGrid.classList.remove('active')
                                        switchList.classList.add('active')
                                    }
                                }
                            })

                            tl.to(wrapper, {
                                opacity: 1,
                                duration: .5
                            })

                        })
                    })

  
                }

                if (filters) {

                    let trigger = filters.querySelector('.filter--active'),
                        cats = filters.querySelectorAll('.filter--cat');

                    trigger.addEventListener('click', () => {

                        filters.classList.toggle('filt--active');


                    })

                    cats.forEach(cat => {

                        cat.addEventListener('click', (e) => {

                            scope.querySelector('.filter--cat.active').classList.remove('active');
                            cat.classList.add('active');

                            var apiUrl = cat.dataset.id ? url + '?cat=' + cat.dataset.id : url;

                            e.preventDefault();

                            document.documentElement.classList.add('loading');

                            var xhr = new XMLHttpRequest();
                            xhr.open('GET', apiUrl);
                            xhr.onreadystatechange = function () {

                                if (xhr.readyState === XMLHttpRequest.DONE) {

                                    if (xhr.status === 200) {

                                        var response = xhr.responseText;

                                        setTimeout(function () {

                                            let items = wrapper.querySelectorAll('.portfolio--project'),
                                                state = Flip.getState(items);

                                            items.forEach(item => item.classList.add('hidden'))

                                            Flip.from(state, {
                                                duration: 1,
                                                ease: "power3.inOut",
                                                fade: true,
                                                absolute: false,
                                                absoluteOnLeave: false,
                                                onComplete: () => {
                                                    items.forEach(item => item.remove())

                                                },
                                                onLeave: elements => gsap.fromTo(elements, {
                                                    opacity: 1,
                                                    y: 0
                                                }, {
                                                    opacity: 0,
                                                    y: -50,
                                                }),
                                            });

                                            var parser = new DOMParser(),
                                                htmlDoc = parser.parseFromString(response, 'text/html'),
                                                newElement = htmlDoc.querySelector('.elementor-element-' + id),
                                                newPosts = newElement.querySelectorAll('.portfolio--project');


                                            if (newPosts.length > 0) {
                                                portfolio.setAttribute('data-max-pages', newElement.querySelector('.pe--portfolio').dataset.maxPages)


                                                let tl = gsap.timeline({
                                                    onComplete: () => {
                                                        ScrollTrigger.refresh()

                                                    }
                                                });

                                                newPosts.forEach(function (post, i) {

                                                    let clone = post.cloneNode(true)
                                                    wrapper.appendChild(clone);

                                                    tl.fromTo(clone, {
                                                        opacity: 0,
                                                        yPercent: 100
                                                    }, {
                                                        opacity: 1,
                                                        yPercent: 0,
                                                        duration: .75,
                                                        ease: 'expo.out'
                                                    }, i * 0.15)

                                                });


                                                cat.dataset.id ? trigger.classList.add('filtered') : trigger.classList.remove('filtered');
                                                cat.dataset.id ? portfolio.classList.add('filtered') : portfolio.classList.remove('filtered');
                                                filters.classList.remove('filt--active');
                                                trigger.innerHTML = cat.innerHTML;
                                                trigger.setAttribute('data-length', cat.dataset.length)
                                                document.documentElement.classList.remove('loading');
                                                catdata.value = cat.dataset.id;
                                            }

                                        }, 200);
                                    } else {
                                        console.error('Request failed. Status: ' + xhr.status);
                                    }
                                }
                            };
                            xhr.send();

                        })


                    })

                }

                if (pagination) {

                    let loadMore = pagination.querySelector('a'),
                        clicks = 0;

                    if (loadMore) {

                        loadMore.addEventListener('click', (e) => {

                            pagination.classList.add('loading');

                            clicks++
                            var apiUrl = catdata.value ? url + '?offset=' + clicks + '&cat=' + catdata.value : url + '?offset=' + clicks;

                            e.preventDefault();


                            document.documentElement.classList.add('loading');
                            pagination.classList.add('loading');

                            var xhr = new XMLHttpRequest();
                            xhr.open('GET', apiUrl);
                            xhr.onreadystatechange = function () {

                                if (xhr.readyState === XMLHttpRequest.DONE) {

                                    if (xhr.status === 200) {

                                        var response = xhr.responseText;

                                        setTimeout(function () {

                                            var parser = new DOMParser(),
                                                htmlDoc = parser.parseFromString(response, 'text/html'),
                                                newElement = htmlDoc.querySelector('.elementor-element-' + id),
                                                newPosts = newElement.querySelectorAll('.portfolio--project');


                                            if (newPosts.length > 0) {

                                                let tl = gsap.timeline({
                                                    onComplete: () => {
                                                        ScrollTrigger.refresh()

                                                    }
                                                });

                                                newPosts.forEach(function (post, i) {

                                                    let clone = post.cloneNode(true)
                                                    wrapper.appendChild(clone);

                                                    tl.fromTo(clone, {
                                                        opacity: 0,
                                                        yPercent: 100
                                                    }, {
                                                        opacity: 1,
                                                        yPercent: 0,
                                                        duration: .75,
                                                        ease: 'expo.out',
                                                        onComplete: () => {
                                                            pagination.classList.remove('loading');

                                                            if (clone.querySelector('.pe-video')) {

                                                                let videos = clone.querySelectorAll('.pe-video')

                                                                for (var i = 0; i < videos.length; i++) {
                                                                    new peVideoPlayer(videos[i]);
                                                                }

                                                            }

                                                        }
                                                    }, i * 0.15)

                                                });

                                                if (portfolio.dataset.maxPages == clicks + 1) {

                                                    pagination.classList.add('hidden');
                                                }

                                                document.documentElement.classList.remove('loading');

                                            }

                                        }, 200);
                                    } else {
                                        console.error('Request failed. Status: ' + xhr.status);
                                    }
                                }
                            };
                            xhr.send();

                        })

                    }

                }




            }

        });



        elementorFrontend.hooks.addAction('frontend/element_ready/peinfinitecards.default', function ($scope, $) {
            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i];
                var infinityCards = scope.querySelectorAll('.leksa-infinity-cards');

                infinityCards.forEach(function ($this) {
                    let project = $this.querySelectorAll('.showcase-project'),
                        projectHeight = project[0].offsetHeight,
                        projectWidth = project[0].offsetWidth,
                        style = window.getComputedStyle(project[0]),
                        switchInfinite = $this.querySelector('.switch-infinite'),
                        switchCollapse = $this.querySelector('.switch-collapse'),
                        switchItem = $this.querySelectorAll('.switch-item'),
                        switchBg = $this.querySelector('.switch-bg'),
                        duration = $this.getAttribute('data-duration'),
                        verticalClass = $this.getAttribute('data-vertical-class'),
                        horizontalClass = $this.getAttribute('data-horizontal-class');



                    projectHeight += parseInt(style.marginBottom) + parseInt(style.marginTop);
                    projectWidth += parseInt(style.marginLeft) + parseInt(style.marginRight);

                    if (project.length % 2 === 1) {
                        project.forEach(function (items, e) {

                            if (e === parseInt(project.length / 2)) {
                                let clonedProject = items.cloneNode(true);
                                $this.querySelector('.lic-wrapper').appendChild(clonedProject)
                            }

                        })
                    }
                    project = $this.querySelectorAll('.showcase-project')

                    const clonedItems = [];
                    project.forEach(function (item) {
                        let clonedItem = item.cloneNode(true);
                        clonedItems.push(clonedItem);


                    });
                    const licWrapper = $this.querySelector('.lic-wrapper');
                    clonedItems.forEach(function (clonedItem) {
                        clonedItem.classList.add('cloned_item');
                        clonedItem.classList.remove('inner--anim');

                        licWrapper.appendChild(clonedItem);
                    });

                    project = $this.querySelectorAll('.showcase-project')

                    let length = project.length,
                        infinityStyle = window.getComputedStyle($this.querySelector('.lic-switcher')),
                        bgInfLeft = parseInt(infinityStyle.paddingLeft),
                        bgColLeft = bgInfLeft + switchInfinite.offsetWidth;

                    if ($this.classList.contains('style-infinity')) {

                        switchInfinite.classList.add('active');
                        switchBg.style.width = switchInfinite.offsetWidth + 'px';
                        switchBg.style.left = bgInfLeft + 'px';
                        gsap.set(document.querySelector(horizontalClass), {
                            opacity: 0
                        })

                    } else if ($this.classList.contains('style-collapse')) {

                        switchCollapse.classList.add('active');
                        switchBg.style.width = switchCollapse.offsetWidth + 'px';
                        switchBg.style.left = bgColLeft + 'px';
                        gsap.set(document.querySelector(verticalClass), {
                            opacity: 0
                        })

                    }

                    project = $this.querySelectorAll('.showcase-project');
                    length = project.length;

                    project.forEach(function (item, i) {
                        item.setAttribute('data-col-top', ($this.offsetHeight / 2) - (projectHeight / 2) + 'px');
                        item.setAttribute('data-col-left', projectWidth * i + 'px');

                        if (i % 2 === 0) {
                            item.classList.add('odd_item');
                            item.setAttribute('data-inf-left', $this.offsetWidth - projectWidth + 'px');
                            item.setAttribute('data-inf-top', projectHeight * (i / 2) + 'px');
                        } else {
                            item.classList.add('even_item');
                            item.setAttribute('data-inf-left', $this.offsetWidth - (projectWidth * 2) + 'px');
                            item.setAttribute('data-inf-top', projectHeight * ((i - 1) / 2) + 'px');
                        }

                        if ($this.classList.contains('style-infinity')) {
                            item.style.top = item.getAttribute('data-inf-top');
                            item.style.left = item.getAttribute('data-inf-left');
                        } else if ($this.classList.contains('style-collapse')) {
                            item.style.top = item.getAttribute('data-col-top');
                            item.style.left = item.getAttribute('data-col-left');
                        }
                    });

                    let infProgLeft = 0,
                        infProgRight = 0,
                        colProg = 0;

                    matchMedia.add({
                        isDesktop: "(min-width: 571px)"
                    }, (context) => {
                        let {
                            isDesktop
                        } = context.conditions;
                        let tl = gsap.timeline({
                            ease: 'none',
                            scrollTrigger: {
                                trigger: $this,
                                start: 'top top',
                                end: $this.getAttribute('data-speed'),
                                scrub: true,
                                pin: true,
                                onUpdate: (self) => {
                                    infProgLeft = self.progress * $this.querySelectorAll('.even_item').length * projectHeight / -2;
                                    infProgRight = ($this.querySelectorAll('.odd_item').length * projectHeight / 2) - (self.progress * $this.querySelectorAll('.odd_item').length * projectHeight / 2);
                                    colProg = self.progress * (projectWidth * length / 2) * -1;

                                    if ($this.classList.contains('style-infinity')) {
                                        gsap.set($this.querySelectorAll('.even_item'), {
                                            y: infProgLeft
                                        });
                                        gsap.set($this.querySelectorAll('.odd_item'), {
                                            y: infProgRight * -1
                                        });
                                    } else if ($this.classList.contains('style-collapse')) {
                                        gsap.set(project, {
                                            x: colProg
                                        });
                                    }
                                },
                            }
                        });

                        if (leksaLenis) {

                            leksaLenis.options.infinite = true;

                            barba.hooks.before(() => {
                                leksaLenis.options.infinite = false;
                            });

                        } else {

                            const lenis = new Lenis({
                                smooth: true,
                                infinite: true,
                                smoothTouch: true
                            });

                            function raf(time) {
                                lenis.raf(time);
                                requestAnimationFrame(raf);
                            }
                            requestAnimationFrame(raf);

                            barba.hooks.before(() => {
                                lenis.destroy();
                            });

                        }

                    })




                    switchItem.forEach(function (switcher) {
                        switcher.addEventListener('click', function () {
                            if (!this.classList.contains('active')) {
                                if (this.classList.contains('switch-infinite')) {
                                    switchCollapse.classList.remove('active');
                                    switchInfinite.classList.add('active');

                                    gsap.to(document.querySelector(horizontalClass), {
                                        opacity: 0
                                    })
                                    gsap.to(document.querySelector(verticalClass), {
                                        opacity: 1,
                                        delay: 1
                                    })

                                    project.forEach(function (item) {
                                        gsap.to(item, {
                                            top: item.getAttribute('data-inf-top'),
                                            left: item.getAttribute('data-inf-left'),
                                            ease: 'power3.out',
                                            duration: duration,
                                            x: 0,
                                            onStart: () => {
                                                document.body.style.overflow = 'auto';
                                            },
                                            onComplete: () => {
                                                $this.classList.remove('style-collapse');
                                                $this.classList.add('style-infinity');
                                                document.body.style.overflow = 'visible';
                                            }
                                        });

                                        if (item.classList.contains('even_item')) {
                                            gsap.to(item, {
                                                y: infProgLeft,
                                                duration: duration,
                                                ease: 'power3.out'
                                            });
                                        } else if (item.classList.contains('odd_item')) {
                                            gsap.to(item, {
                                                y: infProgRight * -1,
                                                duration: duration,
                                                ease: 'power3.out'
                                            });
                                        }

                                        gsap.to(switchBg, {
                                            width: switchInfinite.offsetWidth,
                                            left: bgInfLeft,
                                            duration: duration,
                                            ease: 'power3.out'
                                        });

                                    });
                                } else if (this.classList.contains('switch-collapse')) {
                                    switchCollapse.classList.add('active');
                                    switchInfinite.classList.remove('active');

                                    gsap.to(document.querySelector(horizontalClass), {
                                        opacity: 1,
                                        delay: 1
                                    })
                                    gsap.to(document.querySelector(verticalClass), {
                                        opacity: 0
                                    })


                                    project.forEach(function (item) {
                                        gsap.to(item, {
                                            top: item.getAttribute('data-col-top'),
                                            left: item.getAttribute('data-col-left'),
                                            ease: 'power3.out',
                                            duration: duration,
                                            y: 0,
                                            x: colProg,
                                            onStart: () => {
                                                document.body.style.overflow = 'hidden';
                                            },
                                            onComplete: () => {
                                                $this.classList.remove('style-infinity');
                                                $this.classList.add('style-collapse');
                                                document.body.style.overflow = 'visible';
                                            }
                                        });
                                    });

                                    gsap.to(switchBg, {
                                        width: switchCollapse.offsetWidth,
                                        left: bgColLeft,
                                        duration: duration,
                                        ease: 'power3.out'
                                    });
                                }
                            }
                        });
                    });

                    window.onresize = function () {

                        if (window.innerWidth < 570) {

                            if ($this.classList.contains('style-infinity')) {
                                $this.classList.remove('style-infinity')

                                $this.classList.add('style-collapse')
                                $this.classList.add('return-infinity')

                                project.forEach(function (item) {
                                    gsap.set(item, {
                                        top: item.getAttribute('data-col-top'),
                                        left: item.getAttribute('data-col-left'),
                                        ease: 'power3.out',
                                        y: 0,
                                        x: colProg,
                                    });
                                });
                            }

                        } else {

                            if ($this.classList.contains('return-infinity')) {

                                $this.classList.remove('return-infinity')
                                $this.classList.add('style-infinity')
                                $this.classList.remove('style-collapse')

                                project.forEach(function (item) {
                                    gsap.set(item, {
                                        top: item.getAttribute('data-inf-top'),
                                        left: item.getAttribute('data-inf-left'),
                                        x: 0,
                                    });

                                    gsap.to(item, {
                                        y: infProgLeft,
                                    });

                                    if (item.classList.contains('even_item')) {
                                        gsap.to(item, {
                                            y: infProgLeft,
                                        });
                                    } else if (item.classList.contains('odd_item')) {
                                        gsap.to(item, {
                                            y: infProgRight * -1,
                                        });
                                    }
                                });


                            }

                        }
                    }

                    matchMedia.add({
                        isMobile: "(max-width: 570px)"

                    }, (context) => {

                        let {
                            isMobile
                        } = context.conditions;

                        gsap.set($this.querySelectorAll('.lic-wrapper'), {
                            width: projectWidth * $this.querySelectorAll('.showcase-project').length
                        })

                        function inf(xPosition) {
                            if (xPosition > 0) {
                                xPosition = xPosition - (projectWidth * (length - $this.querySelectorAll('.cloned_item').length))
                                gsap.set($this.querySelectorAll('.lic-wrapper'), {
                                    x: xPosition
                                })
                            } else if (xPosition < -1 * projectWidth * (length - $this.querySelectorAll('.cloned_item').length)) {
                                xPosition = xPosition + (projectWidth * (length - $this.querySelectorAll('.cloned_item').length))
                                gsap.set($this.querySelectorAll('.lic-wrapper'), {
                                    x: xPosition
                                })
                            }

                        }

                        let drag = Draggable.create($this.querySelectorAll('.lic-wrapper'), {
                            type: 'x',
                            inertia: true,
                            bounds: {
                                maxX: 0,
                                minX: (-1 * $this.querySelector('.lic-wrapper').offsetWidth) + document.body.clientWidth
                            }
                            // onThrowUpdate: () => {
                            //     inf(this.x)
                            // },
                            // onDragEnd: function () {
                            //     inf(this.x)
                            // },
                        })

                        $this.classList.remove('style-infinity')

                        $this.classList.add('style-collapse')
                        $this.classList.add('return-infinity')

                        project.forEach(function (item) {
                            gsap.set(item, {
                                top: item.getAttribute('data-col-top'),
                                left: item.getAttribute('data-col-left'),
                                ease: 'power3.out',
                                y: 0,
                                x: colProg,
                            });
                        });


                    });

                });
            }
        });

        elementorFrontend.hooks.addAction('frontend/element_ready/peshowcaserotate.default', function ($scope, $) {
            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i];
                var showcaseRotate = scope.querySelectorAll('.leksa-showcase-rotate');

                showcaseRotate.forEach(function ($this) {
                    let wrap = $this.querySelector('.lsc-wrapper'),
                        project = $this.querySelectorAll('.showcase-project'),
                        rotate = 360 / project.length,
                        styleScroll = $this.querySelector('.style-scroll'),
                        styleExplore = $this.querySelector('.style-explore'),
                        switchBg = $this.querySelector('.switch-bg'),
                        computedStyle = window.getComputedStyle($this.querySelector('.lsc-switcher')),
                        paddingLeft = parseInt(computedStyle.paddingLeft);

                    gsap.set(switchBg, {
                        width: styleScroll.offsetWidth,
                    })


                    var wheeler = Hamster(document.querySelector('.leksa-showcase-rotate')),
                        rotation = 0,
                        direction;

                    matchMedia.add({
                        isPhone: "(max-width: 550px)"

                    }, (context) => {

                        $this.classList.remove('style-scroll')
                        $this.classList.add('style-explore')

                        gsap.to($this.querySelector('.project-meta'), {
                            y: '-40%',
                            delay: 2
                        })


                    });


                        var wheeler = Hamster(document.querySelector('.leksa-showcase-rotate')),
    rotation = 0,
    direction,
    startY = 0,
    isTouch = false;

wheeler.wheel(function (event, delta, deltaX, deltaY) {
    handleRotation(deltaY);
});

wheeler.element.addEventListener("touchstart", function (event) {
    isTouch = true;
    startY = event.touches[0].clientY;
});

wheeler.element.addEventListener("touchmove", function (event) {
    if (!isTouch) return;

    let touchY = event.touches[0].clientY;
    let deltaY = (startY - touchY) * 2; 
    handleRotation(deltaY);10

    startY = touchY;
});

function handleRotation(deltaY) {
    direction = deltaY;

	
	matchMedia.add({
                        isDesktop: "(min-width: 551px)"

                    }, (context) => {

                        	if (window.navigator.platform === 'MacIntel') {
		rotation = rotation + (deltaY / $this.dataset.rotateSpeed);	
	} else {
		rotation = rotation + ((deltaY / $this.dataset.rotateSpeed) * 250);		
	}



                    });
	
	
	matchMedia.add({
                        isPhone: "(max-width: 550px)"

                    }, (context) => {

                        
rotation = rotation + (deltaY / $this.dataset.rotateSpeed);	

                    });
	
	



    if (rotation > 360) {
        rotation = rotation - 360;
    } else if (rotation < 0) {
        rotation = rotation + 360;
    }

    gsap.set(wrap, {
        rotate: rotation
    });

    project.forEach(function (item) {
        if ($this.classList.contains('style-explore')) {
            if (item.classList.contains('data-index_' + (project.length - Math.round(rotation / rotate)))) {
                matchMedia.add({
                    isDesktop: "(min-width: 551px)"
                }, (context) => {
                    gsap.to(item.querySelector('.project-meta'), { x: '85%' });
                });

                matchMedia.add({
                    isPhone: "(max-width: 550px)"
                }, (context) => {
                    gsap.to(item.querySelector('.project-meta'), { y: '-40%' });
                });

            } else {
                gsap.to(item.querySelector('.project-meta'), { x: 0 });
            }
        }
    });
}
                    project.forEach(function (item, i) {
                        let projectWrap = item.querySelector('.project-wrap');

                        projectWrap.classList.add('meta-index_' + i)

                        item.style.zIndex = 99 - i

                        item.classList.add('data-index_' + i)


                        if ($this.classList.contains('intro--on')) {

                            gsap.to(item, {
                                rotate: i * rotate,
                                scrollTrigger: {
                                    trigger: $this,
                                },
                                duration: $this.getAttribute('data-intro'),
                                delay: 0.8 - (i * 0.025),
                                ease: 'expo.out'
                            })

                        } else {

                            gsap.set(item, {
                                rotate: i * rotate,

                            })

                        }


                        item.setAttribute('data-rotate', (i * rotate))


                        item.addEventListener('mouseenter', function () {
                            if ($this.classList.contains('style-scroll')) {

                                item.classList.add('active')
                                let metaIndexes = $this.querySelectorAll('.meta-index_' + i);
                                metaIndexes.forEach(function (metaIndex) {
                                    metaIndex.classList.add('active');
                                });

                            }
                        });

                        item.addEventListener('mouseleave', function () {

                            if ($this.classList.contains('style-scroll')) {

                                item.classList.remove('active')
                                let metaIndexes = $this.querySelectorAll('.meta-index_' + i);
                                metaIndexes.forEach(function (metaIndex) {
                                    metaIndex.classList.remove('active');
                                });

                            }

                        });

                        item.addEventListener('click', function () {

                            let dataRotate = parseInt(item.getAttribute('data-rotate')),
                                clickRotate = rotation + dataRotate

                            styleExplore.classList.add('active')
                            styleScroll.classList.remove('active')
                            gsap.to(switchBg, {
                                width: styleExplore.offsetWidth,
                                left: parseInt(styleScroll.offsetWidth) + paddingLeft
                            })


                            let metaIndexes = $this.querySelectorAll('.meta-index_' + i);
                            metaIndexes.forEach(function (metaIndex) {
                                metaIndex.classList.remove('active');
                            });

                            $this.classList.remove('style-scroll')
                            $this.classList.add('style-explore')


                            if (rotation <= -360) {
                                rotation = rotation + 360
                            } else if (rotation >= 360) {
                                rotation = rotation - 360
                            }

                            if (clickRotate >= 180) {

                                gsap.to(wrap, {
                                    rotate: 360 - dataRotate,
                                    duration: 1.2,
                                    ease: 'power3.inOut',
                                    onStart: () => {
                                        $this.classList.add('is_animating')
                                    },
                                    onComplete: () => {
                                        rotation = 360 - dataRotate
                                        if (rotation >= 360) {
                                            rotation = rotation - 360
                                        } else if (rotation <= -360) {
                                            rotation = rotation + 360
                                        }
                                        gsap.set(wrap, {
                                            rotate: rotation
                                        })

                                        $this.classList.remove('is_animating')
                                    }
                                })

                            } else {
                                gsap.to(wrap, {
                                    rotate: -1 * dataRotate,
                                    duration: 1.2,
                                    ease: 'power3.inOut',
                                    onComplete: () => {
                                        rotation = -1 * dataRotate
                                        if (rotation >= 360) {
                                            rotation = rotation - 360
                                        } else if (rotation <= -360) {
                                            rotation = rotation + 360
                                        }
                                        gsap.set(wrap, {
                                            rotate: rotation
                                        })
                                    }
                                })
                            }


                            matchMedia.add({
                                isDesktop: "(min-width: 551px)"

                            }, (context) => {

                                gsap.to(wrap, {
                                    x: '-57.5%',
                                    scale: 1,
                                    duration: 1.2,
                                    ease: 'power3.inOut'
                                })
                                gsap.to($this.querySelectorAll('.project-meta'), {
                                    x: 0,
                                    duration: 1.2,
                                    ease: 'power3.inOut'
                                })
                                gsap.to(item.querySelector('.project-meta'), {
                                    x: '85%',
                                    duration: 1.2,
                                    ease: 'power3.inOut'
                                })


                            });

                            matchMedia.add({
                                isPhone: "(max-width: 550px)"

                            }, (context) => {

                                gsap.to($this.querySelectorAll('.project-meta'), {
                                    y: '-100%',
                                    duration: 1.2,
                                    ease: 'power3.inOut'
                                })
                                gsap.to(item.querySelector('.project-meta'), {
                                    y: '-40%',
                                    duration: 1.2,
                                    ease: 'power3.inOut'
                                })


                            });





                        })

                    });

                    styleExplore.addEventListener('click', function () {

                        $this.classList.remove('style-scroll')
                        $this.classList.add('style-explore')

                        let roundedNumber = Math.round(rotation / rotate) * rotate;
                        styleExplore.classList.add('active')
                        styleScroll.classList.remove('active')
                        gsap.to(switchBg, {
                            width: styleExplore.offsetWidth,
                            left: parseInt(styleScroll.offsetWidth) + paddingLeft
                        })

                        gsap.to(wrap, {
                            rotate: roundedNumber,
                            x: '-57.5%',
                            scale: 1,
                            duration: 1.2,
                            ease: 'power3.inOut',
                            onComplete: () => {
                                rotation = roundedNumber
                            }
                        })



                        gsap.to($this.querySelectorAll('.project-meta'), {
                            x: '85%',
                            delay: 1
                        })




                    })

                    styleScroll.addEventListener('click', function () {

                        $this.classList.add('style-scroll')
                        $this.classList.remove('style-explore')

                        styleExplore.classList.remove('active')
                        styleScroll.classList.add('active')

                        gsap.to($this.querySelectorAll('.project-meta'), {
                            x: '0%',
                            ease: 'power3.inOut',
                            duration: 1.2,
                        })

                        gsap.to(switchBg, {
                            width: styleScroll.offsetWidth,
                            left: paddingLeft
                        })

                        gsap.to(wrap, {
                            x: '-32.5%',
                            scale: 0.33,
                            duration: 1.2,
                        })

                    })


                })

            }
        });
        elementorFrontend.hooks.addAction('frontend/element_ready/peshowcaseslideshow.default', function ($scope, $) {
            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i];
                var showcaseSlideshow = $scope.find('.leksa-showcase-slideshow');

                showcaseSlideshow.each(function (i) {
                    i++

                    let mainWrap = $(this),
                        projectsWrap = mainWrap.find('.lss-projects-wrapper'),
                        projects = projectsWrap.find('.showcase-project'),
                        imagesWrap = mainWrap.find('.fc-images-slider'),
                        footer = mainWrap.find('.showcase-footer'),
                        category = mainWrap.find('.project-category'),
                        direction = 'horizontal'

                    category.first().addClass('active')

                    category.each(function (i) {
                        $(this).addClass('cat-index_' + i)
                    })

                    if (mainWrap.hasClass('vertical')) {
                        direction = 'vertical'
                    }

                    projectsWrap.addClass('swiper-container').wrapInner('<div class="swiper-wrapper"></div>')

                    projects.each(function (i) {
                        let $this = $(this),
                            title = $this.find('.project-title'),
                            image = $this.find('.project-image');

                        $this.attr('data-index', i)
                        title.attr('data-hover', title.find('*').text())
                        $this.addClass('project_' + i)

                        image.addClass('swiper-slide').wrapInner('<div class="fs-parallax-wrap"><div class="slide-bgimg"></div></div>').appendTo(imagesWrap.find('.swiper-wrapper'));

                        $this.addClass('swiper-slide');

                    })
                    if (projects.length < 10) {
                        mainWrap.find('.lss-total').html('0' + projects.length)
                    } else {
                        mainWrap.find('.lss-total').html(projects.length)
                    }

                    function isAndroid() {
                        return /Android/i.test(navigator.userAgent);
                    }

                    var titlesSlider = new Swiper('.lss-projects-wrapper', {
                        slidesPerView: 'auto',
                        centeredSlides: true,
                        direction: direction,
                        slidesPerView: 1,
                        speed: 1500,
                        noSwiping: true,
                        slideToClickedSlide: true,
                        allowTouchMove: false,
                    }),
                        interleaveOffset = 0.5,
                        imagesSlider = new Swiper('.fc-images-slider', {
                            slidesPerView: 1,
                            speed: 1500,
                            navigation: {
                                nextEl: '.slide-next',
                                prevEl: '.slide-prev',
                            },
                            direction: direction,
                            parallax: true,
                            noSwiping: true,
                            touchReleaseOnEdges: true,
                            watchSlideProgress: true,
                            touchEventsTarget: 'container',
                            cssMode: isAndroid() ? true : false,
                            on: {
                                slideChange: function () {
                                    projects.removeClass('active');
                                    setInterval(function () {
                                        let activeIndex = mainWrap.find('.swiper-slide-active').data('index') + 1;
                                        if (activeIndex < 10) {
                                            mainWrap.find('.lss-current').html('0' + activeIndex)
                                        } else {
                                            mainWrap.find('.lss-current').html(activeIndex)
                                        }
                                        category.removeClass('active')
                                        mainWrap.find('.cat-index_' + activeIndex).addClass('active')
                                    }, 100)

                                },
                                progress: function () {
                                    let swiper = this;
                                    for (let i = 0; i < swiper.slides.length; i++) {
                                        let slideProgress = swiper.slides[i].progress,
                                            innerOffset = swiper.width * interleaveOffset,
                                            innerTranslate = slideProgress * innerOffset;

                                        if (!isAndroid()) {

                                            if (mainWrap.hasClass('vertical')) {

                                                swiper.slides[i].querySelector(".slide-bgimg").style.transform =
                                                    "translateY(" + innerTranslate + "px)";
                                            } else {
                                                swiper.slides[i].querySelector(".slide-bgimg").style.transform =
                                                    "translateX(" + innerTranslate + "px)";
                                            }
                                        }

                                    }
                                },
                                setTransition: function (speed) {
                                    let swiper = this;
                                    for (let i = 0; i < swiper.slides.length; i++) {
                                        swiper.slides[i].style.transition = speed + "ms";
                                        swiper.slides[i].querySelector(".slide-bgimg").style.transition = 1500 + "ms";
                                    }
                                },
                            }

                        });

                    var isScrolling = false;
                    var scrollTimeout;

                    document.querySelector('.leksa-showcase-slideshow').addEventListener('wheel', function (event) {
                        if (isScrolling) return;

                        if (event.deltaY < 0) {
                            imagesSlider.slidePrev();
                        } else {
                            imagesSlider.slideNext();
                        }

                        isScrolling = true;
                        clearTimeout(scrollTimeout);
                        scrollTimeout = setTimeout(function () {
                            isScrolling = false;
                        }, 1750);
                    });
                    imagesSlider.controller.control = titlesSlider;
                });



            }


        });

        elementorFrontend.hooks.addAction('frontend/element_ready/peshowcasewall.default', function ($scope, $) {
            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {

                var scope = jsScopeArray[i],
                    showcaseWalls = $scope.find('.leksa-showcase-wall');

                showcaseWalls.each(function () {

                    let parent = $(this),
                        wrapper = parent.find('.ls-wall-wrapper'),
                        projects = wrapper.find('.showcase-project'),
                        switcList = parent.find('.switch-titles'),
                        switchImages = parent.find('.switch-images'),
                        animation = parent.data('animation');


                    projects.each(function (i) {
                        i++

                        let $this = $(this),
                            image = $this.find('.project-image'),
                            title = $this.find('.project-title');

                        new SplitText(title, {
                            type: 'lines',
                            linesClass: 'title_line'
                        })

                        image.css('width', image.outerWidth())
                        image.css('height', image.outerHeight())

                        $this.attr('data-index', i);

                        $this.on('mousemove', function (e) {

                            let mouseLeft = e.clientX,
                                mouseTop = e.clientY,
                                myLeft = mouseLeft - $this.offset().left,
                                myTop = mouseTop - $this.offset().top,
                                movX = event.movementX < 0 ? event.movementX * -1 : event.movementX;

                            gsap.to(image, {
                                left: myLeft,
                                top: myTop,
                                rotate: gsap.utils.clamp(-10, 10, (event.movementX / 5)),
                                duration: 1,
                                ease: 'power3.out',
                            })



                        })

                        $this.on('mouseenter', function () {

                            parent.addClass('hovered')
                            $this.addClass('current')


                        })

                        $this.on('mouseleave', function () {

                            parent.removeClass('hovered')
                            $this.removeClass('current')

                        })

                        if (animation) {

                            title.find('.title_line').addClass('has-anim-text')
                            title.find('.title_line').addClass(animation)


                            title.find('.title_line').attr('data-delay', (i / 20))

                            $this.addClass('detect-pov')

                        }



                    });





                })


            }
        });

        elementorFrontend.hooks.addAction('frontend/element_ready/pefullscreencards.default', function ($scope, $) {
            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {

                var scope = jsScopeArray[i],
                    fullscreenCards = document.querySelectorAll('.leksa-fullscreen-cards');

                fullscreenCards.forEach(function ($this) {
                    let wrapper = $this.querySelector('.fullscreen-cards-wrapper'),
                        project = $this.querySelectorAll('.showcase-project'),
                        speed = parseInt($this.getAttribute('data-speed')),
                        projectLength = project.length,
                        height = project.offsetHeight,
                        scEnd = height * projectLength,
                        targetID = $this.getAttribute('data-target-id'),
                        tl = gsap.timeline({
                            ease: 'none',
                            scrollTrigger: {
                                trigger: fullscreenCards,
                                start: 'top top',
                                end: 'bottom+=' + speed + ' top',
                                scrub: true,
                                pin: true
                            }
                        }),
                        tlOut = gsap.timeline({
                            ease: 'none',
                            scrollTrigger: {
                                trigger: wrapper,
                                start: 'top top',
                                end: 'bottom+=' + speed + ' top',
                                scrub: true,
                                pin: false,
                                onUpdate: function (self) {
                                    if (self.progress >= 1) {
                                        gsap.to(document.querySelectorAll(targetID), {
                                            opacity: 0,
                                            onComplete: () => {
                                                document.querySelectorAll(targetID).display = 'none'
                                            }
                                        })
                                    }
                                },
                                onEnterBack: () => {
                                    gsap.to(document.querySelectorAll(targetID), {
                                        opacity: 1,
                                        onComplete: () => {
                                            document.querySelectorAll(targetID).display = 'block'
                                        }
                                    })
                                }
                            },
                        })





                    project = $this.querySelectorAll('.showcase-project')


                    project.forEach(function (item, i) {
                        item.classList.add('anim-project')
                        item.classList.add('anim-project_' + i)


                        gsap.set(item, {
                            zIndex: 100 - i,
                            z: -i * 120,
                            y: -i * 40,
                            force3d: true
                        })

                        item.setAttribute('data-z', -i * 120);
                        item.setAttribute('data-y', -i * 40);

                        tl.to(item, {
                            y: parseInt(item.getAttribute('data-y')) + (projectLength * 40),
                            z: parseInt(item.getAttribute('data-z')) + (projectLength * 120),
                            ease: 'none',
                        }, 0)

                        if (!item.classList.contains('clone_project')) {

                            tlOut.to(item, {
                                top: '100vh',
                                ease: 'none'
                            })


                        }

                    })

                })


            }
        });

        elementorFrontend.hooks.addAction('frontend/element_ready/peshowcasecarousel.default', function ($scope, $) {
            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {

                var scope = jsScopeArray[i],
                    leksaShowcaseCarousel = document.querySelectorAll('.leksa-showcase-carousel');

                leksaShowcaseCarousel.forEach(function ($this) {
                    let imageWrap = $this.querySelector('.images-wrapper'),
                        switchWide = $this.querySelector('.style-wide'),
                        switchNarow = $this.querySelector('.style-narrow'),
                        switchBg = $this.querySelector('.switch-bg'),
                        switcher = window.getComputedStyle($this.querySelector('.lsc-switcher')),
                        switcherPad = parseInt(switcher.paddingLeft),
                        projectMeta = $this.querySelectorAll('.project-meta'),
                        projectImage = $this.querySelectorAll('.showcase-project'),
                        projectTitle = $this.querySelectorAll('.project-title'),
                        speed = parseInt($this.getAttribute('data-speed')),
                        imageDuration = $this.getAttribute('data-image-duration'),
                        switchDuration = $this.getAttribute('data-switch-duration'),
                        wideWidth = parseInt(getComputedStyle($this).getPropertyValue('--wideWidth')),
                        narrowWidth = parseInt(getComputedStyle($this).getPropertyValue('--narrowWidth')),
                        firstImage = $this.querySelector('.project-image'),
                        computedStyle = window.getComputedStyle(firstImage),
                        paddingLeft = parseInt(computedStyle.paddingLeft),
                        paddingRight = parseInt(computedStyle.paddingRight);

                    switchBg.style.height = switchNarow.offsetHeight + 'px'

                    matchMedia.add({
                        isMobile: "(max-width: 570px)"

                    }, (context) => {

                        let {
                            isMobile
                        } = context.conditions;

                        let drag = Draggable.create(imageWrap, {
                            trigger: imageWrap,
                            type: 'x',
                            inertia: true,
                            dragResistance: 0.1,
                            edgeResistance: 1,
                            throwProps: {
                                ease: "power3.out",
                                resistance: 1
                            },
                            onDrag: function () {
                                let xPos = this.x / (narrowWidth * (projectImage.length - 1))
                                gsap.set($this.querySelectorAll('.parallax--wrap'), {
                                    x: (-1 * narrowWidth / 20) + (xPos * narrowWidth / -10)
                                })
                            },
                            bounds: {
                                maxX: 0,
                                minX: -1 * narrowWidth * (projectImage.length - 1)
                            }
                        })

                        $this.classList.remove('wide')
                        $this.classList.add('narrow')

                    });

                    projectMeta.forEach(function (meta, i) {
                        meta.classList.add('meta-index_' + i)
                    })

                    projectImage.forEach(function (image, i) {
                        image.setAttribute('data-index', i)

                        image.addEventListener('mouseenter', function () {

                            $this.querySelector('.meta-index_' + image.getAttribute('data-index')).classList.add('meta-hover')
                        })

                        image.addEventListener('mouseleave', function () {

                            $this.querySelector('.meta-index_' + image.getAttribute('data-index')).classList.remove('meta-hover')

                        })
                    })

                    imageWrap.style.width = wideWidth * (projectImage.length + 1) + 'px';


                    matchMedia.add({
                        isDesktop: "(min-width: 571px)"

                    }, (context) => {


                        let {
                            isDesktop
                        } = context.conditions;

                        var tl = gsap.timeline({
                            ease: 'none',
                            scrollTrigger: {
                                trigger: $this,
                                start: 'top top',
                                end: 'bottom+=' + speed + ' top',
                                pin: true,
                                scrub: true,
                                onUpdate: (self) => {
                                    var scrollPos = window.pageYOffset || document.documentElement.scrollTop,
                                        imageProg = (scrollPos / (document.body.scrollHeight - window.innerHeight)) * 100 * (projectImage.length - 1),
                                        lineProg = (scrollPos / (document.body.scrollHeight - window.innerHeight)) * 100,
                                        parallaxProg = self.progress * wideWidth / 5

                                    gsap.set($this.querySelectorAll('.parallax--wrap'), {
                                        x: (-1 * wideWidth / 10) + parallaxProg
                                    })


                                    $this.querySelector('.active-line').style.width = lineProg + '%'

                                    projectImage.forEach(function (image) {
                                        image.style.transform = 'translateX(-' + imageProg + '%) translateY(-50%)';
                                    });
                                }
                            }
                        })


                    });

                    if ($this.classList.contains('wide')) {
                        switchWide.classList.add('active')
                        switchBg.style.width = switchWide.offsetWidth + 'px'
                        switchBg.style.left = switcherPad + 'px'

                    } else if ($this.classList.contains('narrow')) {
                        switchNarow.classList.add('active')
                        switchBg.style.width = switchNarow.offsetWidth + 'px'
                        switchBg.style.left = switcherPad + switchWide.offsetWidth + 'px'

                    }

                    switchNarow.addEventListener('click', function () {

                        if ($this.classList.contains('wide')) {

                            gsap.to(switchBg, {
                                width: switchNarow.offsetWidth,
                                left: switcherPad + switchWide.offsetWidth,
                                duration: switchDuration
                            })

                            if (!switchNarow.classList.contains('active')) {

                                switchWide.classList.remove('active')
                                switchNarow.classList.add('active')

                                $this.classList.remove('wide')
                                $this.classList.add('narrow')
                            }
                        }

                    })

                    switchWide.addEventListener('click', function () {

                        if ($this.classList.contains('narrow')) {

                            gsap.to(switchBg, {
                                width: switchWide.offsetWidth,
                                left: switcherPad,
                                duration: switchDuration
                            })

                            switchNarow.classList.remove('active')
                            switchWide.classList.add('active')

                            $this.classList.remove('narrow')
                            $this.classList.add('wide')

                        }

                    })


                })

            }
        });

        elementorFrontend.hooks.addAction('frontend/element_ready/peshowcasetable.default', function ($scope, $) {
            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {

                var scope = jsScopeArray[i],
                    showcaseTable = document.querySelectorAll('.showcase-table');

                showcaseTable.forEach(function ($this) {
                    let srWrap = $this.querySelector('.st-wrapper'),
                        project = $this.querySelectorAll('.showcase-project'),
                        itemWidth = project.offsetWidth,
                        itemHeight = project.offsetHeight,
                        top = window.innerHeight / 3 - 50,
                        left = window.innerWidth / 3 - 100;

                    project = Array.from(project);
                    project.sort(function () {
                        return 0.5 - Math.random();
                    });

                    project.forEach(function (item) {
                        srWrap.appendChild(item);
                    });

                    var itemsTl = gsap.timeline({
                        scrollTrigger: {
                            trigger: $this,
                            start: 'top bottom'
                        }
                    })

                    project.forEach(function (item, i) {
                        let random = gsap.utils.random,
                            rotate = gsap.utils.random(-45, 45);

                        var itemsDrag = Draggable.create(item, {
                            type: 'left, top',
                            edgeResistance: 0.75,
                            id: 'dragger_item_' + i,
                            bounds: {
                                top: -item.offsetHeight / 2,
                                left: -item.offsetWidth / 2,
                                width: $this.offsetWidth * (item.offsetWidth * 1.5),
                                height: $this.offsetHeight * (item.offsetHeight * 1.5)
                            },
                            dragResistance: 0.35,
                            inertia: true,
                            zIndexBoost: true,
                            alllowEventDefault: true,
                            onPress: () => {
                                item.classList.add('dragging')
                            },
                            onRelease: () => {
                                item.classList.remove('dragging')
                            }
                        })

                        if (i === 0) {

                            itemsTl.to(item, {
                                top: random(-40, top),
                                left: random(-100, left),
                                rotate: rotate,
                                duration: 2,
                                delay: 0,
                                ease: 'expo.out',
                            }, random(0.1, 0.5))
                        } else if (i === 1) {

                            itemsTl.to(item, {
                                top: random(-40, top),
                                left: random(left, left * 2),
                                rotate: rotate,
                                duration: 2,
                                delay: 0,
                                ease: 'expo.out',
                            }, random(0.1, 0.5))
                        } else if (i === 2) {

                            itemsTl.to(item, {
                                top: random(-40, top),
                                left: random(left * 2, left * 3),
                                rotate: rotate,
                                duration: 2,
                                delay: 0,
                                ease: 'expo.out',
                            }, random(0.1, 0.5))
                        } else if (i === 3) {

                            itemsTl.to(item, {
                                top: random(top, top * 2),
                                left: random(-100, left),
                                rotate: rotate,
                                duration: 2,
                                delay: 0,
                                ease: 'expo.out',
                            }, 0)
                        } else if (i === 4) {

                            itemsTl.to(item, {
                                top: random(top, top * 2),
                                left: random(left, left * 2),
                                rotate: rotate,
                                duration: 2,
                                delay: 0,
                                ease: 'expo.out',
                            }, random(0.1, 0.5))
                        } else if (i === 5) {

                            itemsTl.to(item, {
                                top: random(top, top * 2),
                                left: random(left * 2, left * 3),
                                rotate: rotate,
                                duration: 2,
                                delay: 0,
                                ease: 'expo.out',
                            }, random(0.1, 0.5))
                        } else if (i === 6) {

                            itemsTl.to(item, {
                                top: random(top * 2, top * 3),
                                left: random(-40, left),
                                rotate: rotate,
                                duration: 2,
                                delay: 0,
                                ease: 'expo.out',
                            }, random(0.1, 0.5))
                        } else if (i === 7) {

                            itemsTl.to(item, {
                                top: random(top * 2, top * 3),
                                left: random(left, left * 2),
                                rotate: rotate,
                                duration: 2,
                                delay: 0,
                                ease: 'expo.out',
                            }, random(0.1, 0.5))
                        } else if (i === 8) {

                            itemsTl.to(item, {
                                top: random(top * 2, top * 3),
                                left: random(left * 2, left * 3),
                                rotate: rotate,
                                duration: 2,
                                delay: 0,
                                ease: 'expo.out',
                            }, random(0.1, 0.5))

                        } else if (i >= 9) {

                            itemsTl.to(item, {
                                top: random(top * 2, top * 3),
                                left: random(left * 2, left * 3),
                                rotate: rotate,
                                duration: 2,
                                delay: 0,
                                ease: 'expo.out',
                            }, random(0.1, 0.5))
                        }


                    })

                    // matchMedia.add({
                    //     isMobile: "(max-width: 450px)"

                    // }, (context) => {

                    //     let {
                    //         isMobile
                    //     } = context.conditions;

                    //     itemsTl.kill();

                    //     gsap.set(project, {
                    //         clearProps: 'all'
                    //     })

                    //     project.forEach(function (item) {

                    //         Draggable.get(item).kill();

                    //     })

                    //     return () => { }
                    // });

                })

            }
        });

        elementorFrontend.hooks.addAction('frontend/element_ready/pefullscreenlist.default', function ($scope, $) {
            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    fsList = document.querySelectorAll('.leksa-fullscreen-list');

                fsList.forEach(function (list) {
                    let speed = parseInt(list.dataset.speed),
                        title = list.querySelectorAll('.project-title'),
                        length = title.length,
                        mainWrap = list.querySelector('.lfs-main-wrap'),
                        cloneLength;

                    title.forEach(function (title, i) {
                        i++;
                        title.querySelector('a').dataset.index = i;
                        title.classList.add('data-index_' + i);
                        cloneLength = Math.ceil(page.offsetHeight / (title.offsetHeight * length))

                    });

                    for (let i = 0; i <= cloneLength; i++) {
                        title.forEach(function (title) {

                            mainWrap.appendChild(title.cloneNode(true));
                        });
                    }

                    title = list.querySelectorAll('.project-title');

                    matchMedia.add({
                        isDesktop: "(min-width: 550px)"

                    }, (context) => {

                        let {
                            isDesktop
                        } = context.conditions;

                        if (leksaLenis) {

                            leksaLenis.options.infinite = true;

                            barba.hooks.before(() => {
                                leksaLenis.options.infinite = false;
                            });

                        } else {

                            const lenis = new Lenis({
                                smooth: true,
                                infinite: true,
                                smoothTouch: true
                            });

                            function raf(time) {
                                lenis.raf(time);
                                requestAnimationFrame(raf);
                            }
                            requestAnimationFrame(raf);

                            barba.hooks.before(() => {
                                lenis.destroy();
                            });

                        }

                        let sct = new ScrollTrigger({
                            trigger: list,
                            start: 'center center',
                            end: speed,
                            pin: true,
                            onUpdate: function (self) {
                                let prog = self.progress * title[0].offsetHeight * length;
                                mainWrap.style.transform = 'translateY(' + (-1 * prog) + 'px)';
                            }
                        });


                    });


                    title.forEach(function (title) {
                        title.querySelector('a').addEventListener('mouseenter', function () {
                            let activeIndex = parseInt(this.dataset.index);
                            list.querySelector('.showcase-project:nth-child(' + activeIndex + ')').classList.add('active');
                        });

                        title.querySelector('a').addEventListener('mouseleave', function () {
                            let activeIndex = parseInt(this.dataset.index);
                            list.querySelector('.showcase-project:nth-child(' + activeIndex + ')').classList.remove('active');
                        });


                    });

                    matchMedia.add({
                        isMobile: "(max-width: 550px)"

                    }, (context) => {

                        let drag = Draggable.create(mainWrap, {
                            type: 'y',
                            onDrag: function () {
                                var y = this.y
                                if (y > 0) {
                                    y = y - (title[0].offsetHeight * length)
                                    gsap.set(mainWrap, {
                                        y: y
                                    })
                                } else if (y < (title[0].offsetHeight * length * -1)) {
                                    y = y + ((title[0].offsetHeight * length))
                                    gsap.set(mainWrap, {
                                        y: y
                                    })
                                }
                            }
                        })


                    });


                });


            }
        });



    })


})(jQuery)
