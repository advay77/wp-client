<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$home = trailingslashit( home_url( '/' ) );
$front = advay_acf_front_id();
?>
<div class="mega-panel mega-what" role="region" aria-label="<?php esc_attr_e( 'What we do', 'advay-theme' ); ?>">
	<div class="mega-col">
		<a class="mega-head" href="<?php echo esc_url( advay_wwd_url( 'wwd_platforms_url', advay_services_url( 'platforms' ) ) ); ?>">
			<span class="mega-ico mega-ico-sq" aria-hidden="true">
				<svg viewBox="0 0 24 24" width="20" height="20" fill="none"><path d="M6 8h12v11H6V8zm2-3h8l1 3H7l1-3z" stroke="#fff" stroke-width="1.6"/></svg>
			</span>
			<span>
				<strong><?php echo esc_html( advay_get_acf( 'wwd_platforms_title', __( 'Platforms', 'advay-theme' ), $front ) ); ?></strong>
				<em><?php echo esc_html( advay_get_acf( 'wwd_platforms_desc', __( 'Win on every marketplace', 'advay-theme' ), $front ) ); ?></em>
			</span>
			<span class="mega-col-chevron" aria-hidden="true"></span>
		</a>
		<div class="mega-col-links">
			<a href="<?php echo esc_url( advay_wwd_url( 'wwd_amazon_url', advay_services_url( 'amazon' ) ) ); ?>">
				<span class="mega-dot" aria-hidden="true"></span>
				<span>
					<strong><?php echo esc_html( advay_get_acf( 'wwd_amazon_title', __( 'Amazon Ful. Services', 'advay-theme' ), $front ) ); ?></strong>
					<em><?php echo esc_html( advay_get_acf( 'wwd_amazon_desc', __( 'FBA prep and inbound to Amazon FC', 'advay-theme' ), $front ) ); ?></em>
				</span>
			</a>
			<a href="<?php echo esc_url( advay_wwd_url( 'wwd_walmart_url', advay_services_url( 'walmart' ) ) ); ?>">
				<span class="mega-dot" aria-hidden="true"></span>
				<span>
					<strong><?php echo esc_html( advay_get_acf( 'wwd_walmart_title', __( 'Walmart Ful. Services', 'advay-theme' ), $front ) ); ?></strong>
					<em><?php echo esc_html( advay_get_acf( 'wwd_walmart_desc', __( 'WFS-ready labeling and cartons', 'advay-theme' ), $front ) ); ?></em>
				</span>
			</a>
			<a href="<?php echo esc_url( advay_wwd_url( 'wwd_tiktok_url', advay_services_url( 'tiktok' ) ) ); ?>">
				<span class="mega-dot" aria-hidden="true"></span>
				<span>
					<strong><?php echo esc_html( advay_get_acf( 'wwd_tiktok_title', __( 'TikTok Shop Fulfilment', 'advay-theme' ), $front ) ); ?></strong>
					<em><?php echo esc_html( advay_get_acf( 'wwd_tiktok_desc', __( 'FBT prep for TikTok Shop', 'advay-theme' ), $front ) ); ?></em>
				</span>
			</a>
			<a href="<?php echo esc_url( advay_wwd_url( 'wwd_dtc_url', advay_services_url( 'dtc' ) ) ); ?>">
				<span class="mega-dot" aria-hidden="true"></span>
				<span>
					<strong><?php echo esc_html( advay_get_acf( 'wwd_dtc_title', __( 'DTC Fulfilment', 'advay-theme' ), $front ) ); ?></strong>
					<em><?php echo esc_html( advay_get_acf( 'wwd_dtc_desc', __( 'Ship direct, stress-free', 'advay-theme' ), $front ) ); ?></em>
				</span>
			</a>
		</div>
	</div>
	<div class="mega-col">
		<a class="mega-head" href="<?php echo esc_url( advay_wwd_url( 'wwd_services_url', advay_receiving_url() ) ); ?>">
			<span class="mega-ico mega-ico-sq" aria-hidden="true">
				<svg viewBox="0 0 24 24" width="20" height="20" fill="none"><path d="M4 8l8-4 8 4v10l-8 4-8-4V8z" stroke="#fff" stroke-width="1.6"/></svg>
			</span>
			<span>
				<strong><?php echo esc_html( advay_get_acf( 'wwd_services_title', __( 'Services', 'advay-theme' ), $front ) ); ?></strong>
				<em><?php echo esc_html( advay_get_acf( 'wwd_services_desc', __( 'Save on ops costs and sell more', 'advay-theme' ), $front ) ); ?></em>
			</span>
			<span class="mega-col-chevron" aria-hidden="true"></span>
		</a>
		<div class="mega-col-links">
			<a href="<?php echo esc_url( advay_wwd_url( 'wwd_receiving_url', advay_services_url( 'receiving' ) ) ); ?>">
				<span class="mega-dot" aria-hidden="true"></span>
				<span>
					<strong><?php echo esc_html( advay_get_acf( 'wwd_receiving_title', __( 'Receiving & Inspection', 'advay-theme' ), $front ) ); ?></strong>
					<em><?php echo esc_html( advay_get_acf( 'wwd_receiving_desc', __( 'Count, photo, and flag exceptions', 'advay-theme' ), $front ) ); ?></em>
				</span>
			</a>
			<a href="<?php echo esc_url( advay_wwd_url( 'wwd_labeling_url', advay_services_url( 'labeling' ) ) ); ?>">
				<span class="mega-dot" aria-hidden="true"></span>
				<span>
					<strong><?php echo esc_html( advay_get_acf( 'wwd_labeling_title', __( 'Labeling & Prep', 'advay-theme' ), $front ) ); ?></strong>
					<em><?php echo esc_html( advay_get_acf( 'wwd_labeling_desc', __( 'FNSKU, GTIN, polybag, and dunnage', 'advay-theme' ), $front ) ); ?></em>
				</span>
			</a>
			<a href="<?php echo esc_url( advay_wwd_url( 'wwd_kitting_url', advay_services_url( 'kitting' ) ) ); ?>">
				<span class="mega-dot" aria-hidden="true"></span>
				<span>
					<strong><?php echo esc_html( advay_get_acf( 'wwd_kitting_title', __( 'Packaging, Kitting, Rework', 'advay-theme' ), $front ) ); ?></strong>
					<em><?php echo esc_html( advay_get_acf( 'wwd_kitting_desc', __( 'Bundles, inserts, and carton rebuilds', 'advay-theme' ), $front ) ); ?></em>
				</span>
			</a>
			<a href="<?php echo esc_url( advay_wwd_url( 'wwd_outbound_url', advay_services_url( 'outbound' ) ) ); ?>">
				<span class="mega-dot" aria-hidden="true"></span>
				<span>
					<strong><?php echo esc_html( advay_get_acf( 'wwd_outbound_title', __( 'Outbound & Shipping', 'advay-theme' ), $front ) ); ?></strong>
					<em><?php echo esc_html( advay_get_acf( 'wwd_outbound_desc', __( 'Pallet, LTL, and parcel to FC', 'advay-theme' ), $front ) ); ?></em>
				</span>
			</a>
			<a href="<?php echo esc_url( advay_wwd_url( 'wwd_returns_url', advay_services_url( 'returns' ) ) ); ?>">
				<span class="mega-dot" aria-hidden="true"></span>
				<span>
					<strong><?php echo esc_html( advay_get_acf( 'wwd_returns_title', __( 'Returns & Reverse Logistics', 'advay-theme' ), $front ) ); ?></strong>
					<em><?php echo esc_html( advay_get_acf( 'wwd_returns_desc', __( 'Inspect, restock, or dispose', 'advay-theme' ), $front ) ); ?></em>
				</span>
			</a>
		</div>
	</div>
	<div class="mega-col">
		<a class="mega-head" href="<?php echo esc_url( advay_wwd_url( 'wwd_getstarted_url', advay_onboarding_url() ) ); ?>">
			<span class="mega-ico mega-ico-sq" aria-hidden="true">
				<svg viewBox="0 0 24 24" width="20" height="20" fill="none"><path d="M5 7h14v10H5V7zm3 13h8" stroke="#fff" stroke-width="1.6"/></svg>
			</span>
			<span>
				<strong><?php echo esc_html( advay_get_acf( 'wwd_getstarted_title', __( 'Get started', 'advay-theme' ), $front ) ); ?></strong>
				<em><?php echo esc_html( advay_get_acf( 'wwd_getstarted_desc', __( 'Onboard in one conversation', 'advay-theme' ), $front ) ); ?></em>
			</span>
			<span class="mega-col-chevron" aria-hidden="true"></span>
		</a>
		<div class="mega-col-links">
			<a href="<?php echo esc_url( advay_wwd_url( 'wwd_pricing_url', advay_pricing_url() ) ); ?>">
				<span class="mega-dot" aria-hidden="true"></span>
				<span>
					<strong><?php echo esc_html( advay_get_acf( 'wwd_pricing_title', __( 'Pricing', 'advay-theme' ), $front ) ); ?></strong>
					<em><?php echo esc_html( advay_get_acf( 'wwd_pricing_desc', __( 'Published prep rates', 'advay-theme' ), $front ) ); ?></em>
				</span>
			</a>
			<a href="<?php echo esc_url( advay_wwd_url( 'wwd_onboarding_url', advay_onboarding_url() ) ); ?>">
				<span class="mega-dot" aria-hidden="true"></span>
				<span>
					<strong><?php echo esc_html( advay_get_acf( 'wwd_onboarding_title', __( 'One-click Onboarding', 'advay-theme' ), $front ) ); ?></strong>
					<em><?php echo esc_html( advay_get_acf( 'wwd_onboarding_desc', __( 'Share SKUs and a receiving window', 'advay-theme' ), $front ) ); ?></em>
				</span>
			</a>
		</div>
	</div>
</div>
