<?php
/**
 * Seção — CTA final (Vamos conversar).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$marguerite_cta_lead_linhas = marguerite_lines_to_array(
	get_theme_mod( 'marguerite_cta_lead', "Sem briefing formal.\nApenas um diálogo direto com quem conduz." )
);
?>
<section class="section cta-section" id="contato">
	<div class="container">
		<div class="cta-box" data-reveal>
			<span class="cta-box__glow" aria-hidden="true"></span>
			<div class="cta-box__content">
				<h2 class="cta-box__title"><?php echo esc_html( get_theme_mod( 'marguerite_cta_heading', 'Vamos conversar sobre o seu próximo projeto.' ) ); ?></h2>
				<p class="cta-box__lead"><?php echo wp_kses_post( implode( '<br>', array_map( 'esc_html', $marguerite_cta_lead_linhas ) ) ); ?></p>
				<a class="btn btn--pill btn--white" href="<?php echo esc_url( get_theme_mod( 'marguerite_cta_btn_link', 'https://wa.me/5500000000000' ) ); ?>" target="_blank" rel="noopener noreferrer">
					<img src="<?php echo esc_url( MARGUERITE_URI . '/assets/img/icon-whatsapp.svg' ); ?>" alt="" width="20" height="20">
					<span><?php echo esc_html( get_theme_mod( 'marguerite_cta_btn_label', 'Falar via WhatsApp' ) ); ?></span>
				</a>
			</div>
		</div>
	</div>
</section>
