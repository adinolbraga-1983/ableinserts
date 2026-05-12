/* global React */

/* ============================================================
   Variation 02 — Apple Silence (Dark, centered manifesto)
   A single italic statement on full-bleed black. Portrait small,
   bottom-aligned. Reads like a product page that exists to say
   only one thing.
   ============================================================ */
function V2Silence() {
  return (
    <div className="site invert">
      <div className="topbar">
        <span className="wordmark">[Nome]</span>
        <nav className="nav">
          <a href="#">Trabalho</a>
          <a href="#">Sobre</a>
          <a href="#">Processo</a>
          <a href="#">Contato</a>
        </nav>
        <div className="lang"><span className="on">PT</span><span>/</span><span className="off">EN</span></div>
      </div>

      <section style={{minHeight: 720, display:'flex', flexDirection:'column', justifyContent:'space-between', padding: '120px 48px 48px'}}>
        <div style={{textAlign:'center', maxWidth: 1100, margin: '0 auto'}}>
          <span className="kicker" style={{color:'var(--silver)'}}>Consultoria de marca · since [ano]</span>
          <h1 style={{fontSize: 124, lineHeight: 1.0, letterSpacing:'-0.03em', margin:'40px 0 0', fontWeight: 400, color:'var(--paper)'}}>
            Uma marca é uma <em className="italic-statement" style={{color:'var(--paper)'}}>promessa</em><br/>
            que se cumpre, em <em className="italic-statement" style={{color:'var(--paper)'}}>silêncio</em>,<br/>
            ao longo dos anos.
          </h1>
          <p style={{fontFamily:'var(--font-display)', fontStyle:'italic', fontSize: 26, lineHeight: 1.3, marginTop: 36, color:'var(--mist)'}}>
            A brand is a promise — kept quietly, over years.
          </p>
        </div>

        {/* Bottom row: portrait small + meta + CTA */}
        <div style={{display:'grid', gridTemplateColumns: '120px 1fr auto', gap: 32, alignItems:'center', marginTop: 96, paddingTop: 32, borderTop: '0.5px solid rgba(255,255,255,0.14)'}}>
          <div style={{width: 96, height: 96}}>
            <div className="portrait-mask--circle" style={{width:'100%', height:'100%'}}>
              <img className="portrait-img" src="assets/portrait.png" alt="" />
            </div>
          </div>
          <div>
            <div style={{fontFamily:'var(--font-display)', fontStyle:'italic', fontSize: 22}}>— [Nome do Consultor]</div>
            <div style={{fontFamily:'var(--font-mono)', fontSize: 11, letterSpacing:'0.1em', textTransform:'uppercase', color:'var(--silver)', marginTop: 6}}>
              Diretor de marca · [Cidade]
            </div>
          </div>
          <button className="v-btn">Marcar uma conversa <span className="arr"/></button>
        </div>
      </section>
    </div>
  );
}
window.V2Silence = V2Silence;
