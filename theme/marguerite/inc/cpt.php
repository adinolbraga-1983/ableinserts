<?php
/**
 * Custom Post Types: Cases, Clientes, Depoimentos.
 *
 * @package Marguerite
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', function () {

	// ---- Cases ----
	register_post_type( 'case', array(
		'labels' => array(
			'name'               => __( 'Cases', 'marguerite' ),
			'singular_name'      => __( 'Case', 'marguerite' ),
			'add_new_item'       => __( 'Novo case', 'marguerite' ),
			'edit_item'          => __( 'Editar case', 'marguerite' ),
			'menu_name'          => __( 'Cases', 'marguerite' ),
		),
		'public'       => true,
		'has_archive'  => true,
		'menu_icon'    => 'dashicons-format-gallery',
		'menu_position'=> 20,
		'rewrite'      => array( 'slug' => 'cases' ),
		'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
		'show_in_rest' => true,
	) );

	// ---- Clientes ----
	register_post_type( 'cliente', array(
		'labels' => array(
			'name'          => __( 'Clientes', 'marguerite' ),
			'singular_name' => __( 'Cliente', 'marguerite' ),
			'add_new_item'  => __( 'Novo cliente', 'marguerite' ),
			'menu_name'     => __( 'Clientes', 'marguerite' ),
		),
		'public'       => false,
		'show_ui'      => true,
		'menu_icon'    => 'dashicons-awards',
		'menu_position'=> 21,
		'supports'     => array( 'title', 'page-attributes' ),
		'show_in_rest' => true,
	) );

	// ---- Depoimentos ----
	register_post_type( 'depoimento', array(
		'labels' => array(
			'name'          => __( 'Depoimentos', 'marguerite' ),
			'singular_name' => __( 'Depoimento', 'marguerite' ),
			'add_new_item'  => __( 'Novo depoimento', 'marguerite' ),
			'menu_name'     => __( 'Depoimentos', 'marguerite' ),
		),
		'public'       => false,
		'show_ui'      => true,
		'menu_icon'    => 'dashicons-format-quote',
		'menu_position'=> 22,
		'supports'     => array( 'title', 'page-attributes' ),
		'show_in_rest' => true,
	) );
} );

/**
 * Flush de rewrite rules na ativação (para o slug /cases funcionar).
 */
add_action( 'after_switch_theme', function () {
	flush_rewrite_rules();
} );
