# Fase 1 — Descoberta & Análise Criativa

**Projeto:** Marguerite — Agência de Experiência (Dangebel Maison)
**Squad ativado neste documento:** Creative Director, UX/UI Designer, Motion Designer, SEO Specialist
**Status:** aguardando validação para iniciar a Fase 2 (Arquitetura)

Este documento cobre os itens 1–6 do processo obrigatório: análise das imagens, análise do vídeo, conceito criativo, direção de arte e moodboard. Design System (tokens finais), arquitetura WordPress/SEO, animações plano-a-plano, wireframes ASCII e definição de componentes ficam para a **Fase 2**, conforme o faseamento pedido — não faz sentido travar decisões de arquitetura antes de validar o conceito.

---

## 1. Referências recebidas

| Arquivo | Papel |
|---|---|
| `LayoutHOme.png` | Layout de referência da Home (3749×8000) |
| `LayoutInternas.png` | Layout de referência de página interna — Case (3840×6724) |
| `Technical_script_for_hero_video...mp4` | Vídeo de referência de movimento — 10s, 1920×1080, 24fps, H.264 + áudio |

Importante: os layouts são **referência estrutural e de conteúdo**, não de pixel a ser clonado — meu mandato aqui é recriar com princípios de design premium, não copiar. O texto (copy) presente nas imagens é o texto real a ser usado.

---

## 2. Análise dos layouts (Home + Interna)

### 2.1 O que já existe de marca (não é greenfield)
A Marguerite já tem uma identidade rodando: monograma circular em terracota, wordmark minúsculo "marguerite", tagline "agência de experiência". Isso muda o approach — não estamos inventando uma marca do zero, estamos **elevando a execução digital** de uma marca que já tem ponto de vista.

### 2.2 Estrutura observada (Home)
1. **Header** — fixo, fundo quase-branco, logo à esquerda, nav central (Sobre / Metodologia / Cases / Clientes), CTA sublinhado "AGENDE UMA REUNIÃO" à direita. Nenhuma decoração — puro utilitário.
2. **Hero** — foto duotone em ameixa escura (mãos escrevendo/esboçando em tablet), headline gigante quebrada em 3 linhas: "Experiências memoráveis não acontecem." + "São Conduzidas" com destaque em marcador (verde-limão). Subheadline curta. Micro-label tipo breadcrumb no rodapé da seção.
3. **"34 anos"** — foto duotone terracota (retrato executivo), bloco de texto à esquerda com eyebrow, headline, parágrafo, lista de 3 serviços, CTA em texto.
4. **Metodologia** — fundo claro, headline que **termina** nas 4 colunas numeradas (01–04), truque tipográfico interessante: a frase "O sucesso é alcançado em quatro [passos]" só se completa quando o olho lê os números.
5. **Cases** — carrossel horizontal de 4 peças fotográficas grandes (fotografia de evento real: convenção SKY, ativação Tegra.Guest, palco com neon), cada uma com legenda (nome do projeto + meta: nº pessoas · papel · cidade) e um botão circular de "abrir".
6. **Clientes** — faixa escura full-bleed, wordmarks de clientes em mono, seguida de uma frase-manifesto com "conexões reais" em destaque e 4 métricas/valores numerados.
7. **Contato** — formulário simples (Nome, Empresa, WhatsApp), microcopy humana ("Sem lead scoring, apenas uma conversa"), headline em duas linhas com destaque em marcador na segunda.
8. **Footer** — escuro, minimal, logo + links legais.

### 2.3 Estrutura observada (Interna — Case)
- Mesmo header, item de nav ativo sublinhado.
- Hero full-bleed com a foto do evento e um **card de título estilo cartela de filme** (eyebrow "Cases" + título grande) ancorado no canto inferior esquerdo sobre a imagem.
- Ficha técnica editorial logo abaixo: tipo de projeto / dimensão / local — como um "masthead" de reportagem, não um bullet de marketing.
- Corpo de texto longo e substancial: "O Desafio" → "A Solução: Nosso Fluxo na Prática" com 3 subseções numeradas em negrito. Isso é diferencial real: **copy de estudo de caso genuíno**, não enfeite.
- Reaproveita os módulos globais (Cases carrossel, Clientes, footer) — confirma que esses blocos devem ser componentes reutilizáveis no Design System / WordPress (blocos Gutenberg).

### 2.4 Paleta extraída por amostragem de pixel (não estimada — lida direto dos PNGs)

