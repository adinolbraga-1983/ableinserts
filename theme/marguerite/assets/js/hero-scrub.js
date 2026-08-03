/* ============================================================================
   Hero scrub — vídeo full-screen dirigido pelo scroll.
   Sequência de frames (lente roxa embutida) desenhada num canvas; ScrollTrigger
   fixa (pin) o hero e "scrub" mapeia o progresso do scroll → frame. Rolar pra
   baixo avança; pra cima, reverte. Os textos entram e saem no caminho.
   ---------------------------------------------------------------------------
   initHeroScrub({ hero, reduced, mobile }) — usa gsap/ScrollTrigger globais.
   ========================================================================== */
function initHeroScrub({ hero, reduced, mobile }) {
  const canvas = hero.querySelector('.hero__canvas');
  const ctx = canvas.getContext('2d');
  // Frames: por caminho (site) ou embutidos como data URIs (arquivo único).
  const embedded = (typeof window !== 'undefined' && Array.isArray(window.__HERO_FRAMES__)) ? window.__HERO_FRAMES__ : null;
  const base = hero.dataset.heroSeq;
  const N = embedded ? embedded.length : (parseInt(hero.dataset.heroFrames, 10) || 96);
  const srcOf = (i) => (embedded ? embedded[i] : base + pad(i) + '.jpg');
  const scene1 = hero.querySelector('.hero__scene--1');
  const scene2 = hero.querySelector('.hero__scene--2');
  const bar = hero.querySelector('.hero__progress .track');

  const clamp = (v, a = 0, b = 1) => Math.min(b, Math.max(a, v));
  const pad = (n) => String(n).padStart(3, '0');

  // ---- carrega os frames ----
  const imgs = new Array(N);
  let firstReady = false;
  function load(i) {
    const im = new Image();
    im.decoding = 'async';
    im.src = srcOf(i);
    im.onload = () => {
      if (!firstReady && i === 0) { firstReady = true; hero.classList.add('seq-ready'); draw(0); }
    };
    imgs[i] = im;
  }
  // frame 0 primeiro (LCP), depois o resto
  load(0);
  for (let i = 1; i < N; i++) load(i);

  // ---- desenho cover-fit com DPR ----
  function resize() {
    const dpr = Math.min(window.devicePixelRatio || 1, 2);
    canvas.width = Math.round(canvas.clientWidth * dpr);
    canvas.height = Math.round(canvas.clientHeight * dpr);
  }
  function draw(i) {
    const im = imgs[i];
    if (!im || !im.complete || !im.naturalWidth) return;
    const cw = canvas.width, ch = canvas.height;
    const scale = Math.max(cw / im.naturalWidth, ch / im.naturalHeight);
    const w = im.naturalWidth * scale, h = im.naturalHeight * scale;
    ctx.drawImage(im, (cw - w) / 2, (ch - h) / 2, w, h);
  }
  resize();
  window.addEventListener('resize', () => { resize(); draw(current); }, { passive: true });

  let current = 0;

  // ---- textos: entrada/saída em função do progresso ----
  function updateText(p) {
    // Cena 1 sai (0.10 → 0.30)
    const e1 = clamp((p - 0.10) / 0.20);
    scene1.style.opacity = String(1 - e1);
    scene1.style.transform = `translateY(${-e1 * 8}vh)`;
    scene1.style.filter = `blur(${e1 * 8}px)`;
    // Cena 2 entra (0.56 → 0.72) e sai (0.86 → 0.98)
    const in2 = clamp((p - 0.56) / 0.16);
    const out2 = clamp((p - 0.86) / 0.12);
    scene2.style.opacity = String(in2 * (1 - out2));
    scene2.style.transform = `translateY(${(1 - in2) * 8 - out2 * 8}vh)`;
    scene2.style.filter = `blur(${((1 - in2) + out2) * 8}px)`;
    if (bar) bar.style.setProperty('--p', (p * 100).toFixed(1) + '%');
  }

  // ---- modo estático (reduced-motion / mobile): sem pin, 1 tela ----
  if (reduced || mobile || typeof ScrollTrigger === 'undefined') {
    hero.classList.add('is-static');
    const showFirst = () => draw(0);
    if (imgs[0].complete) showFirst(); else imgs[0].onload = () => { hero.classList.add('seq-ready'); showFirst(); };
    return { destroy() {} };
  }

  // ---- pin + scrub ----
  const st = ScrollTrigger.create({
    trigger: hero,
    start: 'top top',
    end: () => '+=' + Math.round(window.innerHeight * 2.6),
    pin: hero.querySelector('.hero__pin'),
    pinSpacing: true,
    anticipatePin: 1,
    scrub: 0.5,
    invalidateOnRefresh: true,
    onUpdate(self) {
      const p = self.progress;
      const fi = Math.min(N - 1, Math.max(0, Math.round(p * (N - 1))));
      if (fi !== current) { current = fi; draw(fi); }
      updateText(p);
    },
  });

  return { destroy() { st.kill(); } };
}

window.initHeroScrub = initHeroScrub;
