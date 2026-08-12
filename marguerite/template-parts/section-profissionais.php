<?php
/**
 * Seção — Profissionais / Executivas.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$marguerite_equipe_defaults = array(
	1 => array(
		'mostrar_foto' => false,
		'foto'         => MARGUERITE_URI . '/assets/img/team-cintia.jpg',
		'nome'         => 'Cíntia Dangebel',
		'cargo'        => 'fundadora · Direção Estratégica',
		'texto'        => '34 anos consolidados no mercado corporativo. Marketing de comunicação com grandes entregas: lançamentos de produto, coletivas, feiras, congressos e convenções nacionais e internacionais.',
	),
	2 => array(
		'mostrar_foto' => true,
		'foto'         => MARGUERITE_URI . '/assets/img/team-marcia.jpg',
		'nome'         => 'Márcia Fernandes',
		'cargo'        => 'Relacionamento e Operações · Parceria',
		'texto'        => '25 anos de mercado, especializada em liderança de atendimento e desenvolvimento de negócios. Relacionamento estratégico com clientes e gestão de operações complexas sem margem para erro.',
	),
);

$marguerite_equipe = array();
foreach ( $marguerite_equipe_defaults as $n => $padrao ) {
	$mostrar_foto = get_theme_mod( "marguerite_pessoa_{$n}_mostrar_foto", $padrao['mostrar_foto'] );
	$marguerite_equipe[] = array(
		'foto'  => $mostrar_foto ? get_theme_mod( "marguerite_pessoa_{$n}_foto", $padrao['foto'] ) : '',
		'nome'  => get_theme_mod( "marguerite_pessoa_{$n}_nome", $padrao['nome'] ),
		'cargo' => get_theme_mod( "marguerite_pessoa_{$n}_cargo", $padrao['cargo'] ),
		'texto' => get_theme_mod( "marguerite_pessoa_{$n}_texto", $padrao['texto'] ),
	);
}
?>
<section class="section profissionais" id="executivas">
	<div class="container">
		<p class="eyebrow eyebrow--tan" data-reveal><?php echo esc_html( get_theme_mod( 'marguerite_profissionais_eyebrow', 'Profissionais' ) ); ?></p>
		<h2 class="h2 profissionais__title" data-reveal><?php echo esc_html( get_theme_mod( 'marguerite_profissionais_heading', 'O diferencial desenvolvido em cada experiência.' ) ); ?></h2>

		<div class="profissionais__grid">
			<?php foreach ( $marguerite_equipe as $i => $pessoa ) : ?>
				<article class="team-card" data-reveal data-reveal-delay="<?php echo esc_attr( $i * 0.1 ); ?>">
					<?php if ( ! empty( $pessoa['foto'] ) ) : ?>
						<img class="team-card__foto" src="<?php echo esc_url( $pessoa['foto'] ); ?>" alt="<?php echo esc_attr( $pessoa['nome'] ); ?>" width="88" height="88">
					<?php endif; ?>
					<h3 class="team-card__nome<?php echo empty( $pessoa['foto'] ) ? ' team-card__nome--sem-foto' : ''; ?>"><?php echo esc_html( $pessoa['nome'] ); ?></h3>
					<p class="team-card__cargo"><?php echo esc_html( $pessoa['cargo'] ); ?></p>
					<p class="team-card__texto"><?php echo esc_html( $pessoa['texto'] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
