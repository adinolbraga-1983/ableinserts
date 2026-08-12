<?php
/**
 * Marguerite Experience — funções do tema.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MARGUERITE_VERSION', '1.0.0' );
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

	register_nav_menus(
		array(
			'primary' => __( 'Menu Principal', 'marguerite' ),
		)
	);
}
add_action( 'after_setup_theme', 'marguerite_setup' );

/**
 * Estilos e scripts.
 */
function marguerite_assets() {
	// Google Fonts — Poppins (pesos usados no design).
	wp_enqueue_style(
		'marguerite-fonts',
		'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'marguerite-style',
		MARGUERITE_URI . '/assets/css/style.css',
		array( 'marguerite-fonts' ),
		MARGUERITE_VERSION
	);

	// GSAP via CDN, conforme solicitado (https://gsap.com/).
	wp_enqueue_script( 'gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js', array(), '3.12.5', true );
	wp_enqueue_script( 'gsap-scrolltrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js', array( 'gsap' ), '3.12.5', true );

	wp_enqueue_script(
		'marguerite-main',
		MARGUERITE_URI . '/assets/js/main.js',
		array( 'gsap', 'gsap-scrolltrigger' ),
		MARGUERITE_VERSION,
		true
	);

	wp_localize_script(
		'marguerite-main',
		'margueriteData',
		array(
			'reducedMotion' => false,
		)
	);
}
add_action( 'wp_enqueue_scripts', 'marguerite_assets' );

/**
 * Remove elementos desnecessários do <head>.
 */
function marguerite_cleanup_head() {
	remove_action( 'wp_head', 'wp_generator' );
}
add_action( 'init', 'marguerite_cleanup_head' );

require MARGUERITE_DIR . '/inc/customizer.php';

/**
 * Fallback de menu quando nenhum menu WP estiver atribuído: usa as âncoras
 * da página única, replicando a navegação definida no Figma.
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
			<li><a class="nav-link" href="#<?php echo esc_attr( $ancora ); ?>"><span><?php echo esc_html( $rotulo ); ?></span><i></i></a></li>
		<?php endforeach; ?>
	</ul>
	<?php
}
