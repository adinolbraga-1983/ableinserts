<?php
/**
 * Bloco: Hero — vídeo full-screen dirigido pelo scroll (frame-sequence).
 * O título é dividido em duas cenas: as linhas normais (cena 1) e a frase
 * marcada com [mark]…[/mark] (cena 2, o "clímax"). Campos com fallback.
 *
 * @package Marguerite
 */

defined( 'ABSPATH' ) || exit;

$headline = get_field( 'headline' ) ?: "Experiências\nmemoráveis não\nacontecem.\n[mark]São conduzidas.[/mark]";
$sub      = get_field( 'sub' ) ?: 'Agência boutique de eventos e marketing de experiência.';
$bc1      = get_field( 'bc1' ) ?: 'Início';
$bc2      = get_field( 'bc2' ) ?: 'Como conduzimos';

// Sequência de frames do hero (fallback: a que acompanha o tema).
$seq_dir = marguerite_asset( 'img/hero-seq/' );
$frames  = 96;

// Divide o título: linhas sem [mark] → cena 1; a linha com [mark] → cena 2.
$lines = preg_split( '/\r\n|\r|\n/', trim( (string) $headline ) );
$scene1_lines = array();
$scene2 = '';
foreach ( $lines as $line ) {
	if ( strpos( $line, '[mark]' ) !== false ) {
		$scene2 = $line;
	} else {
		$scene1_lines[] = $line;
	}
}
if ( '' === $scene2 && $scene1_lines ) {
	$scene2 = '[mark]' . array_pop( $scene1_lines ) . '[/mark]';
}

$title_html = '';
foreach ( $scene1_lines as $line ) {
	$title_html .= '<span class="line"><span>' . marguerite_markup_text( $line ) . '</span></span>';
}

$block_id = ! empty( $block['anchor'] ) ? esc_attr( $block['anchor'] ) : 'hero';
?>
<section class="hero" id="<?php echo $block_id; ?>" aria-label="Apresentação"
         data-hero-seq="<?php echo esc_url( $seq_dir ); ?>" data-hero-frames="<?php echo (int) $frames; ?>">
	<div class="hero__pin">
		<canvas class="hero__canvas" id="hero-canvas" aria-hidden="true"></canvas>
		<img class="hero__poster" src="<?php echo esc_url( $seq_dir . '000.jpg' ); ?>" alt="" aria-hidden="true" fetchpriority="high" />
		<div class="hero__scrim" aria-hidden="true"></div>

		<div class="hero__scenes">
			<div class="hero__scene hero__scene--1">
				<h1 class="hero__title" data-hero-title><?php echo $title_html; // phpcs:ignore ?></h1>
				<p class="hero__sub"><?php echo esc_html( $sub ); ?></p>
			</div>
			<div class="hero__scene hero__scene--2" aria-hidden="true">
				<p class="hero__big"><?php echo marguerite_markup_text( $scene2 ); // phpcs:ignore ?></p>
			</div>
		</div>

		<div class="hero__meta" aria-hidden="true">
			<span><?php echo esc_html( $bc1 ); ?></span><span>·</span><span><?php echo esc_html( $bc2 ); ?></span>
		</div>
		<div class="hero__progress" aria-hidden="true"><span>Role</span><span class="track"><i></i></span></div>
	</div>
</section>
