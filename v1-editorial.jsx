/* global React */
const { useState } = React;

/* ============================================================
   Variation 01 — Editorial Manifesto
   Direct interpretation of the napkin sketch:
   oval portrait top-left, massive italic statement,
   "Apple-like" white silence + magazine kicker rules.
   ============================================================ */
function V1Editorial() {
  return (
    <div className="site" style={{padding: 0}}>
      <div className="topbar">
        <span className="wordmark">[Nome] <em style={{color:'var(--fg-3)'}}>· consultoria de marca</em></span>
        <nav className="nav">
          <a href="#">Trabalho</a>
          <a href="#">Sobre</a>
          <a href="#">Processo</a>
          <a href="#">Diário</a>
          <a href="#">Contato</a>
        </nav>
        <div className="lang"><span className="on">PT</span><span>/</span><span className="off">EN</span></div>
      </div>

      {/* HERO — sketched layout */}
      <section style={{padding: '64px 48px 96px', position:'relative'}}>
        <div style={{display:'grid', gridTemplateColumns: '260px 1fr 180px', gap: 48, alignItems:'start'}}>
          {/* Oval portrait, top-left */}
          <div style={{width: 240, height: 300, marginTop: 12}}>
            <div className="portrait-mask--oval" style={{width:'100%', height:'100%'}}>
              <img className="portrait-img" src="assets/portrait.png" alt="" />
            </div>
            <div style={{marginTop: 14, fontFamily:'var(--font-mono)', fontSize: 10, letterSpacing:'0.12em', textTransform:'uppercase', color:'var(--fg-3)'}}>
              Retrato — São Paulo, 2026
            </div>
          </div>

          {/* Statement block */}
          <div style={{paddingTop: 8}}>
            <span className="kicker" style={{marginBottom: 36, display:'inline-flex'}}>Consultoria de marca · estab. [ano]</span>
            <h1 style={{fontSize: 132, lineHeight: 0.92, letterSpacing:'-0.035em', margin: 0, fontWeight: 400}}>
              Trabalho com<br/>
              marcas que <em className="italic-statement">querem<br/>ser ouvidas</em> —
            </h1>
            <p style={{fontFamily:'var(--font-display)', fontStyle:'italic', fontSize: 26, lineHeight: 1.3, marginTop: 28, maxWidth: 640, color:'var(--fg-3)'}}>
              em silêncio, ao longo dos anos.<br/>
              <span style={{color:'var(--silver)'}}>I work with brands that want to be heard — quietly, over time.</span>
            </p>

            <div style={{marginTop: 48, display:'flex', gap: 16, alignItems:'center'}}>
              <button className="v-btn">Marcar uma conversa <span className="arr"/></button>
              <a style={{borderBottom:'0.5px solid var(--ink)', paddingBottom: 2, fontSize: 14}}>Ver trabalho</a>
            </div>
          </div>

          {/* Right meta column */}
          <aside style={{fontFamily:'var(--font-mono)', fontSize: 11, lineHeight: 1.8, letterSpacing:'0.06em', textTransform:'uppercase', color:'var(--fg-3)', textAlign:'right', paddingTop: 12}}>
            <div>Atende</div>
            <div style={{color:'var(--ink)'}}>Pequenos negócios</div>
            <div style={{color:'var(--ink)'}}>e fundadores</div>
            <div style={{marginTop: 24}}>Baseado em</div>
            <div style={{color:'var(--ink)'}}>[Cidade]</div>
            <div style={{marginTop: 24}}>Disponível</div>
            <div style={{color:'var(--ink)'}}>Q3 — [ano]</div>
          </aside>
        </div>
      </section>

      <div className="hairline" />

      {/* Sub-row: pillar list */}
      <section style={{padding: '40px 48px', display:'grid', gridTemplateColumns: 'repeat(4, 1fr)', gap: 48}}>
        {[
          ['01','Posicionamento','Positioning'],
          ['02','Identidade','Identity'],
          ['03','Naming','Naming'],
          ['04','Narrativa','Narrative'],
        ].map(([n,pt,en]) => (
          <div key={n}>
            <div style={{fontFamily:'var(--font-mono)', fontSize: 11, color:'var(--fg-3)', letterSpacing:'0.1em'}}>{n}</div>
            <div style={{fontFamily:'var(--font-display)', fontSize: 32, lineHeight: 1.1, marginTop: 8}}>
              {pt} <em style={{color:'var(--fg-3)', fontSize: 18, display:'block', marginTop: 4}}>{en}</em>
            </div>
          </div>
        ))}
      </section>
    </div>
  );
}

window.V1Editorial = V1Editorial;
