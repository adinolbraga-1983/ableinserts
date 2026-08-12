<?php
/**
 * Seção — Portfólio (carrossel de cases) + marcas.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Tom de cor e número de cada card ficam fixos (identidade visual);
// os textos e a foto de fundo são editáveis no Personalizar.
$marguerite_cases_estilo = array(
	1 => array( 'tone' => 'sky', 'numero' => '01' ),
	2 => array( 'tone' => 'loft', 'numero' => '02' ),
	3 => array( 'tone' => 'tegra', 'numero' => '03' ),
	4 => array( 'tone' => 'busco', 'numero' => '04' ),
);
$marguerite_cases_textos = array(
	1 => array(
		'top_label' => 'Consultoria Dangebel',
		'categoria' => 'Convenção Comercial 2025',
		'titulo'    => 'SKY',
		'descricao' => 'Equipe comercial, credenciados e acionistas engajados nas novas estratégias e metas anuais, reconhecidos dentro do ecossistema.',
		'meta'      => "980 pessoas\nIberostar · Salvador/BA\n3 dias\nComercial & Acionistas",
		'foto'      => '',
	),
	2 => array(
		'top_label' => 'Consultoria Dangebel',
		'categoria' => 'Convenção Loft / Portas 2026',
		'titulo'    => 'Loft',
		'descricao' => 'Loft posicionada como motor de crescimento, inovação e tecnologia, em união com os parceiros de negócios do ecossistema.',
		'meta'      => "930 pessoas\nCommunity Creators Academy",
		'foto'      => '',
	),
	3 => array(
		'top_label' => 'Agência',
		'categoria' => 'Tegra Incorporadora',
		'titulo'    => 'Tegra Guest',
		'descricao' => 'Quatro experiências curadas: jantar Picchi (Michelin), SP e RJ Open, e o pôr do sol em alto mar no Rio.',
		'meta'      => "Programa de experiências\nProspects, clientes & investidores\nSP / RJ",
		'foto'      => MARGUERITE_URI . '/assets/img/case-tegraguest.png',
	),
	4 => array(
		'top_label' => 'Agência',
		'categoria' => 'Coletiva de Imprensa',
		'titulo'    => 'Busco',
		'descricao' => 'Lançamento da plataforma que reúne as principais viações do Brasil — rotas reais, informações claras e compra online segura.',
		'meta'      => "30 pessoas\nEco Lodge · Pedra Azul/ES\n1 dia\nImprensa & Influenciadores",
		'foto'      => '',
	),
);

$marguerite_cases = array();
foreach ( $marguerite_cases_estilo as $n => $estilo ) {
	$padrao               = $marguerite_cases_textos[ $n ];
	$marguerite_cases[]   = array_merge(
		$estilo,
		array(
			'top_label' => get_theme_mod( "marguerite_case_{$n}_top_label", $padrao['top_label'] ),
			'categoria' => get_theme_mod( "marguerite_case_{$n}_categoria", $padrao['categoria'] ),
			'titulo'    => get_theme_mod( "marguerite_case_{$n}_titulo", $padrao['titulo'] ),
			'descricao' => get_theme_mod( "marguerite_case_{$n}_descricao", $padrao['descricao'] ),
			'meta'      => marguerite_lines_to_array( get_theme_mod( "marguerite_case_{$n}_meta", $padrao['meta'] ) ),
			'foto'      => get_theme_mod( "marguerite_case_{$n}_foto", $padrao['foto'] ),
		)
	);
}

$marguerite_marcas = marguerite_lines_to_array( get_theme_mod( 'marguerite_marcas_lista', "BUSCO\nLOFT\nTEGRA\nSKY®" ) );
?>
<section class="section portfolio" id="cases">
	<div class="container">
		<div class="portfolio__intro" data-reveal>
			<p class="eyebrow eyebrow--tan align-center"><?php echo esc_html( get_theme_mod( 'marguerite_portfolio_eyebrow', 'Portfólio' ) ); ?></p>
			<h2 class="h2 align-center"><?php echo esc_html( get_theme_mod( 'marguerite_portfolio_heading', 'Experiências que geram conexões reais entre marcas e clientes.' ) ); ?></h2>
		</div>

		<div class="portfolio-carousel" data-carousel role="region" aria-roledescription="carrossel" aria-label="Carrossel de cases. Use as setas do teclado para navegar." tabindex="0" data-reveal>
			<div class="portfolio-track-wrap">
				<div class="portfolio-track" data-track>
					<?php foreach ( $marguerite_cases as $i => $case ) : ?>
						<article class="case-card case-card--<?php echo esc_attr( $case['tone'] ); ?>" data-case-index="<?php echo esc_attr( $i ); ?>" aria-hidden="<?php echo 0 === $i ? 'false' : 'true'; ?>">
							<?php if ( ! empty( $case['foto'] ) ) : ?>
								<img class="case-card__photo" src="<?php echo esc_url( $case['foto'] ); ?>" alt="" aria-hidden="true">
							<?php endif; ?>
							<div class="case-card__scrim" aria-hidden="true"></div>
							<div class="case-card__content">
								<div class="case-card__top">
									<p class="case-card__top-label"><?php echo esc_html( $case['top_label'] ); ?></p>
									<p class="case-card__numero"><?php echo esc_html( $case['numero'] ); ?></p>
								</div>
								<div class="case-card__bottom">
									<p class="case-card__eyebrow"><?php echo esc_html( $case['categoria'] ); ?></p>
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
			<p class="marcas__titulo"><?php echo esc_html( get_theme_mod( 'marguerite_marcas_titulo', 'Marcas que confiam na condução da consultoria e agência' ) ); ?></p>
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
