<?php
/**
 * Seção — Portfólio (carrossel de cases) + marcas.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$marguerite_cases = array(
	array(
		'tone'      => 'tegra',
		'numero'    => '01',
		'eyebrow'   => 'Portfólio',
		'titulo'    => 'Tegra Guest',
		'descricao' => 'Vivências exclusivas nos pilares gastronômico, esportivo e entretenimento.',
		'meta'      => array( 'Tegra Incorporadora', '20–30 pessoas', 'SP / RJ', '1 dia/evento' ),
		'foto'      => 'case-tegraguest.png',
	),
	array(
		'tone'      => 'busco',
		'numero'    => '02',
		'eyebrow'   => 'Portfólio',
		'titulo'    => 'Busco',
		'descricao' => 'Lançamento da plataforma que reúne as principais viações de ônibus do Brasil.',
		'meta'      => array( 'Coletiva de Imprensa', '30 pessoas', 'Pedra Azul / ES', '1 dia' ),
		'foto'      => '',
	),
	array(
		'tone'      => 'sky',
		'numero'    => '03',
		'eyebrow'   => 'Portfólio',
		'titulo'    => 'SKY',
		'descricao' => 'Equipe comercial e parceiros engajados nas novas metas comerciais.',
		'meta'      => array( 'Convenção Comercial 2025', '980 pessoas', 'Salvador / BA', '3 dias' ),
		'foto'      => '',
	),
);

$marguerite_marcas = array( 'BUSCO', 'LOFT', 'TEGRA', 'SKY®' );
?>
<section class="section portfolio" id="cases">
	<div class="container">
		<div class="portfolio__intro" data-reveal>
			<p class="eyebrow eyebrow--tan align-center">Portfólio</p>
			<h2 class="h2 align-center">Experiências que geram conexões reais entre marcas e clientes.</h2>
		</div>

		<div class="portfolio-carousel" data-carousel role="region" aria-roledescription="carrossel" aria-label="Carrossel de cases. Use as setas do teclado para navegar." tabindex="0" data-reveal>
			<div class="portfolio-track-wrap">
				<div class="portfolio-track" data-track>
					<?php foreach ( $marguerite_cases as $i => $case ) : ?>
						<article class="case-card case-card--<?php echo esc_attr( $case['tone'] ); ?>" data-case-index="<?php echo esc_attr( $i ); ?>" aria-hidden="<?php echo 0 === $i ? 'false' : 'true'; ?>">
							<?php if ( ! empty( $case['foto'] ) ) : ?>
								<img class="case-card__photo" src="<?php echo esc_url( MARGUERITE_URI . '/assets/img/' . $case['foto'] ); ?>" alt="" aria-hidden="true">
							<?php endif; ?>
							<div class="case-card__scrim" aria-hidden="true"></div>
							<div class="case-card__content">
								<p class="case-card__numero"><?php echo esc_html( $case['numero'] ); ?></p>
								<div class="case-card__bottom">
									<p class="case-card__eyebrow"><?php echo esc_html( $case['eyebrow'] ); ?></p>
									<h3 class="case-card__titulo"><?php echo esc_html( $case['titulo'] ); ?></h3>
									<p class="case-card__descricao"><?php echo esc_html( $case['descricao'] ); ?></p>
									<ul class="case-card__meta">
										<?php foreach ( $case['meta'] as $meta_item ) : ?>
											<li><?php echo esc_html( $meta_item ); ?></li>
										<?php endforeach; ?>
									</ul>
								</div>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="portfolio-controls">
				<button class="carousel-btn carousel-btn--prev" type="button" data-carousel-prev aria-label="Case anterior">
					<img src="<?php echo esc_url( MARGUERITE_URI . '/assets/img/icon-arrow-left.svg' ); ?>" alt="" width="20" height="20">
				</button>
				<div class="portfolio-dots" data-carousel-dots role="tablist">
					<?php foreach ( $marguerite_cases as $i => $case ) : ?>
						<button class="portfolio-dot<?php echo 0 === $i ? ' is-active' : ''; ?>" type="button" role="tab" aria-label="Ir para case <?php echo esc_attr( sprintf( '%02d', $i + 1 ) ); ?>" data-carousel-goto="<?php echo esc_attr( $i ); ?>"></button>
					<?php endforeach; ?>
				</div>
				<button class="carousel-btn carousel-btn--next" type="button" data-carousel-next aria-label="Próximo case">
					<img src="<?php echo esc_url( MARGUERITE_URI . '/assets/img/icon-arrow-right.svg' ); ?>" alt="" width="20" height="20">
				</button>
			</div>
		</div>

		<div class="marcas">
			<p class="marcas__titulo">Marcas que confiam na condução da consultoria e agência</p>
			<div class="marquee" data-marquee>
				<div class="marquee__track" data-marquee-track>
					<?php for ( $r = 0; $r < 2; $r++ ) : ?>
						<?php foreach ( $marguerite_marcas as $marca ) : ?>
							<span class="marquee__item"><?php echo esc_html( $marca ); ?></span>
						<?php endforeach; ?>
					<?php endfor; ?>
				</div>
			</div>
		</div>
	</div>
</section>
