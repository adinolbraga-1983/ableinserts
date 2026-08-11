<?php
/**
 * Template da página inicial — página única "Marguerite".
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="conteudo" class="site-main">
	<?php get_template_part( 'template-parts/section', 'hero' ); ?>
	<?php get_template_part( 'template-parts/section', 'quem-somos' ); ?>
	<?php get_template_part( 'template-parts/section', 'metodologia' ); ?>
	<?php get_template_part( 'template-parts/section', 'profissionais' ); ?>
	<?php get_template_part( 'template-parts/section', 'portfolio' ); ?>
	<?php get_template_part( 'template-parts/section', 'cta' ); ?>

<?php
get_footer();
