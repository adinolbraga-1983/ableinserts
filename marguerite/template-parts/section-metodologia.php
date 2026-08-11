<?php
/**
 * Seção — Nossa Metodologia.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$marguerite_metodologia = array(
	array(
		'numero'       => '01',
		'linha'        => '#e9ef89',
		'titulo'       => 'Atendimento Personalizado',
		'titulo_cor'   => '#d2aa8b',
		'borda'        => '#e9ef89',
		'texto'        => 'Fluxo direto e sem intermediários entre quem decide na marca e quem executa.',
	),
	array(
		'numero'       => '02',
		'linha'        => '#b0aec4',
		'titulo'       => 'Inovação e Criatividade',
		'titulo_cor'   => '#3a2837',
		'borda'        => 'rgba(58,40,55,.12)',
		'texto'        => 'Soluções exclusivas, desenhadas sob medida para o objetivo de cada evento.',
	),
	array(
		'numero'       => '03',
		'linha'        => '#b0aec4',
		'titulo'       => 'Engajamento Memorável',
		'titulo_cor'   => '#3a2837',
		'borda'        => 'rgba(58,40,55,.12)',
		'texto'        => 'Jornadas imersivas que geram conexão emocional real com cada participante.',
	),
	array(
		'numero'       => '04',
		'linha'        => '#e9ef89',
		'titulo'       => 'Resultados Analíticos',
		'titulo_cor'   => '#b98f6c',
		'borda'        => 'rgba(58,40,55,.12)',
		'texto'        => 'Mensuração precisa de alcance, satisfação e retorno estratégico da ação.',
	),
);
?>
<section class="section metodologia" id="metodologia">
	<div class="container">
		<p class="eyebrow eyebrow--tan" data-reveal>Nossa Metodologia</p>
		<h2 class="h2 metodologia__title" data-reveal>O nosso sucesso com 4 propósitos.</h2>

		<div class="metodologia__grid">
			<?php foreach ( $marguerite_metodologia as $i => $item ) : ?>
				<article
					class="metodologia-card"
					style="--linha: <?php echo esc_attr( $item['linha'] ); ?>; --titulo-cor: <?php echo esc_attr( $item['titulo_cor'] ); ?>; --borda: <?php echo esc_attr( $item['borda'] ); ?>;"
					data-reveal data-reveal-delay="<?php echo esc_attr( $i * 0.08 ); ?>"
				>
					<p class="metodologia-card__numero"><?php echo esc_html( $item['numero'] ); ?></p>
					<span class="metodologia-card__linha" aria-hidden="true"></span>
					<h3 class="metodologia-card__titulo"><?php echo esc_html( $item['titulo'] ); ?></h3>
					<p class="metodologia-card__texto"><?php echo esc_html( $item['texto'] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
