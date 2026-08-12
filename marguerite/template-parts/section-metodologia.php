<?php
/**
 * Seção — Nossa Metodologia.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Título, texto e cor do número/linha ficam fixos (identidade visual);
// só título e texto de cada card são editáveis no Personalizar.
$marguerite_metodologia_estilo = array(
	1 => array(
		'numero'     => '01',
		'linha'      => '#e9ef89',
		'titulo_cor' => '#d2aa8b',
		'borda'      => '#e9ef89',
	),
	2 => array(
		'numero'     => '02',
		'linha'      => '#b0aec4',
		'titulo_cor' => '#3a2837',
		'borda'      => 'rgba(58,40,55,.12)',
	),
	3 => array(
		'numero'     => '03',
		'linha'      => '#b0aec4',
		'titulo_cor' => '#3a2837',
		'borda'      => 'rgba(58,40,55,.12)',
	),
	4 => array(
		'numero'     => '04',
		'linha'      => '#e9ef89',
		'titulo_cor' => '#b98f6c',
		'borda'      => 'rgba(58,40,55,.12)',
	),
);
$marguerite_metodologia_textos = array(
	1 => array(
		'titulo' => 'Atendimento Personalizado',
		'texto'  => 'Fluxo direto e sem intermediários entre quem decide na marca e quem executa.',
	),
	2 => array(
		'titulo' => 'Inovação e Criatividade',
		'texto'  => 'Soluções exclusivas, desenhadas sob medida para o objetivo de cada evento.',
	),
	3 => array(
		'titulo' => 'Engajamento Memorável',
		'texto'  => 'Jornadas imersivas que geram conexão emocional real com cada participante.',
	),
	4 => array(
		'titulo' => 'Resultados Analíticos',
		'texto'  => 'Mensuração precisa de alcance, satisfação e retorno estratégico da ação.',
	),
);

$marguerite_metodologia = array();
foreach ( $marguerite_metodologia_estilo as $n => $estilo ) {
	$marguerite_metodologia[] = array_merge(
		$estilo,
		array(
			'titulo' => get_theme_mod( "marguerite_metodologia_{$n}_titulo", $marguerite_metodologia_textos[ $n ]['titulo'] ),
			'texto'  => get_theme_mod( "marguerite_metodologia_{$n}_texto", $marguerite_metodologia_textos[ $n ]['texto'] ),
		)
	);
}
?>
<section class="section metodologia" id="metodologia">
	<div class="container">
		<p class="eyebrow eyebrow--tan" data-reveal><?php echo esc_html( get_theme_mod( 'marguerite_metodologia_eyebrow', 'Nossa Metodologia' ) ); ?></p>
		<h2 class="h2 metodologia__title" data-reveal><?php echo esc_html( get_theme_mod( 'marguerite_metodologia_heading', 'O nosso sucesso com 4 propósitos.' ) ); ?></h2>

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
