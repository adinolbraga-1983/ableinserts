# Fase 2 — Arquitetura

**Projeto:** Marguerite — Agência de Experiência (Dangebel Maison)
**Squad ativado:** UX/UI Designer, WordPress Theme Architect, SEO Specialist, Motion Designer, Front-end Engineer
**Base de decisão:** Fase 1 validada + 3 respostas do cliente:
1. Tipografia → **Poppins** (fiel à marca).
2. Copy → **placeholder**; é a base do CMS → **regra de ouro: nada hardcoded**.
3. Scroll → **pode ir cheio (WebGL/Three.js)**, preservando a **"lente roxa"** (duotone ameixa sobre a imagem do hero da Home).

---

## 0. Princípios que governam toda a arquitetura

1. **Zero hardcode.** Cada string, imagem, vídeo, cor de destaque e a própria ordem das seções vêm do CMS (ACF + Gutenberg). O tema nunca imprime texto fixo; imprime o que o editor cadastrou, com fallback.
2. **Um acento por seção.** O verde-limão `#E9EF89` é o único acento vivo; usado como "marcador" em no máximo 1 elemento por seção (regra herdada da análise, evita poluição).
3. **Cor é recompensa.** Base quase-monocromática (ameixa + off-white). Saturação real só entra via fotografia de evento nos Cases — nunca como cor de UI.
4. **Movimento serve à leitura.** Estático onde há texto para ler; cinético só nas transições entre capítulos (mapeado do vídeo).
5. **Desktop-first, mas nada quebra.** Animações são *adaptadas* em telas menores, não desligadas; `prefers-reduced-motion` corta movimento sem cortar conteúdo.

---

## 1. Design System — Tokens definitivos

Tokens em CSS Custom Properties (camada única de verdade, consumida tanto pelo protótipo quanto pelo `theme.json`/Global Styles do WordPress na Fase 4).

### 1.1 Cor

```css
:root {
  /* Base — ameixa / aubergine (escuros) */
  --c-ink-900: #1D010E;  /* footer, o mais profundo */
  --c-ink-800: #2C1F2A;  /* sombra do duotone hero */
  --c-ink-700: #3A2837;  /* faixa Clientes, blocos escuros */
  --c-ink-600: #665761;  /* ameixa média (texto sobre claro secundário) */

  /* Base — off-white (claros) */
  --c-paper-000: #FDFDFD; /* header, base clara */
  --c-paper-100: #F6EFEB; /* off-white quente, seções de respiro */
  --c-paper-200: #E9D8CC; /* borda/divisor sobre claro */

  /* Acento — único vivo */
  --c-marker: #E9EF89;    /* verde-limão "marcador" */
  --c-marker-ink: #2C1F2A;/* texto sobre o marcador */

  /* Duotone — LENTE ROXA (hero) */
  --duo-hero-shadow: #2C1F2A;
  --duo-hero-light:  #6A5B64;

  /* Duotone — terracota (retratos institucionais, "34 anos") */
  --duo-warm-shadow: #98460D;
  --duo-warm-light:  #D8B9A3;

  /* Semânticos */
  --bg:        var(--c-paper-000);
  --bg-alt:    var(--c-paper-100);
  --bg-invert: var(--c-ink-700);
  --fg:        var(--c-ink-800);
  --fg-muted:  var(--c-ink-600);
  --fg-invert: var(--c-paper-000);
  --line:      color-mix(in srgb, var(--c-ink-800) 12%, transparent);
  --accent:    var(--c-marker);
  --focus:     #6A5B64; /* anel de foco visível em ambos os fundos */
}
```

