# Marguerite — Tema WordPress

Tema premium da **Marguerite — Agência de Experiência**. Converte o protótipo da
Fase 3 num tema WordPress com **blocos Gutenberg via ACF Pro**, **CPTs** e
**tudo editável** — nenhum texto, imagem, vídeo ou seção fica hardcoded.

## Requisitos
- WordPress 6.4+
- PHP 8.0+
- **Advanced Custom Fields PRO** — **opcional**. O tema funciona sem ele (mostra o
  conteúdo-base). O ACF Pro serve para **editar** textos/imagens/vídeos pelo painel.

## Instalação (rápida)
1. *Aparência → Temas → Adicionar novo → Enviar tema* e envie o zip **`marguerite.zip`** (ou extraia a pasta `marguerite/` em `wp-content/themes/`).
2. **Ative** o tema **Marguerite**. **Pronto — a home já aparece completa e correta**, mesmo sem ACF e sem configurar mais nada (o `front-page.php` monta as seções com o conteúdo-base).
3. (Opcional) Para **editar** pelo painel: instale o **ACF Pro**, depois use o menu *Marguerite* (logos/contato/SEO) e edite a página inicial inserindo os blocos "Marguerite" (ou o padrão *Marguerite — Home completa*).
4. (Opcional) Monte o menu em *Aparência → Menus* (posição "Navegação principal") e envie os logos oficiais nas opções.

## Como funciona
- **Blocos** (categoria "Marguerite"), um por seção: `Hero`, `Sobre / 34 anos`, `Metodologia`, `Cases (galeria)`, `Clientes`, `Contato`. Todos editáveis e **reordenáveis** arrastando no editor.
- **Conteúdo-base:** cada bloco tem valores-padrão. Uma home vazia já renderiza a página completa (via o padrão de blocos em `front-page.php`); ao adicionar blocos na página inicial, eles assumem.
- **Realce (marcador amarelo):** em qualquer título, escreva `[mark]trecho[/mark]`.
- **Custom Post Types:**
  - **Cases** (`case`): ficha técnica, O Desafio, A Solução (passos), Resultados, galeria. Alimentam o bloco *Cases* e a página interna (`single-case.php`).
  - **Clientes** (`cliente`): logo + site. Alimentam o marquee do bloco *Clientes* (ordene por *Atributos → Ordem*).
  - **Depoimentos** (`depoimento`): citação, autor, cargo, empresa, foto.
- **Opções globais** (menu *Marguerite*): logos (normal + branco), contato/cidade, redes sociais, texto do CTA, SEO padrão (descrição + imagem OG).
- **SEO técnico** (`inc/seo.php`): `<title>`, meta description, Open Graph, Twitter Cards, canonical e **JSON-LD** (Organization + WebSite na home; CreativeWork nos Cases). Recua automaticamente se Yoast/RankMath estiver ativo.
- **Design system:** tokens em `theme.json` (Global Styles) + `assets/css/tokens.css` (mesma fonte de verdade do protótipo). Cores oficiais do brand guide Dangebel.
- **Animação/performance:** Lenis + GSAP/ScrollTrigger; Three.js (lente roxa) só na home; fontes Poppins woff2 subset com preload; poster do hero como LCP.

## Estrutura
```
marguerite/
├─ style.css, theme.json, functions.php
├─ inc/         (setup, enqueue, cpt, taxonomies, blocks, fields, options, seo, performance, helpers)
├─ blocks/      (hero, sobre, metodologia, cases-gallery, clientes, contato — block.json + render.php)
├─ patterns/    (home.php — padrão "Home completa")
├─ header.php, footer.php, front-page.php, single-case.php, archive-case.php, page.php, index.php, 404.php
└─ assets/      (css, js [gsap/scrolltrigger/lenis/three + app], fonts, img, video)
```

## Notas
- Os 4 logos de clientes (Tegra Guest, Loft, Busco, SKY) e a marca Marguerite acompanham o tema em `assets/img/` como fallback; substitua cadastrando **Clientes** e enviando os logos oficiais nas **Opções**.
- O envio do formulário de contato ainda é só front-end (placeholder); a integração (e-mail/CRM) entra na Fase 5.
- Verificado: 26 arquivos PHP sem erro de sintaxe, todos os blocos renderizam, e a saída bate visualmente com o protótipo aprovado.
