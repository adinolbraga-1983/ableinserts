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
 * Aviso se o ACF Pro não estiver ativo — o tema depende dele para os campos.
 */
add_action( 'admin_notices', function () {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		echo '<div class="notice notice-error"><p><strong>Marguerite:</strong> este tema requer o plugin <em>Advanced Custom Fields PRO</em> ativo para os blocos e campos editáveis.</p></div>';
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
