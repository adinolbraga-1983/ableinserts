#!/usr/bin/env python3
"""
Gera um HTML único e autossuficiente (marguerite-home.html) a partir do
protótipo modular: inline de CSS/JS/fontes/imagens/vídeo como data URIs.
Usa o build global do Three.js (sem ES modules) para que o arquivo funcione
abrindo direto no navegador (file://), sem servidor.
"""
import base64, re, pathlib, sys

ROOT = pathlib.Path(__file__).parent
OUT = ROOT / "standalone" / "marguerite-home.html"
OUT.parent.mkdir(exist_ok=True)

MIME = {
    ".woff2": "font/woff2", ".jpg": "image/jpeg", ".jpeg": "image/jpeg",
    ".png": "image/png", ".svg": "image/svg+xml", ".mp4": "video/mp4",
}

def data_uri(path: pathlib.Path) -> str:
    b = path.read_bytes()
    mime = MIME.get(path.suffix.lower(), "application/octet-stream")
    return f"data:{mime};base64,{base64.b64encode(b).decode()}"

def read(p): return (ROOT / p).read_text(encoding="utf-8")

# ---- CSS (com fontes embutidas) ----
css = "\n".join(read(f"css/{f}") for f in ["tokens.css", "fonts.css", "base.css", "sections.css"])
def font_repl(m):
    rel = m.group(1)
    p = (ROOT / "css" / rel).resolve()
    return f'url("{data_uri(p)}")'
css = re.sub(r'url\("(\.\./assets/fonts/[^"]+)"\)', font_repl, css)

# ---- JS: converte módulos para globais ----
hero = read("js/hero-webgl.js")
hero = hero.replace('import * as THREE from "three";', "")
hero = hero.replace("export function initHeroWebGL", "function initHeroWebGL")
hero += "\nwindow.initHeroWebGL = initHeroWebGL;\n"

main = read("js/main.js")
main = main.replace(
    'const { initHeroWebGL } = await import("./hero-webgl.js");',
    "const initHeroWebGL = window.initHeroWebGL;")

gsap = read("assets/vendor/gsap.min.js")
strig = read("assets/vendor/ScrollTrigger.min.js")
lenis = read("assets/vendor/lenis.min.js")
three = read("assets/vendor/three.umd.min.js")

# ---- HTML base ----
html = read("index.html")

# remove importmap + tags de módulo/vendor externas (vamos inline tudo)
html = re.sub(r'<script type="importmap">.*?</script>', "", html, flags=re.S)
html = re.sub(r'<!-- Vendor.*?</body>', "</body>", html, flags=re.S)
# remove <link rel=stylesheet> e vamos injetar <style>
html = re.sub(r'<link rel="stylesheet"[^>]*>\s*', "", html)
# remove preloads de fonte/imagem (já embutidos)
html = re.sub(r'<link rel="preload"[^>]*>\s*', "", html)

# standalone leve: mantém só o WebM no hero (evita embutir mp4 + webm).
html = re.sub(r'\s*<source src="assets/video/hero\.mp4"[^>]*>', "", html)

# substitui asset URLs (img/src, video source, poster, favicon) por data URIs
def asset_repl(m):
    attr, rel = m.group(1), m.group(2)
    p = (ROOT / rel).resolve()
    if not p.exists():
        return m.group(0)
    return f'{attr}="{data_uri(p)}"'
html = re.sub(r'(src|href|poster)="(assets/[^"]+|favicon\.svg)"', asset_repl, html)

# injeta <style> no <head>
html = html.replace("</head>", f"<style>\n{css}\n</style>\n</head>")

# injeta scripts antes de </body> (ordem importa)
scripts = (
    f"<script>{gsap}</script>\n"
    f"<script>{strig}</script>\n"
    f"<script>{lenis}</script>\n"
    f"<script>{three}</script>\n"
    f"<script>{hero}</script>\n"
    f"<script>{main}</script>\n"
)
html = html.replace("</body>", scripts + "</body>")

OUT.write_text(html, encoding="utf-8")
size = OUT.stat().st_size
print(f"OK: {OUT}  ({size/1_000_000:.1f} MB)")
