<?php
/**
 * Widget — Marcas (faixa deslizante).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Marguerite_Widget_Marcas extends Marguerite_Widget_Base {

	public function get_name() {
		return 'marguerite-marcas';
	}

	public function get_title() {
		return 'Marcas (faixa deslizante)';
	}

	public function get_icon() {
		return 'eicon-animation-text';
	}

	public function get_keywords() {
		return array( 'marguerite', 'marcas', 'clientes', 'logos', 'marquee', 'faixa' );
	}

	protected function register_controls() {

		$this->start_controls_section( 'conteudo', array( 'label' => 'Conteúdo' ) );

		$this->add_control( 'titulo', array( 'label' => 'Frase acima das marcas', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Marcas que confiam na condução da consultoria e agência' ) );

		$repetidor = new \Elementor\Repeater();
		$repetidor->add_control( 'nome', array( 'label' => 'Marca', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '' ) );

		$this->add_control(
			'marcas',
			array(
				'label'       => 'Marcas',
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repetidor->get_controls(),
				'title_field' => '{{{ nome }}}',
				'description' => 'A lista é duplicada automaticamente para o movimento ficar contínuo.',
				'default'     => array(
					array( 'nome' => 'TEGRA.GUEST' ),
					array( 'nome' => 'BusCo' ),
					array( 'nome' => 'Loft' ),
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$s      = $this->get_settings_for_display();
		$marcas = array();
		if ( ! empty( $s['marcas'] ) ) {
			foreach ( $s['marcas'] as $m ) {
				if ( ! empty( $m['nome'] ) ) {
					$marcas[] = $m['nome'];
				}
			}
		}
		if ( ! $marcas ) {
			return;
		}
		?>
		<div class="container">
			<div class="marcas">
				<?php if ( $s['titulo'] ) : ?>
					<p class="marcas__titulo"><?php echo esc_html( $s['titulo'] ); ?></p>
				<?php endif; ?>
				<div class="marquee" data-marquee>
					<div class="marquee__track" data-marquee-track>
						<?php for ( $volta = 0; $volta < 2; $volta++ ) : ?>
							<?php foreach ( $marcas as $marca ) : ?>
								<span class="marquee__item"><?php echo esc_html( $marca ); ?></span>
							<?php endforeach; ?>
						<?php endfor; ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}
