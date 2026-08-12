# Tema WordPress — Marguerite Experience

Tema WordPress clássico, de página única, construído a partir do Figma
["Layout 5 — Dangebel / Marguerite"](https://www.figma.com/design/nHRBZjT6lodaFZq06kt0iY/Layout-5-Dangebel---Marguerite).
Animações com [GSAP](https://gsap.com/) (reveal on scroll, palavras em cascata
nos títulos, parallax no hero, marquee de marcas e carrossel de cases),
carregado via CDN.

**Todo o texto, fotos e alguns liga/desliga da página são editáveis direto
pelo painel do WordPress — ninguém precisa mexer em código para trocar uma
frase, um título ou uma foto.** Veja "Como editar" abaixo.

## Instalação

1. Copie a pasta `marguerite/` inteira para `wp-content/themes/` na sua instalação WordPress.
2. No painel, vá em **Aparência → Temas** e ative "Marguerite Experience".
3. Em **Configurações → Leitura**, defina "Uma página estática" e escolha
   qualquer página como inicial — o tema usa `front-page.php`, que já renderiza
   a página completa independentemente do conteúdo da página escolhida.
4. (Opcional) Em **Aparência → Menus**, crie um menu e atribua-o ao local
   "Menu Principal" caso queira um menu diferente das âncoras padrão
   (`#sobre`, `#metodologia`, `#executivas`, `#cases`, `#contato`).

## Como editar textos, fotos e links (sem programar)

Vá em **Aparência → Personalizar**. O painel mostra uma prévia da página à
direita e, à esquerda, os grupos de campos — cada mudança pode ser conferida
na prévia antes de clicar em **Publicar**:

- **Cabeçalho e Menu** — texto de cada link do menu e do botão "Agende uma Reunião".
- **Topo da Página (Hero)** — etiqueta, título, parágrafo e botão.
- **Quem Somos** — etiqueta, título, parágrafo e as 3 palavras-chave (uma por linha).
- **Metodologia (4 cards)** — um painel com uma seção por card (título + texto).
- **Profissionais (equipe)** — um painel com uma seção por pessoa: nome, cargo,
  bio, foto, e um **checkbox "Mostrar foto no card?"** para exibir ou esconder
  a foto sem apagar nada (é assim que a foto da Cíntia foi desativada por
  enquanto — quando for hora de mostrar, é só marcar a caixinha e publicar).
- **Portfólio (cases)** — um painel com uma seção por case (SKY, Loft, Tegra
  Guest, Busco): etiqueta, categoria, título, descrição, informações (uma por
  linha — cada linha vira um item separado por "·" no card) e foto de fundo
  opcional. Tem também uma seção "Marcas" para a lista que roda no rodapé do
  carrossel.
- **Fale Conosco** — título, parágrafo e o botão do WhatsApp (**é aqui que
  se troca o número real**, hoje está com um link de exemplo
  `https://wa.me/5500000000000`).
- **Rodapé** — cidade/UF, e-mail de contato e o texto de direitos autorais
  (o ano é preenchido sozinho).

**Dica do negrito/destaque:** nos campos de texto maiores, envolva um trecho
com `**dois asteriscos**` para deixá-lo em negrito (ou, no título do Hero,
para deixá-lo na cor lilás de destaque) — por exemplo:
`Experiências memoráveis são planejadas, desenhadas e **conduzidas**.`

Todo campo tem um valor padrão (o conteúdo atual do site) — nada muda até
alguém realmente editar e clicar em **Publicar** no Personalizador.

## Estrutura

```
marguerite/
├── style.css                  # Cabeçalho do tema (obrigatório pelo WP)
├── functions.php              # Setup, enqueue de CSS/JS (inclui GSAP via CDN)
├── inc/
│   └── customizer.php         # Todos os campos editáveis do Personalizar
├── header.php / footer.php
├── front-page.php             # Monta a página única a partir das seções
├── index.php                  # Fallback exigido pela hierarquia do WP
├── template-parts/
│   ├── section-hero.php
│   ├── section-quem-somos.php
│   ├── section-metodologia.php
│   ├── section-profissionais.php
│   ├── section-portfolio.php  # Carrossel de cases + marquee de marcas
│   └── section-cta.php
└── assets/
    ├── css/style.css          # Estilos (design tokens, layout, componentes)
    ├── js/main.js             # GSAP: reveals, parallax, marquee, carrossel, menu mobile
    └── img/                   # Logos, fotos e ícones exportados do Figma (valores padrão)
```

## Pontos que ainda merecem uma olhada

- **WhatsApp do CTA final**: ainda está com o link de exemplo
  `https://wa.me/5500000000000`. Troque em **Personalizar → Fale Conosco**
  pelo número real (sem precisar mexer em código).
- O carrossel de Portfólio tem os **4 cases com o conteúdo que a Cíntia
  passou** (SKY, Loft, Tegra Guest, Busco). Qualquer ajuste de texto agora é
  feito direto em **Personalizar → Portfólio (cases)**.

## Responsividade

O layout do Figma é desenhado para desktop. Foram adicionados breakpoints
próprios para tablet/mobile (menu hamburguer, grades empilhadas, tags do
"Quem Somos" empilhadas em linhas distintas, carrossel simplificado em tela
pequena) mantendo a fidelidade visual no desktop.
