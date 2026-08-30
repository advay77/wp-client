<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$front = advay_acf_front_id();

$popup_kicker = advay_get_acf( 'home_popup_kicker', __( 'Walmart-approved · Amazon-ready', 'advay-theme' ), $front );
$popup_visual = advay_get_acf( 'home_popup_visual_title', __( 'Your inventory shouldn\'t wait.', 'advay-theme' ), $front );
$popup_title  = advay_get_acf( 'home_popup_title', __( 'Prep that ships on time, every time.', 'advay-theme' ), $front );
$popup_copy   = advay_get_acf( 'home_popup_copy', __( 'One flat rate. No hidden fees. No minimums. Compliant, accurate, and out the door in 24-48 hours.', 'advay-theme' ), $front );

$cta_primary       = advay_get_acf( 'home_popup_cta_primary', '', $front );
$cta_primary_label = advay_acf_link_title( $cta_primary, __( 'Get a Free Quote', 'advay-theme' ) );
$cta_primary_url   = advay_acf_quote_link_url( $cta_primary, advay_quote_url() );

$cta_secondary       = advay_get_acf( 'home_popup_cta_secondary', '', $front );
$cta_secondary_label = advay_acf_link_title( $cta_secondary, __( 'Book a Call with Odi', 'advay-theme' ) );
$cta_secondary_url   = advay_acf_book_call_link_url( $cta_secondary, advay_book_call_url() );

$popup_img     = advay_get_acf( 'home_popup_image', null, $front );
$popup_img_src = advay_acf_image_url( $popup_img, advay_asset_uri( 'images/svc-warehouse.jpg' ) );
$popup_lane_1  = advay_get_acf( 'home_popup_lane_1', __( 'Amazon FBA', 'advay-theme' ), $front );
$popup_lane_2  = advay_get_acf( 'home_popup_lane_2', __( 'Walmart WFS', 'advay-theme' ), $front );
$popup_lane_3  = advay_get_acf( 'home_popup_lane_3', __( 'TikTok Shop', 'advay-theme' ), $front );
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
			<p class="epc-popup-kicker"><?php echo esc_html( $popup_kicker ); ?></p>
			<p class="epc-popup-visual-title"><?php echo esc_html( $popup_visual ); ?></p>
			<div class="epc-popup-lanes">
				<span><?php echo esc_html( $popup_lane_1 ); ?></span>
				<span><?php echo esc_html( $popup_lane_2 ); ?></span>
				<span><?php echo esc_html( $popup_lane_3 ); ?></span>
			</div>
			<div class="epc-popup-cartons" aria-hidden="true">
				<img
					src="<?php echo esc_url( $popup_img_src ); ?>"
					alt=""
					width="320"
					height="140"
					loading="lazy"
					decoding="async"
				>
			</div>
		</div>
		<div class="epc-popup-copy">
			<h2 id="epc-popup-title"><?php echo esc_html( $popup_title ); ?></h2>
			<p id="epc-popup-copy">
				<?php echo esc_html( $popup_copy ); ?>
			</p>
			<div class="epc-popup-actions">
				<a class="button button-primary epc-popup-cta" href="<?php echo esc_url( $cta_primary_url ); ?>">
					<?php echo esc_html( $cta_primary_label ); ?>
				</a>
				<a class="button epc-popup-cta-secondary" href="<?php echo esc_url( $cta_secondary_url ); ?>">
					<?php echo esc_html( $cta_secondary_label ); ?>
				</a>
			</div>
		</div>
	</div>
</div>
