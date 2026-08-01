<?php
/**
 * Helpers de apresentação. Mantêm os render.php enxutos e seguros (escape).
 *
 * @package Marguerite
 */

defined( 'ABSPATH' ) || exit;

/**
 * Renderiza um texto com um trecho realçado (marcador verde-limão).
 * Aceita o padrão [mark]trecho[/mark] vindo do CMS e o converte em <em class="marker">.
 * Escapa todo o resto.
 *
 * @param string $text Texto com marcações opcionais [mark]…[/mark].
 * @return string HTML seguro.
 */
function marguerite_markup_text( $text ) {
	$text = (string) $text;
	// Escapa tudo primeiro.
	$safe = esc_html( $text );
	// Reintroduz apenas o realce e quebras de linha explícitas.
	$safe = str_replace( array( '[mark]', '[/mark]' ), array( '<em class="marker">', '</em>' ), $safe );
	$safe = str_replace( array( "\r\n", "\n" ), '<br />', $safe );
	return $safe;
}

/**
 * Ícone (SVG inline) de seta usado em CTAs.
 */
function marguerite_arrow() {
	return '<span class="arrow" aria-hidden="true">→</span>';
}

/**
 * URL de um asset do tema.
 *
 * @param string $path Caminho relativo a assets/.
 * @return string
 */
function marguerite_asset( $path ) {
	return MARGUERITE_URI . '/assets/' . ltrim( $path, '/' );
}

/**
 * Recupera um valor de opção global (ACF options) com fallback.
 *
 * @param string $name    Nome do campo.
 * @param mixed  $default Valor padrão.
 * @return mixed
 */
function marguerite_option( $name, $default = '' ) {
	if ( function_exists( 'get_field' ) ) {
		$val = get_field( $name, 'option' );
		if ( ! empty( $val ) ) {
			return $val;
		}
	}
	return $default;
}

/**
 * Marca de imagem responsiva a partir de um array de imagem do ACF.
 *
 * @param array|int $image ACF image (array) ou attachment ID.
 * @param string    $size  Tamanho registrado.
 * @param array     $attr  Atributos extra (class, loading, etc.).
 * @return string
 */
function marguerite_image( $image, $size = 'large', $attr = array() ) {
	$id = is_array( $image ) ? ( $image['ID'] ?? 0 ) : (int) $image;
	if ( ! $id ) {
		return '';
	}
	return wp_get_attachment_image( $id, $size, false, $attr );
}
