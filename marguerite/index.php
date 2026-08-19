<?php
/**
 * Fallback exigido pela hierarquia de templates do WordPress.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="conteudo" class="site-main">
	<div class="container section">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article <?php post_class(); ?>>
					<h1 class="h2"><?php the_title(); ?></h1>
					<div class="entry-content"><?php the_content(); ?></div>
				</article>
			<?php endwhile; ?>
		<?php else : ?>
			<p><?php esc_html_e( 'Nada encontrado.', 'marguerite' ); ?></p>
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();
