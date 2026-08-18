<?php
/**
 * Widget — Executivas (cards de pessoas).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Marguerite_Widget_Executivas extends Marguerite_Widget_Base {

	public function get_name() {
		return 'marguerite-executivas';
	}

	public function get_title() {
		return 'Executivas (equipe)';
	}

	public function get_icon() {
		return 'eicon-person';
	}

	public function get_keywords() {
		return array( 'marguerite', 'executivas', 'equipe', 'time', 'pessoas', 'profissionais', 'socias' );
	}

	protected function register_controls() {

		$this->start_controls_section( 'conteudo', array( 'label' => 'Conteúdo' ) );

		$this->add_control( 'ancora', array( 'label' => 'Âncora (id da seção)', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'executivas' ) );
		$this->add_control( 'etiqueta', array( 'label' => 'Etiqueta pequena', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Profissionais' ) );
		$this->add_control( 'titulo', array( 'label' => 'Título', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 2, 'default' => 'O diferencial desenvolvido em cada experiência.' ) );

		$repetidor = new \Elementor\Repeater();
		$repetidor->add_control(
			'mostrar_foto',
			array(
				'label'     => 'Mostrar foto',
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => 'Sim',
				'label_off' => 'Não',
				'default'   => 'yes',
			)
		);
		$repetidor->add_control(
			'foto',
			array(
				'label'     => 'Foto',
				'type'      => \Elementor\Controls_Manager::MEDIA,
				'condition' => array( 'mostrar_foto' => 'yes' ),
			)
		);
		$repetidor->add_control( 'nome', array( 'label' => 'Nome', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '' ) );
		$repetidor->add_control( 'cargo', array( 'label' => 'Cargo', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '' ) );
		$repetidor->add_control( 'bio', array( 'label' => 'Bio', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 5, 'default' => '' ) );

		$this->add_control(
			'pessoas',
			array(
				'label'       => 'Pessoas',
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repetidor->get_controls(),
				'title_field' => '{{{ nome }}}',
				'default'     => array(
					array(
						'mostrar_foto' => 'yes',
						'foto'         => array( 'url' => MARGUERITE_URI . '/assets/img/team-cintia.jpg' ),
						'nome'         => 'Cíntia Dangebel',
						'cargo'        => 'Fundadora · Direção Estratégica',
						'bio'          => '34 anos consolidados no mercado corporativo. Marketing de comunicação com grandes entregas: lançamentos de produto, coletivas, feiras, congressos e convenções nacionais e internacionais.',
					),
					array(
						'mostrar_foto' => 'yes',
						'foto'         => array( 'url' => MARGUERITE_URI . '/assets/img/team-marcia.jpg' ),
						'nome'         => 'Márcia Fernandes',
						'cargo'        => 'Relacionamento e Operações · Parceria',
						'bio'          => '25 anos de mercado, especializada em liderança de atendimento e desenvolvimento de negócios. Relacionamento estratégico com clientes e gestão de operações complexas sem margem para erro.',
					),
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		?>
		<section class="section profissionais" id="<?php echo esc_attr( $s['ancora'] ? $s['ancora'] : 'executivas' ); ?>">
			<div class="container">
				<?php if ( $s['etiqueta'] ) : ?>
					<p class="eyebrow eyebrow--tan" data-reveal><?php echo esc_html( $s['etiqueta'] ); ?></p>
				<?php endif; ?>
				<?php if ( $s['titulo'] ) : ?>
					<h2 class="h2 profissionais__title" data-reveal><?php echo esc_html( $s['titulo'] ); ?></h2>
				<?php endif; ?>

				<?php if ( ! empty( $s['pessoas'] ) ) : ?>
					<div class="profissionais__grid">
						<?php foreach ( array_values( $s['pessoas'] ) as $i => $pessoa ) : ?>
							<?php
							$tem_foto = ( 'yes' === $pessoa['mostrar_foto'] ) && ! empty( $pessoa['foto']['url'] );
							?>
							<article class="team-card" data-reveal data-reveal-delay="<?php echo esc_attr( $i * 0.1 ); ?>">
								<?php if ( $tem_foto ) : ?>
									<img class="team-card__foto" src="<?php echo esc_url( $pessoa['foto']['url'] ); ?>" alt="<?php echo esc_attr( $pessoa['nome'] ); ?>" width="88" height="88">
								<?php endif; ?>
								<?php if ( ! empty( $pessoa['nome'] ) ) : ?>
									<h3 class="team-card__nome<?php echo $tem_foto ? '' : ' team-card__nome--sem-foto'; ?>"><?php echo esc_html( $pessoa['nome'] ); ?></h3>
								<?php endif; ?>
								<?php if ( ! empty( $pessoa['cargo'] ) ) : ?>
									<p class="team-card__cargo"><?php echo esc_html( $pessoa['cargo'] ); ?></p>
								<?php endif; ?>
								<?php if ( ! empty( $pessoa['bio'] ) ) : ?>
									<p class="team-card__texto"><?php echo esc_html( $pessoa['bio'] ); ?></p>
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
