<?php
/**
 * Seção — Quem Somos.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$marguerite_qs_tags = marguerite_lines_to_array(
	get_theme_mod( 'marguerite_quemsomos_tags', "Projetos Corporativos\nExperiências Imersivas\nAtivação de Marca" )
);
?>
<section class="section quem-somos" id="sobre">
	<div class="container">
		<div class="quem-somos__grid">
			<div class="quem-somos__heading" data-reveal>
				<p class="eyebrow eyebrow--tan"><?php echo esc_html( get_theme_mod( 'marguerite_quemsomos_eyebrow', 'Quem Somos' ) ); ?></p>
				<h2 class="h2"><?php echo esc_html( get_theme_mod( 'marguerite_quemsomos_heading', 'Trinta e quatro anos de mercado moram aqui.' ) ); ?></h2>
			</div>

			<div class="quem-somos__body" data-reveal>
				<p class="lead">
					<?php
					echo marguerite_richtext_bold(
						get_theme_mod(
							'marguerite_quemsomos_texto',
							'A Marguerite nasce de um conceito boutique: fazer diferente, com mais sentido e proximidade em cada entrega. Construímos um fluxo personalizado para cada cliente — sem barreiras, mais conversa, mais construção conjunta. **Não somos mais um fornecedor. Somos uma parceria.**'
						)
					);
					?>
				</p>

				<?php if ( ! empty( $marguerite_qs_tags ) ) : ?>
					<ul class="quem-somos__tags">
						<?php foreach ( $marguerite_qs_tags as $tag ) : ?>
							<li><?php echo esc_html( $tag ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
