<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
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
			<p class="epc-popup-kicker"><?php esc_html_e( 'Franklinville dock is live', 'advay-theme' ); ?></p>
			<p class="epc-popup-visual-title"><?php esc_html_e( 'Inbound that does not stall.', 'advay-theme' ); ?></p>
			<div class="epc-popup-lanes">
				<span><?php esc_html_e( 'Amazon FBA', 'advay-theme' ); ?></span>
				<span><?php esc_html_e( 'Walmart WFS', 'advay-theme' ); ?></span>
				<span><?php esc_html_e( 'TikTok Shop', 'advay-theme' ); ?></span>
			</div>
			<div class="epc-popup-scan"></div>
			<div class="epc-popup-brand">
				<img src="<?php echo esc_url( advay_logo_url() ); ?>" alt="" width="120" height="36">
			</div>
		</div>
		<div class="epc-popup-copy">
			<h2 id="epc-popup-title"><?php esc_html_e( 'Prep that keeps pace with your ads.', 'advay-theme' ); ?></h2>
			<p id="epc-popup-copy">
				<?php esc_html_e( 'When volume jumps, most 3PLs scramble. ElitePrep already has a named owner, a receiving window, and a lane into Amazon, Walmart, and TikTok.', 'advay-theme' ); ?>
			</p>
			<div class="epc-popup-actions">
				<a class="button button-primary epc-popup-cta" href="<?php echo esc_url( advay_contact_url() ); ?>">
					<?php esc_html_e( 'Grow with ElitePrep', 'advay-theme' ); ?>
				</a>
				<a class="button epc-popup-cta-secondary" href="<?php echo esc_url( advay_contact_url() ); ?>">
					<?php esc_html_e( 'Book a call with our MD', 'advay-theme' ); ?>
				</a>
			</div>
		</div>
	</div>
</div>
