<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$services = array(
	array(
		'num'   => '01',
		'title' => __( 'Amazon FBA prep', 'advay-theme' ),
		'text'  => __( 'FNSKU labeling, polybagging, bubble wrap, expiration stickers, and carton labeling to current Amazon inbound requirements.', 'advay-theme' ),
	),
	array(
		'num'   => '02',
		'title' => __( 'Walmart WFS prep', 'advay-theme' ),
		'text'  => __( 'GTIN/UPC labeling, WFS packaging standards, pallet builds, and documentation so shipments clear Walmart fulfillment without chargebacks.', 'advay-theme' ),
	),
	array(
		'num'   => '03',
		'title' => __( 'Receiving', 'advay-theme' ),
		'text'  => __( 'Inbound appointments, carton counts, SKU verification, and digital receiving reports so you know what landed and when.', 'advay-theme' ),
	),
	array(
		'num'   => '04',
		'title' => __( 'Inspection', 'advay-theme' ),
		'text'  => __( 'Visual QC, quantity checks, and exception photos. Damaged or incorrect units are isolated before they reach a fulfillment center.', 'advay-theme' ),
	),
	array(
		'num'   => '05',
		'title' => __( 'Labeling', 'advay-theme' ),
		'text'  => __( 'Barcode application, transparency codes, suffocation warnings, and lot/expiry labels applied to spec—not “close enough.”', 'advay-theme' ),
	),
	array(
		'num'   => '06',
		'title' => __( 'Packaging', 'advay-theme' ),
		'text'  => __( 'Polybags, dunnage, box-in-box, and kitting. We pack for transit and for marketplace cubiscan rules.', 'advay-theme' ),
	),
	array(
		'num'   => '07',
		'title' => __( 'Shipping & forwarding', 'advay-theme' ),
		'text'  => __( 'Palletizing, BOL prep, small-parcel or LTL, and forwarding into Amazon FCs or Walmart WFS nodes on your timeline.', 'advay-theme' ),
	),
);
?>
<section class="services-section" id="services" aria-labelledby="services-heading">
	<div class="container">
		<header class="section-heading">
			<p class="eyebrow"><?php esc_html_e( 'Services', 'advay-theme' ); ?></p>
			<h2 id="services-heading"><?php esc_html_e( 'Every step from dock to fulfillment center.', 'advay-theme' ); ?></h2>
			<p><?php esc_html_e( 'One operation for Amazon and Walmart. You send inventory; we return marketplace-ready shipments and a clear paper trail.', 'advay-theme' ); ?></p>
		</header>

		<div class="services-grid">
			<?php foreach ( $services as $service ) : ?>
				<article class="service-card">
					<span class="service-number"><?php echo esc_html( $service['num'] ); ?></span>
					<h3><?php echo esc_html( $service['title'] ); ?></h3>
					<p><?php echo esc_html( $service['text'] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
