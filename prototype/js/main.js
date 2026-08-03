/* ============================================================================
   Marguerite — orquestrador do front-end (protótipo Fase 3)
   Responsabilidades separadas em funções puras; nada de conteúdo hardcoded
   além de comportamento. GSAP/ScrollTrigger/Lenis vêm como globais (vendor).
   ========================================================================== */
const REDUCED = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
const DESKTOP = window.matchMedia("(min-width: 1024px)").matches;

document.documentElement.classList.add("is-ready");

/* -------------------------------------------------------------------------
   1. Smooth scroll (Lenis) + ponte com ScrollTrigger
   ------------------------------------------------------------------------- */
let lenis = null;
function initSmoothScroll() {
  if (REDUCED || typeof Lenis === "undefined") return;
  lenis = new Lenis({ lerp: 0.09, wheelMultiplier: 1, smoothWheel: true });
  lenis.on("scroll", () => window.ScrollTrigger && ScrollTrigger.update());
  gsap.ticker.add((t) => lenis.raf(t * 1000));
  gsap.ticker.lagSmoothing(0);
}

/* -------------------------------------------------------------------------
   2. Header: sombra sutil ao descolar (fundo é sempre sólido/claro)
   ------------------------------------------------------------------------- */
function initHeader() {
  const header = document.querySelector(".site-header");
  const onScroll = () => header.classList.toggle("is-stuck", window.scrollY > 40);
  onScroll();
  window.addEventListener("scroll", onScroll, { passive: true });
}

/* -------------------------------------------------------------------------
   3. Scroll-spy da navegação (IntersectionObserver)
   ------------------------------------------------------------------------- */
function initScrollSpy() {
  const links = [...document.querySelectorAll(".nav__link[data-spy]")];
  const map = new Map(links.map((l) => [l.dataset.spy, l]));
  const io = new IntersectionObserver(
    (entries) => {
      entries.forEach((e) => {
        if (!e.isIntersecting) return;
        links.forEach((l) => l.classList.remove("is-active"));
        map.get(e.target.id)?.classList.add("is-active");
      });
    },
    { rootMargin: "-45% 0px -50% 0px" }
  );
  ["sobre", "metodologia", "cases", "clientes"].forEach((id) => {
    const el = document.getElementById(id); if (el) io.observe(el);
  });
}

/* -------------------------------------------------------------------------
   4. Reveals + marcadores + underline da metodologia
   ------------------------------------------------------------------------- */
function initReveals() {
  if (REDUCED || !window.ScrollTrigger) {
    document.querySelectorAll("[data-reveal]").forEach((el) => (el.style.opacity = 1));
    document.querySelectorAll("[data-marker-draw], .metodo__title").forEach((el) => el.classList.add("is-in"));
    return;
  }
  gsap.utils.toArray("[data-reveal]").forEach((el) => {
    gsap.to(el, {
      opacity: 1, y: 0, duration: 0.9, ease: "expo.out",
      scrollTrigger: { trigger: el, start: "top 88%" },
    });
  });
  // stagger nos grupos 01–04 (fromTo com estado final explícito p/ evitar
  // corrida com o reveal genérico — os filhos NÃO usam [data-reveal])
  gsap.utils.toArray(".metodo__grid, .clientes__metrics").forEach((grid) => {
    gsap.fromTo(grid.children,
      { opacity: 0, y: 26 },
      { opacity: 1, y: 0, duration: 0.7, ease: "expo.out", stagger: 0.08,
        scrollTrigger: { trigger: grid, start: "top 82%" } });
  });
  // classes .is-in (marcador desenha / underline anima)
  document.querySelectorAll("[data-marker-draw], .metodo__title").forEach((el) => {
    ScrollTrigger.create({ trigger: el, start: "top 80%", onEnter: () => el.classList.add("is-in") });
  });
}

/* -------------------------------------------------------------------------
   5. Parallax das imagens institucionais
   ------------------------------------------------------------------------- */
function initParallax() {
  if (REDUCED || !window.ScrollTrigger) return;
  gsap.utils.toArray("[data-parallax]").forEach((img) => {
    gsap.fromTo(img, { yPercent: -8 }, {
      yPercent: 8, ease: "none",
      scrollTrigger: { trigger: img, start: "top bottom", end: "bottom top", scrub: true },
    });
  });
}

/* -------------------------------------------------------------------------
   5b. Fluxo de conteúdo — saída sutil (as seções recuam ao sair pelo topo).
   Combinado com os reveals de entrada, dá a sensação de entra-e-sai pedida.
   ------------------------------------------------------------------------- */
function initContentFlow() {
  if (REDUCED || !window.ScrollTrigger) return;
  // Só elementos de topo (eyebrow + título) recuam/desvanecem ao sair pelo topo —
  // nunca o corpo (form, métricas, grid), que permanece legível enquanto visível.
  const targets = gsap.utils.toArray(
    ".metodo__head, .cases__head, .sobre__body, .clientes__manifesto, .contato__title"
  );
  targets.forEach((el) => {
    gsap.to(el, {
      opacity: 0.5, y: -20, ease: "none",
      scrollTrigger: { trigger: el, start: "top 6%", end: "top -12%", scrub: true },
    });
  });
}

