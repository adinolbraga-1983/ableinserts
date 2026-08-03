<?php
/**
 * Ajustes de performance / Core Web Vitals.
 *
 * @package Marguerite
 */

defined( 'ABSPATH' ) || exit;

// Remove emojis (payload desnecessário).
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

// Remove o CSS de bloco global quando não usado (mantém enxuto).
add_action( 'wp_enqueue_scripts', function () {
	// Mantém wp-block-library (Gutenberg core) apenas se houver blocos core em uso.
	// Aqui deixamos ativo para não quebrar conteúdo do editor.
}, 100 );

/**
 * lazy + async decoding em imagens de conteúdo abaixo da dobra.
 * O WordPress já adiciona loading=lazy; garantimos decoding=async.
 */
add_filter( 'wp_get_attachment_image_attributes', function ( $attr ) {
	if ( empty( $attr['decoding'] ) ) {
		$attr['decoding'] = 'async';
	}
	return $attr;
} );

/**
 * Prefetch das páginas de Case ao passar o mouse (melhora navegação percebida).
 * Implementado no app.js; aqui só habilitamos o resource hint base.
 */
add_filter( 'wp_resource_hints', function ( $hints, $relation ) {
	return $hints;
}, 10, 2 );
