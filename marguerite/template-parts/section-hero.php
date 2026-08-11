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
		<p class="eyebrow" data-reveal>Agência Boutique</p>
		<h1 class="hero__title" data-reveal>
			Experiências memoráveis são planejadas, desenhadas e <span class="text-accent-lavender">conduzidas</span>.
		</h1>
		<p class="hero__lead" data-reveal>
			Da primeira conversa ao desmonte, cada projeto é conduzido pessoalmente pela agência.
			<strong>Sem repasse. Sem tradução perdida no caminho.</strong>
		</p>
		<div class="hero__actions" data-reveal>
			<a class="btn btn--pill btn--lavender" href="#contato">Agende uma Reunião</a>
		</div>
	</div>

	<div class="hero__scroll-cue">
		<span class="hero__scroll-line" aria-hidden="true"></span>
		<span>Role para descobrir</span>
	</div>
</section>
