<?php
/**
 * Rodapé do tema.
 *
 * @package Marguerite
 */

defined( 'ABSPATH' ) || exit;

$icon_w = marguerite_option( 'logo_icon_white' );
$word_w = marguerite_option( 'logo_wordmark_white' );
$icon_url = is_array( $icon_w ) ? $icon_w['url'] : ( $icon_w ?: marguerite_asset( 'img/marguerite-icon-white.svg' ) );
$word_url = is_array( $word_w ) ? $word_w['url'] : ( $word_w ?: marguerite_asset( 'img/marguerite-wordmark-white.svg' ) );

$email  = marguerite_option( 'contato_email', 'contato@marguerite.com.br' );
$cidade = marguerite_option( 'org_cidade', 'São Paulo' );
$uf     = marguerite_option( 'org_uf', 'SP' );
$social = marguerite_option( 'social', array() );
?>
</main>

<footer class="site-footer">
	<div class="container">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="Marguerite — Agência de Experiência">
			<img class="footer__brand-icon" src="<?php echo esc_url( $icon_url ); ?>" alt="" aria-hidden="true" width="30" height="30" />
			<img class="footer__wordmark" src="<?php echo esc_url( $word_url ); ?>" alt="Marguerite — Agência de Experiência" />
		</a>
		<nav class="footer__links" aria-label="<?php esc_attr_e( 'Rodapé', 'marguerite' ); ?>">
			<a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
			<a href="#"><?php echo esc_html( $cidade . ' / ' . $uf ); ?></a>
			<?php foreach ( (array) $social as $s ) : ?>
				<a href="<?php echo esc_url( $s['url'] ?? '#' ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $s['label'] ?? '' ); ?></a>
			<?php endforeach; ?>
		</nav>
		<small>© <span><?php echo esc_html( gmdate( 'Y' ) ); ?></span> <?php echo esc_html( marguerite_option( 'org_nome', 'Marguerite' ) ); ?>. <?php esc_html_e( 'Todos os direitos reservados.', 'marguerite' ); ?></small>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
