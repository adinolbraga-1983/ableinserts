<?php
/**
 * Cabeçalho do tema.
 *
 * @package Marguerite
 */

defined( 'ABSPATH' ) || exit;

// Logos: opções globais → fallback para os assets do tema.
$icon = marguerite_option( 'logo_icon' );
$word = marguerite_option( 'logo_wordmark' );
$icon_url = is_array( $icon ) ? $icon['url'] : ( $icon ?: marguerite_asset( 'img/marguerite-icon.svg' ) );
$word_url = is_array( $word ) ? $word['url'] : ( $word ?: marguerite_asset( 'img/marguerite-wordmark.svg' ) );

$cta_label = marguerite_option( 'cta_label', 'Agende uma reunião' );
$cta_link  = marguerite_option( 'cta_link', '#contato' );
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="theme-color" content="#1B0710" />
	<link rel="icon" href="<?php echo esc_url( marguerite_asset( 'img/marguerite-icon.svg' ) ); ?>" type="image/svg+xml" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#conteudo"><?php esc_html_e( 'Pular para o conteúdo', 'marguerite' ); ?></a>

<header class="site-header" data-over-dark="<?php echo is_front_page() ? 'true' : 'false'; ?>" id="topo">
	<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="Marguerite — Agência de Experiência, início">
		<img class="brand__icon" src="<?php echo esc_url( $icon_url ); ?>" alt="" aria-hidden="true" width="30" height="30" />
		<img class="brand__wordmark" src="<?php echo esc_url( $word_url ); ?>" alt="Marguerite — Agência de Experiência" />
	</a>

	<?php if ( has_nav_menu( 'primary' ) ) : ?>
		<nav class="nav" aria-label="<?php esc_attr_e( 'Navegação principal', 'marguerite' ); ?>">
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'items_wrap' => '%3$s', 'depth' => 1 ) ); ?>
		</nav>
	<?php else : ?>
		<nav class="nav" aria-label="<?php esc_attr_e( 'Navegação principal', 'marguerite' ); ?>">
			<a class="nav__link" href="<?php echo esc_url( home_url( '/#sobre' ) ); ?>" data-spy="sobre">Sobre</a>
			<a class="nav__link" href="<?php echo esc_url( home_url( '/#metodologia' ) ); ?>" data-spy="metodologia">Metodologia</a>
			<a class="nav__link" href="<?php echo esc_url( home_url( '/#cases' ) ); ?>" data-spy="cases">Cases</a>
			<a class="nav__link" href="<?php echo esc_url( home_url( '/#clientes' ) ); ?>" data-spy="clientes">Clientes</a>
		</nav>
	<?php endif; ?>

	<a class="header__cta link-underline" href="<?php echo esc_url( $cta_link ); ?>"><?php echo esc_html( $cta_label ); ?></a>
	<button class="nav-toggle" aria-label="<?php esc_attr_e( 'Abrir menu', 'marguerite' ); ?>" aria-expanded="false" aria-controls="menu"><span></span></button>
</header>

<div class="menu-overlay" id="menu" role="dialog" aria-modal="true" aria-label="Menu" hidden>
	<button class="menu-overlay__close" aria-label="<?php esc_attr_e( 'Fechar menu', 'marguerite' ); ?>">&times;</button>
	<a href="<?php echo esc_url( home_url( '/#sobre' ) ); ?>">Sobre</a>
	<a href="<?php echo esc_url( home_url( '/#metodologia' ) ); ?>">Metodologia</a>
	<a href="<?php echo esc_url( home_url( '/#cases' ) ); ?>">Cases</a>
	<a href="<?php echo esc_url( home_url( '/#clientes' ) ); ?>">Clientes</a>
	<a href="<?php echo esc_url( $cta_link ); ?>" class="marker"><?php echo esc_html( $cta_label ); ?></a>
</div>

<main id="conteudo">
