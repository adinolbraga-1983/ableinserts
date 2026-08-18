<?php
/**
 * Widget — Metodologia (cards numerados).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Marguerite_Widget_Metodologia extends Marguerite_Widget_Base {

	public function get_name() {
		return 'marguerite-metodologia';
	}

	public function get_title() {
		return 'Metodologia (cards)';
	}

	public function get_icon() {
		return 'eicon-number-field';
	}

	public function get_keywords() {
		return array( 'marguerite', 'metodologia', 'cards', 'propositos', 'numeros', 'processo' );
	}

	protected function register_controls() {

		$this->start_controls_section( 'conteudo', array( 'label' => 'Conteúdo' ) );

		$this->add_control( 'ancora', array( 'label' => 'Âncora (id da seção)', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'metodologia' ) );
		$this->add_control( 'etiqueta', array( 'label' => 'Etiqueta pequena', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Nossa Metodologia' ) );
		$this->add_control( 'titulo', array( 'label' => 'Título', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 2, 'default' => 'O nosso sucesso com 4 propósitos.' ) );

		$repetidor = new \Elementor\Repeater();
		$repetidor->add_control( 'numero', array( 'label' => 'Número', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '01' ) );
		$repetidor->add_control( 'titulo', array( 'label' => 'Título do card', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Atendimento Personalizado' ) );
		$repetidor->add_control( 'texto', array( 'label' => 'Texto do card', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => '' ) );
		$repetidor->add_control(
			'cor_linha',
			array(
				'label'   => 'Cor do traço',
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '#e9ef89',
			)
		);
		$repetidor->add_control(
			'cor_titulo',
			array(
				'label'   => 'Cor do título',
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '#3a2837',
			)
		);
		$repetidor->add_control(
			'cor_borda',
			array(
				'label'   => 'Cor da borda do card',
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => 'rgba(58,40,55,.12)',
			)
		);

		$this->add_control(
			'cards',
			array(
				'label'       => 'Cards',
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repetidor->get_controls(),
				'title_field' => '{{{ numero }}} — {{{ titulo }}}',
				'default'     => array(
					array(
						'numero'     => '01',
						'titulo'     => 'Atendimento Personalizado',
						'texto'      => 'Fluxo direto e sem intermediários entre quem decide na marca e quem executa.',
						'cor_linha'  => '#e9ef89',
						'cor_titulo' => '#d2aa8b',
						'cor_borda'  => '#e9ef89',
					),
					array(
						'numero'     => '02',
						'titulo'     => 'Inovação e Criatividade',
						'texto'      => 'Soluções exclusivas, desenhadas sob medida para o objetivo de cada evento.',
						'cor_linha'  => '#b0aec4',
						'cor_titulo' => '#3a2837',
						'cor_borda'  => 'rgba(58,40,55,.12)',
					),
					array(
						'numero'     => '03',
						'titulo'     => 'Engajamento Memorável',
						'texto'      => 'Jornadas imersivas que geram conexão emocional real com cada participante.',
						'cor_linha'  => '#b0aec4',
						'cor_titulo' => '#3a2837',
						'cor_borda'  => 'rgba(58,40,55,.12)',
					),
					array(
						'numero'     => '04',
						'titulo'     => 'Resultados Analíticos',
						'texto'      => 'Mensuração precisa de alcance, satisfação e retorno estratégico da ação.',
						'cor_linha'  => '#e9ef89',
						'cor_titulo' => '#b98f6c',
						'cor_borda'  => 'rgba(58,40,55,.12)',
					),
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		?>
		<section class="section metodologia" id="<?php echo esc_attr( $s['ancora'] ? $s['ancora'] : 'metodologia' ); ?>">
			<div class="container">
				<?php if ( $s['etiqueta'] ) : ?>
					<p class="eyebrow eyebrow--tan" data-reveal><?php echo esc_html( $s['etiqueta'] ); ?></p>
				<?php endif; ?>
				<?php if ( $s['titulo'] ) : ?>
					<h2 class="h2 metodologia__title" data-reveal><?php echo esc_html( $s['titulo'] ); ?></h2>
				<?php endif; ?>

				<?php if ( ! empty( $s['cards'] ) ) : ?>
					<div class="metodologia__grid">
						<?php foreach ( array_values( $s['cards'] ) as $i => $card ) : ?>
							<article
								class="metodologia-card"
								style="--linha: <?php echo esc_attr( $card['cor_linha'] ); ?>; --titulo-cor: <?php echo esc_attr( $card['cor_titulo'] ); ?>; --borda: <?php echo esc_attr( $card['cor_borda'] ); ?>;"
								data-reveal data-reveal-delay="<?php echo esc_attr( $i * 0.08 ); ?>"
							>
								<?php if ( ! empty( $card['numero'] ) ) : ?>
									<p class="metodologia-card__numero"><?php echo esc_html( $card['numero'] ); ?></p>
								<?php endif; ?>
								<span class="metodologia-card__linha" aria-hidden="true"></span>
								<?php if ( ! empty( $card['titulo'] ) ) : ?>
									<h3 class="metodologia-card__titulo"><?php echo esc_html( $card['titulo'] ); ?></h3>
								<?php endif; ?>
								<?php if ( ! empty( $card['texto'] ) ) : ?>
									<p class="metodologia-card__texto"><?php echo esc_html( $card['texto'] ); ?></p>
								<?php endif; ?>
							</article>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}
}
