<?php
/**
 * 404.
 *
 * @package Marguerite
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<section class="section" style="min-height:60vh;display:grid;place-content:center;text-align:center">
	<div class="container container--text">
		<span class="eyebrow">Erro 404</span>
		<h1 class="metodo__title"><?php esc_html_e( 'Esta página saiu de cena.', 'marguerite' ); ?></h1>
		<p style="margin-top:var(--space-m)"><a class="btn btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Voltar ao início', 'marguerite' ); ?> <?php echo marguerite_arrow(); // phpcs:ignore ?></a></p>
	</div>
</section>
<?php
get_footer();
