# Tema Marguerite — instalação no WordPress

Arquivo: **marguerite-tema-wordpress.zip**
Site de destino: margueriteexperience.com.br

---

## Antes de começar (2 minutos)

Faça um backup do site atual. Na Hostinger: **hPanel → Sites → Gerenciar → Backups → Criar backup**.
Nada do que está no ar é apagado por este processo, mas backup nunca é demais.

---

## Passo 1 — Instalar o Elementor (gratuito)

O tema usa o Elementor gratuito. **Não precisa do Elementor Pro.**

1. Entre no painel: `margueriteexperience.com.br/wp-admin`
2. **Plugins → Adicionar novo**
3. Busque por **Elementor**
4. No card "Elementor Website Builder", clique em **Instalar agora** e depois em **Ativar**

---

## Passo 2 — Instalar o tema

1. **Aparência → Temas → Adicionar novo → Enviar tema**
2. Escolha o arquivo `marguerite-tema-wordpress.zip`
3. Clique em **Instalar agora** e depois em **Ativar**

> Se der erro de "arquivo muito grande", suba pelo Gerenciador de Arquivos da Hostinger:
> `public_html/wp-content/themes/` → envie o zip → clique com o botão direito → **Extrair**.
> Depois volte em Aparência → Temas e ative o "Marguerite Experience".

---

## Passo 3 — Montar a página (1 clique)

1. **Aparência → Layout da Marguerite**
2. Clique em **Montar a página inicial**

Pronto. A página inicial é criada com todas as seções na ordem certa e já fica definida
como página inicial do site. Abra `margueriteexperience.com.br` para conferir.

---

## Passo 4 — Ajustes finais (importante)

**Número do WhatsApp** (hoje está com um número de exemplo):
1. **Páginas → Início → Editar com Elementor**
2. Clique no bloco roxo "Vamos conversar sobre o seu próximo projeto"
3. No painel da esquerda, campo **Botão — link**, coloque: `https://wa.me/5511999999999`
   (55 + DDD + número, só dígitos, sem espaços ou traços)
4. Clique em **Publicar**

---

## Onde edito cada coisa

| O que | Onde |
|---|---|
| Textos, fotos, links e ficha técnica das seções | **Páginas → Início → Editar com Elementor** |
| Logo, itens do menu, botão do topo | **Aparência → Personalizar → Cabeçalho e Menu** |
| E-mail, cidade e direitos autorais do rodapé | **Aparência → Personalizar → Rodapé** |

### Editando no Elementor

Ao abrir "Editar com Elementor", clique em qualquer seção da página e os campos aparecem
à esquerda. As sete seções são widgets prontos (procure por **"marguerite"** no painel de
widgets se precisar adicionar algum de novo):

- **Topo da Página (Hero)**
- **Quem Somos**
- **Metodologia (cards)**
- **Executivas (equipe)** — cada pessoa tem um botão liga/desliga para a foto
- **Cases (carrossel)**
- **Marcas (faixa deslizante)**
- **Fale Conosco (bloco final)**

**Dois detalhes úteis:**

1. **Destaque em lilás / negrito** — nos campos de texto, escreva `**assim**` (dois asteriscos
   antes e depois) e o trecho ganha destaque. Ex.: `desenhadas e **conduzidas**.`

2. **Links do Instagram dos cases** — no widget "Cases", cada case tem um campo
   *Links do Instagram* onde você escreve **um link por linha** neste formato:

   ```
   Rótulo | Categoria | URL
   ```

   Exemplo real (o do TEGRA.GUEST):
   ```
   Picchi | Gastronômico | https://www.instagram.com/reel/DSYQVS-DWLg/
   SP Open | Esportivo · SP | https://www.instagram.com/reel/DMOnIuYxsRW/
   ```

   Para adicionar o link do case SKY quando ele existir, é só preencher esse campo no case dele.

---

## Perguntas rápidas

**Vou precisar pagar o Elementor Pro?**
Não. Todas as seções são widgets próprios do tema, que funcionam na versão gratuita.
O cabeçalho e o rodapé (que no Elementor só o Pro edita) vêm do tema e são editados
no Personalizar.

**O site depende de algum serviço externo?**
Não. Fontes, animações (GSAP) e imagens estão todas dentro do tema. Se a internet do
visitante for lenta ou algum CDN cair, o site continua igual.

**Posso trocar uma foto?**
Sim, qualquer foto. No Elementor, clique na imagem no painel esquerdo e escolha outra
da biblioteca de mídia do WordPress.

**E se eu bagunçar tudo?**
Volte em **Aparência → Layout da Marguerite** e clique em "Montar a página inicial"
novamente — isso restaura a página ao layout aprovado.
