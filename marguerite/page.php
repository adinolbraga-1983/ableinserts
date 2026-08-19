<?php
/**
 * Página. Quando o conteúdo é construído no Elementor, ele assume a largura
 * total; caso contrário, cai no container padrão do tema.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$marguerite_built_with_elementor = marguerite_is_built_with_elementor( get_the_ID() );
?>
<main id="conteudo" class="site-main<?php echo $marguerite_built_with_elementor ? ' site-main--elementor' : ''; ?>">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php if ( $marguerite_built_with_elementor ) : ?>
			<?php the_content(); ?>
		<?php else : ?>
			<div class="container section">
				<h1 class="h2"><?php the_title(); ?></h1>
				<div class="entry-content"><?php the_content(); ?></div>
			</div>
		<?php endif; ?>
	<?php endwhile; ?>
</main>
<?php
get_footer();
