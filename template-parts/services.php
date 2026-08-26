<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="services-section" id="services" aria-labelledby="services-heading">
	<div class="container">
		<header class="section-heading services-heading-row">
			<div class="services-heading-copy">
				<p class="eyebrow"><?php esc_html_e( 'Services', 'advay-theme' ); ?></p>
				<h2 id="services-heading"><?php esc_html_e( 'Every step from dock to fulfillment center.', 'advay-theme' ); ?></h2>
				<p><?php esc_html_e( 'One operation for Amazon and Walmart. You send inventory; we return marketplace-ready shipments and a clear paper trail.', 'advay-theme' ); ?></p>
			</div>
			<a class="button button-primary services-explore" href="<?php echo esc_url( advay_services_url() ); ?>">
				<?php esc_html_e( 'Explore our services', 'advay-theme' ); ?>
				<span class="btn-arrow" aria-hidden="true"></span>
			</a>
		</header>
	</div>
</section>
