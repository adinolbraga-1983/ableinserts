<?php
/**
 * Rodapé do tema.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
	<footer class="site-footer">
		<div class="container site-footer__inner">
			<a class="footer-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="Marguerite — início">
				<img class="footer-logo__emblem" src="<?php echo esc_url( MARGUERITE_URI . '/assets/img/footer-emblem.svg' ); ?>" alt="" width="103" height="102">
				<span class="footer-logo__type">
					<img class="footer-logo__wordmark" src="<?php echo esc_url( MARGUERITE_URI . '/assets/img/footer-wordmark.svg' ); ?>" alt="Marguerite" width="326" height="43">
					<img class="footer-logo__tagline" src="<?php echo esc_url( MARGUERITE_URI . '/assets/img/footer-tagline.svg' ); ?>" alt="Agência de Experiência" width="155" height="10">
				</span>
			</a>

			<?php
			$marguerite_footer_email     = get_theme_mod( 'marguerite_footer_email', 'cintia@margueriteexperience.com.br' );
			$marguerite_footer_endereco  = get_theme_mod( 'marguerite_footer_endereco', 'São Paulo · SP' );
			$marguerite_footer_copyright = str_replace(
				'%ano%',
				date_i18n( 'Y' ),
				get_theme_mod( 'marguerite_footer_copyright', '© %ano% Agência Marguerite. Todos os direitos reservados.' )
			);
			?>
			<div class="site-footer__meta">
				<p><?php echo esc_html( $marguerite_footer_endereco ); ?> | <a href="mailto:<?php echo esc_attr( $marguerite_footer_email ); ?>"><?php echo esc_html( $marguerite_footer_email ); ?></a></p>
				<p><?php echo esc_html( $marguerite_footer_copyright ); ?></p>
			</div>
		</div>
	</footer>
</main><!-- #conteudo -->

<?php wp_footer(); ?>
</body>
</html>
