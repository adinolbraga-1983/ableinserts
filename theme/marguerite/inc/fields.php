<?php
/**
 * Grupos de campos ACF: blocos (seções) e CPTs.
 * Dica: use [mark]trecho[/mark] em títulos para o realce amarelo, e quebras de
 * linha normais para novas linhas. Campos vazios caem para o conteúdo-base no render.
 *
 * @package Marguerite
 */

defined( 'ABSPATH' ) || exit;

add_action( 'acf/init', function () {

	$loc = function ( $block ) {
		return array( array( array( 'param' => 'block', 'operator' => '==', 'value' => 'acf/' . $block ) ) );
	};

	/* ---------------------------------------------------------------- HERO */
	acf_add_local_field_group( array(
		'key' => 'grp_hero', 'title' => 'Hero', 'location' => $loc( 'hero' ),
		'fields' => array(
			array( 'key' => 'hero_headline', 'label' => 'Título', 'name' => 'headline', 'type' => 'textarea', 'rows' => 3, 'instructions' => 'Use [mark]…[/mark] para o realce.', 'default_value' => "Experiências\nmemoráveis não\nacontecem.\n[mark]São conduzidas.[/mark]" ),
			array( 'key' => 'hero_sub', 'label' => 'Subtítulo', 'name' => 'sub', 'type' => 'text', 'default_value' => 'Agência boutique de eventos e marketing de experiência.' ),
			array( 'key' => 'hero_bc1', 'label' => 'Breadcrumb 1', 'name' => 'bc1', 'type' => 'text', 'default_value' => 'Início' ),
			array( 'key' => 'hero_bc2', 'label' => 'Breadcrumb 2', 'name' => 'bc2', 'type' => 'text', 'default_value' => 'Como conduzimos' ),
			array( 'key' => 'hero_video', 'label' => 'Vídeo (mp4)', 'name' => 'video', 'type' => 'file', 'return_format' => 'url', 'mime_types' => 'mp4' ),
			array( 'key' => 'hero_video_webm', 'label' => 'Vídeo (webm, opcional)', 'name' => 'video_webm', 'type' => 'file', 'return_format' => 'url', 'mime_types' => 'webm' ),
			array( 'key' => 'hero_poster', 'label' => 'Poster', 'name' => 'poster', 'type' => 'image', 'return_format' => 'array' ),
			array( 'key' => 'hero_lente', 'label' => 'Lente roxa (duotone)', 'name' => 'lente_roxa', 'type' => 'true_false', 'ui' => 1, 'default_value' => 1 ),
		),
	) );

	/* --------------------------------------------------------------- SOBRE */
	acf_add_local_field_group( array(
		'key' => 'grp_sobre', 'title' => 'Sobre / 34 anos', 'location' => $loc( 'sobre' ),
		'fields' => array(
			array( 'key' => 'sobre_eyebrow', 'label' => 'Eyebrow', 'name' => 'eyebrow', 'type' => 'text', 'default_value' => 'Sobre' ),
			array( 'key' => 'sobre_headline', 'label' => 'Título', 'name' => 'headline', 'type' => 'textarea', 'rows' => 2, 'default_value' => "Trinta e quatro anos\nde mercado moram aqui." ),
			array( 'key' => 'sobre_texto', 'label' => 'Texto', 'name' => 'texto', 'type' => 'textarea', 'rows' => 4, 'default_value' => 'Uma agência boutique apaixonada por criar experiências sob medida para marcas que não podem errar em público. Da primeira conversa ao desmonte, cada projeto é conduzido pessoalmente — sem repasse, sem tradução perdida no caminho.' ),
			array( 'key' => 'sobre_servicos', 'label' => 'Serviços', 'name' => 'servicos', 'type' => 'repeater', 'button_label' => 'Adicionar serviço', 'sub_fields' => array(
				array( 'key' => 'sobre_serv_item', 'label' => 'Item', 'name' => 'item', 'type' => 'text' ),
			) ),
			array( 'key' => 'sobre_cta_label', 'label' => 'CTA — texto', 'name' => 'cta_label', 'type' => 'text', 'default_value' => 'Conheça o método' ),
			array( 'key' => 'sobre_cta_link', 'label' => 'CTA — link', 'name' => 'cta_link', 'type' => 'text', 'default_value' => '#metodologia' ),
			array( 'key' => 'sobre_img', 'label' => 'Imagem (retrato)', 'name' => 'imagem', 'type' => 'image', 'return_format' => 'array' ),
		),
	) );

	/* --------------------------------------------------------- METODOLOGIA */
	acf_add_local_field_group( array(
		'key' => 'grp_metodo', 'title' => 'Metodologia', 'location' => $loc( 'metodologia' ),
		'fields' => array(
			array( 'key' => 'met_eyebrow', 'label' => 'Eyebrow', 'name' => 'eyebrow', 'type' => 'text', 'default_value' => 'Metodologia' ),
			array( 'key' => 'met_headline', 'label' => 'Título', 'name' => 'headline', 'type' => 'textarea', 'rows' => 2, 'default_value' => "O sucesso é alcançado\nem quatro" ),
			array( 'key' => 'met_itens', 'label' => 'Passos', 'name' => 'itens', 'type' => 'repeater', 'button_label' => 'Adicionar passo', 'sub_fields' => array(
				array( 'key' => 'met_num', 'label' => 'Número', 'name' => 'num', 'type' => 'text' ),
				array( 'key' => 'met_titulo', 'label' => 'Título', 'name' => 'titulo', 'type' => 'text' ),
				array( 'key' => 'met_bold', 'label' => 'Destaque (negrito)', 'name' => 'bold', 'type' => 'true_false', 'ui' => 1 ),
			) ),
			array( 'key' => 'met_foot', 'label' => 'Texto de fechamento', 'name' => 'foot', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Construímos um fluxo personalizado para cada cliente: sem barreiras, mais conversas, mais construção, resultando em uma parceria sólida e não em apenas mais um fornecedor.' ),
		),
	) );

	/* ---------------------------------------------------------------- CASES */
	acf_add_local_field_group( array(
		'key' => 'grp_cases', 'title' => 'Cases (galeria)', 'location' => $loc( 'cases-gallery' ),
		'fields' => array(
			array( 'key' => 'cg_eyebrow', 'label' => 'Eyebrow', 'name' => 'eyebrow', 'type' => 'text', 'default_value' => 'Cases' ),
			array( 'key' => 'cg_headline', 'label' => 'Título', 'name' => 'headline', 'type' => 'text', 'default_value' => 'Projetos conduzidos por nossas executivas' ),
			array( 'key' => 'cg_cta_label', 'label' => 'CTA — texto', 'name' => 'cta_label', 'type' => 'text', 'default_value' => 'Ver todos' ),
			array( 'key' => 'cg_qtd', 'label' => 'Quantidade', 'name' => 'quantidade', 'type' => 'number', 'default_value' => 4, 'min' => 1, 'max' => 12 ),
		),
	) );

	/* ------------------------------------------------------------- CLIENTES */
	acf_add_local_field_group( array(
		'key' => 'grp_clientes', 'title' => 'Clientes', 'location' => $loc( 'clientes' ),
		'fields' => array(
			array( 'key' => 'cl_eyebrow', 'label' => 'Eyebrow', 'name' => 'eyebrow', 'type' => 'text', 'default_value' => 'Clientes' ),
			array( 'key' => 'cl_manifesto', 'label' => 'Manifesto', 'name' => 'manifesto', 'type' => 'textarea', 'rows' => 2, 'instructions' => 'Use [mark]…[/mark] para o realce.', 'default_value' => 'Criamos experiências memoráveis que geram [mark]conexões reais[/mark] entre marcas e clientes.' ),
			array( 'key' => 'cl_fonte', 'label' => 'Fonte dos logos', 'name' => 'fonte', 'type' => 'select', 'choices' => array( 'cpt' => 'CPT Clientes', 'manual' => 'Manual (abaixo)' ), 'default_value' => 'cpt' ),
			array( 'key' => 'cl_logos', 'label' => 'Logos (manual)', 'name' => 'logos', 'type' => 'repeater', 'button_label' => 'Adicionar logo', 'conditional_logic' => array( array( array( 'field' => 'cl_fonte', 'operator' => '==', 'value' => 'manual' ) ) ), 'sub_fields' => array(
				array( 'key' => 'cl_logo_img', 'label' => 'Logo', 'name' => 'logo', 'type' => 'image', 'return_format' => 'array' ),
				array( 'key' => 'cl_logo_nome', 'label' => 'Nome', 'name' => 'nome', 'type' => 'text' ),
			) ),
			array( 'key' => 'cl_metricas', 'label' => 'Métricas', 'name' => 'metricas', 'type' => 'repeater', 'button_label' => 'Adicionar métrica', 'sub_fields' => array(
				array( 'key' => 'cl_met_num', 'label' => 'Número', 'name' => 'num', 'type' => 'text' ),
				array( 'key' => 'cl_met_titulo', 'label' => 'Título', 'name' => 'titulo', 'type' => 'text' ),
			) ),
		),
	) );

	/* -------------------------------------------------------------- CONTATO */
	acf_add_local_field_group( array(
		'key' => 'grp_contato', 'title' => 'Contato', 'location' => $loc( 'contato' ),
		'fields' => array(
			array( 'key' => 'ct_eyebrow', 'label' => 'Eyebrow', 'name' => 'eyebrow', 'type' => 'text', 'default_value' => 'Convite' ),
			array( 'key' => 'ct_headline', 'label' => 'Título', 'name' => 'headline', 'type' => 'textarea', 'rows' => 2, 'instructions' => 'Use [mark]…[/mark] para o realce.', 'default_value' => "Vamos conversar sobre\n[mark]o seu próximo projeto[/mark]" ),
			array( 'key' => 'ct_micro', 'label' => 'Microcopy', 'name' => 'microcopy', 'type' => 'text', 'default_value' => 'Sem briefing formal. Só uma conversa.' ),
			array( 'key' => 'ct_btn', 'label' => 'Texto do botão', 'name' => 'btn', 'type' => 'text', 'default_value' => 'Iniciar conversa' ),
			array( 'key' => 'ct_destino', 'label' => 'E-mail de destino', 'name' => 'destino', 'type' => 'email', 'instructions' => 'Para onde enviar as mensagens (integração na Fase 5).' ),
		),
	) );

	/* --------------------------------------------------------- CASE (CPT) */
	acf_add_local_field_group( array(
		'key' => 'grp_case', 'title' => 'Detalhes do Case',
		'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'case' ) ) ),
		'fields' => array(
			array( 'key' => 'case_tab_ficha', 'label' => 'Ficha técnica', 'type' => 'tab' ),
			array( 'key' => 'case_tipo', 'label' => 'Tipo de projeto', 'name' => 'ficha_tipo', 'type' => 'text', 'default_value' => 'Gestão e Execução de Evento Corporativo' ),
			array( 'key' => 'case_dim', 'label' => 'Dimensão', 'name' => 'ficha_dimensao', 'type' => 'text' ),
			array( 'key' => 'case_local', 'label' => 'Local', 'name' => 'ficha_local', 'type' => 'text' ),
			array( 'key' => 'case_meta', 'label' => 'Meta do card (nº · papel · cidade)', 'name' => 'card_meta', 'type' => 'text' ),
			array( 'key' => 'case_video', 'label' => 'Vídeo do hero (opcional)', 'name' => 'hero_video', 'type' => 'file', 'return_format' => 'url', 'mime_types' => 'mp4' ),

			array( 'key' => 'case_tab_conteudo', 'label' => 'Conteúdo', 'type' => 'tab' ),
			array( 'key' => 'case_desafio', 'label' => 'O Desafio', 'name' => 'desafio', 'type' => 'wysiwyg', 'media_upload' => 0 ),
			array( 'key' => 'case_solucao', 'label' => 'A Solução (passos)', 'name' => 'solucao', 'type' => 'repeater', 'button_label' => 'Adicionar passo', 'sub_fields' => array(
				array( 'key' => 'case_sol_titulo', 'label' => 'Título', 'name' => 'titulo', 'type' => 'text' ),
				array( 'key' => 'case_sol_texto', 'label' => 'Texto', 'name' => 'texto', 'type' => 'textarea', 'rows' => 3 ),
			) ),
			array( 'key' => 'case_resultado', 'label' => 'Resultados', 'name' => 'resultado', 'type' => 'repeater', 'button_label' => 'Adicionar resultado', 'sub_fields' => array(
				array( 'key' => 'case_res_metrica', 'label' => 'Métrica', 'name' => 'metrica', 'type' => 'text' ),
				array( 'key' => 'case_res_valor', 'label' => 'Valor', 'name' => 'valor', 'type' => 'text' ),
			) ),
			array( 'key' => 'case_galeria', 'label' => 'Galeria', 'name' => 'galeria', 'type' => 'gallery', 'return_format' => 'array' ),
		),
	) );

	/* ------------------------------------------------------- CLIENTE (CPT) */
	acf_add_local_field_group( array(
		'key' => 'grp_cliente', 'title' => 'Logo do Cliente',
		'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'cliente' ) ) ),
		'fields' => array(
			array( 'key' => 'cliente_logo', 'label' => 'Logo (mono/branco)', 'name' => 'logo', 'type' => 'image', 'return_format' => 'array', 'instructions' => 'De preferência branco ou monocromático (exibido sobre fundo escuro).' ),
			array( 'key' => 'cliente_url', 'label' => 'Site', 'name' => 'url', 'type' => 'url' ),
		),
	) );

	/* ---------------------------------------------------- DEPOIMENTO (CPT) */
	acf_add_local_field_group( array(
		'key' => 'grp_depo', 'title' => 'Depoimento',
		'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'depoimento' ) ) ),
		'fields' => array(
			array( 'key' => 'depo_quote', 'label' => 'Depoimento', 'name' => 'quote', 'type' => 'textarea', 'rows' => 3 ),
			array( 'key' => 'depo_autor', 'label' => 'Autor', 'name' => 'autor', 'type' => 'text' ),
			array( 'key' => 'depo_cargo', 'label' => 'Cargo', 'name' => 'cargo', 'type' => 'text' ),
			array( 'key' => 'depo_empresa', 'label' => 'Empresa (cliente)', 'name' => 'empresa', 'type' => 'post_object', 'post_type' => array( 'cliente' ), 'return_format' => 'id' ),
			array( 'key' => 'depo_foto', 'label' => 'Foto', 'name' => 'foto', 'type' => 'image', 'return_format' => 'array' ),
		),
	) );

	/* ------------------------------------------- SEO por página/post/case */
	acf_add_local_field_group( array(
		'key' => 'grp_seo', 'title' => 'SEO',
		'location' => array(
			array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'page' ) ),
			array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'case' ) ),
			array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'post' ) ),
		),
		'menu_order' => 20,
		'fields' => array(
			array( 'key' => 'seo_desc', 'label' => 'Descrição (meta)', 'name' => 'seo_descricao', 'type' => 'textarea', 'rows' => 2, 'maxlength' => 180 ),
			array( 'key' => 'seo_img', 'label' => 'Imagem OG', 'name' => 'seo_imagem', 'type' => 'image', 'return_format' => 'array' ),
		),
	) );
} );
