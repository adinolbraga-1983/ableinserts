<?php
/**
 * Registro dos blocos ACF (um por seção) e categoria própria.
 *
 * @package Marguerite
 */

defined( 'ABSPATH' ) || exit;

// Categoria de blocos "Marguerite".
add_filter( 'block_categories_all', function ( $cats ) {
	array_unshift( $cats, array(
		'slug'  => 'marguerite',
		'title' => __( 'Marguerite', 'marguerite' ),
		'icon'  => null,
	) );
	return $cats;
} );

// Registra cada bloco a partir do seu block.json (ACF 6+ lê o campo "acf").
// Só quando o ACF Pro está ativo — sem ele, as seções são renderizadas
// diretamente pelos templates (marguerite_render_section), sem editor.
add_action( 'init', function () {
	if ( ! function_exists( 'acf_register_block_type' ) && ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}
	$blocks = array( 'hero', 'sobre', 'metodologia', 'cases-gallery', 'clientes', 'contato' );
	foreach ( $blocks as $block ) {
		$dir = MARGUERITE_DIR . '/blocks/' . $block;
		if ( file_exists( $dir . '/block.json' ) ) {
			register_block_type( $dir );
		}
	}
} );
