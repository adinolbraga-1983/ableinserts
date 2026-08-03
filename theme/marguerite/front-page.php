<?php
/**
 * Front page. Se a página inicial tiver conteúdo (blocos do editor), renderiza-o;
 * caso contrário, monta a home padrão com as seções Marguerite (conteúdo-base).
 * Funciona com ou sem ACF Pro.
 *
 * @package Marguerite
 */

defined( 'ABSPATH' ) || exit;

get_header();

$has_content = false;
if ( have_posts() ) {
	the_post();
	$has_content = trim( get_the_content() ) !== '';
	rewind_posts();
}

if ( $has_content ) {
	while ( have_posts() ) {
		the_post();
		the_content();
	}
} else {
	// Home padrão — cada seção cai para o conteúdo-base.
	foreach ( array( 'hero', 'sobre', 'metodologia', 'cases-gallery', 'clientes', 'contato' ) as $section ) {
		marguerite_render_section( $section );
	}
}

get_footer();
