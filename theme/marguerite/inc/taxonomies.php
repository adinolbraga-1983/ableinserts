<?php
/**
 * Taxonomias dos Cases: tipo de projeto e segmento.
 *
 * @package Marguerite
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', function () {
	register_taxonomy( 'tipo_projeto', array( 'case' ), array(
		'labels'       => array(
			'name'          => __( 'Tipos de projeto', 'marguerite' ),
			'singular_name' => __( 'Tipo de projeto', 'marguerite' ),
		),
		'hierarchical' => true,
		'public'       => true,
		'show_in_rest' => true,
		'rewrite'      => array( 'slug' => 'tipo' ),
	) );

	register_taxonomy( 'segmento', array( 'case', 'cliente' ), array(
		'labels'       => array(
			'name'          => __( 'Segmentos', 'marguerite' ),
			'singular_name' => __( 'Segmento', 'marguerite' ),
		),
		'hierarchical' => false,
		'public'       => true,
		'show_in_rest' => true,
		'rewrite'      => array( 'slug' => 'segmento' ),
	) );
} );
