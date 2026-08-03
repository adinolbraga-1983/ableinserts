<?php
/**
 * Bloco: Contato.
 *
 * @package Marguerite
 */

defined( 'ABSPATH' ) || exit;

$eyebrow  = get_field( 'eyebrow' ) ?: 'Convite';
$headline = get_field( 'headline' ) ?: "Vamos conversar sobre\n[mark]o seu próximo projeto[/mark]";
$micro    = get_field( 'microcopy' ) ?: 'Sem briefing formal. Só uma conversa.';
$btn      = get_field( 'btn' ) ?: 'Iniciar conversa';

$block_id = ! empty( $block['anchor'] ) ? esc_attr( $block['anchor'] ) : 'contato';
?>
<section class="section section--alt contato" id="<?php echo $block_id; ?>" aria-labelledby="contato-title">
	<div class="container">
		<span class="eyebrow" data-reveal><?php echo esc_html( $eyebrow ); ?></span>
		<h2 class="contato__title" id="contato-title" data-reveal data-marker-draw><?php echo marguerite_markup_text( $headline ); // phpcs:ignore ?></h2>
		<form class="contato__form" id="contato-form" method="post" novalidate data-reveal>
			<div class="field">
				<label for="nome">Nome</label>
				<input type="text" id="nome" name="nome" required autocomplete="name" />
			</div>
			<div class="field">
				<label for="empresa">Empresa</label>
				<input type="text" id="empresa" name="empresa" autocomplete="organization" />
			</div>
			<div class="field">
				<label for="whatsapp">WhatsApp</label>
				<input type="tel" id="whatsapp" name="whatsapp" autocomplete="tel" aria-describedby="contato-micro" required />
			</div>
			<p class="contato__micro" id="contato-micro"><?php echo esc_html( $micro ); ?></p>
			<button type="submit" class="btn btn--primary contato__submit"><?php echo esc_html( $btn ); ?> <?php echo marguerite_arrow(); // phpcs:ignore ?></button>
		</form>
	</div>
</section>
