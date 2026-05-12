/* global React */

/* ============================================================
   Variation 04 — Letter (Personal essay / correspondence)
   The page presented as a written letter. Single narrow column,
   signed at the bottom. Maximally personal.
   ============================================================ */
function V4Letter() {
  return (
    <div className="site bone">
      <div className="topbar" style={{borderBottomColor:'rgba(10,10,10,0.08)'}}>
        <span className="wordmark">[Nome]</span>
        <nav className="nav">
          <a href="#">Carta</a>
          <a href="#">Casos</a>
          <a href="#">Diário</a>
          <a href="#">Escreva</a>
        </nav>
        <div className="lang"><span className="on">PT</span><span>/</span><span className="off">EN</span></div>
      </div>

      <section style={{maxWidth: 720, margin:'0 auto', padding: '96px 24px 64px'}}>
        <div style={{display:'flex', justifyContent:'space-between', alignItems:'baseline', marginBottom: 64}}>
          <span className="kicker">Carta aberta · Open letter</span>
          <span style={{fontFamily:'var(--font-mono)', fontSize: 11, color:'var(--fg-3)', letterSpacing:'0.08em', textTransform:'uppercase'}}>[Cidade], [mês] de 2026</span>
        </div>

        <h1 style={{fontSize: 72, lineHeight: 0.98, letterSpacing:'-0.025em', margin: 0, fontWeight: 400}}>
          Caro fundador, <em className="italic-statement">cara fundadora —</em>
        </h1>

        <div style={{marginTop: 48, fontFamily:'var(--font-display)', fontSize: 22, lineHeight: 1.5, color:'var(--fg-1)', letterSpacing:'-0.005em'}}>
          <p style={{margin: 0}}>Eu trabalho com marcas — não como projetos curtos, mas como conversas longas. Acredito que a maior parte do branding contemporâneo é barulho: logos refeitos, slogans esquecíveis, manifestos que ninguém lê.</p>
          <p style={{margin: '24px 0 0'}}>O que ofereço é o contrário disso. <em className="italic-statement">Um processo lento, íntimo, em três etapas:</em> entender, posicionar, traduzir. Trabalho com pequenos negócios e fundadores que querem construir algo que dure.</p>
          <p style={{margin: '24px 0 0', color:'var(--fg-3)'}}>I work with founders and small businesses — slowly, intimately. Three stages: understand, position, translate. If that sounds like what you need, write to me.</p>
        </div>

        <div style={{marginTop: 64, display:'flex', alignItems:'center', gap: 24}}>
          <div style={{width: 88, height: 88}}>
            <div className="portrait-mask--circle" style={{width:'100%', height:'100%'}}>
              <img className="portrait-img" src="assets/portrait.png" alt="" />
            </div>
          </div>
          <div>
            <div style={{fontFamily:'var(--font-display)', fontStyle:'italic', fontSize: 36, lineHeight: 1.1}}>— [Nome]</div>
            <div style={{fontFamily:'var(--font-mono)', fontSize: 11, letterSpacing:'0.1em', textTransform:'uppercase', color:'var(--fg-3)', marginTop: 4}}>
              Consultor de marca
            </div>
          </div>
        </div>

        <div style={{marginTop: 64, paddingTop: 32, borderTop: '0.5px solid rgba(10,10,10,0.14)', display:'flex', justifyContent:'space-between', alignItems:'center'}}>
          <span style={{fontFamily:'var(--font-mono)', fontSize: 11, color:'var(--fg-3)', letterSpacing:'0.08em', textTransform:'uppercase'}}>P.S. — Leia as cartas anteriores no diário.</span>
          <button className="v-btn">Escrever de volta <span className="arr"/></button>
        </div>
      </section>
    </div>
  );
}
window.V4Letter = V4Letter;
