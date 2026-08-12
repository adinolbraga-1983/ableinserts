<?php
/**
 * Seção — Hero.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="hero" id="home">
	<div class="hero__media" aria-hidden="true">
		<img src="<?php echo esc_url( MARGUERITE_URI . '/assets/img/hero.jpg' ); ?>" alt="" width="2761" height="1263" fetchpriority="high">
	</div>

	<span class="hero__blob hero__blob--top" aria-hidden="true"></span>
	<span class="hero__blob hero__blob--bottom" aria-hidden="true"></span>

	<div class="hero__content container">
		<div class="hero__text">
			<p class="eyebrow" data-reveal><?php echo esc_html( get_theme_mod( 'marguerite_hero_eyebrow', 'Agência Boutique' ) ); ?></p>
			<h1 class="hero__title" data-reveal>
				<?php echo marguerite_richtext_accent( get_theme_mod( 'marguerite_hero_heading', 'Experiências memoráveis são planejadas, desenhadas e **conduzidas**.' ) ); ?>
			</h1>
			<p class="hero__lead" data-reveal>
				<?php echo marguerite_richtext_bold( get_theme_mod( 'marguerite_hero_lead', 'Da primeira conversa ao desmonte, cada projeto é conduzido pessoalmente pela agência. **Sem repasse. Sem tradução perdida no caminho.**' ) ); ?>
			</p>
			<div class="hero__actions" data-reveal>
				<a class="btn btn--pill btn--lavender" href="<?php echo esc_url( get_theme_mod( 'marguerite_hero_btn_link', '#contato' ) ); ?>">
					<?php echo esc_html( get_theme_mod( 'marguerite_hero_btn_label', 'Agende uma Reunião' ) ); ?>
				</a>
			</div>
		</div>
	</div>

	<div class="hero__scroll-cue">
		<span class="hero__scroll-line" aria-hidden="true"></span>
		<span>Role para descobrir</span>
	</div>
</section>
