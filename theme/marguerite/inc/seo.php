<?php
/**
 * SEO técnico: meta description/OG/Twitter, JSON-LD, canonical.
 * Se um plugin de SEO (Yoast/RankMath) estiver ativo, recua para não duplicar.
 *
 * @package Marguerite
 */

defined( 'ABSPATH' ) || exit;

function marguerite_seo_plugin_active() {
	return defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' );
}

/**
 * Meta tags (description, Open Graph, Twitter) por página.
 */
add_action( 'wp_head', function () {
	if ( marguerite_seo_plugin_active() ) {
		return;
	}

	$site   = get_bloginfo( 'name' );
	$default_desc = marguerite_option( 'seo_descricao_padrao', get_bloginfo( 'description' ) );
	$title  = wp_get_document_title();
	$desc   = $default_desc;
	$image  = marguerite_option( 'seo_og_padrao' );
	$image  = is_array( $image ) ? ( $image['url'] ?? '' ) : $image;
	$url    = home_url( add_query_arg( array(), $GLOBALS['wp']->request ?? '' ) );

	if ( is_singular() ) {
		$post_id = get_queried_object_id();
		$ov_desc = get_field( 'seo_descricao', $post_id );
		if ( $ov_desc ) {
			$desc = $ov_desc;
		} elseif ( has_excerpt( $post_id ) ) {
			$desc = get_the_excerpt( $post_id );
		}
		$ov_img = get_field( 'seo_imagem', $post_id );
		if ( $ov_img ) {
			$image = is_array( $ov_img ) ? ( $ov_img['url'] ?? '' ) : $ov_img;
		} elseif ( has_post_thumbnail( $post_id ) ) {
			$image = get_the_post_thumbnail_url( $post_id, 'large' );
		}
		$url = get_permalink( $post_id );
	}

	$desc = wp_strip_all_tags( (string) $desc );

	echo "\n<!-- Marguerite SEO -->\n";
	if ( $desc ) {
		echo '<meta name="description" content="' . esc_attr( $desc ) . '" />' . "\n";
	}
	echo '<meta property="og:type" content="' . ( is_singular() ? 'article' : 'website' ) . '" />' . "\n";
	echo '<meta property="og:site_name" content="' . esc_attr( $site ) . '" />' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '" />' . "\n";
	if ( $desc ) {
		echo '<meta property="og:description" content="' . esc_attr( $desc ) . '" />' . "\n";
	}
	echo '<meta property="og:url" content="' . esc_url( $url ) . '" />' . "\n";
	echo '<meta property="og:locale" content="pt_BR" />' . "\n";
	if ( $image ) {
		echo '<meta property="og:image" content="' . esc_url( $image ) . '" />' . "\n";
	}
	echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
	if ( ! is_singular() || ! get_post_meta( get_queried_object_id(), '_wp_page_template', true ) ) {
		echo '<link rel="canonical" href="' . esc_url( $url ) . '" />' . "\n";
	}
}, 2 );

/**
 * JSON-LD: Organization + WebSite na home; CreativeWork nos Cases.
 */
add_action( 'wp_head', function () {
	if ( marguerite_seo_plugin_active() ) {
		return;
	}

	$graph = array();

	$org_name = marguerite_option( 'org_nome', get_bloginfo( 'name' ) );
	$graph[]  = array(
		'@type'       => 'Organization',
		'name'        => $org_name,
		'url'         => home_url( '/' ),
		'description' => wp_strip_all_tags( marguerite_option( 'seo_descricao_padrao', get_bloginfo( 'description' ) ) ),
		'foundingDate'=> marguerite_option( 'org_fundacao', '1991' ),
		'address'     => array(
			'@type'           => 'PostalAddress',
			'addressLocality' => marguerite_option( 'org_cidade', 'São Paulo' ),
			'addressRegion'   => marguerite_option( 'org_uf', 'SP' ),
			'addressCountry'  => 'BR',
		),
	);

	if ( is_front_page() ) {
		$graph[] = array(
			'@type'      => 'WebSite',
			'name'       => $org_name,
			'url'        => home_url( '/' ),
			'inLanguage' => 'pt-BR',
		);
	}

	if ( is_singular( 'case' ) ) {
		$post_id = get_queried_object_id();
		$graph[] = array(
			'@type'         => 'CreativeWork',
			'name'          => get_the_title( $post_id ),
			'description'   => wp_strip_all_tags( get_the_excerpt( $post_id ) ),
			'image'         => get_the_post_thumbnail_url( $post_id, 'large' ) ?: '',
			'url'           => get_permalink( $post_id ),
			'author'        => array( '@type' => 'Organization', 'name' => $org_name ),
			'datePublished' => get_the_date( 'c', $post_id ),
		);
	}

	$json = array( '@context' => 'https://schema.org', '@graph' => $graph );
	echo '<script type="application/ld+json">' . wp_json_encode( $json, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}, 3 );
