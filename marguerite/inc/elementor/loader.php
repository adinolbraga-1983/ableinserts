<?php
/**
 * Integração com o Elementor.
 *
 * Registra uma categoria própria ("Marguerite") e os widgets de cada seção da
 * página. Usa apenas APIs do Elementor GRATUITO — nada aqui depende do Pro.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Categoria própria no painel de widgets do Elementor.
 */
function marguerite_elementor_category( $elements_manager ) {
	$elements_manager->add_category(
		'marguerite',
		array(
			'title' => 'Marguerite',
			'icon'  => 'eicon-flower',
		)
	);
}
add_action( 'elementor/elements/categories_registered', 'marguerite_elementor_category' );

/**
 * Registra os widgets do tema.
 */
function marguerite_register_widgets( $widgets_manager ) {
	$base = MARGUERITE_DIR . '/inc/elementor/widgets/';

	require_once $base . 'class-base.php';

	$widgets = array(
		'hero'        => 'Marguerite_Widget_Hero',
		'quem-somos'  => 'Marguerite_Widget_Quem_Somos',
		'metodologia' => 'Marguerite_Widget_Metodologia',
		'executivas'  => 'Marguerite_Widget_Executivas',
		'cases'       => 'Marguerite_Widget_Cases',
		'marcas'      => 'Marguerite_Widget_Marcas',
		'cta'         => 'Marguerite_Widget_Cta',
	);

	foreach ( $widgets as $arquivo => $classe ) {
		$caminho = $base . 'class-' . $arquivo . '.php';
		if ( file_exists( $caminho ) ) {
			require_once $caminho;
			if ( class_exists( $classe ) ) {
				$widgets_manager->register( new $classe() );
			}
		}
	}
}
add_action( 'elementor/widgets/register', 'marguerite_register_widgets' );

/**
 * Aviso caso o Elementor não esteja instalado/ativo.
 */
function marguerite_elementor_missing_notice() {
	if ( did_action( 'elementor/loaded' ) || ! current_user_can( 'activate_plugins' ) ) {
		return;
	}
	echo '<div class="notice notice-warning"><p><strong>Tema Marguerite:</strong> instale e ative o plugin <em>Elementor</em> (versão gratuita) para editar as seções da página. O site continua funcionando sem ele, mas as seções não aparecerão no editor.</p></div>';
}
add_action( 'admin_notices', 'marguerite_elementor_missing_notice' );
