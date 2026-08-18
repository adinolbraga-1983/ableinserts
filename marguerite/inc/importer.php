<?php
/**
 * Importador de um clique.
 *
 * Cria a página inicial já montada com as seções da Marguerite (na mesma ordem
 * e com o mesmo conteúdo do layout aprovado) e a define como página inicial do
 * site. Fica em Aparência → Layout da Marguerite.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gera um id no formato que o Elementor usa (7 caracteres hexadecimais).
 */
function marguerite_elementor_id() {
	return substr( md5( uniqid( (string) wp_rand(), true ) ), 0, 7 );
}

/**
 * Monta o JSON de conteúdo do Elementor: um container por seção, largura total
 * e sem espaçamento — o espaçamento real vem do CSS do tema.
 */
function marguerite_layout_elementor() {
	$widgets = array(
		'marguerite-hero',
		'marguerite-quem-somos',
		'marguerite-metodologia',
		'marguerite-executivas',
		'marguerite-cases',
		'marguerite-marcas',
		'marguerite-cta',
	);

	$layout = array();

	foreach ( $widgets as $widget ) {
		$layout[] = array(
			'id'       => marguerite_elementor_id(),
			'elType'   => 'container',
			'settings' => array(
				'content_width'    => 'full',
				'padding'          => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
				'flex_gap'         => array(
					'unit'   => 'px',
					'size'   => 0,
					'column' => '0',
					'row'    => '0',
				),
			),
			'elements' => array(
				array(
					'id'         => marguerite_elementor_id(),
					'elType'     => 'widget',
					'widgetType' => $widget,
					'settings'   => new stdClass(), // usa os padrões do widget (= layout aprovado)
					'elements'   => array(),
				),
			),
			'isInner'  => false,
		);
	}

	return $layout;
}

/**
 * Cria (ou atualiza) a página inicial com o layout da Marguerite.
 */
function marguerite_importar_layout() {
	$existente = get_page_by_path( 'inicio' );

	$dados = array(
		'post_title'   => 'Início',
		'post_name'    => 'inicio',
		'post_status'  => 'publish',
		'post_type'    => 'page',
		'post_content' => '',
	);

	if ( $existente ) {
		$dados['ID'] = $existente->ID;
		$page_id     = wp_update_post( $dados, true );
	} else {
		$page_id = wp_insert_post( $dados, true );
	}

	if ( is_wp_error( $page_id ) ) {
		return $page_id;
	}

	// Marca a página como feita no Elementor e grava o layout.
	update_post_meta( $page_id, '_elementor_edit_mode', 'builder' );
	update_post_meta( $page_id, '_elementor_template_type', 'wp-page' );
	update_post_meta( $page_id, '_wp_page_template', 'elementor_header_footer' );
	if ( defined( 'ELEMENTOR_VERSION' ) ) {
		update_post_meta( $page_id, '_elementor_version', ELEMENTOR_VERSION );
	}
	update_post_meta(
		$page_id,
		'_elementor_data',
		wp_slash( wp_json_encode( marguerite_layout_elementor() ) )
	);

	// Define como página inicial do site.
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $page_id );

	// Limpa o CSS gerado para a página ser recompilada.
	if ( class_exists( '\Elementor\Plugin' ) && isset( \Elementor\Plugin::$instance->files_manager ) ) {
		\Elementor\Plugin::$instance->files_manager->clear_cache();
	}

	return $page_id;
}

/**
 * Página no admin: Aparência → Layout da Marguerite.
 */
function marguerite_admin_menu() {
	add_theme_page(
		'Layout da Marguerite',
		'Layout da Marguerite',
		'edit_theme_options',
		'marguerite-layout',
		'marguerite_admin_page'
	);
}
add_action( 'admin_menu', 'marguerite_admin_menu' );

function marguerite_admin_page() {
	$mensagem = '';

	if ( isset( $_POST['marguerite_importar'] ) && check_admin_referer( 'marguerite_importar_layout' ) ) {
		$resultado = marguerite_importar_layout();
		if ( is_wp_error( $resultado ) ) {
			$mensagem = '<div class="notice notice-error"><p>Não foi possível criar a página: ' . esc_html( $resultado->get_error_message() ) . '</p></div>';
		} else {
			$mensagem = '<div class="notice notice-success"><p><strong>Pronto!</strong> A página inicial foi montada com todas as seções. ' .
				'<a href="' . esc_url( get_permalink( $resultado ) ) . '" target="_blank">Ver o site</a> · ' .
				'<a href="' . esc_url( admin_url( 'post.php?post=' . $resultado . '&action=elementor' ) ) . '">Editar no Elementor</a></p></div>';
		}
	}

	$elementor_ativo = did_action( 'elementor/loaded' );
	?>
	<div class="wrap">
		<h1>Layout da Marguerite</h1>
		<?php echo $mensagem; // phpcs:ignore WordPress.Security.EscapeOutput ?>

		<?php if ( ! $elementor_ativo ) : ?>
			<div class="notice notice-warning">
				<p>O plugin <strong>Elementor</strong> (versão gratuita) precisa estar instalado e ativo. Vá em <em>Plugins → Adicionar novo</em>, procure por “Elementor” e ative.</p>
			</div>
		<?php else : ?>
			<p>Clique no botão abaixo para criar a página inicial já montada com todas as seções do site
				(topo, quem somos, metodologia, executivas, cases, marcas e contato), exatamente como no layout aprovado.</p>
			<p>Depois é só clicar em <strong>Editar com Elementor</strong> para trocar textos, fotos e links.</p>

			<form method="post">
				<?php wp_nonce_field( 'marguerite_importar_layout' ); ?>
				<p>
					<button type="submit" name="marguerite_importar" class="button button-primary button-hero">
						Montar a página inicial
					</button>
				</p>
			</form>

			<hr>
			<h2>Onde edito cada coisa?</h2>
			<ul style="list-style: disc; padding-left: 22px;">
				<li><strong>Textos, fotos e links das seções</strong> → Páginas → Início → “Editar com Elementor”.</li>
				<li><strong>Menu, logo e rodapé</strong> → Aparência → Personalizar.</li>
			</ul>
		<?php endif; ?>
	</div>
	<?php
}
