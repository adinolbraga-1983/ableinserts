<?php
/**
 * Widget — Quem Somos.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Marguerite_Widget_Quem_Somos extends Marguerite_Widget_Base {

	public function get_name() {
		return 'marguerite-quem-somos';
	}

	public function get_title() {
		return 'Quem Somos';
	}

	public function get_icon() {
		return 'eicon-text-align-left';
	}

	public function get_keywords() {
		return array( 'marguerite', 'quem somos', 'sobre', 'institucional', 'texto' );
	}

	protected function register_controls() {

		$this->start_controls_section( 'conteudo', array( 'label' => 'Conteúdo' ) );

		$this->add_control( 'ancora', array( 'label' => 'Âncora (id da seção)', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'sobre' ) );
		$this->add_control( 'etiqueta', array( 'label' => 'Etiqueta pequena', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Quem Somos' ) );
		$this->add_control( 'titulo', array( 'label' => 'Título', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 2, 'default' => 'Trinta e quatro anos de mercado moram aqui.' ) );

		$this->add_control(
			'texto',
			array(
				'label'       => 'Parágrafo',
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'rows'        => 6,
				'default'     => 'A Marguerite nasce de um conceito boutique: fazer diferente, com mais sentido e proximidade em cada entrega. Construímos um fluxo personalizado para cada cliente — sem barreiras, mais conversa, mais construção conjunta. **Não somos mais um fornecedor. Somos uma parceria.**',
				'description' => 'Use **dois asteriscos** ao redor do trecho que deve ficar em negrito.',
			)
		);

		$repetidor = new \Elementor\Repeater();
		$repetidor->add_control( 'texto', array( 'label' => 'Palavra-chave', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Projetos Corporativos' ) );

		$this->add_control(
			'tags',
			array(
				'label'       => 'Palavras-chave',
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repetidor->get_controls(),
				'title_field' => '{{{ texto }}}',
				'default'     => array(
					array( 'texto' => 'Projetos Corporativos' ),
					array( 'texto' => 'Experiências Imersivas' ),
					array( 'texto' => 'Ativação de Marca' ),
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		?>
		<section class="section quem-somos" id="<?php echo esc_attr( $s['ancora'] ? $s['ancora'] : 'sobre' ); ?>">
			<div class="container">
				<div class="quem-somos__grid">
					<div class="quem-somos__heading" data-reveal>
						<?php if ( $s['etiqueta'] ) : ?>
							<p class="eyebrow eyebrow--tan"><?php echo esc_html( $s['etiqueta'] ); ?></p>
						<?php endif; ?>
						<?php if ( $s['titulo'] ) : ?>
							<h2 class="h2"><?php echo esc_html( $s['titulo'] ); ?></h2>
						<?php endif; ?>
					</div>

					<div class="quem-somos__body" data-reveal>
						<?php if ( $s['texto'] ) : ?>
							<p class="lead"><?php echo $this->negrito( $s['texto'] ); ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $s['tags'] ) ) : ?>
							<ul class="quem-somos__tags">
								<?php foreach ( $s['tags'] as $tag ) : ?>
									<?php if ( empty( $tag['texto'] ) ) { continue; } ?>
									<li><?php echo esc_html( $tag['texto'] ); ?></li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</section>
		<?php
	}
}
