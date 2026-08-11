# Tema WordPress — Marguerite Experience

Tema WordPress clássico, de página única, construído a partir do Figma
["Layout 5 — Dangebel / Marguerite"](https://www.figma.com/design/nHRBZjT6lodaFZq06kt0iY/Layout-5-Dangebel---Marguerite).
Animações com [GSAP](https://gsap.com/) (reveal on scroll, marquee de marcas e
carrossel de cases), carregado via CDN.

## Instalação

1. Copie a pasta `marguerite/` inteira para `wp-content/themes/` na sua instalação WordPress.
2. No painel, vá em **Aparência → Temas** e ative "Marguerite Experience".
3. Em **Configurações → Leitura**, defina "Uma página estática" e escolha
   qualquer página como inicial — o tema usa `front-page.php`, que já renderiza
   a página completa independentemente do conteúdo da página escolhida.
4. (Opcional) Em **Aparência → Menus**, crie um menu e atribua-o ao local
   "Menu Principal" caso queira substituir a navegação padrão por âncoras
   (`#sobre`, `#metodologia`, `#executivas`, `#cases`, `#contato`).

## Estrutura

```
marguerite/
├── style.css                  # Cabeçalho do tema (obrigatório pelo WP)
├── functions.php              # Setup, enqueue de CSS/JS (inclui GSAP via CDN)
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
    ├── js/main.js             # GSAP: reveals, marquee, carrossel, menu mobile
    └── img/                   # Logos, fotos e ícones exportados do Figma
```

## Pontos que precisam da sua revisão

- **WhatsApp do CTA final**: o link em `template-parts/section-cta.php` está
  como `https://wa.me/5500000000000` (placeholder). Troque pelo número real.
- **Texto do case "SKY"**: a descrição completa não veio no Figma (texto
  truncado no arquivo de origem). Usei uma frase equivalente ao trecho
  visível — revise em `template-parts/section-portfolio.php`.
- **E-mail no rodapé**: usei `cintia@margueriteexperience.com.br`, conforme o
  nó mais detalhado do Figma (havia uma variante truncada com
  `contato@margueriteexperience.com.` em outra parte do arquivo).
- O carrossel de Portfólio foi implementado com os **3 cases com conteúdo
  completo no Figma** (Tegra Guest, Busco, SKY). Se houver um 4º case, envie
  os textos/imagens que eu adiciono.

## Responsividade

O layout do Figma é desenhado para desktop. Foram adicionados breakpoints
próprios para tablet/mobile (menu hamburguer, grades empilhadas, carrossel
simplificado em tela pequena) mantendo a fidelidade visual no desktop.
