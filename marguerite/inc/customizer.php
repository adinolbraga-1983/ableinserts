<?php
/**
 * Personalizador — cabeçalho e rodapé.
 *
 * O corpo da página é editado no Elementor; aqui ficam as partes que o
 * Elementor gratuito não alcança (cabeçalho, menu e rodapé).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function marguerite_customize_register( $wp_customize ) {

	/* ---------------- Cabeçalho e Menu ---------------- */
	$wp_customize->add_section(
		'marguerite_sec_header',
		array(
			'title'       => 'Cabeçalho e Menu',
			'priority'    => 30,
			'description' => 'Textos dos links do menu e do botão. Para trocar a ordem ou incluir páginas, use Aparência → Menus.',
		)
	);

	$campos_menu = array(
		'marguerite_nav_sobre'       => array( 'Menu — 1º link', 'Sobre' ),
		'marguerite_nav_metodologia' => array( 'Menu — 2º link', 'Metodologia' ),
		'marguerite_nav_executivas'  => array( 'Menu — 3º link', 'Executivas' ),
		'marguerite_nav_cases'       => array( 'Menu — 4º link', 'Cases' ),
		'marguerite_nav_contato'     => array( 'Menu — 5º link', 'Contato' ),
		'marguerite_nav_cta_label'   => array( 'Botão do menu — texto', 'Agende uma Reunião' ),
	);
	foreach ( $campos_menu as $id => $dados ) {
		$wp_customize->add_setting( $id, array( 'default' => $dados[1], 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control( $id, array( 'label' => $dados[0], 'section' => 'marguerite_sec_header', 'type' => 'text' ) );
	}

	$wp_customize->add_setting( 'marguerite_nav_cta_link', array( 'default' => '#contato', 'sanitize_callback' => 'esc_url_raw' ) );
	$wp_customize->add_control( 'marguerite_nav_cta_link', array( 'label' => 'Botão do menu — link', 'section' => 'marguerite_sec_header', 'type' => 'text' ) );

	$logos = array(
		'marguerite_logo_emblema'    => array( 'Logo — símbolo', '/assets/img/header-emblem.svg' ),
		'marguerite_logo_marca'      => array( 'Logo — nome "marguerite"', '/assets/img/header-wordmark.svg' ),
		'marguerite_logo_assinatura' => array( 'Logo — assinatura "agência de experiência"', '/assets/img/header-tagline.svg' ),
	);
	foreach ( $logos as $id => $dados ) {
		$wp_customize->add_setting( $id, array( 'default' => MARGUERITE_URI . $dados[1], 'sanitize_callback' => 'esc_url_raw' ) );
		$wp_customize->add_control(
			new WP_Customize_Image_Control( $wp_customize, $id, array( 'label' => $dados[0], 'section' => 'marguerite_sec_header' ) )
		);
	}

	/* ---------------- Rodapé ---------------- */
	$wp_customize->add_section( 'marguerite_sec_footer', array( 'title' => 'Rodapé', 'priority' => 31 ) );

	$wp_customize->add_setting( 'marguerite_footer_endereco', array( 'default' => 'São Paulo · SP', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'marguerite_footer_endereco', array( 'label' => 'Cidade / UF', 'section' => 'marguerite_sec_footer', 'type' => 'text' ) );

	$wp_customize->add_setting( 'marguerite_footer_email', array( 'default' => 'cintia@margueriteexperience.com.br', 'sanitize_callback' => 'sanitize_email' ) );
	$wp_customize->add_control( 'marguerite_footer_email', array( 'label' => 'E-mail de contato', 'section' => 'marguerite_sec_footer', 'type' => 'text' ) );

	$wp_customize->add_setting( 'marguerite_footer_copyright', array( 'default' => '© %ano% Agência Marguerite. Todos os direitos reservados.', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control(
		'marguerite_footer_copyright',
		array(
			'label'       => 'Direitos autorais',
			'description' => 'Use %ano% para inserir o ano atual automaticamente.',
			'section'     => 'marguerite_sec_footer',
			'type'        => 'text',
		)
	);

	$logos_rodape = array(
		'marguerite_footer_emblema'    => array( 'Logo do rodapé — símbolo', '/assets/img/footer-emblem.svg' ),
		'marguerite_footer_marca'      => array( 'Logo do rodapé — nome', '/assets/img/footer-wordmark.svg' ),
		'marguerite_footer_assinatura' => array( 'Logo do rodapé — assinatura', '/assets/img/footer-tagline.svg' ),
	);
	foreach ( $logos_rodape as $id => $dados ) {
		$wp_customize->add_setting( $id, array( 'default' => MARGUERITE_URI . $dados[1], 'sanitize_callback' => 'esc_url_raw' ) );
		$wp_customize->add_control(
			new WP_Customize_Image_Control( $wp_customize, $id, array( 'label' => $dados[0], 'section' => 'marguerite_sec_footer' ) )
		);
	}
}
add_action( 'customize_register', 'marguerite_customize_register' );
