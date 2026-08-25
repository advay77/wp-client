<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$reasons = array(
	array(
		'title' => __( 'Marketplace fluency', 'advay-theme' ),
		'text'  => __( 'FBA and WFS rules change. Our SOPs track current labeling, packaging, and inbound requirements—not last year’s PDF.', 'advay-theme' ),
	),
	array(
		'title' => __( 'Exception handling', 'advay-theme' ),
		'text'  => __( 'Shortages, damage, and mixed SKUs are documented before they become FC refusals or Walmart chargebacks.', 'advay-theme' ),
	),
	array(
		'title' => __( 'Seller-first communication', 'advay-theme' ),
		'text'  => __( 'Receiving reports, prep confirmations, and tracking in one thread. You should never wonder where a pallet is.', 'advay-theme' ),
	),
	array(
		'title' => __( 'Scalable slots', 'advay-theme' ),
		'text'  => __( 'Seasonal spikes and restocks get reserved capacity. We plan labor around your inbound calendar, not the other way around.', 'advay-theme' ),
	),
);
?>
<section class="why-section" id="why-us" aria-labelledby="why-heading">
	<div class="container why-grid">
		<div class="why-intro">
			<p class="eyebrow"><?php esc_html_e( 'Why this warehouse', 'advay-theme' ); ?></p>
			<h2 id="why-heading"><?php esc_html_e( 'Ops you can put on a P&L.', 'advay-theme' ); ?></h2>
			<p><?php esc_html_e( 'Prep is not a side hustle for us. It is the product: accurate units, documented exceptions, and outbound that Amazon and Walmart actually accept.', 'advay-theme' ); ?></p>
			<a class="text-link" href="<?php echo esc_url( advay_contact_url() ); ?>">
				<?php esc_html_e( 'Talk to intake', 'advay-theme' ); ?>
			</a>
		</div>
		<div class="why-list">
			<?php foreach ( $reasons as $reason ) : ?>
				<article class="why-item">
					<h3><?php echo esc_html( $reason['title'] ); ?></h3>
					<p><?php echo esc_html( $reason['text'] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
