<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$home = trailingslashit( home_url( '/' ) );
?>
<div class="mega-panel mega-what" role="region" aria-label="<?php esc_attr_e( 'What we do', 'advay-theme' ); ?>">
	<div class="mega-col">
		<a class="mega-head" href="<?php echo esc_url( advay_services_url( 'platforms' ) ); ?>">
			<span class="mega-ico mega-ico-sq" aria-hidden="true">
				<svg viewBox="0 0 24 24" width="20" height="20" fill="none"><path d="M6 8h12v11H6V8zm2-3h8l1 3H7l1-3z" stroke="#fff" stroke-width="1.6"/></svg>
			</span>
			<span>
				<strong><?php esc_html_e( 'Platforms', 'advay-theme' ); ?></strong>
				<em><?php esc_html_e( 'Win on every marketplace', 'advay-theme' ); ?></em>
			</span>
		</a>
		<a href="<?php echo esc_url( advay_services_url( 'platforms' ) ); ?>">
			<span class="mega-dot" aria-hidden="true"></span>
			<span>
				<strong><?php esc_html_e( 'Amazon Ful. Services', 'advay-theme' ); ?></strong>
				<em><?php esc_html_e( 'FBA prep and inbound to Amazon FC', 'advay-theme' ); ?></em>
			</span>
		</a>
		<a href="<?php echo esc_url( advay_services_url( 'platforms' ) ); ?>">
			<span class="mega-dot" aria-hidden="true"></span>
			<span>
				<strong><?php esc_html_e( 'Walmart Ful. Services', 'advay-theme' ); ?></strong>
				<em><?php esc_html_e( 'WFS-ready labeling and cartons', 'advay-theme' ); ?></em>
			</span>
		</a>
		<a href="<?php echo esc_url( advay_services_url( 'platforms' ) ); ?>">
			<span class="mega-dot" aria-hidden="true"></span>
			<span>
				<strong><?php esc_html_e( 'TikTok Shop Fulfilment', 'advay-theme' ); ?></strong>
				<em><?php esc_html_e( 'FBT prep for TikTok Shop', 'advay-theme' ); ?></em>
			</span>
		</a>
		<a href="<?php echo esc_url( advay_services_url( 'platforms' ) ); ?>">
			<span class="mega-dot" aria-hidden="true"></span>
			<span>
				<strong><?php esc_html_e( 'DTC Fulfilment', 'advay-theme' ); ?></strong>
				<em><?php esc_html_e( 'Ship direct, stress-free', 'advay-theme' ); ?></em>
			</span>
		</a>
	</div>
	<div class="mega-col">
		<a class="mega-head" href="<?php echo esc_url( advay_services_url() ); ?>">
			<span class="mega-ico mega-ico-sq" aria-hidden="true">
				<svg viewBox="0 0 24 24" width="20" height="20" fill="none"><path d="M4 8l8-4 8 4v10l-8 4-8-4V8z" stroke="#fff" stroke-width="1.6"/></svg>
			</span>
			<span>
				<strong><?php esc_html_e( 'Services', 'advay-theme' ); ?></strong>
				<em><?php esc_html_e( 'Save on ops costs and sell more', 'advay-theme' ); ?></em>
			</span>
		</a>
		<a href="<?php echo esc_url( advay_services_url( 'receiving' ) ); ?>">
			<span class="mega-dot" aria-hidden="true"></span>
			<span>
				<strong><?php esc_html_e( 'Receiving & Inspection', 'advay-theme' ); ?></strong>
				<em><?php esc_html_e( 'Count, photo, and flag exceptions', 'advay-theme' ); ?></em>
			</span>
		</a>
		<a href="<?php echo esc_url( advay_services_url( 'labeling' ) ); ?>">
			<span class="mega-dot" aria-hidden="true"></span>
			<span>
				<strong><?php esc_html_e( 'Labeling & Prep', 'advay-theme' ); ?></strong>
				<em><?php esc_html_e( 'FNSKU, GTIN, polybag, and dunnage', 'advay-theme' ); ?></em>
			</span>
		</a>
		<a href="<?php echo esc_url( advay_services_url( 'kitting' ) ); ?>">
			<span class="mega-dot" aria-hidden="true"></span>
			<span>
				<strong><?php esc_html_e( 'Packaging, Kitting, Rework', 'advay-theme' ); ?></strong>
				<em><?php esc_html_e( 'Bundles, inserts, and carton rebuilds', 'advay-theme' ); ?></em>
			</span>
		</a>
		<a href="<?php echo esc_url( advay_services_url( 'outbound' ) ); ?>">
			<span class="mega-dot" aria-hidden="true"></span>
			<span>
				<strong><?php esc_html_e( 'Outbound & Shipping', 'advay-theme' ); ?></strong>
				<em><?php esc_html_e( 'Pallet, LTL, and parcel to FC', 'advay-theme' ); ?></em>
			</span>
		</a>
		<a href="<?php echo esc_url( advay_services_url( 'returns' ) ); ?>">
			<span class="mega-dot" aria-hidden="true"></span>
			<span>
				<strong><?php esc_html_e( 'Returns & Reverse Logistics', 'advay-theme' ); ?></strong>
				<em><?php esc_html_e( 'Inspect, restock, or dispose', 'advay-theme' ); ?></em>
			</span>
		</a>
	</div>
	<div class="mega-col">
		<a class="mega-head" href="<?php echo esc_url( $home . '#contact' ); ?>">
			<span class="mega-ico mega-ico-sq" aria-hidden="true">
				<svg viewBox="0 0 24 24" width="20" height="20" fill="none"><path d="M5 7h14v10H5V7zm3 13h8" stroke="#fff" stroke-width="1.6"/></svg>
			</span>
			<span>
				<strong><?php esc_html_e( 'Get started', 'advay-theme' ); ?></strong>
				<em><?php esc_html_e( 'Onboard in one conversation', 'advay-theme' ); ?></em>
			</span>
		</a>
		<a href="<?php echo esc_url( advay_pricing_url() ); ?>">
			<span class="mega-dot" aria-hidden="true"></span>
			<span>
				<strong><?php esc_html_e( 'Pricing', 'advay-theme' ); ?></strong>
				<em><?php esc_html_e( 'Published prep rates', 'advay-theme' ); ?></em>
			</span>
		</a>
		<a href="<?php echo esc_url( $home . '#contact' ); ?>">
			<span class="mega-dot" aria-hidden="true"></span>
			<span>
				<strong><?php esc_html_e( 'One-click Onboarding', 'advay-theme' ); ?></strong>
				<em><?php esc_html_e( 'Share SKUs and a receiving window', 'advay-theme' ); ?></em>
			</span>
		</a>
	</div>
</div>
