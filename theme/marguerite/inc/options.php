<?php
/**
 * Página de opções globais (ACF) + campos de identidade/contato/SEO.
 *
 * @package Marguerite
 */

defined( 'ABSPATH' ) || exit;

// Página de opções "Marguerite".
add_action( 'acf/init', function () {
	if ( ! function_exists( 'acf_add_options_page' ) ) {
		return;
	}
	acf_add_options_page( array(
		'page_title' => __( 'Configurações Marguerite', 'marguerite' ),
		'menu_title' => __( 'Marguerite', 'marguerite' ),
		'menu_slug'  => 'marguerite-settings',
		'capability' => 'edit_theme_options',
		'position'   => 2,
		'icon_url'   => 'dashicons-admin-customizer',
		'redirect'   => false,
	) );
} );

add_action( 'acf/init', function () {
	acf_add_local_field_group( array(
		'key'      => 'group_marguerite_options',
		'title'    => __( 'Configurações globais', 'marguerite' ),
		'location' => array( array( array(
			'param'    => 'options_page',
			'operator' => '==',
			'value'    => 'marguerite-settings',
		) ) ),
		'fields'   => array(
			// Identidade.
			array( 'key' => 'opt_tab_id', 'label' => __( 'Identidade', 'marguerite' ), 'type' => 'tab' ),
			array( 'key' => 'opt_logo_icon', 'label' => __( 'Ícone (flor)', 'marguerite' ), 'name' => 'logo_icon', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'thumbnail' ),
			array( 'key' => 'opt_logo_wordmark', 'label' => __( 'Wordmark (marguerite)', 'marguerite' ), 'name' => 'logo_wordmark', 'type' => 'image', 'return_format' => 'array' ),
			array( 'key' => 'opt_logo_icon_white', 'label' => __( 'Ícone — versão branca', 'marguerite' ), 'name' => 'logo_icon_white', 'type' => 'image', 'return_format' => 'array' ),
			array( 'key' => 'opt_logo_wordmark_white', 'label' => __( 'Wordmark — versão branca', 'marguerite' ), 'name' => 'logo_wordmark_white', 'type' => 'image', 'return_format' => 'array' ),

			// Contato / social.
			array( 'key' => 'opt_tab_contato', 'label' => __( 'Contato & Social', 'marguerite' ), 'type' => 'tab' ),
			array( 'key' => 'opt_email', 'label' => __( 'E-mail', 'marguerite' ), 'name' => 'contato_email', 'type' => 'email', 'default_value' => 'contato@marguerite.com.br' ),
			array( 'key' => 'opt_cidade', 'label' => __( 'Cidade', 'marguerite' ), 'name' => 'org_cidade', 'type' => 'text', 'default_value' => 'São Paulo' ),
			array( 'key' => 'opt_uf', 'label' => __( 'UF', 'marguerite' ), 'name' => 'org_uf', 'type' => 'text', 'default_value' => 'SP' ),
			array( 'key' => 'opt_org_nome', 'label' => __( 'Nome da organização', 'marguerite' ), 'name' => 'org_nome', 'type' => 'text', 'default_value' => 'Marguerite' ),
			array( 'key' => 'opt_org_fund', 'label' => __( 'Ano de fundação', 'marguerite' ), 'name' => 'org_fundacao', 'type' => 'text', 'default_value' => '1991' ),
			array( 'key' => 'opt_social', 'label' => __( 'Redes sociais', 'marguerite' ), 'name' => 'social', 'type' => 'repeater', 'button_label' => __( 'Adicionar rede', 'marguerite' ), 'sub_fields' => array(
				array( 'key' => 'opt_social_label', 'label' => 'Rótulo', 'name' => 'label', 'type' => 'text' ),
				array( 'key' => 'opt_social_url', 'label' => 'URL', 'name' => 'url', 'type' => 'url' ),
			) ),

			// CTA global.
			array( 'key' => 'opt_tab_cta', 'label' => __( 'CTA', 'marguerite' ), 'type' => 'tab' ),
			array( 'key' => 'opt_cta_label', 'label' => __( 'Texto do CTA do header', 'marguerite' ), 'name' => 'cta_label', 'type' => 'text', 'default_value' => 'Agende uma reunião' ),
			array( 'key' => 'opt_cta_link', 'label' => __( 'Link do CTA', 'marguerite' ), 'name' => 'cta_link', 'type' => 'text', 'default_value' => '#contato' ),

			// SEO padrão.
			array( 'key' => 'opt_tab_seo', 'label' => __( 'SEO', 'marguerite' ), 'type' => 'tab' ),
			array( 'key' => 'opt_seo_desc', 'label' => __( 'Descrição padrão', 'marguerite' ), 'name' => 'seo_descricao_padrao', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Agência boutique de eventos e marketing de experiência. Há 34 anos criando experiências memoráveis e conexões reais entre marcas e pessoas.' ),
			array( 'key' => 'opt_seo_og', 'label' => __( 'Imagem OG padrão', 'marguerite' ), 'name' => 'seo_og_padrao', 'type' => 'image', 'return_format' => 'array' ),
		),
	) );
} );
