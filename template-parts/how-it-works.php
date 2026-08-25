<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$steps = array(
	array(
		'num'   => '01',
		'title' => __( 'Share your SKUs', 'advay-theme' ),
		'text'  => __( 'Send packing lists, FNSKUs or GTINs, and any special prep notes. We confirm capacity and a receiving window.', 'advay-theme' ),
	),
	array(
		'num'   => '02',
		'title' => __( 'Ship inbound', 'advay-theme' ),
		'text'  => __( 'Freight or parcel to our warehouse. We check in cartons, count units, and flag exceptions with photos.', 'advay-theme' ),
	),
	array(
		'num'   => '03',
		'title' => __( 'We prep to spec', 'advay-theme' ),
		'text'  => __( 'Label, bag, inspect, and carton according to FBA or WFS rules. You get status updates as work completes.', 'advay-theme' ),
	),
	array(
		'num'   => '04',
		'title' => __( 'We forward', 'advay-theme' ),
		'text'  => __( 'Shipments leave for Amazon or Walmart with labels, pallets, and tracking. You stay in stock without running a warehouse.', 'advay-theme' ),
	),
);
?>
<section class="process-section" id="how-it-works" aria-labelledby="process-heading">
	<div class="container">
		<header class="section-heading">
			<p class="eyebrow"><?php esc_html_e( 'Process', 'advay-theme' ); ?></p>
			<h2 id="process-heading"><?php esc_html_e( 'Four steps. No mystery.', 'advay-theme' ); ?></h2>
			<a class="button button-primary process-onboard" href="<?php echo esc_url( advay_onboarding_url() ); ?>">
				<?php esc_html_e( 'One-Click Onboarding', 'advay-theme' ); ?>
				<span class="btn-arrow" aria-hidden="true"></span>
			</a>
		</header>

		<ol class="process-grid">
			<?php foreach ( $steps as $step ) : ?>
				<li class="process-card">
					<span class="process-num"><?php echo esc_html( $step['num'] ); ?></span>
					<h3><?php echo esc_html( $step['title'] ); ?></h3>
					<p><?php echo esc_html( $step['text'] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>
