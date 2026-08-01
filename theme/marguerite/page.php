<?php
/**
 * Página genérica (renderiza blocos do editor).
 *
 * @package Marguerite
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	// Se a página só tem blocos full-bleed, o the_content já os renderiza.
	if ( trim( get_the_content() ) === '' ) {
		echo '<section class="section"><div class="container container--text"><h1>' . esc_html( get_the_title() ) . '</h1></div></section>';
	} else {
		the_content();
	}
endwhile;

get_footer();
