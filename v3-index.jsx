/* global React */

/* ============================================================
   Variation 03 — Index (Typographic catalog)
   Inspired by table-of-contents pages in editorial books.
   Everything is a list. Numbered. Quiet. Systematic.
   ============================================================ */
function V3Index() {
  const items = [
    ['01','Posicionamento estratégico','Strategic positioning','01—04 sem'],
    ['02','Identidade visual','Visual identity','06—10 sem'],
    ['03','Naming','Naming','02—04 sem'],
    ['04','Narrativa & voz','Narrative & voice','03—05 sem'],
    ['05','Workshops','Workshops','1—2 dias'],
    ['06','Consultoria contínua','Advisory retainer','mensal'],
  ];
  return (
    <div className="site">
      <div className="topbar">
        <span className="wordmark">[Nome]<em style={{color:'var(--fg-3)'}}> ·  branding</em></span>
        <nav className="nav">
          <a href="#">Índice</a>
          <a href="#">Trabalho</a>
          <a href="#">Carta</a>
          <a href="#">Contato</a>
        </nav>
        <div className="lang"><span className="on">PT</span><span>/</span><span className="off">EN</span></div>
      </div>

      {/* Hero: title row */}
      <section style={{padding: '64px 48px 36px'}}>
        <div style={{display:'grid', gridTemplateColumns: '1fr 1fr', gap: 64, alignItems:'end'}}>
          <div>
            <span className="kicker">Volume I · 2026</span>
            <h1 style={{fontSize: 104, lineHeight: 0.95, letterSpacing:'-0.03em', margin:'24px 0 0', fontWeight: 400}}>
              Índice de <em className="italic-statement">trabalho.</em>
            </h1>
            <p className="lead" style={{marginTop: 18, fontSize: 22, color:'var(--fg-3)'}}>An index of practice.</p>
          </div>
          <div style={{paddingBottom: 8}}>
            <p style={{maxWidth: 460, fontSize: 16, color:'var(--fg-2)', lineHeight: 1.6}}>
              Trabalho com pequenos negócios e fundadores em projetos de marca de longa duração. Esta página funciona como índice — cada entrada abre um caso, um ensaio ou uma conversa.
            </p>
          </div>
        </div>
      </section>

      {/* The list */}
      <section style={{padding: '0 48px 48px'}}>
        <div className="hairline" />
        {items.map(([n, pt, en, dur]) => (
          <a key={n} href="#" style={{
            display:'grid', gridTemplateColumns: '64px 1fr 1fr 120px 48px',
            alignItems:'baseline', gap: 24,
            padding: '28px 0', borderBottom: '0.5px solid var(--border-1)',
            border: 'none', borderBottom: '0.5px solid var(--border-1)',
            textDecoration:'none', color:'inherit',
          }}>
            <span style={{fontFamily:'var(--font-mono)', fontSize: 11, color:'var(--fg-3)', letterSpacing:'0.1em'}}>{n}</span>
            <span style={{fontFamily:'var(--font-display)', fontSize: 40, lineHeight: 1.05, letterSpacing:'-0.015em'}}>{pt}</span>
            <span style={{fontFamily:'var(--font-display)', fontStyle:'italic', fontSize: 24, color:'var(--fg-3)'}}>{en}</span>
            <span style={{fontFamily:'var(--font-mono)', fontSize: 11, color:'var(--fg-3)', letterSpacing:'0.08em', textTransform:'uppercase'}}>{dur}</span>
            <span style={{fontFamily:'var(--font-mono)', fontSize: 11, color:'var(--ink)', textAlign:'right'}}>→</span>
          </a>
        ))}
      </section>

      {/* Footer bilingual block */}
      <section style={{padding: '48px 48px 64px', display:'grid', gridTemplateColumns:'160px 1fr auto', gap: 32, alignItems:'center'}}>
        <div style={{width: 120, height: 120}}>
          <div className="portrait-mask--square" style={{width:'100%', height:'100%'}}>
            <img className="portrait-img" src="assets/portrait.png" alt="" />
          </div>
        </div>
        <p className="lead" style={{fontSize: 28, maxWidth: 720}}>
          Se você procura uma marca discreta, atemporal e durável, fale comigo. <em style={{color:'var(--fg-3)'}}>If you're looking for a quiet, durable brand — let's talk.</em>
        </p>
        <button className="v-btn">Contato <span className="arr"/></button>
      </section>
    </div>
  );
}
window.V3Index = V3Index;
