<?php
/**
 * Widget — Cases (carrossel horizontal: capa + links do Instagram).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Marguerite_Widget_Cases extends Marguerite_Widget_Base {

	public function get_name() {
		return 'marguerite-cases';
	}

	public function get_title() {
		return 'Cases (carrossel)';
	}

	public function get_icon() {
		return 'eicon-slides';
	}

	public function get_keywords() {
		return array( 'marguerite', 'cases', 'carrossel', 'portfolio', 'projetos', 'instagram' );
	}

	protected function register_controls() {

		$this->start_controls_section( 'cabecalho', array( 'label' => 'Título da seção' ) );

		$this->add_control( 'ancora', array( 'label' => 'Âncora (id da seção)', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'cases' ) );
		$this->add_control( 'etiqueta', array( 'label' => 'Etiqueta pequena', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Portfólio' ) );
		$this->add_control( 'titulo', array( 'label' => 'Título', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 2, 'default' => 'Experiências que geram conexões reais entre marcas e clientes.' ) );

		$this->end_controls_section();

		$this->start_controls_section( 'lista', array( 'label' => 'Cases' ) );

		$repetidor = new \Elementor\Repeater();

		$repetidor->add_control( 'top_label', array( 'label' => 'Etiqueta (quem assina)', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Agência Marguerite' ) );
		$repetidor->add_control( 'marca', array( 'label' => 'Nome da marca', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '', 'description' => 'Respeite a grafia oficial de cada marca (ex.: TEGRA.GUEST, BusCo, Loft, SKY).' ) );
		$repetidor->add_control( 'texto', array( 'label' => 'Descrição', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 4, 'default' => '' ) );

		$repetidor->add_control(
			'meta',
			array(
				'label'       => 'Ficha técnica',
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'rows'        => 4,
				'default'     => '',
				'description' => 'Um item por linha (ex.: 980 pessoas). Aparecem separados por “·”.',
			)
		);

		$repetidor->add_control(
			'links',
			array(
				'label'       => 'Links do Instagram',
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'rows'        => 6,
				'default'     => '',
				'description' => 'Um por linha, no formato: <code>Rótulo | Categoria | URL</code><br>Ex.: <code>Picchi | Gastronômico | https://instagram.com/reel/...</code><br>Deixe vazio se o case ainda não tem link.',
			)
		);

		$repetidor->add_control(
			'tom',
			array(
				'label'   => 'Cor da capa',
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'tegra',
				'options' => array(
					'tegra' => 'Nude → tinta (TEGRA.GUEST)',
					'busco' => 'Lavanda → azulado (BusCo)',
					'loft'  => 'Nude → roxo (Loft)',
					'sky'   => 'Vinho escuro (SKY)',
				),
			)
		);

		$repetidor->add_control( 'foto', array( 'label' => 'Textura de fundo (opcional)', 'type' => \Elementor\Controls_Manager::MEDIA ) );

		$this->add_control(
			'cases',
			array(
				'label'       => 'Cases',
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repetidor->get_controls(),
				'title_field' => '{{{ marca }}}',
				'default'     => array(
					array(
						'top_label' => 'Agência Marguerite',
						'marca'     => 'TEGRA.GUEST',
						'texto'     => 'TEGRA.GUEST: programa que proporciona uma experiência única e memorável nos pilares gastronômico, entretenimento e esporte.',
						'meta'      => "Prospects e Clientes\nSP / RJ",
						'links'     => "Picchi | Gastronômico | https://www.instagram.com/reel/DSYQVS-DWLg/?igsi=MWlpMDNkcTEzcHE1OQ==\nSP Open | Esportivo · SP | https://www.instagram.com/reel/DMOnIuYxsRW/?igsi=cDhndHJ3bWFkN2lo\nPôr do Sol no RJ | Entretenimento | https://www.instagram.com/reel/DPB_w-kEUME/?igsi=bWNpdGxjaDQ0c2h1\nRJ Open | Esportivo · RJ | https://www.instagram.com/reel/DVYwJCAkQwR/?igsi=NGw3bmI1N2lmb2hi",
						'tom'       => 'tegra',
						'foto'      => array( 'url' => MARGUERITE_URI . '/assets/img/case-tegraguest.png' ),
					),
					array(
						'top_label' => 'Agência Marguerite',
						'marca'     => 'BusCo',
						'texto'     => 'Coletiva de imprensa: expansão para quatro novas rotas no Brasil, com nova identidade visual e benefícios diferenciados em relação ao mercado.',
						'meta'      => "30 pessoas\nEco Lodge · Pedra Azul/ES\nImprensa & Influenciadores",
						'links'     => "Cobertura da coletiva | Imprensa | https://www.instagram.com/p/DM06SxFI78s/?igsi=MW4ybmlpNnk4MHMzcg==",
						'tom'       => 'busco',
					),
					array(
						'top_label' => 'Consultoria Dangebel',
						'marca'     => 'Loft',
						'texto'     => 'Convenção Loft: posicionamento como motor de crescimento, inovação e tecnologia no segmento imobiliário, em união com os parceiros do ecossistema.',
						'meta'      => "930 pessoas\nCommunity Creators Academy",
						'links'     => "Convenção Loft | Portas 2026 | https://www.instagram.com/reel/DXPCKKFjhOI/?igsi=MTk2cHc5aW5sNjRpag==",
						'tom'       => 'loft',
					),
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * "Rótulo | Categoria | URL" por linha → array de links.
	 */
	protected function parse_links( $texto ) {
		$links = array();
		foreach ( $this->linhas( $texto ) as $linha ) {
			$partes = array_map( 'trim', explode( '|', $linha ) );
			$url    = '';
			// A URL é sempre a última parte que parece um endereço.
			foreach ( array_reverse( $partes ) as $parte ) {
				if ( preg_match( '#^https?://#i', $parte ) ) {
					$url = $parte;
					break;
				}
			}
			if ( ! $url ) {
				continue;
			}
			$links[] = array(
				'label' => isset( $partes[0] ) ? $partes[0] : '',
				'cat'   => ( isset( $partes[1] ) && $partes[1] !== $url ) ? $partes[1] : '',
				'url'   => $url,
			);
		}
		return $links;
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$cases = ! empty( $s['cases'] ) ? array_values( $s['cases'] ) : array();
		?>
		<section class="section portfolio" id="<?php echo esc_attr( $s['ancora'] ? $s['ancora'] : 'cases' ); ?>">
			<div class="container">
				<?php if ( $s['etiqueta'] || $s['titulo'] ) : ?>
					<div class="portfolio__intro" data-reveal>
						<?php if ( $s['etiqueta'] ) : ?>
							<p class="eyebrow eyebrow--tan align-center"><?php echo esc_html( $s['etiqueta'] ); ?></p>
						<?php endif; ?>
						<?php if ( $s['titulo'] ) : ?>
							<h2 class="h2 align-center"><?php echo esc_html( $s['titulo'] ); ?></h2>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php if ( $cases ) : ?>
					<div class="case-carousel" data-cases-carousel>
						<div class="case-list" data-cases-track>
							<?php foreach ( $cases as $case ) : ?>
								<?php
								$meta  = $this->linhas( $case['meta'] );
								$links = $this->parse_links( $case['links'] );
								$tom   = ! empty( $case['tom'] ) ? $case['tom'] : 'tegra';
								?>
								<article class="case-block">
									<div class="case-cover case-cover--<?php echo esc_attr( $tom ); ?>" data-reveal>
										<?php if ( ! empty( $case['foto']['url'] ) ) : ?>
											<img class="case-cover__photo" src="<?php echo esc_url( $case['foto']['url'] ); ?>" alt="" aria-hidden="true">
										<?php endif; ?>
										<div class="case-cover__inner">
											<?php if ( ! empty( $case['top_label'] ) ) : ?>
												<p class="case-cover__top-label"><?php echo esc_html( $case['top_label'] ); ?></p>
											<?php endif; ?>
											<?php if ( ! empty( $case['marca'] ) ) : ?>
												<h3 class="case-cover__marca"><?php echo esc_html( $case['marca'] ); ?></h3>
											<?php endif; ?>
											<?php if ( ! empty( $case['texto'] ) ) : ?>
												<p class="case-cover__texto"><?php echo esc_html( $case['texto'] ); ?></p>
											<?php endif; ?>
											<?php if ( $meta ) : ?>
												<ul class="case-cover__meta">
													<?php foreach ( $meta as $item ) : ?>
														<li><?php echo esc_html( $item ); ?></li>
													<?php endforeach; ?>
												</ul>
											<?php endif; ?>
										</div>
									</div>

									<?php if ( $links ) : ?>
										<div class="case-links" data-reveal data-reveal-delay="0.1">
											<?php foreach ( $links as $i => $link ) : ?>
												<a class="case-link" href="<?php echo esc_url( $link['url'] ); ?>" target="_blank" rel="noopener noreferrer">
													<span class="case-link__num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
													<span class="case-link__text">
														<span class="case-link__label"><?php echo esc_html( $link['label'] ); ?></span>
														<?php if ( $link['cat'] ) : ?>
															<span class="case-link__cat"><?php echo esc_html( $link['cat'] ); ?></span>
														<?php endif; ?>
													</span>
													<?php echo $this->icone_instagram(); ?>
												</a>
											<?php endforeach; ?>
										</div>
									<?php endif; ?>
								</article>
							<?php endforeach; ?>
						</div>

						<?php if ( count( $cases ) > 1 ) : ?>
							<div class="portfolio-controls">
								<button class="carousel-btn carousel-btn--prev" type="button" data-cases-prev aria-label="Case anterior">
									<img src="<?php echo esc_url( MARGUERITE_URI . '/assets/img/icon-arrow-left.svg' ); ?>" alt="" width="20" height="20">
								</button>
								<div class="portfolio-dots" data-cases-dots role="tablist"></div>
								<button class="carousel-btn carousel-btn--next" type="button" data-cases-next aria-label="Próximo case">
									<img src="<?php echo esc_url( MARGUERITE_URI . '/assets/img/icon-arrow-right.svg' ); ?>" alt="" width="20" height="20">
								</button>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}
}
