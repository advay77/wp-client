<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="cta-section" id="contact" aria-labelledby="cta-heading">
	<div class="container cta-inner">
		<div>
			<p class="eyebrow"><?php esc_html_e( 'Intake', 'advay-theme' ); ?></p>
			<h2 id="cta-heading"><?php esc_html_e( 'Send your next inbound to a warehouse that prep is built for.', 'advay-theme' ); ?></h2>
			<p class="cta-copy"><?php esc_html_e( 'Share SKU counts, marketplace, and timing. We will reply with capacity, pricing structure, and a receiving plan.', 'advay-theme' ); ?></p>
		</div>
		<div class="cta-actions">
			<a class="button button-light" href="<?php echo esc_url( advay_intake_email_url() ); ?>">
				<?php esc_html_e( 'Email intake', 'advay-theme' ); ?>
				<span class="btn-arrow" aria-hidden="true"></span>
			</a>
			<a class="button button-ghost-light" href="<?php echo esc_url( advay_intake_phone_url() ); ?>">
				<?php esc_html_e( 'Call the warehouse', 'advay-theme' ); ?>
				<span class="btn-arrow" aria-hidden="true"></span>
			</a>
		</div>
	</div>
</section>
