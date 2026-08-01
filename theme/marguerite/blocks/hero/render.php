<?php
/**
 * Bloco: Hero. Campos ACF com fallback para o conteúdo-base.
 *
 * @package Marguerite
 */

defined( 'ABSPATH' ) || exit;

$headline = get_field( 'headline' ) ?: "Experiências\nmemoráveis não\nacontecem.\n[mark]São conduzidas.[/mark]";
$sub      = get_field( 'sub' ) ?: 'Agência boutique de eventos e marketing de experiência.';
$bc1      = get_field( 'bc1' ) ?: 'Início';
$bc2      = get_field( 'bc2' ) ?: 'Como conduzimos';
$lente    = get_field( 'lente_roxa' );
$lente    = ( '' === $lente || null === $lente ) ? true : (bool) $lente;

$video    = get_field( 'video' );
$video    = $video ?: marguerite_asset( 'video/hero.mp4' );
$webm     = get_field( 'video_webm' );
$webm     = $webm ?: marguerite_asset( 'video/hero.webm' );
$poster   = get_field( 'poster' );
$poster_url = is_array( $poster ) ? ( $poster['url'] ?? '' ) : $poster;
$poster_url = $poster_url ?: marguerite_asset( 'img/hero-poster.jpg' );

// Título em linhas (cada uma anima separadamente).
$lines = preg_split( '/\r\n|\r|\n/', trim( (string) $headline ) );
$title_html = '';
foreach ( $lines as $line ) {
	$title_html .= '<span class="line"><span>' . marguerite_markup_text( $line ) . '</span></span>';
}

$block_id = ! empty( $block['anchor'] ) ? esc_attr( $block['anchor'] ) : 'hero';
?>
<section class="hero<?php echo $lente ? '' : ' no-lente'; ?>" id="<?php echo $block_id; ?>" aria-label="Apresentação">
	<div class="hero__stage" aria-hidden="true">
		<canvas class="hero__canvas" id="hero-canvas"></canvas>
		<video class="hero__media" id="hero-video" playsinline muted loop autoplay preload="metadata" poster="<?php echo esc_url( $poster_url ); ?>">
			<?php if ( $webm ) : ?><source src="<?php echo esc_url( $webm ); ?>" type="video/webm" /><?php endif; ?>
			<source src="<?php echo esc_url( $video ); ?>" type="video/mp4" />
		</video>
		<div class="hero__duotone"></div>
		<div class="hero__tint"></div>
	</div>
	<div class="hero__content">
		<h1 class="hero__title" data-hero-title data-marker-draw><?php echo $title_html; // phpcs:ignore ?></h1>
		<p class="hero__sub" data-reveal><?php echo esc_html( $sub ); ?></p>
		<div class="hero__meta" data-reveal>
			<span><?php echo esc_html( $bc1 ); ?></span><span aria-hidden="true">·</span><span><?php echo esc_html( $bc2 ); ?></span>
		</div>
	</div>
</section>
