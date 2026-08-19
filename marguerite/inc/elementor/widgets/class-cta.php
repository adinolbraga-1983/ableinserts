<?php
/**
 * Widget — Fale Conosco (bloco final).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Marguerite_Widget_Cta extends Marguerite_Widget_Base {

	public function get_name() {
		return 'marguerite-cta';
	}

	public function get_title() {
		return 'Fale Conosco (bloco final)';
	}

	public function get_icon() {
		return 'eicon-call-to-action';
	}

	public function get_keywords() {
		return array( 'marguerite', 'cta', 'contato', 'whatsapp', 'fale conosco', 'chamada' );
	}

	protected function register_controls() {

		$this->start_controls_section( 'conteudo', array( 'label' => 'Conteúdo' ) );

		$this->add_control( 'ancora', array( 'label' => 'Âncora (id da seção)', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'contato' ) );
		$this->add_control( 'titulo', array( 'label' => 'Título', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 2, 'default' => 'Vamos conversar sobre o seu próximo projeto.' ) );

		$this->add_control(
			'texto',
			array(
				'label'       => 'Parágrafo',
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'rows'        => 3,
				'default'     => "Sem briefing formal.\nApenas um diálogo direto com quem conduz.",
				'description' => 'Cada linha vira uma linha no texto.',
			)
		);

		$this->add_control( 'botao_texto', array( 'label' => 'Botão — texto', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Falar via WhatsApp' ) );

		$this->add_control(
			'botao_link',
			array(
				'label'       => 'Botão — link',
				'type'        => \Elementor\Controls_Manager::URL,
				'default'     => array( 'url' => 'https://wa.me/5511988506101?text=Ol%C3%A1%2C%20cliquei%20no%20link%20do%20site%20e%20gostaria%20de%20agendar%20uma%20reuni%C3%A3o%20com%20voc%C3%AA.', 'is_external' => true ),
				'description' => 'Formato do WhatsApp: https://wa.me/55DDDNUMERO (só números).',
			)
		);

		$this->add_control(
			'mostrar_icone',
			array(
				'label'     => 'Mostrar ícone do WhatsApp',
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => 'Sim',
				'label_off' => 'Não',
				'default'   => 'yes',
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$s      = $this->get_settings_for_display();
		$linhas = $this->linhas( $s['texto'] );
		$link   = ! empty( $s['botao_link']['url'] ) ? $s['botao_link']['url'] : '#';
		?>
		<section class="section cta-section" id="<?php echo esc_attr( $s['ancora'] ? $s['ancora'] : 'contato' ); ?>">
			<div class="container">
				<div class="cta-box" data-reveal>
					<span class="cta-box__glow" aria-hidden="true"></span>
					<div class="cta-box__content">
						<?php if ( $s['titulo'] ) : ?>
							<h2 class="cta-box__title"><?php echo esc_html( $s['titulo'] ); ?></h2>
						<?php endif; ?>

						<?php if ( $linhas ) : ?>
							<p class="cta-box__lead"><?php echo wp_kses( implode( '<br>', array_map( 'esc_html', $linhas ) ), array( 'br' => array() ) ); ?></p>
						<?php endif; ?>

						<?php if ( $s['botao_texto'] ) : ?>
							<a class="btn btn--pill btn--white" href="<?php echo esc_url( $link ); ?>" target="_blank" rel="noopener noreferrer">
								<?php if ( 'yes' === $s['mostrar_icone'] ) : ?>
									<img src="<?php echo esc_url( MARGUERITE_URI . '/assets/img/icon-whatsapp.svg' ); ?>" alt="" width="20" height="20">
								<?php endif; ?>
								<span><?php echo esc_html( $s['botao_texto'] ); ?></span>
							</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</section>
		<?php
	}
}
