<?php
/**
 * Enfileiramento de estilos e scripts (front-end + editor).
 *
 * @package Marguerite
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', function () {
	$css = MARGUERITE_URI . '/assets/css/';
	$js  = MARGUERITE_URI . '/assets/js/';
	$v   = MARGUERITE_VERSION;

	// Ordem: tokens → fontes → base → seções.
	wp_enqueue_style( 'marguerite-tokens', $css . 'tokens.css', array(), $v );
	wp_enqueue_style( 'marguerite-fonts', $css . 'fonts.css', array(), $v );
	wp_enqueue_style( 'marguerite-base', $css . 'base.css', array( 'marguerite-tokens', 'marguerite-fonts' ), $v );
	wp_enqueue_style( 'marguerite-sections', $css . 'sections.css', array( 'marguerite-base' ), $v );

	// Bibliotecas de animação (globais, vendorizadas — sem CDN).
	wp_enqueue_script( 'gsap', $js . 'gsap.min.js', array(), '3.12.5', true );
	wp_enqueue_script( 'gsap-scrolltrigger', $js . 'ScrollTrigger.min.js', array( 'gsap' ), '3.12.5', true );
	wp_enqueue_script( 'lenis', $js . 'lenis.min.js', array(), '1.0.42', true );

	// Three.js só onde há hero WebGL (front page). Carrega antes do hero-webgl.
	if ( is_front_page() || is_page_template( 'templates/page-home.php' ) ) {
		wp_enqueue_script( 'three', $js . 'three.umd.min.js', array(), '0.160.0', true );
		wp_enqueue_script( 'marguerite-hero-webgl', $js . 'hero-webgl.js', array( 'three' ), $v, true );
	}

	wp_enqueue_script( 'marguerite-app', $js . 'app.js', array( 'gsap', 'gsap-scrolltrigger', 'lenis' ), $v, true );
}, 20 );

/**
 * Preload do LCP (poster do hero) e das fontes críticas.
 */
add_action( 'wp_head', function () {
	if ( ! is_front_page() ) {
		return;
	}
	$img  = MARGUERITE_URI . '/assets/img/hero-poster.jpg';
	$f400 = MARGUERITE_URI . '/assets/fonts/poppins-400.woff2';
	$f500 = MARGUERITE_URI . '/assets/fonts/poppins-500.woff2';
	echo '<link rel="preload" as="image" href="' . esc_url( $img ) . '" fetchpriority="high" />' . "\n";
	echo '<link rel="preload" as="font" type="font/woff2" href="' . esc_url( $f400 ) . '" crossorigin />' . "\n";
	echo '<link rel="preload" as="font" type="font/woff2" href="' . esc_url( $f500 ) . '" crossorigin />' . "\n";
}, 1 );

/**
 * Estilos do editor (Gutenberg) — carrega os mesmos tokens para preview fiel.
 */
add_action( 'enqueue_block_editor_assets', function () {
	$css = MARGUERITE_URI . '/assets/css/';
	wp_enqueue_style( 'marguerite-editor-tokens', $css . 'tokens.css', array(), MARGUERITE_VERSION );
	wp_enqueue_style( 'marguerite-editor-fonts', $css . 'fonts.css', array(), MARGUERITE_VERSION );
	wp_enqueue_style( 'marguerite-editor-sections', $css . 'sections.css', array(), MARGUERITE_VERSION );
} );
