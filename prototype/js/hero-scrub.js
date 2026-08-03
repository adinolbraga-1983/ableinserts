/* ============================================================================
   Hero scrub — vídeo full-screen dirigido pelo scroll.
   Sequência de frames (lente roxa embutida) desenhada num canvas; ScrollTrigger
   fixa (pin) o hero e "scrub" mapeia o progresso do scroll → frame. Rolar pra
   baixo avança; pra cima, reverte. O texto fica fixo e legível o tempo todo.
   ---------------------------------------------------------------------------
   initHeroScrub({ hero, reduced, mobile }) — usa gsap/ScrollTrigger globais.
   ========================================================================== */
export function initHeroScrub({ hero, reduced, mobile }) {
  const canvas = hero.querySelector('.hero__canvas');
  const ctx = canvas.getContext('2d');
  // Frames: por caminho (site) ou embutidos como data URIs (arquivo único).
  const embedded = (typeof window !== 'undefined' && Array.isArray(window.__HERO_FRAMES__)) ? window.__HERO_FRAMES__ : null;
  const base = hero.dataset.heroSeq;
  const N = embedded ? embedded.length : (parseInt(hero.dataset.heroFrames, 10) || 96);
  const srcOf = (i) => (embedded ? embedded[i] : base + pad(i) + '.jpg');
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

  // ---- modo estático (reduced-motion / mobile): sem pin, 1 tela ----
  if (reduced || mobile || typeof ScrollTrigger === 'undefined') {
    hero.classList.add('is-static');
    const showFirst = () => draw(0);
    if (imgs[0].complete) showFirst(); else imgs[0].onload = () => { hero.classList.add('seq-ready'); showFirst(); };
    return { destroy() {} };
  }

  // ---- pin + scrub (só o fundo; o texto fica fixo e legível) ----
  const st = ScrollTrigger.create({
    trigger: hero,
    start: 'top top',
    end: () => '+=' + Math.round(window.innerHeight * 1.4),
    pin: hero.querySelector('.hero__pin'),
    pinSpacing: true,
    anticipatePin: 1,
    scrub: 0.5,
    invalidateOnRefresh: true,
    onUpdate(self) {
      const p = self.progress;
      const fi = Math.min(N - 1, Math.max(0, Math.round(p * (N - 1))));
      if (fi !== current) { current = fi; draw(fi); }
    },
  });

  return { destroy() { st.kill(); } };
}
