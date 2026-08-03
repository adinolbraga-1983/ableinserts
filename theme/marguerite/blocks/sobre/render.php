<?php
/**
 * Bloco: Sobre / 34 anos.
 *
 * @package Marguerite
 */

defined( 'ABSPATH' ) || exit;

$eyebrow  = get_field( 'eyebrow' ) ?: 'Sobre';
$headline = get_field( 'headline' ) ?: "Trinta e quatro anos\nde mercado moram aqui.";
$texto    = get_field( 'texto' ) ?: 'Uma agência boutique apaixonada por criar experiências sob medida para marcas que não podem errar em público. Da primeira conversa ao desmonte, cada projeto é conduzido pessoalmente — sem repasse, sem tradução perdida no caminho.';
$cta_label= get_field( 'cta_label' ) ?: 'Conheça o método';
$cta_link = get_field( 'cta_link' ) ?: '#metodologia';
$imagem   = get_field( 'imagem' );

$servicos = get_field( 'servicos' );
if ( empty( $servicos ) ) {
	$servicos = array(
		array( 'item' => 'Projetos Corporativos' ),
		array( 'item' => 'Experiências Imersivas' ),
		array( 'item' => 'Ativação de Marcas' ),
	);
}

$img_html = $imagem
	? marguerite_image( $imagem, 'marguerite-portrait', array( 'class' => 'sobre__img', 'data-parallax' => '1' ) )
	: '<img class="sobre__img" data-parallax src="' . esc_url( marguerite_asset( 'img/sobre-portrait.jpg' ) ) . '" alt="" loading="lazy" decoding="async" />';

$block_id = ! empty( $block['anchor'] ) ? esc_attr( $block['anchor'] ) : 'sobre';
?>
<section class="sobre" id="<?php echo $block_id; ?>" aria-labelledby="sobre-title">
	<div class="sobre__bg" aria-hidden="true">
		<?php echo $img_html; // phpcs:ignore ?>
		<div class="sobre__duotone"></div>
		<div class="sobre__warm"></div>
	</div>
	<div class="container sobre__inner">
		<div class="sobre__body">
			<span class="eyebrow" data-reveal><?php echo esc_html( $eyebrow ); ?></span>
			<h2 class="sobre__title" id="sobre-title" data-reveal><?php echo marguerite_markup_text( $headline ); // phpcs:ignore ?></h2>
			<p class="sobre__text" data-reveal><?php echo esc_html( $texto ); ?></p>
			<ul class="sobre__services" data-reveal>
				<?php foreach ( $servicos as $s ) : ?>
					<li><?php echo esc_html( $s['item'] ?? '' ); ?></li>
				<?php endforeach; ?>
			</ul>
			<a class="sobre__cta link-underline" href="<?php echo esc_url( $cta_link ); ?>" data-reveal><?php echo esc_html( $cta_label ); ?> <?php echo marguerite_arrow(); // phpcs:ignore ?></a>
		</div>
	</div>
</section>
