<?php
/**
 * Bloco: Galeria de Cases. Puxa do CPT `case`; cai para placeholders se vazio.
 *
 * @package Marguerite
 */

defined( 'ABSPATH' ) || exit;

$eyebrow  = get_field( 'eyebrow' ) ?: 'Cases';
$headline = get_field( 'headline' ) ?: 'Projetos conduzidos por nossas executivas';
$cta      = get_field( 'cta_label' ) ?: 'Ver todos';
$qtd      = (int) ( get_field( 'quantidade' ) ?: 4 );

$block_id = ! empty( $block['anchor'] ) ? esc_attr( $block['anchor'] ) : 'cases';

$query = new WP_Query( array(
	'post_type'      => 'case',
	'posts_per_page' => $qtd,
	'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
	'no_found_rows'  => true,
) );

// Placeholders (quando ainda não há Cases cadastrados).
$placeholders = array(
	array( 'nome' => 'Convenção SKY 2023', 'meta' => '300 pessoas · Jequitimar · Guarujá', 'img' => 'img/case-sky.jpg' ),
	array( 'nome' => 'Tegra Guest', 'meta' => '980 pessoas · Iberostar · Salvador', 'img' => 'img/case-tegra.jpg' ),
	array( 'nome' => 'Convenção SKY 2025', 'meta' => '980 pessoas · Iberostar · Salvador', 'img' => 'img/case-neon.jpg' ),
	array( 'nome' => 'Palco Principal', 'meta' => '980 pessoas · Iberostar · Salvador', 'img' => 'img/case-stage.jpg' ),
);
?>
<section class="section cases" id="<?php echo $block_id; ?>" aria-labelledby="cases-title">
	<div class="container cases__head">
		<div>
			<span class="eyebrow" data-reveal><?php echo esc_html( $eyebrow ); ?></span>
			<h2 class="cases__title" id="cases-title" data-reveal><?php echo esc_html( $headline ); ?></h2>
		</div>
		<a class="link-underline" href="<?php echo esc_url( get_post_type_archive_link( 'case' ) ?: '#' ); ?>" data-reveal><?php echo esc_html( $cta ); ?> <?php echo marguerite_arrow(); // phpcs:ignore ?></a>
	</div>
	<div class="cases__track-wrap">
		<ul class="cases__track" id="cases-track">
			<?php if ( $query->have_posts() ) : ?>
				<?php while ( $query->have_posts() ) : $query->the_post(); $meta = get_field( 'card_meta' ); ?>
					<li class="case-card">
						<a class="case-card__media" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( sprintf( 'Abrir case %s', get_the_title() ) ); ?>">
							<?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'marguerite-case', array( 'class' => 'case-card__img', 'loading' => 'lazy' ) ); endif; ?>
							<span class="case-card__overlay"></span>
							<span class="case-card__play" aria-hidden="true">▶</span>
						</a>
						<div class="case-card__cap">
							<p class="case-card__name"><?php the_title(); ?></p>
							<?php if ( $meta ) : ?><p class="case-card__meta"><?php echo esc_html( $meta ); ?></p><?php endif; ?>
						</div>
					</li>
				<?php endwhile; wp_reset_postdata(); ?>
			<?php else : ?>
				<?php foreach ( $placeholders as $c ) : ?>
					<li class="case-card">
						<a class="case-card__media" href="#" aria-label="<?php echo esc_attr( sprintf( 'Abrir case %s', $c['nome'] ) ); ?>">
							<img class="case-card__img" src="<?php echo esc_url( marguerite_asset( $c['img'] ) ); ?>" alt="<?php echo esc_attr( $c['nome'] ); ?>" loading="lazy" decoding="async" />
							<span class="case-card__overlay"></span>
							<span class="case-card__play" aria-hidden="true">▶</span>
						</a>
						<div class="case-card__cap">
							<p class="case-card__name"><?php echo esc_html( $c['nome'] ); ?></p>
							<p class="case-card__meta"><?php echo esc_html( $c['meta'] ); ?></p>
						</div>
					</li>
				<?php endforeach; ?>
			<?php endif; ?>
		</ul>
	</div>
</section>
