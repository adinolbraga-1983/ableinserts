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

	document.addEventListener('DOMContentLoaded', function () {
		initHeader();
		initWordReveal();
		initReveals();
		initHero();
		initHeroParallax();
		initMarquee();
		initCarousel();
	});

	/* ---------------- Header ---------------- */
	function initHeader() {
		var header = document.querySelector('.site-header');
		var toggle = document.querySelector('.nav-toggle');
		var nav = document.querySelector('.site-navigation');
		if (!header || !toggle || !nav) return;

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
		if (cue) {
			gsap.to(cue, { y: 6, duration: 1.1, ease: 'sine.inOut', repeat: -1, yoyo: true });
		}
	}

	/* ---------------- Parallax do hero (imagem e blobs em profundidades diferentes) ---------------- */
	function initHeroParallax() {
		if (!window.gsap || reduceMotion) return;
		var hero = document.querySelector('.hero');
		var heroImg = document.querySelector('.hero__media img');
		if (!hero || !heroImg) return;

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

	/* ---------------- Carrossel de cases ---------------- */
	function initCarousel() {
		var root = document.querySelector('[data-carousel]');
		if (!root) return;

		var wrap = root.querySelector('.portfolio-track-wrap');
		var track = root.querySelector('[data-track]');
		var cards = Array.prototype.slice.call(track.querySelectorAll('.case-card'));
		var dots = Array.prototype.slice.call(root.querySelectorAll('[data-carousel-goto]'));
		var prevBtn = root.querySelector('[data-carousel-prev]');
		var nextBtn = root.querySelector('[data-carousel-next]');
		var total = cards.length;
		if (!total) return;

		var DESIGN_WIDTH = 1160;
		var DESIGN_HEIGHT = 600;

		// Geometria (px, espaço de desenho do Figma) por posição relativa ao card ativo.
		var SLOTS = [
			{ left: 380, top: 40, width: 400, height: 520, opacity: 1, zIndex: 3 },
			{ left: 786.3, top: 71.2, width: 352, height: 457.6, opacity: 0.58, zIndex: 2 },
			{ left: 1113.7, top: 102.4, width: 304, height: 395.2, opacity: 0.16, zIndex: 1 },
		];
		var HIDDEN_SLOT = { left: 1420, top: 130, width: 260, height: 340, opacity: 0, zIndex: 0 };

		var activeIndex = 0;
		var isMobile = window.matchMedia('(max-width: 900px)').matches;
		var autoplayTimer;

		function scaleFactor() {
			return wrap.clientWidth / DESIGN_WIDTH;
		}

		function layoutDesktop(animate) {
			var scale = scaleFactor();
			track.style.transform = 'scale(' + scale + ')';
			wrap.style.height = (DESIGN_HEIGHT * scale) + 'px';

			cards.forEach(function (card, i) {
				var relative = (i - activeIndex + total) % total;
				var slot = SLOTS[relative] || HIDDEN_SLOT;
				var props = {
					left: slot.left,
					top: slot.top,
					width: slot.width,
					height: slot.height,
					opacity: slot.opacity,
				};

				card.setAttribute('aria-hidden', relative === 0 ? 'false' : 'true');
				// z-index não é interpolável de forma útil: aplica-se de imediato.
				card.style.zIndex = slot.zIndex;

				if (window.gsap && animate && !reduceMotion) {
					gsap.to(card, Object.assign({ duration: 0.7, ease: 'power3.inOut' }, props));
				} else if (window.gsap) {
					gsap.set(card, props);
				} else {
					Object.keys(props).forEach(function (key) {
						card.style[key] = key !== 'opacity' ? props[key] + 'px' : props[key];
					});
				}
			});
		}

		function layoutMobile(animate) {
			track.style.transform = 'none';
			wrap.style.height = 'auto';
			cards.forEach(function (card, i) {
				var active = i === activeIndex;
				card.classList.toggle('is-mobile-active', active);
				card.setAttribute('aria-hidden', active ? 'false' : 'true');
				if (window.gsap && active && animate && !reduceMotion) {
					gsap.fromTo(card, { opacity: 0 }, { opacity: 1, duration: 0.5, ease: 'power2.out' });
				}
			});
		}

		function render(animate) {
			if (isMobile) {
				layoutMobile(animate);
			} else {
				layoutDesktop(animate);
			}
			dots.forEach(function (dot, i) {
				dot.classList.toggle('is-active', i === activeIndex);
			});
		}

		function goTo(index, animate) {
			activeIndex = ((index % total) + total) % total;
			render(animate !== false);
			resetAutoplay();
		}

		function next() { goTo(activeIndex + 1); }
		function prev() { goTo(activeIndex - 1); }

		if (prevBtn) prevBtn.addEventListener('click', prev);
		if (nextBtn) nextBtn.addEventListener('click', next);
		dots.forEach(function (dot) {
			dot.addEventListener('click', function () {
				goTo(parseInt(dot.getAttribute('data-carousel-goto'), 10));
			});
		});

		root.addEventListener('keydown', function (e) {
			if (e.key === 'ArrowRight') { e.preventDefault(); next(); }
			if (e.key === 'ArrowLeft') { e.preventDefault(); prev(); }
		});

		function resetAutoplay() {
			if (reduceMotion) return;
			clearInterval(autoplayTimer);
			autoplayTimer = setInterval(next, 6500);
		}
		root.addEventListener('mouseenter', function () { clearInterval(autoplayTimer); });
		root.addEventListener('mouseleave', resetAutoplay);
		root.addEventListener('focusin', function () { clearInterval(autoplayTimer); });
		root.addEventListener('focusout', resetAutoplay);

		window.addEventListener('resize', debounce(function () {
			isMobile = window.matchMedia('(max-width: 900px)').matches;
			render(false);
		}, 200));

		render(false);
		resetAutoplay();
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
