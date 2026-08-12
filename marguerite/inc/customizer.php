<?php
/**
 * Marguerite — Personalizador (Aparência → Personalizar).
 *
 * Deixa todo o texto, imagens e pequenos "liga/desliga" da página editáveis
 * pelo painel do WordPress, sem precisar mexer em código. Cada campo tem um
 * valor padrão igual ao conteúdo atual do site — nada muda até alguém editar.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Converte **texto** em <strong>texto</strong> (uso: parágrafos com um trecho em negrito).
 * Tudo o mais é escapado — não dá pra colar HTML aqui, só o "negrito com asteriscos".
 */
function marguerite_richtext_bold( $texto ) {
	$html = preg_replace( '/\*\*(.+?)\*\*/s', '<strong>$1</strong>', esc_html( (string) $texto ) );
	return wp_kses_post( $html );
}

/**
 * Como marguerite_richtext_bold(), mas o trecho entre ** vira a palavra
 * destacada em lilás do título do Hero, em vez de negrito.
 */
function marguerite_richtext_accent( $texto ) {
	$html = preg_replace( '/\*\*(.+?)\*\*/s', '<span class="text-accent-lavender">$1</span>', esc_html( (string) $texto ) );
	return wp_kses_post( $html );
}

/**
 * Textarea "um item por linha" → array de strings, sem linhas vazias.
 */
function marguerite_lines_to_array( $texto ) {
	$linhas = preg_split( '/\r\n|\r|\n/', (string) $texto );
	$linhas = array_map( 'trim', $linhas );
	return array_values( array_filter( $linhas, 'strlen' ) );
}

/**
 * Sanitizer para textarea: mantém quebras de linha (ao contrário de sanitize_text_field).
 */
function marguerite_sanitize_textarea( $texto ) {
	return sanitize_textarea_field( (string) $texto );
}

/**
 * Sanitizer para checkbox.
 */
function marguerite_sanitize_checkbox( $valor ) {
	return ( isset( $valor ) && true === $valor ) || '1' === $valor || 1 === $valor;
}

/**
 * Atalho: registra um par setting+control de texto simples (uma linha).
 */
