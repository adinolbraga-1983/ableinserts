<?php
/**
 * Bloco: Clientes (marquee de logos + manifesto + métricas).
 *
 * @package Marguerite
 */

defined( 'ABSPATH' ) || exit;

$eyebrow   = get_field( 'eyebrow' ) ?: 'Clientes';
$manifesto = get_field( 'manifesto' ) ?: 'Criamos experiências memoráveis que geram [mark]conexões reais[/mark] entre marcas e clientes.';
$fonte     = get_field( 'fonte' ) ?: 'cpt';

// Monta a lista de logos [ ['url','alt','class'] ].
$logos = array();

if ( 'manual' === $fonte ) {
	foreach ( (array) get_field( 'logos' ) as $row ) {
		$img = $row['logo'] ?? null;
		if ( $img ) {
			$logos[] = array( 'url' => is_array( $img ) ? $img['url'] : $img, 'alt' => $row['nome'] ?? '', 'class' => '' );
		}
	}
} else {
	$q = new WP_Query( array( 'post_type' => 'cliente', 'posts_per_page' => -1, 'orderby' => array( 'menu_order' => 'ASC', 'title' => 'ASC' ), 'no_found_rows' => true ) );
	while ( $q->have_posts() ) {
		$q->the_post();
		$img = get_field( 'logo' );
		if ( $img ) {
			$logos[] = array( 'url' => is_array( $img ) ? $img['url'] : $img, 'alt' => get_the_title(), 'class' => '' );
		}
	}
	wp_reset_postdata();
}

// Fallback: os 4 logos reais que acompanham o tema.
if ( empty( $logos ) ) {
	$logos = array(
		array( 'url' => marguerite_asset( 'img/tegra.png' ), 'alt' => 'Tegra Guest', 'class' => 'clientes__logo--tegra' ),
		array( 'url' => marguerite_asset( 'img/loft.png' ),  'alt' => 'Loft',        'class' => 'clientes__logo--loft' ),
		array( 'url' => marguerite_asset( 'img/busco.png' ), 'alt' => 'Busco',       'class' => 'clientes__logo--busco' ),
		array( 'url' => marguerite_asset( 'img/sky.svg' ),   'alt' => 'SKY',         'class' => 'clientes__logo--sky' ),
	);
}

$metricas = get_field( 'metricas' );
if ( empty( $metricas ) ) {
	$metricas = array(
		array( 'num' => '01', 'titulo' => 'Estratégia Atingida' ),
		array( 'num' => '02', 'titulo' => 'Confiança e Tranquilidade' ),
		array( 'num' => '03', 'titulo' => 'Budget Planejado' ),
		array( 'num' => '04', 'titulo' => 'Excelência da Entrega' ),
	);
}

$block_id = ! empty( $block['anchor'] ) ? esc_attr( $block['anchor'] ) : 'clientes';

// Renderiza um logo.
$render_logo = function ( $l, $hidden = false ) {
	printf(
		'<img class="clientes__logo %1$s" src="%2$s" alt="%3$s" %4$s loading="lazy" />',
		esc_attr( $l['class'] ),
		esc_url( $l['url'] ),
		$hidden ? '' : esc_attr( $l['alt'] ),
		$hidden ? 'aria-hidden="true"' : 'role="listitem"'
	);
};
?>
<section class="section section--invert clientes" id="<?php echo $block_id; ?>" aria-labelledby="clientes-title">
	<div class="container">
		<h2 class="eyebrow" id="clientes-title" style="display:block;text-align:center" data-reveal><?php echo esc_html( $eyebrow ); ?></h2>
		<div class="clientes__marquee" data-reveal role="list" aria-label="Nossos clientes">
			<div class="clientes__track">
				<?php foreach ( $logos as $l ) { $render_logo( $l, false ); } ?>
				<?php foreach ( $logos as $l ) { $render_logo( $l, true ); } ?>
				<?php foreach ( $logos as $l ) { $render_logo( $l, true ); } ?>
			</div>
		</div>
		<p class="clientes__manifesto" data-reveal><?php echo marguerite_markup_text( $manifesto ); // phpcs:ignore ?></p>
		<ol class="clientes__metrics">
			<?php foreach ( $metricas as $m ) : ?>
				<li class="clientes__metric" data-reveal>
					<span class="index-num"><?php echo esc_html( $m['num'] ?? '' ); ?></span>
					<h3><?php echo esc_html( $m['titulo'] ?? '' ); ?></h3>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>
