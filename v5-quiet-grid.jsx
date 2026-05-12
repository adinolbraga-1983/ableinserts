/* global React */

/* ============================================================
   Variation 05 — Quiet Grid (Asymmetric catalog)
   12-col grid with zones of negative space. Portrait sits as
   a small tile in a grid of facts and statements. The most
   "designed", but still monochrome.
   ============================================================ */
function V5QuietGrid() {
  return (
    <div className="site">
      <div className="topbar">
        <span className="wordmark">[Nome] <span style={{fontFamily:'var(--font-mono)', fontSize: 11, letterSpacing:'0.1em', textTransform:'uppercase', color:'var(--fg-3)', marginLeft: 12}}>· est. [ano]</span></span>
        <nav className="nav">
          <a href="#">Estúdio</a>
          <a href="#">Trabalho</a>
          <a href="#">Processo</a>
          <a href="#">Diário</a>
          <a href="#">Contato</a>
        </nav>
        <div className="lang"><span className="on">PT</span><span>/</span><span className="off">EN</span></div>
      </div>

      <section style={{padding: '48px 48px 64px'}}>
        <div style={{display:'grid', gridTemplateColumns:'repeat(12, 1fr)', gridAutoRows: 'minmax(120px, auto)', gap: 24}}>
          {/* Main statement, cols 1-8 rows 1-2 */}
          <div style={{gridColumn:'1 / span 8', gridRow:'1 / span 2', display:'flex', flexDirection:'column', justifyContent:'flex-end', paddingTop: 24}}>
            <span className="kicker" style={{marginBottom: 24}}>Consultoria · Branding</span>
            <h1 style={{fontSize: 108, lineHeight: 0.95, letterSpacing:'-0.03em', margin: 0, fontWeight: 400}}>
              Identidade discreta para marcas com <em className="italic-statement">tempo de vida longo.</em>
            </h1>
            <p style={{fontFamily:'var(--font-display)', fontStyle:'italic', fontSize: 22, color:'var(--fg-3)', marginTop: 24, maxWidth: 640}}>
              Quiet identity for brands meant to last.
            </p>
          </div>

          {/* Portrait card, cols 9-12 row 1 */}
          <div style={{gridColumn:'9 / span 4', gridRow:'1 / span 2', position:'relative', overflow:'hidden', background: 'var(--bone)'}}>
            <img src="assets/portrait.png" alt="" style={{width:'100%', height:'100%', objectFit:'cover', filter:'grayscale(1) contrast(1.05)'}} />
            <div style={{position:'absolute', left: 20, bottom: 18, fontFamily:'var(--font-mono)', fontSize: 11, letterSpacing:'0.08em', textTransform:'uppercase', color:'var(--paper)', mixBlendMode:'difference'}}>
              [Nome] · [Cidade]
            </div>
          </div>

          {/* Fact cells */}
          <FactCell n="01" t="14 anos" s="de prática em marca" pos="3 / span 3" />
          <FactCell n="02" t="42 marcas" s="parceiras desde [ano]" pos="6 / span 3" />
          <FactCell n="03" t="2 clientes" s="por trimestre, no máximo" pos="9 / span 4" />

          {/* Services row, cols 1-2 spans 3 each */}
          <ServiceCell pos="1 / span 3" pt="Posicionamento" en="Positioning" />
          <ServiceCell pos="4 / span 3" pt="Identidade" en="Identity" />
          <ServiceCell pos="7 / span 3" pt="Naming" en="Naming" />
          <div style={{gridColumn:'10 / span 3', display:'flex', alignItems:'flex-end', justifyContent:'flex-end', paddingTop: 24}}>
            <button className="v-btn">Marcar conversa <span className="arr"/></button>
          </div>
        </div>
      </section>

      <div className="hairline" />
      <section style={{padding: '28px 48px', display:'flex', justifyContent:'space-between', alignItems:'center'}}>
        <span style={{fontFamily:'var(--font-mono)', fontSize: 11, letterSpacing:'0.1em', textTransform:'uppercase', color:'var(--fg-3)'}}>
          Atendimento — São Paulo, remoto · Próxima vaga: Q3
        </span>
        <span style={{fontFamily:'var(--font-display)', fontStyle:'italic', fontSize: 20, color:'var(--fg-1)'}}>
          contato@[dominio].com
        </span>
      </section>
    </div>
  );
}

function FactCell({n, t, s, pos}) {
  return (
    <div style={{gridColumn: pos, display:'flex', flexDirection:'column', justifyContent:'flex-end', padding: '24px 0', borderTop:'0.5px solid var(--border-1)'}}>
      <span style={{fontFamily:'var(--font-mono)', fontSize: 11, color:'var(--fg-3)', letterSpacing:'0.1em'}}>{n}</span>
      <div style={{fontFamily:'var(--font-display)', fontSize: 56, lineHeight: 1, marginTop: 12, letterSpacing:'-0.02em'}}>{t}</div>
      <div style={{fontFamily:'var(--font-display)', fontStyle:'italic', fontSize: 18, color:'var(--fg-3)', marginTop: 6}}>{s}</div>
    </div>
  );
}
function ServiceCell({pos, pt, en}) {
  return (
    <div style={{gridColumn: pos, padding: '24px 0 0', borderTop:'0.5px solid var(--border-1)'}}>
      <div style={{fontFamily:'var(--font-display)', fontSize: 32, letterSpacing:'-0.015em'}}>{pt}</div>
      <div style={{fontFamily:'var(--font-display)', fontStyle:'italic', fontSize: 18, color:'var(--fg-3)', marginTop: 4}}>{en}</div>
    </div>
  );
}

window.V5QuietGrid = V5QuietGrid;
