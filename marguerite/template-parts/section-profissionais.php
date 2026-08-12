<?php
/**
 * Seção — Profissionais / Executivas.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$marguerite_equipe = array(
	array(
		'foto'   => '',
		'nome'   => 'Cíntia Dangebel',
		'cargo'  => 'fundadora · Direção Estratégica',
		'texto'  => '34 anos consolidados no mercado corporativo. Marketing de comunicação com grandes entregas: lançamentos de produto, coletivas, feiras, congressos e convenções nacionais e internacionais.',
	),
	array(
		'foto'   => 'team-marcia.jpg',
		'nome'   => 'Márcia Fernandes',
		'cargo'  => 'Relacionamento e Operações · Parceria',
		'texto'  => '25 anos de mercado, especializada em liderança de atendimento e desenvolvimento de negócios. Relacionamento estratégico com clientes e gestão de operações complexas sem margem para erro.',
	),
);
?>
<section class="section profissionais" id="executivas">
	<div class="container">
		<p class="eyebrow eyebrow--tan" data-reveal>Profissionais</p>
		<h2 class="h2 profissionais__title" data-reveal>O diferencial desenvolvido em cada experiência.</h2>

		<div class="profissionais__grid">
			<?php foreach ( $marguerite_equipe as $i => $pessoa ) : ?>
				<article class="team-card" data-reveal data-reveal-delay="<?php echo esc_attr( $i * 0.1 ); ?>">
					<?php if ( ! empty( $pessoa['foto'] ) ) : ?>
						<img class="team-card__foto" src="<?php echo esc_url( MARGUERITE_URI . '/assets/img/' . $pessoa['foto'] ); ?>" alt="<?php echo esc_attr( $pessoa['nome'] ); ?>" width="88" height="88">
					<?php endif; ?>
					<h3 class="team-card__nome<?php echo empty( $pessoa['foto'] ) ? ' team-card__nome--sem-foto' : ''; ?>"><?php echo esc_html( $pessoa['nome'] ); ?></h3>
					<p class="team-card__cargo"><?php echo esc_html( $pessoa['cargo'] ); ?></p>
					<p class="team-card__texto"><?php echo esc_html( $pessoa['texto'] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
