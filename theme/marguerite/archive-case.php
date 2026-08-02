<?php
/**
 * Arquivo de Cases — grid de exposição.
 *
 * @package Marguerite
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<section class="section cases cases--archive">
	<div class="container">
		<span class="eyebrow"><?php esc_html_e( 'Cases', 'marguerite' ); ?></span>
		<h1 class="cases__title"><?php post_type_archive_title(); ?></h1>
	</div>
	<div class="container">
		<ul class="cases__grid">
			<?php while ( have_posts() ) : the_post(); $meta = get_field( 'card_meta' ); ?>
				<li class="case-card">
					<a class="case-card__media" href="<?php the_permalink(); ?>">
						<?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'marguerite-case', array( 'class' => 'case-card__img', 'loading' => 'lazy' ) ); } ?>
						<span class="case-card__overlay"></span>
						<span class="case-card__play" aria-hidden="true">▶</span>
					</a>
					<div class="case-card__cap">
						<p class="case-card__name"><?php the_title(); ?></p>
						<?php if ( $meta ) : ?><p class="case-card__meta"><?php echo esc_html( $meta ); ?></p><?php endif; ?>
					</div>
				</li>
			<?php endwhile; ?>
		</ul>
		<?php the_posts_pagination(); ?>
	</div>
</section>
<?php
marguerite_render_section( 'clientes' );
get_footer();
