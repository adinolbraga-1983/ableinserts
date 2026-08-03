<?php
/**
 * Case individual (template Interna).
 *
 * @package Marguerite
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	$tipo   = get_field( 'ficha_tipo' );
	$dim    = get_field( 'ficha_dimensao' );
	$local  = get_field( 'ficha_local' );
	$desafio= get_field( 'desafio' );
	$solucao= get_field( 'solucao' );
	$result = get_field( 'resultado' );
	$galeria= get_field( 'galeria' );
	?>
	<article class="case">
		<header class="case-hero">
			<div class="case-hero__bg" aria-hidden="true">
				<?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'marguerite-hero', array( 'class' => 'case-hero__img' ) ); } ?>
				<div class="case-hero__overlay"></div>
			</div>
			<div class="container case-hero__cartela">
				<span class="eyebrow">Cases</span>
				<h1 class="case-hero__title"><?php the_title(); ?></h1>
			</div>
		</header>

		<div class="container container--text case-body">
			<?php if ( $tipo || $dim || $local ) : ?>
				<div class="case-sheet">
					<?php if ( $tipo ) : ?><p class="case-sheet__row"><?php echo esc_html( $tipo ); ?></p><?php endif; ?>
					<?php if ( $dim ) : ?><p class="case-sheet__row"><?php echo esc_html( $dim ); ?></p><?php endif; ?>
					<?php if ( $local ) : ?><p class="case-sheet__row"><?php echo esc_html( $local ); ?></p><?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( $desafio ) : ?>
				<h2 class="case-body__h" data-reveal>O Desafio</h2>
				<div class="case-body__rich" data-reveal><?php echo wp_kses_post( $desafio ); ?></div>
			<?php endif; ?>

			<?php if ( $solucao ) : ?>
				<h2 class="case-body__h" data-reveal>A Solução: Nosso Fluxo na Prática</h2>
				<ol class="case-steps">
					<?php foreach ( $solucao as $i => $step ) : ?>
						<li class="case-steps__item" data-reveal>
							<h3><?php echo esc_html( ( $i + 1 ) . '. ' . ( $step['titulo'] ?? '' ) ); ?></h3>
							<?php if ( ! empty( $step['texto'] ) ) : ?><p><?php echo esc_html( $step['texto'] ); ?></p><?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ol>
			<?php endif; ?>

			<?php if ( $result ) : ?>
				<div class="case-results" data-reveal>
					<?php foreach ( $result as $r ) : ?>
						<div class="case-results__item">
							<span class="case-results__value"><?php echo esc_html( $r['valor'] ?? '' ); ?></span>
							<span class="case-results__label"><?php echo esc_html( $r['metrica'] ?? '' ); ?></span>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php if ( $galeria ) : ?>
				<div class="case-gallery" data-reveal>
					<?php foreach ( $galeria as $img ) : ?>
						<?php echo marguerite_image( $img, 'large', array( 'class' => 'case-gallery__img', 'loading' => 'lazy' ) ); // phpcs:ignore ?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</article>

	<?php
	// Reaproveita seções globais: outros cases + clientes.
	marguerite_render_section( 'cases-gallery' );
	marguerite_render_section( 'clientes' );

endwhile;

get_footer();
