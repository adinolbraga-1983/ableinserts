<?php
/**
 * Cabeçalho do tema.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#conteudo">Pular para o conteúdo</a>

<header class="site-header" id="topo">
	<div class="site-header__inner container">
		<a class="site-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="Marguerite — início">
			<img class="site-logo__emblem" src="<?php echo esc_url( MARGUERITE_URI . '/assets/img/header-emblem.svg' ); ?>" alt="" width="79" height="79">
			<span class="site-logo__type">
				<img class="site-logo__wordmark" src="<?php echo esc_url( MARGUERITE_URI . '/assets/img/header-wordmark.svg' ); ?>" alt="Marguerite" width="251" height="33">
				<img class="site-logo__tagline" src="<?php echo esc_url( MARGUERITE_URI . '/assets/img/header-tagline.svg' ); ?>" alt="Agência de Experiência" width="119" height="8">
			</span>
		</a>

		<button class="nav-toggle" type="button" aria-expanded="false" aria-controls="site-navigation">
			<span></span><span></span><span></span>
			<span class="screen-reader-text">Abrir menu</span>
		</button>

		<nav class="site-navigation" id="site-navigation" aria-label="Navegação principal">
			<?php marguerite_primary_menu(); ?>
			<a class="btn btn--pill nav-cta" href="<?php echo esc_url( get_theme_mod( 'marguerite_nav_cta_link', '#contato' ) ); ?>">
				<?php echo esc_html( get_theme_mod( 'marguerite_nav_cta_label', 'Agende uma Reunião' ) ); ?>
			</a>
		</nav>
	</div>
</header>
