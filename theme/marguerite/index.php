<?php
/**
 * Fallback genérico (blog/arquivos). O tema é focado em páginas + Cases.
 *
 * @package Marguerite
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<section class="section">
	<div class="container container--text">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article <?php post_class( 'entry' ); ?>>
					<h2 class="entry__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="entry__excerpt"><?php the_excerpt(); ?></div>
				</article>
			<?php endwhile; ?>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'Nada encontrado.', 'marguerite' ); ?></p>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