/* -------------------------------------------------------------------------
   6. Cases — grid 4-up no desktop (LayoutHOme); scroll horizontal nativo ≤1023.
   Enriquece o scroll nativo com roda vertical→horizontal e teclado (a11y).
   ------------------------------------------------------------------------- */
function initCasesGallery() {
  const track = document.getElementById("cases-track");
  if (!track) return;
  const scrolls = () => track.scrollWidth - track.clientWidth > 4; // só quando há overflow (mobile/tablet)

  track.tabIndex = 0;
  track.setAttribute("aria-label", "Galeria de cases — use as setas para navegar");
  track.addEventListener("keydown", (e) => {
    if (!scrolls()) return;
    const step = track.clientWidth * 0.7;
    if (e.key === "ArrowRight") { track.scrollBy({ left: step, behavior: "smooth" }); e.preventDefault(); }
    if (e.key === "ArrowLeft")  { track.scrollBy({ left: -step, behavior: "smooth" }); e.preventDefault(); }
  });

  // roda vertical → horizontal quando a faixa realmente rola (não intercepta no grid)
  track.addEventListener("wheel", (e) => {
    if (!scrolls()) return;
    const primary = Math.abs(e.deltaY) > Math.abs(e.deltaX) ? e.deltaY : e.deltaX;
    const atStart = track.scrollLeft <= 0 && primary < 0;
    const atEnd = track.scrollLeft >= track.scrollWidth - track.clientWidth - 1 && primary > 0;
    if (atStart || atEnd) return;
    e.preventDefault();
    track.scrollLeft += primary;
  }, { passive: false });
}

/* -------------------------------------------------------------------------
   7. Menu mobile + formulário (UI)
   ------------------------------------------------------------------------- */
function initUI() {
  const toggle = document.querySelector(".nav-toggle");
  const menu = document.getElementById("menu");
  const close = menu.querySelector(".menu-overlay__close");
  const open = (state) => {
    menu.hidden = false;
    requestAnimationFrame(() => menu.classList.toggle("is-open", state));
    toggle.setAttribute("aria-expanded", String(state));
    document.documentElement.classList.toggle("lenis-stopped", state);
    if (lenis) state ? lenis.stop() : lenis.start();
    if (!state) setTimeout(() => (menu.hidden = true), 400);
  };
  toggle.addEventListener("click", () => open(!menu.classList.contains("is-open")));
  close.addEventListener("click", () => open(false));
  menu.querySelectorAll("a").forEach((a) => a.addEventListener("click", () => open(false)));
  window.addEventListener("keydown", (e) => { if (e.key === "Escape" && menu.classList.contains("is-open")) open(false); });

  // âncoras suaves via Lenis
  document.querySelectorAll('a[href^="#"]').forEach((a) => {
    a.addEventListener("click", (e) => {
      const id = a.getAttribute("href");
      if (id.length < 2) return;
      const el = document.querySelector(id);
      if (!el) return;
      e.preventDefault();
      if (lenis) lenis.scrollTo(el, { offset: -10 });
      else el.scrollIntoView({ behavior: REDUCED ? "auto" : "smooth" });
    });
  });

  // formulário (protótipo: sem backend; Fase 4 pluga destino via ACF)
  const form = document.getElementById("contato-form");
  form.addEventListener("submit", (e) => {
    e.preventDefault();
    const btn = form.querySelector(".contato__submit");
    btn.textContent = "Recebido — em breve retornamos ✓";
    btn.disabled = true;
  });
}

/* -------------------------------------------------------------------------
   8. Hero — vídeo full-screen dirigido pelo scroll (frame-sequence pin/scrub)
   ------------------------------------------------------------------------- */
async function initHero() {
  const hero = document.querySelector(".hero");
  if (!hero) return;
  const MOBILE = window.matchMedia("(max-width: 900px)").matches;

  // Entrada do título (independe do scrub): as linhas sobem ao carregar.
  if (!REDUCED && window.gsap) {
    gsap.set(".hero__title .line > span", { yPercent: 110 });
    gsap.set(".hero__sub", { opacity: 0, y: 16 });
    gsap.to(".hero__title .line > span", { yPercent: 0, duration: 1.1, ease: "expo.out", stagger: 0.09, delay: 0.25 });
    gsap.to(".hero__sub", { opacity: 1, y: 0, duration: 0.9, ease: "expo.out", delay: 0.7 });
  }

  try {
    const { initHeroScrub } = await import("./hero-scrub.js");
    initHeroScrub({ hero, reduced: REDUCED, mobile: MOBILE });
  } catch (err) {
    console.warn("[hero] scrub indisponível:", err);
    hero.classList.add("is-static", "seq-ready");
  }
}

/* -------------------------------------------------------------------------
   Boot
   ------------------------------------------------------------------------- */
function boot() {
  if (window.gsap && window.ScrollTrigger) gsap.registerPlugin(ScrollTrigger);
  initSmoothScroll();
  initHeader();
  initScrollSpy();
  initReveals();
  initParallax();
  initContentFlow();
  initCasesGallery();
  initUI();
  initHero();
  if (window.ScrollTrigger) ScrollTrigger.refresh();
}

if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", boot);
else boot();
