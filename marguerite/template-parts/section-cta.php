<?php
/**
 * Seção — CTA final (Vamos conversar).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="section cta-section" id="contato">
	<div class="container">
		<div class="cta-box" data-reveal>
			<span class="cta-box__glow" aria-hidden="true"></span>
			<div class="cta-box__content">
				<h2 class="cta-box__title">Vamos conversar sobre o seu próximo projeto.</h2>
				<p class="cta-box__lead">Sem briefing formal.<br>Apenas um diálogo direto com quem conduz.</p>
				<a class="btn btn--pill btn--white" href="https://wa.me/5500000000000" target="_blank" rel="noopener noreferrer">
					<img src="<?php echo esc_url( MARGUERITE_URI . '/assets/img/icon-whatsapp.svg' ); ?>" alt="" width="20" height="20">
					<span>Falar via WhatsApp</span>
				</a>
			</div>
		</div>
	</div>
</section>