| Uso | Hex aproximado | Observação |
|---|---|---|
| Base clara / header | `#FDFDFD` | quase-branco, não branco puro |
| Bloco claro alternativo | `#F6EFEB` | off-white quente, usado em seções de respiro |
| Ameixa/aubergine (overlay do hero, seção "34 anos" tem variação terracota) | `#3A2837` | cor de marca dominante nos blocos escuros |
| Vinho quase-preto (footer) | `#1D010E` | mais escuro que o "Clientes", reforça hierarquia de profundidade |
| Destaque "marcador" (highlight de texto) | `#E9EF89` | verde-limão/chartreuse, não amarelo puro — é o único acento vivo do sistema |
| Duotone terracota (seção "34 anos") | tons de `#BF8C69` sobre a base ameixa | fotografia tratada, não cor sólida |

**Leitura:** paleta quase monocromática (ameixa escura + off-white) com **um único acento vivo** (o verde-limão do marcador) usado com extrema economia — só em 2 pontos da home inteira. Isso é uma pista de direção de arte muito forte: o acento marca literalmente "onde olhar primeiro" em cada seção, e deve continuar restrito a 1 elemento por seção no site novo.

### 2.5 Tipografia — achado importante
A pasta de design system já enviada em anexo em conversa anterior (`_ds/.../assets/fonts/`) contém a família **Poppins completa** (Black, Bold, ExtraBold, ExtraLight, Italic, Light, Medium, Regular, SemiBold) — geometric sans, cantos levemente arredondados, o que bate exatamente com a headline gigante e arredondada vista no hero.

**Isso é uma decisão que preciso validar com você (ver seção 6):** o prompt-modelo cita Neue Haas / Suisse / Inter / Manrope / General Sans / Space Grotesk como referência tipográfica "premium". Mas a marca **já usa Poppins** e ela já entrega o efeito geométrico-grande visto no hero. Trocar a fonte é uma decisão de rebranding, não de execução — recomendo manter Poppins por consistência de marca, mas é a sua chamada.

---

## 3. Análise do vídeo (roteiro técnico do hero)

**Ficha técnica:** 10s · 1920×1080 · 24fps · H.264 · com trilha de áudio · sem texto/grafismo on-screen (é puro b-roll — tipografia e copy são 100% responsabilidade do site).

### 3.1 Decupagem plano a plano

| Tempo | Plano | Câmera | Cor/luz |
|---|---|---|---|
| 0.0–1.5s | Mãos esboçando em caderno pontilhado, ao lado de MacBook + iPad/Pencil | Top-down estático, trípode | Cinza-azulado frio, quase monocromático, madeira escura |
| ~2.0–3.5s | Over-the-shoulder de um designer numa mesa, tela mostrando um render 3D (tipo Cinema 4D) de um palco/estrutura de truss sendo montado digitalmente | Estático, profundidade rasa | Cinza frio de estúdio + luminária de mesa quente (único calor da cena) |
| ~4.5s | Coordenadora de produção em galpão/hangar, colete tático, rádio no rosto, equipe de câmera desfocada ao fundo | Handheld leve, foco raso | Fluorescente industrial frio |
| ~5.0s | Esqueleto do palco já montado (truss, line array) mas **sem conteúdo de LED ainda** — o "antes" | Wide estático | Cinza neutro |
| ~6.0–7.5s | O mesmo palco **completo**: telão de LED com motivo de losango azul/magenta, palestrante centralizado num catwalk em V, plateia de terno cheia | Wide simétrico, plano mais longo do vídeo — é o clímax | Único momento saturado: azul + magenta contra quase-preto |
| ~7.5s | Plano fechado e simétrico: palestrante curvando-se (reverência) contra o mesmo fundo de LED | Estático, close | Mesma paleta saturada — o "humano" depois do "espetáculo" |
| ~8.5s | Equipe em preto empurrando flight cases pelo galpão | Handheld, motion blur, documental | Volta ao cinza frio |
| ~9.5s | Retorna ao caderno — agora em branco de novo | Top-down estático (espelha a abertura) | Frio, fecha o ciclo |

### 3.2 Leitura da linguagem de movimento
- **Estrutura é um loop:** Ideia → Design → Coordenação → Construção (estado bruto) → Revelação (estado saturado) → Momento humano → Desmontagem → Ideia de novo. Não é uma progressão linear de "processo → resultado" — é um ciclo contínuo, o que é uma metáfora perfeita para uma agência que faz isso repetidamente, projeto após projeto.
- **Câmera:** planos estáticos/simétricos são reservados para os momentos de "conceito" e "espetáculo" (caderno, render 3D, palco cheio). Planos com handheld e desfoque raso são reservados para os momentos "humanos/processo" (coordenadora, equipe carregando cases). Essa alternância estática↔cinética é traduzível 1:1 para a coreografia de scroll.
- **Cor como recompensa, não como constante:** ~90% do vídeo é cinza frio dessaturado (o "como se faz", cru, sem glamour). A cor viva (azul/magenta neon) aparece só no clímax — é a recompensa visual, não o estado padrão. Isso valida a paleta quase-monocromática + 1 acento observada nos layouts.
- **Ritmo:** devagar no início (esboço, planejamento) → acelera em cortes mais curtos e humanos → segura mais tempo no palco cheio (o único plano "demorado" depois da abertura) → acelera de novo na desmontagem → devagar no fechamento. Um arco de "lento → constrói → segura no pico → rápido → lento".

