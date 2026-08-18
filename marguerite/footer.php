<?php
/**
 * Rodapé do site (editável em Aparência → Personalizar → Rodapé).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$marguerite_footer_email     = get_theme_mod( 'marguerite_footer_email', 'cintia@margueriteexperience.com.br' );
$marguerite_footer_endereco  = get_theme_mod( 'marguerite_footer_endereco', 'São Paulo · SP' );
$marguerite_footer_copyright = str_replace(
	'%ano%',
	date_i18n( 'Y' ),
	get_theme_mod( 'marguerite_footer_copyright', '© %ano% Agência Marguerite. Todos os direitos reservados.' )
);
?>
<footer class="site-footer">
	<div class="container site-footer__inner">
		<a class="footer-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="Marguerite — início">
			<img class="footer-logo__emblem" src="<?php echo esc_url( get_theme_mod( 'marguerite_footer_emblema', MARGUERITE_URI . '/assets/img/footer-emblem.svg' ) ); ?>" alt="" width="103" height="102">
			<span class="footer-logo__type">
				<img class="footer-logo__wordmark" src="<?php echo esc_url( get_theme_mod( 'marguerite_footer_marca', MARGUERITE_URI . '/assets/img/footer-wordmark.svg' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>" width="326" height="43">
				<img class="footer-logo__tagline" src="<?php echo esc_url( get_theme_mod( 'marguerite_footer_assinatura', MARGUERITE_URI . '/assets/img/footer-tagline.svg' ) ); ?>" alt="Agência de Experiência" width="155" height="10">
			</span>
		</a>

		<div class="site-footer__meta">
			<p>
				<?php echo esc_html( $marguerite_footer_endereco ); ?>
				<?php if ( $marguerite_footer_email ) : ?>
					| <a href="mailto:<?php echo esc_attr( $marguerite_footer_email ); ?>"><?php echo esc_html( $marguerite_footer_email ); ?></a>
				<?php endif; ?>
			</p>
			<p><?php echo esc_html( $marguerite_footer_copyright ); ?></p>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
