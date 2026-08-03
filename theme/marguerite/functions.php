<?php
/**
 * Marguerite — bootstrap do tema.
 *
 * @package Marguerite
 */

defined( 'ABSPATH' ) || exit;

define( 'MARGUERITE_VERSION', '1.0.0' );
define( 'MARGUERITE_DIR', get_template_directory() );
define( 'MARGUERITE_URI', get_template_directory_uri() );

/**
 * O tema FUNCIONA sem ACF: mostra o conteúdo-base de cada seção. O ACF Pro é
 * opcional e serve para EDITAR pelo painel. Shims garantem que os render.php
 * não quebrem quando o ACF não está ativo (get_field devolve null → fallback).
 */
if ( ! function_exists( 'get_field' ) ) {
	function get_field( $selector = '', $post_id = false, $format_value = true ) { return null; }
}
if ( ! function_exists( 'the_field' ) ) {
	function the_field( $selector = '', $post_id = false ) { echo ''; }
}
if ( ! function_exists( 'have_rows' ) ) {
	function have_rows( $selector = '', $post_id = false ) { return false; }
}

// Aviso amigável (não bloqueante) sugerindo o ACF Pro para edição.
add_action( 'admin_notices', function () {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		echo '<div class="notice notice-info is-dismissible"><p><strong>Marguerite:</strong> o site já funciona com o conteúdo-base. Para <em>editar</em> textos, imagens e vídeos pelo painel, instale o <em>Advanced Custom Fields PRO</em>.</p></div>';
	}
} );

require_once MARGUERITE_DIR . '/inc/helpers.php';
require_once MARGUERITE_DIR . '/inc/setup.php';
require_once MARGUERITE_DIR . '/inc/enqueue.php';
require_once MARGUERITE_DIR . '/inc/cpt.php';
require_once MARGUERITE_DIR . '/inc/taxonomies.php';
require_once MARGUERITE_DIR . '/inc/blocks.php';
require_once MARGUERITE_DIR . '/inc/performance.php';
require_once MARGUERITE_DIR . '/inc/seo.php';

// Campos ACF (blocos + CPTs + opções globais).
if ( function_exists( 'acf_add_local_field_group' ) ) {
	require_once MARGUERITE_DIR . '/inc/options.php';
	require_once MARGUERITE_DIR . '/inc/fields.php';
}
