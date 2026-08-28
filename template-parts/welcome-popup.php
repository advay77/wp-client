<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$quote_url = advay_contact_url();
$book_url  = advay_onboarding_url();
?>
<div class="epc-popup" id="epc-popup" hidden>
	<div class="epc-popup-backdrop" data-popup-close></div>
	<div
		class="epc-popup-card"
		role="dialog"
		aria-modal="true"
		aria-labelledby="epc-popup-title"
		aria-describedby="epc-popup-copy"
	>
		<button class="epc-popup-close" type="button" data-popup-close aria-label="<?php esc_attr_e( 'Close', 'advay-theme' ); ?>">
			<span aria-hidden="true">&times;</span>
		</button>
		<div class="epc-popup-visual" aria-hidden="true">
			<p class="epc-popup-kicker"><?php esc_html_e( 'Walmart-approved · Amazon-ready', 'advay-theme' ); ?></p>
			<p class="epc-popup-visual-title"><?php esc_html_e( 'Your inventory shouldn\'t wait.', 'advay-theme' ); ?></p>
			<div class="epc-popup-lanes">
				<span><?php esc_html_e( 'Amazon FBA', 'advay-theme' ); ?></span>
				<span><?php esc_html_e( 'Walmart WFS', 'advay-theme' ); ?></span>
				<span><?php esc_html_e( 'TikTok Shop', 'advay-theme' ); ?></span>
			</div>
			<div class="epc-popup-cartons" aria-hidden="true">
				<img
					src="<?php echo esc_url( advay_asset_uri( 'images/svc-warehouse.jpg' ) ); ?>"
					alt=""
					width="320"
					height="140"
					loading="lazy"
					decoding="async"
				>
			</div>
		</div>
		<div class="epc-popup-copy">
			<h2 id="epc-popup-title"><?php esc_html_e( 'Prep that ships on time, every time.', 'advay-theme' ); ?></h2>
			<p id="epc-popup-copy">
				<?php esc_html_e( 'One flat rate. No hidden fees. No minimums. Compliant, accurate, and out the door in 24-48 hours.', 'advay-theme' ); ?>
			</p>
			<div class="epc-popup-actions">
				<a class="button button-primary epc-popup-cta" href="<?php echo esc_url( $quote_url ); ?>">
					<?php esc_html_e( 'Get a Free Quote', 'advay-theme' ); ?>
				</a>
				<a class="button epc-popup-cta-secondary" href="<?php echo esc_url( $book_url ); ?>">
					<?php esc_html_e( 'Book a Call with Odi', 'advay-theme' ); ?>
				</a>
			</div>
		</div>
	</div>
</div>