Contraste verificado (WCAG AA): `--fg`(#2C1F2A) sobre `--bg`(#FDFDFD) ≈ 15:1; `--fg-invert` sobre `--bg-invert`(#3A2837) ≈ 9:1; marcador é usado só como *background de realce* atrás de texto escuro, nunca como texto.

### 1.2 Tipografia — Poppins

```css
:root {
  --font-sans: "Poppins", system-ui, -apple-system, "Segoe UI", sans-serif;

  /* Escala fluida (clamp) — desktop-first, colapsa suave */
  --step--1: clamp(0.83rem, 0.78rem + 0.24vw, 0.95rem);   /* micro / eyebrow */
  --step-0:  clamp(1.00rem, 0.94rem + 0.30vw, 1.18rem);   /* corpo */
  --step-1:  clamp(1.33rem, 1.16rem + 0.85vw, 1.90rem);   /* subtítulo */
  --step-2:  clamp(1.78rem, 1.35rem + 2.10vw, 3.05rem);   /* H3 */
  --step-3:  clamp(2.37rem, 1.55rem + 4.10vw, 4.88rem);   /* H2 seção */
  --step-4:  clamp(3.16rem, 1.40rem + 8.80vw, 7.80rem);   /* Hero display */

  --w-hair: 200; --w-light: 300; --w-reg: 400; --w-med: 500;
  --w-semi: 600; --w-bold: 700; --w-xbold: 800; --w-black: 900;

  --lh-tight: 0.98;  /* headlines gigantes */
  --lh-snug:  1.12;
  --lh-body:  1.55;
  --tracking-display: -0.02em; /* Poppins grande pede tracking negativo */
  --tracking-eyebrow: 0.16em;  /* eyebrows/labels em caixa alta */
}
```

Regras de uso: **Hero display** = `--step-4` peso `--w-med`(500), tracking negativo, `--lh-tight`; **H2 de seção** = `--step-3` peso 500; **eyebrow/label** = `--step--1` peso 600 caixa alta com `--tracking-eyebrow`; **corpo** = `--step-0` peso 400 `--lh-body`. O peso Black/ExtraBold fica reservado a números grandes (01–04) e ao wordmark.

### 1.3 Espaço, ritmo e grid

```css
:root {
  --space-3xs: 4px; --space-2xs: 8px; --space-xs: 12px;
  --space-s: 16px;  --space-m: 24px;  --space-l: 40px;
  --space-xl: 64px; --space-2xl: 96px; --space-3xl: 160px; --space-4xl: 240px;

  --container: 1440px;      /* largura máx do conteúdo */
  --container-text: 68ch;   /* medida de leitura confortável */
  --gutter: clamp(20px, 4vw, 80px);
  --grid-cols: 12;
  --radius-s: 6px; --radius-m: 12px; --radius-pill: 999px;
  --section-pad: clamp(72px, 12vh, 200px); /* respiro vertical entre capítulos */
}
```

Grid de 12 colunas, gutters fluidos. Seções full-bleed (hero, 34 anos, cases, clientes, footer) escapam do container; blocos de texto respeitam `--container-text`.

### 1.4 Movimento (tokens)

```css
:root {
  --ease-out-expo: cubic-bezier(0.16, 1, 0.3, 1);   /* revelações */
  --ease-in-out:   cubic-bezier(0.65, 0, 0.35, 1);  /* transições de câmera */
  --dur-fast: 240ms; --dur-med: 560ms; --dur-slow: 900ms; --dur-cine: 1400ms;
  --lenis-lerp: 0.09;   /* suavidade do smooth-scroll */
  --stagger: 80ms;      /* atraso entre elementos irmãos */
}
```

### 1.5 Elevação e efeitos

Sombras quase inexistentes (design plano/editorial). Profundidade é criada por **camadas e paralaxe**, não por drop-shadows. Único uso de sombra: card circular "abrir case" e o header ao descolar do topo (`0 1px 0 var(--line)`).

---

## 2. Arquitetura de Informação (IA)

### 2.1 Mapa do site

```
/                         Home (single-page com âncoras + capítulos)
/sobre                    (opcional: expansão do "34 anos")
/cases                    Arquivo de Cases (grid de exposição)
/cases/{slug}             Case individual (template Interna)
/contato                  (âncora #contato na home; página própria opcional)
/politica-privacidade     Legal
/{sitemap.xml, robots.txt, feed}
```

A Home é a espinha narrativa. Cada seção é um "capítulo" com âncora (`#sobre`, `#metodologia`, `#cases`, `#clientes`, `#contato`) para a nav.

### 2.2 Navegação
- **Header** persistente, translúcido→sólido ao descolar. Nav: Sobre · Metodologia · Cases · Clientes + CTA "Agende uma reunião". Item ativo por `IntersectionObserver` (scroll-spy).
- **Skip-link** "Pular para o conteúdo" (a11y).
- Mobile: menu overlay full-screen, tipografia grande, mesmo CTA fixo.

### 2.3 Sequência de capítulos (mapeada ao roteiro do vídeo)

| # | Capítulo | Plano do vídeo correspondente | Registro |
|---|---|---|---|
| 1 | Hero | caderno/esboço + render 3D | Ideia (estático→cinético) |
| 2 | Quem somos / 34 anos | coordenadora (humano) | Método (leitura) |
| 3 | Metodologia (01–04) | montagem do palco cru | Processo |
| 4 | Cases | palco completo saturado | Prova (clímax) |
| 5 | Clientes + métricas | a reverência | Confiança |
| 6 | Contato | retorno ao caderno em branco | Convite (loop) |
| — | Footer | — | — |

---

## 3. Wireframes ASCII

### 3.1 Home

```
┌───────────────────────────────────────────────────────────────┐
│ ⬡ marguerite      Sobre  Metodologia  Cases  Clientes   AGENDE │  header (fixo)
├───────────────────────────────────────────────────────────────┤
│                                                               │
│  ██ VÍDEO HERO (duotone LENTE ROXA, scrub por scroll) ██      │
│                                                               │
│  Experiências                                                 │  H1 display
│  memoráveis não                                               │  (step-4, 3 linhas)
│  acontecem.                                                   │
│  ▓São Conduzidas▓   ← realce marcador (único acento)          │
│  agência boutique de eventos e marketing de experiência       │  sub
│                                       Início · Como conduzimos │  micro-breadcrumb
├───────────────────────────────────────────────────────────────┤
│ ░░ FOTO DUOTONE TERRACOTA (retrato) ░░ full-bleed              │
│  SOBRE                                                         │  eyebrow
│  Trinta e quatro anos                                         │  H2
│  de mercado moram aqui.                                       │
│  [parágrafo institucional ......................]            │
│  • Projetos Corporativos • Experiências Imersivas • Marcas    │  lista serviços
│  Conheça a método →                                          │  CTA texto
├───────────────────────────────────────────────────────────────┤
│  METODOLOGIA                                                   │  (bg claro)
│  O sucesso é alcançado                                        │  H2 que "completa"
│  em quatro ────────────────────────────────────────           │   nos números ↓
│  01            02            03            04                 │
│  Atendimento   Inovação e    Engajamento   Resultados        │
│  Personalizado Criatividade  Memorável     Analíticos        │
│  [parágrafo de fechamento .............................]      │
├───────────────────────────────────────────────────────────────┤
│  CASES                              Ver todos →               │
│  Projetos conduzidos por nossas executivas                    │
│  ┌────────┐ ┌────────┐ ┌────────┐ ┌────────┐   ▶ (arrasta)    │  galeria horizontal
│  │ SKY    │ │TEGRA   │ │ neon   │ │TEGRA   │                 │  fotografia plena
│  │ ●abrir │ │ ●abrir │ │ ●abrir │ │ ●abrir │                 │
│  └────────┘ └────────┘ └────────┘ └────────┘                 │
│   legenda    legenda    legenda    legenda                    │  nome · nº · cidade
├───────────────────────────────────────────────────────────────┤
│ ▓▓▓▓▓▓▓▓ CLIENTES (faixa ameixa escura) ▓▓▓▓▓▓▓▓              │
│      logo   logo   logo   logo   logo   logo                  │  wordmarks mono
│  Criamos experiências que geram ▓conexões reais▓ ...          │  manifesto
│  01 Estratégia  02 Confiança  03 Budget  04 Excelência        │  métricas/valores
├───────────────────────────────────────────────────────────────┤
│  CONTATO                                                      │
│  Vamos conversar sobre                                       │  H2
│  ▓o seu próximo projeto▓                                      │  realce marcador
│  [ Nome ]  [ Empresa ]  [ WhatsApp ]     Iniciar conversa →   │  form (3 campos)
│  Sem lead scoring, apenas uma conversa.                       │  microcopy
├───────────────────────────────────────────────────────────────┤
│ ⬡ marguerite   contato@… · São Paulo/SP · LinkedIn · ©        │  footer ameixa 900
└───────────────────────────────────────────────────────────────┘
```

### 3.2 Case (Interna)

```
┌───────────────────────────────────────────────────────────────┐
│ ⬡ marguerite      Sobre  Metodologia  Cases  Clientes   AGENDE │
├───────────────────────────────────────────────────────────────┤
│ ██████ FOTO/VÍDEO DO EVENTO (full-bleed, cinematográfico) █████│
│                                                               │
│  CASES                                                        │  cartela (canto ↙)
│  Convenção SKY 2025                                           │  título grande
├───────────────────────────────────────────────────────────────┤
│  Gestão e Execução de Evento Corporativo                     │  ficha técnica
│  Dimensão: 980 Pessoas | Iberostar Selection                 │  (masthead editorial)
│  Praia do Forte — Salvador/BA                                │
│                                                               │
│  O Desafio                                                   │  H2
│  [texto longo ...........................................]    │
│                                                               │
│  A Solução: Nosso Fluxo na Prática                           │  H2
│  1. Diálogo Direto e Zero Barreiras Logísticas               │  subtítulos num.
│     [texto ...]                                              │
│  2. Construção Conjunta da Experiência                       │
│  3. Integração e Controle Operacional                        │
│                                                               │
│  [ Resultado / métricas do case ]                            │  (bloco CMS opcional)
├───────────────────────────────────────────────────────────────┤
│  Outros cases  ┌──┐┌──┐┌──┐┌──┐   Ver todos →                │  reaproveita galeria
├───────────────────────────────────────────────────────────────┤
│  CLIENTES + footer (blocos globais reutilizados)             │
└───────────────────────────────────────────────────────────────┘
```

---

## 4. Arquitetura WordPress (Theme Architect)

Tema **block-based híbrido** (FSE onde ajuda + PHP templates onde precisa de controle). ACF Pro para campos ricos; blocos ACF nativos para os módulos autorais; CPTs para conteúdo repetível.

### 4.1 Estrutura de diretórios do tema

```
marguerite/
├─ style.css                 (cabeçalho do tema)
├─ theme.json                (Global Styles ← espelha tokens da seção 1)
├─ functions.php             (bootstrap: enqueue, supports, registros)
├─ inc/
│  ├─ setup.php              (theme supports, menus, image sizes)
│  ├─ enqueue.php            (assets, defer, preload de fontes/vídeo)
│  ├─ cpt.php                (CPTs: case, cliente, depoimento)
│  ├─ taxonomies.php         (tipo-de-projeto, segmento)
│  ├─ acf/                   (field groups em JSON — acf-json/ versionado)
│  ├─ blocks.php             (registro dos blocos ACF)
│  ├─ seo.php                (JSON-LD, OG, meta dinâmicas, breadcrumbs)
│  └─ performance.php        (lazy, preconnect, critical CSS inline)
├─ blocks/                   (1 pasta por bloco: block.json + render.php + view.js)
│  ├─ hero/
│  ├─ sobre/
│  ├─ metodologia/
│  ├─ cases-gallery/
│  ├─ clientes/
│  ├─ contato/
│  └─ case-body/
├─ templates/                (FSE: front-page, single-case, archive-case, 404)
├─ parts/                    (header, footer, chapter-nav)
├─ patterns/                 (patterns pré-montados para o editor)
├─ src/                      (JS/CSS fonte → build)
│  ├─ js/ (lenis.js, scroll.js, hero-webgl.js, gallery.js, form.js, a11y.js)
│  └─ scss/ (tokens, base, components, sections)
└─ assets/ (fonts/, img/, video/)
```

### 4.2 Custom Post Types

| CPT | Slug | Uso | Campos-chave (ACF) |
|---|---|---|---|
| **Case** | `case` | Projetos/estudos de caso | hero_media (img/vídeo), ficha (tipo, dimensão, local), desafio (WYSIWYG), solução (repeater de blocos numerados), resultado (repeater métrica+valor), galeria, seo_override |
| **Cliente** | `cliente` | Logos de clientes | logo (mono), logo_white, url, ordem |
| **Depoimento** | `depoimento` | Depoimentos | quote, autor, cargo, empresa (rel. cliente), foto |

CPTs com `show_in_rest: true` (Gutenberg + headless-ready), `menu_icon`, `supports` mínimos (title + editor só onde faz sentido; o resto é ACF).

### 4.3 Blocos (todos ACF, `render.php` + `view.js`)

Cada bloco = 1 capítulo. Todos os textos/mídias são **campos ACF** — nada hardcoded. Ordem das seções na home é editável arrastando os blocos no editor (ou via um campo `flexible_content` "Seções" no template front-page).

| Bloco | Campos editáveis (resumo) | Nota de animação |
|---|---|---|
| `hero` | eyebrow, headline (com marcação de realce), sub, vídeo (mp4/webm/poster), toggle duotone-lente-roxa, breadcrumb | scrub de vídeo + reveal em camadas |
| `sobre` | eyebrow, headline, texto, lista de serviços (repeater), CTA (texto+link), imagem duotone terracota | parallax da imagem, split-reveal do texto |
| `metodologia` | eyebrow, headline (parte 1 + palavra-âncora), itens 01–04 (repeater: num, título), texto de fechamento | contagem/underline anima ao entrar; stagger dos 4 |
| `cases-gallery` | fonte (CPT `case` — query), CTA "ver todos", nº de itens | scroll horizontal (drag + wheel), inércia |
| `clientes` | manifesto (com realce), fonte de logos (CPT `cliente`), métricas (repeater num+título), cor de fundo | marquee sutil dos logos, reveal métricas |
| `contato` | headline (com realce), campos do form (config), microcopy, destino (email/CRM/webhook) | reveal + foco animado nos inputs |
| `case-body` | (contexto single-case) puxa ficha/desafio/solução/resultado do CPT | sticky do título, reveal por parágrafo |

### 4.4 Editabilidade global (Customizer / theme settings via ACF Options)
Página de opções ACF "Marguerite" com: identidade (logo, logo-white, monograma), cores de marca (sobrescrevem tokens), contatos/redes, SEO padrão (título, descrição, OG default), scripts (GA4/pixel), toggles de performance/movimento. Menus e widgets nativos do WP.

### 4.5 Fluxo de dados (separação de responsabilidades — SOLID na prática)
```
CMS (ACF/CPT)  →  render.php (só apresentação, escapa saída)  →  HTML semântico
                       │
                       └─ data-* atributos  →  view.js (só comportamento/animação)
tokens (theme.json + CSS vars)  →  estilo (SCSS)   [UI isolada de lógica e dados]
seo.php  →  <head> (JSON-LD/OG/meta)               [SEO isolado da view]
```

---

## 5. Arquitetura SEO (SEO Specialist)

### 5.1 On-page / semântica
- **1 `<h1>` por página** (hero da home; título do case na interna). Hierarquia h2→h3 sem pular níveis.
- HTML5 semântico: `<header> <main> <article> <section aria-labelledby> <figure> <figcaption> <footer>`.
- URLs limpas: `/cases/convencao-sky-2025`. Sem parâmetros. Trailing-slash consistente.
- Breadcrumbs visíveis + `BreadcrumbList` JSON-LD.

### 5.2 Dados estruturados (JSON-LD, gerados em `seo.php`)
- Home: `Organization` + `WebSite` (com `SearchAction` se houver busca) + `LocalBusiness` (São Paulo/SP).
- Case: `CreativeWork`/`Article` (nome, imagem, descrição, autor=Organization, sobre o cliente).
- Depoimentos → `Review`/`aggregateRating` quando aplicável.

### 5.3 Meta dinâmicas & social
- `<title>` e `meta[description]` por página, com override ACF por Case.
- Open Graph completo + Twitter Cards (`summary_large_image`), imagem OG gerada/definida por página.
- `canonical` autorreferente; `hreflang` pt-BR (single-locale por ora, mas preparado).

### 5.4 Técnico / crawl
- `sitemap.xml` (nativo do WP 5.5+ estendido para incluir CPT `case`), `robots.txt` com allow + link do sitemap.
- `<link rel="preload">` para a fonte crítica (Poppins subset) e o poster do vídeo; `preconnect` a origens de mídia; `prefetch` das rotas de Case ao hover na galeria.
- `loading="lazy"` + `decoding="async"` em toda imagem abaixo da dobra; `fetchpriority="high"` no LCP (poster do hero).
- Feed RSS mantido; 404 útil; redirects 301 preservados via plugin/tabela.

---

## 6. Definição de animações (Motion Designer)

Stack: **Lenis** (smooth-scroll) + **GSAP + ScrollTrigger** (coreografia) + **Three.js/WebGL só no hero** (câmera 3D + shader duotone da lente roxa). Tudo atrás de `prefers-reduced-motion`.

| Momento | Técnica | Detalhe |
|---|---|---|
| Hero — plano de fundo | Three.js plane com **vídeo como textura** + **shader duotone** (mapeia luminância → gradiente `--duo-hero-shadow`→`--duo-hero-light` = a "lente roxa") | scroll faz *scrub* do tempo do vídeo e move a câmera (dolly + leve parallax de profundidade); texto entra entre planos (z-layers) |
| Hero — texto | GSAP split (linhas) + clip-path reveal | realce "marcador" desenha da esquerda p/ direita |
| 34 anos | ScrollTrigger parallax na imagem (y translate ~12%) + reveal do texto por máscara | imagem "respira" mais devagar que o texto |
| Metodologia | underline da palavra-âncora anima (scaleX) + stagger dos 01–04 | números sobem com `--ease-out-expo`, stagger `--stagger` |
| Cases | scroll horizontal com inércia (wheel+drag), snap suave; card cresce levemente no foco; **transição cinematográfica** ao abrir (FLIP: card → hero da interna, cross-fade de ambiente) | herda o "clímax" saturado do vídeo |
| Clientes | marquee lento dos logos (pausa no hover) + reveal das 4 métricas | movimento contido (registro "confiança") |
| Contato | reveal + realce; foco anima o rótulo (float label) | |
| Global | header sólida ao descolar; scroll-spy da nav; progress sutil | |

**Fallbacks:** sem WebGL → hero vira `<video>` com overlay CSS duotone (mesma lente roxa via `mix-blend` + gradiente). Reduced-motion → sem scrub/parallax; conteúdo aparece com fade curto; scroll nativo.

---

## 7. Inventário de componentes (UI)

Átomos → moléculas → organismos (feeds do WordPress como blocos):

- **Átomos:** Button (primário/ghost/texto-sublinhado), Eyebrow, Tag, NumberedIndex (01–04), MarkerHighlight, Field (input flutuante), Logo/Monograma, IconArrow, PlayCircle.
- **Moléculas:** NavBar + NavItem (scroll-spy), CaseCard (imagem+legenda+PlayCircle), ClientLogo, MetricItem, ServiceListItem, TechSheet (ficha do case), FormRow.
- **Organismos (= blocos):** Header, HeroCinematic, SobreDuotone, MetodologiaGrid, CasesGallery, ClientesBand, ContatoForm, CaseBody, Footer.

Cada componente terá: markup semântico (render.php), estilo por token (SCSS), comportamento isolado (view.js), e estados de foco/hover/reduced-motion.

---

## 8. Responsividade (breakpoints)

Desktop-first; degradação planejada:

| Faixa | Largura | Adaptações |
|---|---|---|
| Desktop | ≥1280px | experiência plena (WebGL, horizontal cases, parallax) |
| Notebook | 1024–1279 | escala tipográfica reduz via clamp; câmera hero mais discreta |
| Tablet | 768–1023 | cases viram scroll-snap horizontal simples (sem WebGL pesado); grid 12→8 |
| Mobile | <768 | hero = vídeo/poster com overlay CSS (sem Three.js); seções empilham; nav overlay; animações = fades curtos + parallax leve |

---

## 9. Acessibilidade (baseline obrigatório)

- Landmarks + skip-link; ordem de foco lógica; foco visível (`--focus`).
- Navegação por teclado em nav, galeria (setas), form e menu mobile.
- `prefers-reduced-motion`: corta scrub/parallax/marquee; mantém conteúdo.
- Contraste AA (verificado na seção 1.1); marcador nunca como texto.
- `alt` inteligente (vem do CMS por imagem; fallback do título do case); vídeo do hero é decorativo (`aria-hidden`, sem áudio autoplay) com conteúdo textual equivalente ao lado.
- Form com `<label>` associado, `aria-describedby` para microcopy, estados de erro anunciados.

---

## 10. Performance — orçamento (Performance Engineer)

Meta Lighthouse ≥95 nas 4 categorias.

- **JS:** GSAP+ScrollTrigger (~40kb gz) + Lenis (~3kb) + Three.js **só na home** e **code-split/dynamic import** após `load` e só se `matchMedia` desktop + WebGL disponível. Interna/Case não carrega Three.js.
- **CSS:** critical inline no `<head>`; resto deferido. Sem framework CSS.
- **Fontes:** Poppins **subsetada** (latin + pt-BR glyphs) em woff2, `font-display: swap`, preload só dos 2 pesos do above-the-fold (400/500).
- **Mídia:** vídeo hero em H.264 **+ webm/AV1**, poster leve como LCP (`fetchpriority=high`), `preload=metadata`; imagens em WebP/AVIF responsivo (`srcset`/`sizes`), lazy abaixo da dobra.
- **Entrega:** cache longo + hash nos assets; sem render-blocking; DOM enxuto por bloco.

---

## 11. Faseamento restante

- **Fase 3 (próxima):** protótipo front-end estático fiel a esta arquitetura (HTML semântico + SCSS por tokens + GSAP/Lenis + hero WebGL com lente roxa), com **conteúdo placeholder** (é a base do CMS). Serve para validar a experiência antes de "wordpressar".
- **Fase 4:** conversão para o tema (blocos ACF, CPTs, theme.json, opções globais) — cada string/mídia vira campo.
- **Fase 5:** auditoria CWV + SEO técnico + a11y.

**Ponto de decisão antes da Fase 3:** confirma que a sequência de capítulos (seção 2.3) e a estrutura dos blocos (4.3) estão certas? Se sim, começo o protótipo pela **Home** (hero + lente roxa primeiro, por ser o elemento de maior risco técnico).