function marguerite_add_text_field( $wp_customize, $section, $id, $label, $default, $args = array() ) {
	$wp_customize->add_setting(
		$id,
		array(
			'default'           => $default,
			'sanitize_callback' => isset( $args['sanitize_callback'] ) ? $args['sanitize_callback'] : 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		$id,
		array(
			'label'   => $label,
			'section' => $section,
			'type'    => isset( $args['type'] ) ? $args['type'] : 'text',
		)
	);
}

/**
 * Atalho: registra um campo textarea.
 */
function marguerite_add_textarea_field( $wp_customize, $section, $id, $label, $default, $description = '' ) {
	$wp_customize->add_setting(
		$id,
		array(
			'default'           => $default,
			'sanitize_callback' => 'marguerite_sanitize_textarea',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		$id,
		array(
			'label'       => $label,
			'description' => $description,
			'section'     => $section,
			'type'        => 'textarea',
		)
	);
}

/**
 * Atalho: registra um campo de imagem.
 */
function marguerite_add_image_field( $wp_customize, $section, $id, $label, $default ) {
	$wp_customize->add_setting(
		$id,
		array(
			'default'           => $default,
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			$id,
			array(
				'label'   => $label,
				'section' => $section,
			)
		)
	);
}

/**
 * Atalho: registra um checkbox.
 */
function marguerite_add_checkbox_field( $wp_customize, $section, $id, $label, $default ) {
	$wp_customize->add_setting(
		$id,
		array(
			'default'           => $default,
			'sanitize_callback' => 'marguerite_sanitize_checkbox',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		$id,
		array(
			'label'   => $label,
			'section' => $section,
			'type'    => 'checkbox',
		)
	);
}

function marguerite_customize_register( $wp_customize ) {

	$wp_customize->get_section( 'title_tagline' )->title = 'Identidade do Site (nome, e-mail admin)';

	/* =====================================================
	 * Cabeçalho / Menu
	 * ===================================================== */
	$wp_customize->add_section(
		'marguerite_sec_header',
		array(
			'title'       => 'Cabeçalho e Menu',
			'priority'    => 30,
			'description' => 'Textos dos links do menu (o destino de cada link continua sendo a seção correspondente da página).',
		)
	);
	$nav_labels_default = array(
		'sobre'       => 'Sobre',
		'metodologia' => 'Metodologia',
		'executivas'  => 'Executivas',
		'cases'       => 'Cases',
		'contato'     => 'Contato',
	);
	foreach ( $nav_labels_default as $key => $label ) {
		marguerite_add_text_field( $wp_customize, 'marguerite_sec_header', "marguerite_nav_{$key}", "Menu — {$label}", $label );
	}
	marguerite_add_text_field( $wp_customize, 'marguerite_sec_header', 'marguerite_nav_cta_label', 'Botão do menu — texto', 'Agende uma Reunião' );
	marguerite_add_text_field( $wp_customize, 'marguerite_sec_header', 'marguerite_nav_cta_link', 'Botão do menu — link', '#contato', array( 'sanitize_callback' => 'esc_url_raw' ) );

	/* =====================================================
	 * Hero (topo da página)
	 * ===================================================== */
	$wp_customize->add_section(
		'marguerite_sec_hero',
		array(
			'title'    => 'Topo da Página (Hero)',
			'priority' => 31,
		)
	);
	marguerite_add_text_field( $wp_customize, 'marguerite_sec_hero', 'marguerite_hero_eyebrow', 'Etiqueta pequena acima do título', 'Agência Boutique' );
	marguerite_add_textarea_field(
		$wp_customize,
		'marguerite_sec_hero',
		'marguerite_hero_heading',
		'Título principal',
		'Experiências memoráveis são planejadas, desenhadas e **conduzidas**.',
		'Coloque **duas asteriscos** ao redor da palavra que deve aparecer destacada em lilás — ex: **conduzidas**.'
	);
	marguerite_add_textarea_field(
		$wp_customize,
		'marguerite_sec_hero',
		'marguerite_hero_lead',
		'Parágrafo de apoio',
		'Da primeira conversa ao desmonte, cada projeto é conduzido pessoalmente pela agência. **Sem repasse. Sem tradução perdida no caminho.**',
		'Use **duas asteriscos** ao redor do trecho que deve ficar em negrito.'
	);
	marguerite_add_text_field( $wp_customize, 'marguerite_sec_hero', 'marguerite_hero_btn_label', 'Botão — texto', 'Agende uma Reunião' );
	marguerite_add_text_field( $wp_customize, 'marguerite_sec_hero', 'marguerite_hero_btn_link', 'Botão — link', '#contato', array( 'sanitize_callback' => 'esc_url_raw' ) );

	/* =====================================================
	 * Quem Somos
	 * ===================================================== */
	$wp_customize->add_section(
		'marguerite_sec_quemsomos',
		array(
			'title'    => 'Quem Somos',
			'priority' => 32,
		)
	);
	marguerite_add_text_field( $wp_customize, 'marguerite_sec_quemsomos', 'marguerite_quemsomos_eyebrow', 'Etiqueta pequena', 'Quem Somos' );
	marguerite_add_text_field( $wp_customize, 'marguerite_sec_quemsomos', 'marguerite_quemsomos_heading', 'Título', 'Trinta e quatro anos de mercado moram aqui.' );
	marguerite_add_textarea_field(
		$wp_customize,
		'marguerite_sec_quemsomos',
		'marguerite_quemsomos_texto',
		'Parágrafo',
		"A Marguerite nasce de um conceito boutique: fazer diferente, com mais sentido e proximidade em cada entrega. Construímos um fluxo personalizado para cada cliente — sem barreiras, mais conversa, mais construção conjunta. **Não somos mais um fornecedor. Somos uma parceria.**",
		'Use **duas asteriscos** ao redor do trecho que deve ficar em negrito.'
	);
	marguerite_add_textarea_field(
		$wp_customize,
		'marguerite_sec_quemsomos',
		'marguerite_quemsomos_tags',
		'Palavras-chave (uma por linha)',
		"Projetos Corporativos\nExperiências Imersivas\nAtivação de Marca",
		'Cada linha vira um item na lista abaixo do texto.'
	);

	/* =====================================================
	 * Metodologia (painel com 1 seção de título + 4 cards)
	 * ===================================================== */
	$wp_customize->add_panel(
		'marguerite_panel_metodologia',
		array(
			'title'    => 'Metodologia (4 cards)',
			'priority' => 33,
		)
	);
	$wp_customize->add_section(
		'marguerite_sec_metodologia_titulo',
		array(
			'title'  => 'Título da seção',
			'panel'  => 'marguerite_panel_metodologia',
		)
	);
	marguerite_add_text_field( $wp_customize, 'marguerite_sec_metodologia_titulo', 'marguerite_metodologia_eyebrow', 'Etiqueta pequena', 'Nossa Metodologia' );
	marguerite_add_text_field( $wp_customize, 'marguerite_sec_metodologia_titulo', 'marguerite_metodologia_heading', 'Título', 'O nosso sucesso com 4 propósitos.' );

	$metodologia_defaults = array(
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
	foreach ( $metodologia_defaults as $n => $card ) {
		$section_id = "marguerite_sec_metodologia_{$n}";
		$wp_customize->add_section(
			$section_id,
			array(
				'title' => "Card {$n}",
				'panel' => 'marguerite_panel_metodologia',
			)
		);
		marguerite_add_text_field( $wp_customize, $section_id, "marguerite_metodologia_{$n}_titulo", 'Título do card', $card['titulo'] );
		marguerite_add_textarea_field( $wp_customize, $section_id, "marguerite_metodologia_{$n}_texto", 'Texto do card', $card['texto'] );
	}

	/* =====================================================
	 * Profissionais (painel com 1 seção de título + pessoas)
	 * ===================================================== */
	$wp_customize->add_panel(
		'marguerite_panel_profissionais',
		array(
			'title'    => 'Profissionais (equipe)',
			'priority' => 34,
		)
	);
	$wp_customize->add_section(
		'marguerite_sec_profissionais_titulo',
		array(
			'title' => 'Título da seção',
			'panel' => 'marguerite_panel_profissionais',
		)
	);
	marguerite_add_text_field( $wp_customize, 'marguerite_sec_profissionais_titulo', 'marguerite_profissionais_eyebrow', 'Etiqueta pequena', 'Profissionais' );
	marguerite_add_text_field( $wp_customize, 'marguerite_sec_profissionais_titulo', 'marguerite_profissionais_heading', 'Título', 'O diferencial desenvolvido em cada experiência.' );

	$equipe_defaults = array(
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
	foreach ( $equipe_defaults as $n => $pessoa ) {
		$section_id = "marguerite_sec_pessoa_{$n}";
		$wp_customize->add_section(
			$section_id,
			array(
				'title' => "Pessoa {$n} — {$pessoa['nome']}",
				'panel' => 'marguerite_panel_profissionais',
			)
		);
		marguerite_add_checkbox_field( $wp_customize, $section_id, "marguerite_pessoa_{$n}_mostrar_foto", 'Mostrar foto no card?', $pessoa['mostrar_foto'] );
		marguerite_add_image_field( $wp_customize, $section_id, "marguerite_pessoa_{$n}_foto", 'Foto', $pessoa['foto'] );
		marguerite_add_text_field( $wp_customize, $section_id, "marguerite_pessoa_{$n}_nome", 'Nome', $pessoa['nome'] );
		marguerite_add_text_field( $wp_customize, $section_id, "marguerite_pessoa_{$n}_cargo", 'Cargo', $pessoa['cargo'] );
		marguerite_add_textarea_field( $wp_customize, $section_id, "marguerite_pessoa_{$n}_texto", 'Bio', $pessoa['texto'] );
	}

	/* =====================================================
	 * Portfólio (painel com título + 4 cases + marcas)
	 * ===================================================== */
	$wp_customize->add_panel(
		'marguerite_panel_portfolio',
		array(
			'title'    => 'Portfólio (cases)',
			'priority' => 35,
		)
	);
	$wp_customize->add_section(
		'marguerite_sec_portfolio_titulo',
		array(
			'title' => 'Título da seção',
			'panel' => 'marguerite_panel_portfolio',
		)
	);
	marguerite_add_text_field( $wp_customize, 'marguerite_sec_portfolio_titulo', 'marguerite_portfolio_eyebrow', 'Etiqueta pequena', 'Portfólio' );
	marguerite_add_textarea_field( $wp_customize, 'marguerite_sec_portfolio_titulo', 'marguerite_portfolio_heading', 'Título', 'Experiências que geram conexões reais entre marcas e clientes.' );

	$cases_defaults = array(
		1 => array(
			'top_label' => 'Consultoria Dangebel',
			'categoria' => 'Convenção Comercial 2025',
			'titulo'    => 'SKY',
			'descricao' => 'Equipe comercial, credenciados e acionistas engajados nas novas estratégias e metas anuais, reconhecidos dentro do ecossistema.',
			'meta'      => "980 pessoas\nIberostar · Salvador/BA\n3 dias\nComercial & Acionistas",
			'foto'      => '',
		),
		2 => array(
			'top_label' => 'Consultoria Dangebel',
			'categoria' => 'Convenção Loft / Portas 2026',
			'titulo'    => 'Loft',
			'descricao' => 'Loft posicionada como motor de crescimento, inovação e tecnologia, em união com os parceiros de negócios do ecossistema.',
			'meta'      => "930 pessoas\nCommunity Creators Academy",
			'foto'      => '',
		),
		3 => array(
			'top_label' => 'Agência',
			'categoria' => 'Tegra Incorporadora',
			'titulo'    => 'Tegra Guest',
			'descricao' => 'Quatro experiências curadas: jantar Picchi (Michelin), SP e RJ Open, e o pôr do sol em alto mar no Rio.',
			'meta'      => "Programa de experiências\nProspects, clientes & investidores\nSP / RJ",
			'foto'      => MARGUERITE_URI . '/assets/img/case-tegraguest.png',
		),
		4 => array(
			'top_label' => 'Agência',
			'categoria' => 'Coletiva de Imprensa',
			'titulo'    => 'Busco',
			'descricao' => 'Lançamento da plataforma que reúne as principais viações do Brasil — rotas reais, informações claras e compra online segura.',
			'meta'      => "30 pessoas\nEco Lodge · Pedra Azul/ES\n1 dia\nImprensa & Influenciadores",
			'foto'      => '',
		),
	);
	foreach ( $cases_defaults as $n => $case ) {
		$section_id = "marguerite_sec_case_{$n}";
		$wp_customize->add_section(
			$section_id,
			array(
				'title' => "Case {$n} — {$case['titulo']}",
				'panel' => 'marguerite_panel_portfolio',
			)
		);
		marguerite_add_text_field( $wp_customize, $section_id, "marguerite_case_{$n}_top_label", 'Etiqueta pequena (ex: Agência)', $case['top_label'] );
		marguerite_add_text_field( $wp_customize, $section_id, "marguerite_case_{$n}_categoria", 'Categoria / nome do evento', $case['categoria'] );
		marguerite_add_text_field( $wp_customize, $section_id, "marguerite_case_{$n}_titulo", 'Título (nome do cliente)', $case['titulo'] );
		marguerite_add_textarea_field( $wp_customize, $section_id, "marguerite_case_{$n}_descricao", 'Descrição', $case['descricao'] );
		marguerite_add_textarea_field( $wp_customize, $section_id, "marguerite_case_{$n}_meta", 'Informações (uma por linha)', $case['meta'], 'Ex: número de pessoas, local, duração — cada linha vira um item separado por "·".' );
		marguerite_add_image_field( $wp_customize, $section_id, "marguerite_case_{$n}_foto", 'Foto de fundo (opcional)', $case['foto'] );
	}

	$wp_customize->add_section(
		'marguerite_sec_marcas',
		array(
			'title' => 'Marcas (rodapé do carrossel)',
			'panel' => 'marguerite_panel_portfolio',
		)
	);
	marguerite_add_text_field( $wp_customize, 'marguerite_sec_marcas', 'marguerite_marcas_titulo', 'Frase acima das marcas', 'Marcas que confiam na condução da consultoria e agência' );
	marguerite_add_textarea_field( $wp_customize, 'marguerite_sec_marcas', 'marguerite_marcas_lista', 'Marcas (uma por linha)', "BUSCO\nLOFT\nTEGRA\nSKY®" );

	/* =====================================================
	 * Fale Conosco (CTA final)
	 * ===================================================== */
	$wp_customize->add_section(
		'marguerite_sec_cta',
		array(
			'title'    => 'Fale Conosco (bloco final)',
			'priority' => 36,
		)
	);
	marguerite_add_textarea_field( $wp_customize, 'marguerite_sec_cta', 'marguerite_cta_heading', 'Título', 'Vamos conversar sobre o seu próximo projeto.' );
	marguerite_add_textarea_field( $wp_customize, 'marguerite_sec_cta', 'marguerite_cta_lead', 'Parágrafo', "Sem briefing formal.\nApenas um diálogo direto com quem conduz.", 'Cada linha vira uma linha separada no texto.' );
	marguerite_add_text_field( $wp_customize, 'marguerite_sec_cta', 'marguerite_cta_btn_label', 'Botão — texto', 'Falar via WhatsApp' );
	marguerite_add_text_field( $wp_customize, 'marguerite_sec_cta', 'marguerite_cta_btn_link', 'Botão — link (ex: https://wa.me/55DDDNUMERO)', 'https://wa.me/5500000000000', array( 'sanitize_callback' => 'esc_url_raw' ) );

	/* =====================================================
	 * Rodapé
	 * ===================================================== */
	$wp_customize->add_section(
		'marguerite_sec_footer',
		array(
			'title'    => 'Rodapé',
			'priority' => 37,
		)
	);
	marguerite_add_text_field( $wp_customize, 'marguerite_sec_footer', 'marguerite_footer_endereco', 'Cidade / UF', 'São Paulo · SP' );
	marguerite_add_text_field( $wp_customize, 'marguerite_sec_footer', 'marguerite_footer_email', 'E-mail de contato', 'cintia@margueriteexperience.com.br', array( 'sanitize_callback' => 'sanitize_email' ) );
	marguerite_add_text_field(
		$wp_customize,
		'marguerite_sec_footer',
		'marguerite_footer_copyright',
		'Texto de direitos autorais',
		'© %ano% Agência Marguerite. Todos os direitos reservados.',
		array()
	);
}
add_action( 'customize_register', 'marguerite_customize_register' );
