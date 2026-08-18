<?php
/**
 * Widget — Topo da página (Hero).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Marguerite_Widget_Hero extends Marguerite_Widget_Base {

	public function get_name() {
		return 'marguerite-hero';
	}

	public function get_title() {
		return 'Topo da Página (Hero)';
	}

	public function get_icon() {
		return 'eicon-header';
	}

	public function get_keywords() {
		return array( 'marguerite', 'hero', 'topo', 'capa', 'banner', 'inicio', 'principal' );
	}

	protected function register_controls() {

		$this->start_controls_section( 'conteudo', array( 'label' => 'Conteúdo' ) );

		$this->add_control(
			'ancora',
			array(
				'label'       => 'Âncora (id da seção)',
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => 'home',
				'description' => 'Usado pelos links do menu. Não use espaços nem acentos.',
			)
		);

		$this->add_control(
			'etiqueta',
			array(
				'label'   => 'Etiqueta pequena',
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'Agência Boutique',
			)
		);

		$this->add_control(
			'titulo',
			array(
				'label'       => 'Título',
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'rows'        => 3,
				'default'     => 'Experiências memoráveis são planejadas, desenhadas e **conduzidas**.',
				'description' => 'Coloque **dois asteriscos** ao redor da palavra que deve aparecer destacada em lilás. Ex.: **conduzidas**',
			)
		);

		$this->add_control(
			'texto',
			array(
				'label'       => 'Parágrafo',
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'rows'        => 4,
				'default'     => 'Da primeira conversa ao desmonte, cada projeto é conduzido pessoalmente pela agência. **Sem repasse. Sem tradução perdida no caminho.**',
				'description' => 'Use **dois asteriscos** ao redor do trecho que deve ficar em negrito.',
			)
		);

		$this->add_control(
			'botao_texto',
			array(
				'label'   => 'Botão — texto',
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'Agende uma Reunião',
			)
		);

		$this->add_control(
			'botao_link',
			array(
				'label'   => 'Botão — link',
				'type'    => \Elementor\Controls_Manager::URL,
				'default' => array( 'url' => '#contato' ),
			)
		);

		$this->add_control(
			'imagem',
			array(
				'label'   => 'Imagem de fundo',
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => array( 'url' => MARGUERITE_URI . '/assets/img/hero.jpg' ),
			)
		);

		$this->add_control(
			'aviso_rolagem',
			array(
				'label'        => 'Mostrar "Role para descobrir"',
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => 'Sim',
				'label_off'    => 'Não',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'texto_rolagem',
			array(
				'label'     => 'Texto da rolagem',
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => 'Role para descobrir',
				'condition' => array( 'aviso_rolagem' => 'yes' ),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();

		$imagem = ! empty( $s['imagem']['url'] ) ? $s['imagem']['url'] : '';
		$link   = ! empty( $s['botao_link']['url'] ) ? $s['botao_link']['url'] : '#contato';
		$alvo   = ! empty( $s['botao_link']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
		?>
		<section class="hero" id="<?php echo esc_attr( $s['ancora'] ? $s['ancora'] : 'home' ); ?>">
			<?php if ( $imagem ) : ?>
				<div class="hero__media" aria-hidden="true">
					<img src="<?php echo esc_url( $imagem ); ?>" alt="" fetchpriority="high">
				</div>
			<?php endif; ?>

			<span class="hero__blob hero__blob--top" aria-hidden="true"></span>
			<span class="hero__blob hero__blob--bottom" aria-hidden="true"></span>

			<div class="hero__content container">
				<div class="hero__text">
					<?php if ( $s['etiqueta'] ) : ?>
						<p class="eyebrow" data-reveal><?php echo esc_html( $s['etiqueta'] ); ?></p>
					<?php endif; ?>

					<?php if ( $s['titulo'] ) : ?>
						<h1 class="hero__title" data-reveal><?php echo $this->destaque( $s['titulo'] ); ?></h1>
					<?php endif; ?>

					<?php if ( $s['texto'] ) : ?>
						<p class="hero__lead" data-reveal><?php echo $this->negrito( $s['texto'] ); ?></p>
					<?php endif; ?>

					<?php if ( $s['botao_texto'] ) : ?>
						<div class="hero__actions" data-reveal>
							<a class="btn btn--pill btn--lavender" href="<?php echo esc_url( $link ); ?>"<?php echo $alvo; ?>><?php echo esc_html( $s['botao_texto'] ); ?></a>
						</div>
					<?php endif; ?>
				</div>
			</div>

			<?php if ( 'yes' === $s['aviso_rolagem'] && $s['texto_rolagem'] ) : ?>
				<div class="hero__scroll-cue">
					<span class="hero__scroll-line" aria-hidden="true"></span>
					<span><?php echo esc_html( $s['texto_rolagem'] ); ?></span>
				</div>
			<?php endif; ?>
		</section>
		<?php
	}
}
