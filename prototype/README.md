# Marguerite — Protótipo Front-end (Fase 3)

Protótipo estático, autoral, da home da Marguerite. Fiel à direção de arte da
Fase 1 e à arquitetura da Fase 2 (`../docs`). Conteúdo é **placeholder** — a
base do CMS que será plugada na Fase 4 (tema WordPress + ACF).

## Como rodar

Precisa ser servido por HTTP (usa ES modules + importmap). Não abra o `file://`.

```bash
cd prototype
python3 -m http.server 8123
# abra http://127.0.0.1:8123
```

> O vídeo do hero é **H.264**. Chromium open-source (headless) não decodifica
> esse codec — use Chrome/Safari/Edge para ver o vídeo animar. Em qualquer
> navegador, o **fallback** (poster com a lente roxa) aparece corretamente.

## Estrutura

```
prototype/
├─ index.html            HTML semântico (1 h1, landmarks, JSON-LD, OG, preload)
├─ css/
│  ├─ tokens.css         design tokens (cor/tipografia/espaço/movimento) — §1 da arquitetura
│  ├─ fonts.css          Poppins (woff2 subset latin)
│  ├─ base.css           reset, utilidades, botões, reveals, reduced-motion
│  └─ sections.css       cada capítulo + responsivo + menu mobile
├─ js/
│  ├─ main.js            orquestrador: Lenis, ScrollTrigger, reveals, spy, header,
│  │                     parallax, galeria de cases, menu, form, boot do hero
│  └─ hero-webgl.js      Three.js: plano + vídeo-textura + shader duotone (lente roxa)
├─ assets/
│  ├─ vendor/            gsap, ScrollTrigger, lenis, three (vendorizados, sem CDN)
│  ├─ fonts/             poppins-*.woff2
│  ├─ video/hero.mp4     vídeo de referência do hero (placeholder editável no CMS)
│  └─ img/               poster (lente roxa), retratos e cases (frames do vídeo — placeholder)
└─ favicon.svg
```

## Decisões de implementação

- **Zero hardcode de conteúdo** já no protótipo: textos/imagens estão no HTML como
  placeholder, prontos para virar campos ACF (mapa em `../docs/02-arquitetura.md` §4.3).
- **Lente roxa** implementada em dois níveis: shader WebGL (luminância → gradiente
  ameixa→mauve) no caminho premium, e duotone CSS (`mix-blend`) no fallback — o
  mesmo look em ambos.
- **Scroll = câmera** no hero: `ScrollTrigger` alimenta `gl.setProgress(0→1)` que
  faz dolly-in, deriva vertical, aprofunda o duotone e desacelera o vídeo.
- **Degradação real, não desligamento:** WebGL só em desktop + suporte a WebGL +
  sem `prefers-reduced-motion`. Fora disso, `<video>`/poster + CSS. Reduced-motion
  mantém todo o conteúdo visível, sem movimento.
- **Acessibilidade:** skip-link, landmarks, foco visível, galeria navegável por
  teclado, menu mobile com `Esc`/`aria-expanded`, vídeo decorativo `aria-hidden`.
- **Performance:** libs vendorizadas, Three.js via `import()` dinâmico (só carrega
  no caminho WebGL), fontes woff2 subset + preload, poster como LCP (`fetchpriority`),
  imagens `lazy`/`async`.

## Verificação

Renderizado no Chromium (Playwright) em 1440×900 e 390×844: **0 erros de página**,
todas as seções e os 4 itens de cada grid visíveis, scroll-spy, galeria horizontal,
menu mobile e formulário funcionais. Screenshots no processo de review da Fase 3.

## Próximo (Fase 4)

Converter cada seção nos blocos ACF descritos em `../docs/02-arquitetura.md`,
mover os tokens para `theme.json`, criar os CPTs (Case/Cliente/Depoimento) e tornar
todo texto/mídia/ordem editável no editor do WordPress.
