# ableinserts — fonte "Bem Me Quer"

Este repositório contém a fonte **Bem Me Quer**, construída a partir da arte
vetorial original (`source/BemMeQuertype.ai`) desenhada no Illustrator, com
os caracteres em 5 pesos: **Light, Regular, SemiBold, Bold e Black**.

## Onde estão os arquivos

- `build/` — os arquivos de fonte prontos para uso, em 4 formatos por peso:
  `.ttf`, `.otf`, `.woff` e `.woff2` (20 arquivos no total).
- `source/` — a arte original (`BemMeQuertype.ai`), o vetor extraído dela
  (`vector.svg`) e o manifesto de glifos (`glyphs.json`) usado para montar a
  fonte.
- `tools/` — os dois scripts Python que fazem a extração e a montagem:
  - `extract_glyphs.py`: lê `source/vector.svg` e identifica cada caractere
    desenhado (posição, peso, contorno), gerando `source/glyphs.json`.
  - `build_font.py`: lê `source/glyphs.json` e monta as 5 fontes completas
    (métricas, acentos compostos, pontuação, exporta os 4 formatos).

Para regerar tudo do zero:

```bash
python3 tools/extract_glyphs.py
python3 tools/build_font.py
```

(dependências: `fontTools`, `svgelements` — `pip install fontTools svgelements`)

## O que foi desenhado à mão vs. gerado automaticamente

O arquivo original tinha o alfabeto completo (A-Z, a-z, 0-9) desenhado nos
5 pesos, mais um conjunto de símbolos (`* & ^ % $ # @ ! ( ) + -`) e o
acento agudo (usado em "Pétala"), só que **desenhados uma única vez**, sem
variação de peso. Como o pedido incluía suporte a português (acentos, ç,
etc.) que não estava desenhado, o restante foi resolvido automaticamente,
seguindo a estética da fonte (serifa alta-contraste, terminais em bola):

- **Letras A-Z, a-z, 0-9**: vetor original, fiel ao desenho, em cada um dos
  5 pesos.
- **Acentos portugueses** (á à â ã é ê í ó ô õ ú ü ç e maiúsculas): os
  marcadores de acento (agudo, grave, circunflexo, til, trema, cedilha)
  foram desenhados por código, com espessura de traço ajustada a cada peso,
  e combinados com as letras-base já existentes.
- **Símbolos** (`* & ^ % $ # @ ! ( )`): reaproveitados do único desenho
  original, escalados para a altura de caixa-alta de cada peso (sem ajuste
  fino de espessura por peso — podem parecer um pouco mais leves no Black e
  um pouco mais pesados no Light).
- **Pontuação não desenhada** (`. , ; : ' " ?`) e **`+` `-`**: geradas por
  código (o `+` e o `-` originais eram traços quase invisíveis no desenho,
  então foram refeitos do zero).

Isso cobre o necessário para digitar em português (título, corpo de texto
com acentuação, pontuação básica), mas os itens gerados por código são uma
aproximação — não foram desenhados à mão pela Danielle. Se quiser refinar
visualmente algum desses (ex.: desenhar o `?` ou os acentos "de verdade"),
me envie os SVGs e eu recomponho a fonte com eles no lugar das versões
geradas.

## Pesos e nomes de família

Cada peso é exportado como uma família independente (`Bem Me Quer Light`,
`Bem Me Quer`, `Bem Me Quer SemiBold`, `Bem Me Quer Bold`, `Bem Me Quer
Black`), o jeito mais simples de instalar e selecionar cada peso em
qualquer programa (Word, Figma, Illustrator, CSS, etc.) sem depender de
suporte a "font-weight" variável.
