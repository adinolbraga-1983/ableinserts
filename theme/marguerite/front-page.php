<?php
/**
 * Front page. Renderiza o conteúdo (blocos) da página inicial; se estiver
 * vazia, monta a home padrão com os blocos Marguerite (que usam o conteúdo-base).
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
	// Home padrão: sequência de blocos (cada um cai para o conteúdo-base).
	$default = implode( "\n", array(
		'<!-- wp:acf/hero {"name":"acf/hero","mode":"preview"} /-->',
		'<!-- wp:acf/sobre {"name":"acf/sobre","mode":"preview"} /-->',
		'<!-- wp:acf/metodologia {"name":"acf/metodologia","mode":"preview"} /-->',
		'<!-- wp:acf/cases-gallery {"name":"acf/cases-gallery","mode":"preview"} /-->',
		'<!-- wp:acf/clientes {"name":"acf/clientes","mode":"preview"} /-->',
		'<!-- wp:acf/contato {"name":"acf/contato","mode":"preview"} /-->',
	) );
	echo do_blocks( $default ); // phpcs:ignore WordPress.Security.EscapeOutput
}

get_footer();
