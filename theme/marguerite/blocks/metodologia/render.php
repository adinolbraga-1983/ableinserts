<?php
/**
 * Bloco: Metodologia.
 *
 * @package Marguerite
 */

defined( 'ABSPATH' ) || exit;

$eyebrow  = get_field( 'eyebrow' ) ?: 'Metodologia';
$headline = get_field( 'headline' ) ?: "O sucesso é alcançado\nem quatro";
$foot     = get_field( 'foot' ) ?: 'Construímos um fluxo personalizado para cada cliente: sem barreiras, mais conversas, mais construção, resultando em uma parceria sólida e não em apenas mais um fornecedor.';

$itens = get_field( 'itens' );
if ( empty( $itens ) ) {
	$itens = array(
		array( 'num' => '01', 'titulo' => 'Atendimento Personalizado', 'bold' => true ),
		array( 'num' => '02', 'titulo' => 'Inovação e Criatividade', 'bold' => false ),
		array( 'num' => '03', 'titulo' => 'Engajamento Memorável', 'bold' => false ),
		array( 'num' => '04', 'titulo' => 'Resultados Analíticos', 'bold' => true ),
	);
}

$block_id = ! empty( $block['anchor'] ) ? esc_attr( $block['anchor'] ) : 'metodologia';
?>
<section class="section metodo" id="<?php echo $block_id; ?>" aria-labelledby="metodo-title">
	<div class="container">
		<div class="metodo__head">
			<span class="eyebrow" data-reveal><?php echo esc_html( $eyebrow ); ?></span>
			<h2 class="metodo__title" id="metodo-title" data-reveal><?php echo marguerite_markup_text( $headline ); // phpcs:ignore ?></h2>
		</div>
		<ol class="metodo__grid">
			<?php foreach ( $itens as $it ) : $bold = ! empty( $it['bold'] ); ?>
				<li class="metodo__item">
					<span class="index-num"><?php echo esc_html( $it['num'] ?? '' ); ?></span>
					<h3<?php echo $bold ? ' style="font-weight:var(--w-bold)"' : ''; ?>><?php echo esc_html( $it['titulo'] ?? '' ); ?></h3>
				</li>
			<?php endforeach; ?>
		</ol>
		<p class="metodo__foot" data-reveal><?php echo esc_html( $foot ); ?></p>
	</div>
</section>
