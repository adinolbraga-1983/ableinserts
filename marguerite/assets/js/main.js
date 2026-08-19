/* =========================================================
   Marguerite — Agência de Experiência
   Interações e animações (GSAP + ScrollTrigger)
   ========================================================= */
(function () {
	'use strict';

	var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	if (window.gsap) {
		gsap.registerPlugin(ScrollTrigger);
	}

	/**
	 * Marca um elemento como já inicializado e devolve `false` se ele já tiver
	 * sido tratado antes. É o que permite rodar o boot() várias vezes (necessário
	 * dentro do editor do Elementor, que recria os widgets a cada alteração)
	 * sem duplicar animações, listeners ou bolinhas do carrossel.
	 */
	function once(el, chave) {
		if (!el) return false;
		var attr = 'mgInit' + chave;
		if (el.dataset[attr]) return false;
		el.dataset[attr] = '1';
		return true;
	}

	/**
	 * Liga tudo. Pode ser chamado quantas vezes for preciso.
	 */
	function boot() {
		initHeader();
		initWordReveal();
		initReveals();
		initHero();
		initHeroParallax();
		initMarquee();
		initCasesCarousel();
	}

	document.addEventListener('DOMContentLoaded', boot);

	// No editor do Elementor cada widget é re-renderizado ao ser editado; o hook
	// oficial abaixo garante que as interações voltem a funcionar na hora.
	window.jQuery && jQuery(window).on('elementor/frontend/init', function () {
		if (!window.elementorFrontend || !elementorFrontend.hooks) return;
		[
			'marguerite-hero',
			'marguerite-quem-somos',
			'marguerite-metodologia',
			'marguerite-executivas',
			'marguerite-cases',
			'marguerite-marcas',
			'marguerite-cta'
		].forEach(function (widget) {
			elementorFrontend.hooks.addAction('frontend/element_ready/' + widget + '.default', boot);
		});
	});

	window.MargueriteUI = { boot: boot };

	/* ---------------- Header ---------------- */
	function initHeader() {
		var header = document.querySelector('.site-header');
		var toggle = document.querySelector('.nav-toggle');
		var nav = document.querySelector('.site-navigation');
		if (!header || !toggle || !nav) return;
		if (!once(header, 'Header')) return;

		toggle.addEventListener('click', function () {
			var isOpen = header.classList.toggle('is-open');
			nav.classList.toggle('is-open', isOpen);
			toggle.setAttribute('aria-expanded', String(isOpen));
		});

		nav.querySelectorAll('a').forEach(function (link) {
			link.addEventListener('click', function () {
				header.classList.remove('is-open');
				nav.classList.remove('is-open');
				toggle.setAttribute('aria-expanded', 'false');
			});
		});
	}

	/* ---------------- Reveal on scroll (entra e sai nos dois sentidos) ---------------- */
	function initReveals() {
		var items = document.querySelectorAll('[data-reveal]');
		if (!items.length) return;

		if (!window.gsap || reduceMotion) {
			items.forEach(function (el) { el.classList.add('reveal-ready'); });
			return;
		}

		items.forEach(function (el) {
			if (!once(el, 'Reveal')) return;
			var delay = parseFloat(el.getAttribute('data-reveal-delay') || '0');
			gsap.fromTo(
				el,
				{ opacity: 0, y: 34 },
				{
					opacity: 1,
					y: 0,
					duration: 0.9,
					delay: delay,
					ease: 'power3.out',
					scrollTrigger: {
						trigger: el,
						start: 'top 88%',
						end: 'bottom 12%',
						// Anima ao entrar rolando pra baixo E ao reentrar rolando pra cima.
						toggleActions: 'play reverse play reverse',
					},
				}
			);
		});
	}

	/* ---------------- Títulos: palavras aparecendo em cascata ---------------- */
	function splitIntoWords(root) {
		function walk(node) {
			Array.prototype.slice.call(node.childNodes).forEach(function (child) {
				if (child.nodeType === 3) {
					if (!child.textContent || !child.textContent.trim()) return;
					var frag = document.createDocumentFragment();
					var parts = child.textContent.split(/(\s+)/);
					parts.forEach(function (part) {
						if (part === '') return;
						if (/^\s+$/.test(part)) {
							frag.appendChild(document.createTextNode(part));
							return;
						}
						var mask = document.createElement('span');
						mask.className = 'word-mask';
						var word = document.createElement('span');
						word.className = 'word';
						word.textContent = part;
						mask.appendChild(word);
						frag.appendChild(mask);
					});
					node.replaceChild(frag, child);
				} else if (child.nodeType === 1) {
					walk(child);
				}
			});
		}
		walk(root);
		return root.querySelectorAll('.word');
	}

	function initWordReveal() {
		if (!window.gsap || reduceMotion) return;
		var headings = document.querySelectorAll('.hero__title, .h2');

		headings.forEach(function (heading) {
			if (!once(heading, 'Words')) return;
			var words = splitIntoWords(heading);
			if (!words.length) return;

			gsap.set(words, { yPercent: 115, opacity: 0 });
			gsap.to(words, {
				yPercent: 0,
				opacity: 1,
				duration: 0.85,
				ease: 'power4.out',
				stagger: 0.032,
				scrollTrigger: {
					trigger: heading,
					start: 'top 90%',
					end: 'bottom 20%',
					toggleActions: 'play reverse play reverse',
				},
			});
		});
	}

	/* ---------------- Hero ---------------- */
	function initHero() {
		if (!window.gsap || reduceMotion) return;

		var blobs = document.querySelectorAll('.hero__blob');
		blobs.forEach(function (blob, i) {
			if (!once(blob, 'Blob')) return;
			gsap.to(blob, {
				y: i % 2 === 0 ? 22 : -22,
				x: i % 2 === 0 ? -14 : 14,
				duration: 6 + i,
				ease: 'sine.inOut',
				repeat: -1,
				yoyo: true,
			});
		});

		var cue = document.querySelector('.hero__scroll-cue');
		if (cue && once(cue, 'Cue')) {
			gsap.to(cue, { y: 6, duration: 1.1, ease: 'sine.inOut', repeat: -1, yoyo: true });
		}
	}

	/* ---------------- Parallax do hero (imagem e blobs em profundidades diferentes) ---------------- */
	function initHeroParallax() {
		if (!window.gsap || reduceMotion) return;
		var hero = document.querySelector('.hero');
		var heroImg = document.querySelector('.hero__media img');
		if (!hero || !heroImg) return;
		if (!once(heroImg, 'Parallax')) return;

		// Só a imagem recebe o scrub de parallax; os blobs já têm sua própria
		// animação contínua (initHero) — evita duas tweens disputando o mesmo transform.
		gsap.to(heroImg, {
			yPercent: 14,
			scale: 1.08,
			ease: 'none',
			scrollTrigger: { trigger: hero, start: 'top top', end: 'bottom top', scrub: 0.6 },
		});
	}

	/* ---------------- Marquee de marcas ---------------- */
	function initMarquee() {
		var track = document.querySelector('[data-marquee-track]');
		var wrap = document.querySelector('[data-marquee]');
		if (!track || !wrap) return;
		if (!once(track, 'Marquee')) return;

		if (!window.gsap || reduceMotion) return;

		var tween;

		function build() {
			if (tween) tween.kill();
			gsap.set(track, { xPercent: 0 });
			var distance = track.scrollWidth / 2;
			var duration = distance / 55; // velocidade constante (px/s)
			tween = gsap.to(track, {
				x: -distance,
				duration: duration,
				ease: 'none',
				repeat: -1,
			});
		}

		build();
		window.addEventListener('resize', debounce(build, 250));

		wrap.addEventListener('mouseenter', function () { if (tween) tween.pause(); });
		wrap.addEventListener('mouseleave', function () { if (tween) tween.resume(); });
	}

	/* ---------------- Carrossel horizontal dos cases ---------------- */
	function initCasesCarousel() {

			var carousel = document.querySelector('[data-cases-carousel]');
			var track = document.querySelector('[data-cases-track]');
			if (!carousel || !track) return;
			if (!once(carousel, 'Cases')) return;

			var slides = Array.prototype.filter.call(track.children, function (el) {
				return el.classList.contains('case-block') && !el.hasAttribute('hidden');
			});
			if (slides.length < 2) return; // nada para navegar

			var prevBtn = carousel.querySelector('[data-cases-prev]');
			var nextBtn = carousel.querySelector('[data-cases-next]');
			var dotsWrap = carousel.querySelector('[data-cases-dots]');
			var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

			var dots = slides.map(function (_, i) {
				var dot = document.createElement('button');
				dot.type = 'button';
				dot.className = 'portfolio-dot' + (i === 0 ? ' is-active' : '');
				dot.setAttribute('role', 'tab');
				dot.setAttribute('aria-label', 'Ir para o case ' + (i + 1));
				dot.addEventListener('click', function () { goTo(i); });
				dotsWrap.appendChild(dot);
				return dot;
			});

			function slideLeft(el) {
				return el.getBoundingClientRect().left - track.getBoundingClientRect().left + track.scrollLeft;
			}

			function goTo(index) {
				index = Math.max(0, Math.min(slides.length - 1, index));
				track.scrollTo({ left: slideLeft(slides[index]), behavior: reduceMotion ? 'auto' : 'smooth' });
			}

			function currentIndex() {
				var center = track.scrollLeft + track.clientWidth / 2;
				var closest = 0;
				var closestDist = Infinity;
				slides.forEach(function (el, i) {
					var mid = slideLeft(el) + el.offsetWidth / 2;
					var dist = Math.abs(mid - center);
					if (dist < closestDist) { closestDist = dist; closest = i; }
				});
				return closest;
			}

			function updateDots() {
				var idx = currentIndex();
				dots.forEach(function (dot, i) { dot.classList.toggle('is-active', i === idx); });
			}

			if (prevBtn) prevBtn.addEventListener('click', function () { goTo(currentIndex() - 1); });
			if (nextBtn) nextBtn.addEventListener('click', function () { goTo(currentIndex() + 1); });

			carousel.setAttribute('tabindex', '0');
			carousel.addEventListener('keydown', function (e) {
				if (e.key === 'ArrowRight') { e.preventDefault(); goTo(currentIndex() + 1); }
				if (e.key === 'ArrowLeft') { e.preventDefault(); goTo(currentIndex() - 1); }
			});

			var scrollTimer;
			track.addEventListener('scroll', function () {
				clearTimeout(scrollTimer);
				scrollTimer = setTimeout(updateDots, 100);
			}, { passive: true });

			window.addEventListener('resize', function () {
				clearTimeout(scrollTimer);
				scrollTimer = setTimeout(updateDots, 150);
			});

	}

	/* ---------------- Utils ---------------- */
	function debounce(fn, wait) {
		var t;
		return function () {
			clearTimeout(t);
			var args = arguments;
			t = setTimeout(function () { fn.apply(null, args); }, wait);
		};
	}
})();

