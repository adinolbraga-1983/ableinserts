<?php
/**
 * Classe base dos widgets da Marguerite.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Marguerite_Widget_Base extends \Elementor\Widget_Base {

	public function get_categories() {
		return array( 'marguerite' );
	}

	/**
	 * Os estilos/scripts já são carregados pelo tema em todas as páginas.
	 */
	public function get_style_depends() {
		return array( 'marguerite-style' );
	}

	public function get_script_depends() {
		return array( 'marguerite-main' );
	}

	/**
	 * Converte **trecho** em <strong>trecho</strong>, escapando todo o resto.
	 */
	protected function negrito( $texto ) {
		$html = preg_replace( '/\*\*(.+?)\*\*/s', '<strong>$1</strong>', esc_html( (string) $texto ) );
		return wp_kses( $html, array( 'strong' => array(), 'br' => array() ) );
	}

	/**
	 * Converte **trecho** no destaque em lilás do título.
	 */
	protected function destaque( $texto ) {
		$html = preg_replace( '/\*\*(.+?)\*\*/s', '<span class="text-accent-lavender">$1</span>', esc_html( (string) $texto ) );
		return wp_kses( $html, array( 'span' => array( 'class' => array() ), 'br' => array() ) );
	}

	/**
	 * Textarea "um item por linha" → array de strings.
	 */
	protected function linhas( $texto ) {
		$linhas = preg_split( '/\r\n|\r|\n/', (string) $texto );
		$linhas = array_map( 'trim', $linhas );
		return array_values( array_filter( $linhas, 'strlen' ) );
	}

	/**
	 * Ícone do Instagram usado nos cards de link dos cases.
	 */
	protected function icone_instagram() {
		return '<svg class="case-link__icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><rect x="2.5" y="2.5" width="19" height="19" rx="5.5" stroke="currentColor" stroke-width="1.6"/><circle cx="12" cy="12" r="4.2" stroke="currentColor" stroke-width="1.6"/><circle cx="17.3" cy="6.7" r="1.05" fill="currentColor"/></svg>';
	}
}
