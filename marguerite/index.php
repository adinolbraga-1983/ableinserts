<?php
/**
 * Template padrão (fallback). A página inicial usa front-page.php;
 * este arquivo cobre demais contextos exigidos pela hierarquia do WordPress.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="conteudo" class="site-main site-main--simple">
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

<?php
get_footer();
