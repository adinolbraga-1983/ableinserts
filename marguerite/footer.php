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

			<div class="site-footer__meta">
				<p>São Paulo · SP | <a href="mailto:cintia@margueriteexperience.com.br">cintia@margueriteexperience.com.br</a></p>
				<p>&copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?> Agência Marguerite. Todos os direitos reservados.</p>
			</div>
		</div>
	</footer>
</main><!-- #conteudo -->

<?php wp_footer(); ?>
</body>
</html>
