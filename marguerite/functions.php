<?php
/**
 * Marguerite Experience — funções do tema.
 *
 * As seções da página são widgets do Elementor (registrados em inc/elementor/),
 * o que funciona no Elementor GRATUITO. O cabeçalho e o rodapé vêm do tema e são
 * editáveis em Aparência → Personalizar, cobrindo o que o Theme Builder (Pro) faria.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MARGUERITE_VERSION', '2.0.0' );
define( 'MARGUERITE_DIR', get_template_directory() );
define( 'MARGUERITE_URI', get_template_directory_uri() );

/**
 * Setup do tema.
 */
function marguerite_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'align-wide' );

	register_nav_menus(
		array(
			'primary' => __( 'Menu Principal', 'marguerite' ),
		)
	);
}
add_action( 'after_setup_theme', 'marguerite_setup' );

/**
 * O conteúdo desta página foi construído com o Elementor?
 */
function marguerite_is_built_with_elementor( $post_id ) {
	if ( ! $post_id || ! did_action( 'elementor/loaded' ) ) {
		return false;
	}
	if ( ! class_exists( '\Elementor\Plugin' ) || ! isset( \Elementor\Plugin::$instance->documents ) ) {
		return false;
	}
	$document = \Elementor\Plugin::$instance->documents->get( $post_id );
	return $document && $document->is_built_with_elementor();
}

/**
 * Estilos e scripts do site.
 */
function marguerite_assets() {
	// Poppins servida pelo próprio site (sem depender do Google Fonts):
	// carrega mais rápido e não vaza IP dos visitantes para terceiros.
	wp_enqueue_style(
		'marguerite-fonts',
		MARGUERITE_URI . '/assets/css/fonts.css',
		array(),
		MARGUERITE_VERSION
	);

	wp_enqueue_style(
		'marguerite-style',
		MARGUERITE_URI . '/assets/css/style.css',
		array( 'marguerite-fonts' ),
		MARGUERITE_VERSION
	);

	// GSAP + ScrollTrigger (animações de entrada, parallax, marquee).
	// Ficam dentro do tema de propósito: se um CDN externo falhar, o site perde
	// as animações — assim ele não depende de nada fora do servidor.
	wp_enqueue_script( 'gsap', MARGUERITE_URI . '/assets/js/gsap.min.js', array(), '3.12.5', true );
	wp_enqueue_script( 'gsap-scrolltrigger', MARGUERITE_URI . '/assets/js/ScrollTrigger.min.js', array( 'gsap' ), '3.12.5', true );

	wp_enqueue_script(
		'marguerite-main',
		MARGUERITE_URI . '/assets/js/main.js',
		array( 'gsap', 'gsap-scrolltrigger' ),
		MARGUERITE_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'marguerite_assets' );

/**
 * O kit padrão do Elementor baixa Roboto e Roboto Slab do Google Fonts — fontes
 * que este layout não usa. Desligamos para não gastar duas requisições externas
 * (a tipografia do site é a Poppins, servida pelo próprio servidor).
 */
add_filter( 'elementor/frontend/print_google_fonts', '__return_false' );

/**
 * Dentro do editor do Elementor, as animações de entrada escondem o conteúdo
 * (opacity: 0) e atrapalham a edição. Neutralizamos só no editor/preview.
 */
function marguerite_editor_reveal_fix() {
	echo '<style>[data-reveal]{opacity:1 !important;transform:none !important}</style>';
}
add_action( 'elementor/editor/wp_head', 'marguerite_editor_reveal_fix' );
add_action( 'elementor/preview/enqueue_styles', function () {
	wp_add_inline_style( 'marguerite-style', '[data-reveal]{opacity:1 !important;transform:none !important}' );
} );

/**
 * Remove itens desnecessários do <head>.
 */
function marguerite_cleanup_head() {
	remove_action( 'wp_head', 'wp_generator' );
}
add_action( 'init', 'marguerite_cleanup_head' );

/**
 * Menu principal: usa o menu do WordPress quando houver um atribuído;
 * caso contrário, cai nas âncoras da página única.
 */
function marguerite_primary_menu() {
	if ( has_nav_menu( 'primary' ) ) {
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'nav-list',
				'depth'          => 1,
			)
		);
		return;
	}

	$itens = array(
		'sobre'       => get_theme_mod( 'marguerite_nav_sobre', 'Sobre' ),
		'metodologia' => get_theme_mod( 'marguerite_nav_metodologia', 'Metodologia' ),
		'executivas'  => get_theme_mod( 'marguerite_nav_executivas', 'Executivas' ),
		'cases'       => get_theme_mod( 'marguerite_nav_cases', 'Cases' ),
		'contato'     => get_theme_mod( 'marguerite_nav_contato', 'Contato' ),
	);
	?>
	<ul class="nav-list">
		<?php foreach ( $itens as $ancora => $rotulo ) : ?>
			<?php if ( '' === trim( (string) $rotulo ) ) { continue; } ?>
			<li><a href="#<?php echo esc_attr( $ancora ); ?>"><?php echo esc_html( $rotulo ); ?></a></li>
		<?php endforeach; ?>
	</ul>
	<?php
}

require MARGUERITE_DIR . '/inc/customizer.php';
require MARGUERITE_DIR . '/inc/elementor/loader.php';
require MARGUERITE_DIR . '/inc/importer.php';
