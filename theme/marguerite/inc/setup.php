<?php
/**
 * Suporte do tema, menus e tamanhos de imagem.
 *
 * @package Marguerite
 */

defined( 'ABSPATH' ) || exit;

add_action( 'after_setup_theme', function () {
	load_theme_textdomain( 'marguerite', MARGUERITE_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor.css' );

	// Menus.
	register_nav_menus( array(
		'primary' => __( 'Navegação principal', 'marguerite' ),
		'footer'  => __( 'Rodapé', 'marguerite' ),
	) );

	// Tamanhos de imagem alinhados aos usos (hero, retrato, card 2:3).
	add_image_size( 'marguerite-hero', 1920, 900, true );
	add_image_size( 'marguerite-portrait', 1600, 1000, true );
	add_image_size( 'marguerite-case', 780, 1170, true ); // 2:3
} );

/**
 * Classe do menu de navegação (scroll-spy usa data-spy; ver walker simples abaixo).
 * Para simplicidade, o header usa wp_nav_menu com fallback para âncoras da home.
 */
add_filter( 'nav_menu_link_attributes', function ( $atts, $item ) {
	// Se o link for uma âncora (#sobre), marca com data-spy para o scroll-spy do JS.
	if ( isset( $atts['href'] ) && strpos( $atts['href'], '#' ) !== false ) {
		$frag = substr( strrchr( $atts['href'], '#' ), 1 );
		if ( $frag ) {
			$atts['data-spy'] = $frag;
		}
	}
	$atts['class'] = trim( ( $atts['class'] ?? '' ) . ' nav__link' );
	return $atts;
}, 10, 2 );