### 3.3 Tradução direta para a experiência de scroll
Não vou tratar o vídeo como "um vídeo que toca no hero" — vou usar a estrutura dele como o roteiro do scroll inteiro:

- **Hero:** o vídeo entra como plano de fundo, mas o scroll assume o papel de "câmera": ao rolar, muda-se a perspectiva/profundidade, o vídeo desacelera (scrub em vez de autoplay linear), e o texto ("Experiências memoráveis não acontecem. São Conduzidas.") surge entre camadas — igual ao efeito de profundidade visto no plano do render 3D.
- **Seções de processo (34 anos / Metodologia):** herdam a linguagem "handheld/humana" — transições mais suaves, sem grande espetáculo, espaço para leitura.
- **Cases:** herdam o clímax saturado do vídeo — é aqui que a cor viva do marcador e a fotografia de evento (que já é naturalmente colorida/neon nos cases reais) devem dominar, com transição cinematográfica ao abrir um case (mudança de ambiente, como visto no corte para o plano do palco).
- **Clientes/Contato:** o "momento humano" (a reverência) — mais quieto, mais confiante, menos efeito.

---

## 4. Conceito criativo

**Conceito-síntese: "A Coreografia Invisível."**

A Marguerite não vende eventos — vende o controle absoluto de algo que parece espontâneo. O vídeo mostra isso literalmente: nada no palco final é acaso, tudo foi esboçado, renderizado, coordenado por rádio, montado peça a peça. O site deve fazer o usuário **sentir esse mesmo processo de composição** enquanto rola a página: cada seção se monta diante dele como o palco se monta no vídeo — camada por camada, com intenção, nunca por acaso.

Isso também resolve o pedido de "storytelling por capítulos": cada seção do site = um "plano" do roteiro do vídeo (Ideia → Método → Prova → Confiança → Convite), com a mesma alternância estática/cinética observada na decupagem.

---

## 5. Direção de arte (moodboard textual)

- **Paleta:** ameixa quase-preta (`#1D010E`–`#3A2837`) + off-white quente (`#F6EFEB`/`#FDFDFD`) como base; **um único acento vivo** verde-limão (`#E9EF89`) usado como "marcador", nunca como cor decorativa recorrente; duotones terracota/âmbar reservados a fotografia editorial (retratos, "34 anos"); a saturação real (azul/magenta neon) só aparece via fotografia de evento nos Cases — nunca como cor de UI.
- **Tipografia:** Poppins (peso variável Black→ExtraLight), headlines gigantes, quebra de linha deliberada como recurso narrativo (visto no "O sucesso é alcançado em quatro" e no "São Conduzidas" destacado).
- **Fotografia:** duotone/monocromático para retrato institucional; cor plena e crua (não estilizada) para fotografia de evento real — o contraste entre os dois tratamentos já comunica "storytelling" vs. "prova social".
- **Movimento:** parcimonioso, nunca decorativo. Estático quando o conteúdo pede leitura; cinético só nas transições entre "capítulos". Um único acento de cor por seção, um único movimento de destaque por seção — eco direto da economia visual já presente nos layouts.
- **Tom de UX:** confiante e discreto — como visto na estrutura do site (nada pisca, nada grita), consistente com o público-alvo (executivos).

---

## 6. Decisões em aberto — preciso da sua validação antes da Fase 2

1. **Tipografia:** manter Poppins (fiel à marca já existente e aos assets de fonte já enviados) ou migrar para a referência do brief (Neue Haas/Suisse/Inter/etc.)?
2. **Fidelidade de copy:** o texto dos dois layouts (hero, "34 anos", metodologia, case SKY) é o **copy final** a ser usado no site, ou é placeholder e alguém vai revisar depois?
3. **Intensidade do scroll cinematográfico:** os layouts de referência são, na estrutura, relativamente "planos" (seções empilhadas, sem indício de parallax/3D nelas). O vídeo pede movimento rico. Quer que eu vá "cheio" (Three.js/WebGL, câmera 3D real no hero) já na Fase 3, ou prefere começar com GSAP/ScrollTrigger/Lenis 2D bem executado e só escalar para WebGL se o resultado pedir mais?

Assim que confirmar (ou ajustar) esses 3 pontos eu sigo para a **Fase 2 — Arquitetura** (Design System com tokens definitivos, IA, wireframes ASCII, arquitetura WordPress/ACF e arquitetura SEO).
