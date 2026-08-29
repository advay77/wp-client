<?php
/**
 * Template Name: Receiving
 * Template Post Type: page
 *
 * Receiving & Inspection — scroll-down drives left→right warehouse journey.
 * Prefer a published Page with slug "receiving" for Rank Math + ACF editing.
 *
 * @package Advay_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$slug = 'receiving';

$stations_defaults = array(
	array(
		'id'    => 'receiving',
		'tag'   => __( 'Station 01 — Receiving', 'advay-theme' ),
		'title' => __( 'Receiving & Inspection', 'advay-theme' ),
		'desc'  => __( 'Every pallet is counted, photographed, and checked against your manifest before anything goes onto the floor.', 'advay-theme' ),
	),
	array(
		'id'    => 'labeling',
		'tag'   => __( 'Station 02 — Prep', 'advay-theme' ),
		'title' => __( 'Labeling & Prep', 'advay-theme' ),
		'desc'  => __( 'FNSKU, GTIN, and polybag prep — done to spec for Amazon, Walmart, or TikTok Shop.', 'advay-theme' ),
	),
	array(
		'id'    => 'kitting',
		'tag'   => __( 'Station 03 — Assembly', 'advay-theme' ),
		'title' => __( 'Packaging, Kitting & Rework', 'advay-theme' ),
		'desc'  => __( 'Bundles, inserts, and carton rebuilds — assembled by hand, to your exact spec.', 'advay-theme' ),
	),
	array(
		'id'    => 'outbound',
		'tag'   => __( 'Station 04 — Outbound', 'advay-theme' ),
		'title' => __( 'Outbound & Shipping', 'advay-theme' ),
		'desc'  => __( 'Palletized, LTL, or parcel — routed to the right fulfillment center, on schedule.', 'advay-theme' ),
	),
	array(
		'id'    => 'returns',
		'tag'   => __( 'Station 05 — Reverse logistics', 'advay-theme' ),
		'title' => __( 'Returns & Reverse Logistics', 'advay-theme' ),
		'desc'  => __( 'Inspected, restocked, or disposed of — so returns never sit as dead inventory.', 'advay-theme' ),
	),
);

$stations = array();
foreach ( $stations_defaults as $i => $row ) {
	$n = $i + 1;
	$stations[] = array(
		'id'    => $row['id'],
		'tag'   => advay_page_acf( $slug, 'receiving_station_' . $n . '_tag', $row['tag'] ),
		'title' => advay_page_acf( $slug, 'receiving_station_' . $n . '_title', $row['title'] ),
		'desc'  => advay_page_acf( $slug, 'receiving_station_' . $n . '_description', $row['desc'] ),
	);
}

$total = count( $stations );

$recv_eyebrow = advay_page_acf( $slug, 'receiving_eyebrow', __( 'What we do', 'advay-theme' ) );
$recv_heading = advay_page_acf( $slug, 'receiving_heading', __( 'How your inventory moves through Elite Prep Center', 'advay-theme' ) );
$recv_lede    = advay_page_acf( $slug, 'receiving_lede', __( 'One warehouse, five stages. Scroll down — the journey moves left to right through the warehouse.', 'advay-theme' ) );
$recv_hint    = advay_page_acf( $slug, 'receiving_scroll_hint', __( 'Scroll to move through the warehouse', 'advay-theme' ) );
$recv_video   = advay_page_acf( $slug, 'receiving_video_url', advay_asset_uri( 'video/DTC.mp4' ) );

$recv_cta_heading = advay_page_acf( $slug, 'receiving_cta_heading', __( 'Ready to send your next inbound?', 'advay-theme' ) );
$recv_cta_copy    = advay_page_acf( $slug, 'receiving_cta_copy', __( 'Share SKU counts, marketplace, and timing — we\'ll reply with capacity and a receiving plan.', 'advay-theme' ) );
$recv_cta_p       = advay_page_acf( $slug, 'receiving_cta_primary', '' );
$recv_cta_s       = advay_page_acf( $slug, 'receiving_cta_secondary', '' );
$recv_cta_p_label = advay_acf_link_title( $recv_cta_p, __( 'Talk to ElitePrep', 'advay-theme' ) );
$recv_cta_p_url   = advay_acf_link_url( $recv_cta_p, advay_contact_url() );
$recv_cta_s_label = advay_acf_link_title( $recv_cta_s, __( 'See platforms', 'advay-theme' ) );
$recv_cta_s_url   = advay_acf_link_url( $recv_cta_s, advay_services_url( 'platforms' ) );

get_header();
?>

<main id="main-content" class="wj-page">
	<section class="wj-intro" aria-labelledby="wj-intro-heading">
		<div class="wj-intro-media" aria-hidden="true">
			<video class="wj-intro-video" autoplay muted loop playsinline preload="metadata">
				<source src="<?php echo esc_url( $recv_video ); ?>" type="video/mp4">
			</video>
			<span class="wj-intro-overlay"></span>
		</div>
		<div class="wj-intro-inner">
			<p class="wj-eyebrow"><?php echo esc_html( $recv_eyebrow ); ?></p>
			<h1 id="wj-intro-heading"><?php echo esc_html( $recv_heading ); ?></h1>
			<p class="wj-lede">
				<?php echo esc_html( $recv_lede ); ?>
			</p>
			<p class="wj-scroll-hint">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
				<?php echo esc_html( $recv_hint ); ?>
			</p>
		</div>
	</section>

	<!--
		Critical CSS: sticky viewport + horizontal track.
		Does NOT use ScrollTrigger pin (broken by body overflow-x / smooth scroll).
	-->
	<style id="wj-critical">
		html.wj-journey-html,
		body.wj-journey {
			scroll-behavior: auto !important;
			/* overflow-x:hidden on body breaks position:sticky in Chromium */
			overflow-x: visible !important;
		}
		.wj-page .wj-space {
			position: relative;
			/* JS sets exact height; fallback keeps room to scroll */
			height: 450vh;
			background: #fafaf9;
		}
		.wj-page .wj-sticky {
			position: sticky;
			top: var(--header-h, 72px);
			height: calc(100vh - var(--header-h, 72px));
			min-height: 520px;
			overflow: hidden;
			width: 100%;
			max-width: 100vw;
		}
		.wj-page .wj-hscroll-panels {
			display: flex !important;
			flex-direction: row !important;
			flex-wrap: nowrap !important;
			height: 100%;
			width: max-content;
			will-change: transform;
			transform: translate3d(0, 0, 0);
		}
		.wj-page .wj-panel {
			flex: 0 0 100vw;
			width: 100vw;
			min-width: 100vw;
			max-width: 100vw;
			height: 100%;
			box-sizing: border-box;
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 2rem 1.5rem 5.5rem;
			position: relative;
		}
		.wj-page .wj-panel-inner {
			display: flex;
			flex-direction: column;
			align-items: center;
			gap: 0.55rem;
			max-width: 960px;
			width: 100%;
			text-align: center;
		}
		.wj-page .wj-panel .wj-scene-tag {
			order: 1;
			margin: 0;
			font-family: "IBM Plex Mono", ui-monospace, monospace;
			font-size: 11.5px;
			font-weight: 600;
			letter-spacing: 0.1em;
			text-transform: uppercase;
			color: #9aa1ac;
		}
		.wj-page .wj-panel.is-active .wj-scene-tag { color: #3457e0; }
		.wj-page .wj-panel .wj-scene-art {
			order: 2;
			width: min(520px, 78vw);
			height: auto;
			margin: 0.35rem 0;
		}
		.wj-page .wj-panel .wj-scene-title {
			order: 3;
			margin: 0;
			font-family: "Space Grotesk", var(--font, sans-serif);
			font-weight: 600;
			font-size: clamp(22px, 2.6vw, 30px);
		}
		.wj-page .wj-panel .wj-scene-desc {
			order: 4;
			margin: 0;
			max-width: 440px;
			font-size: 14.5px;
			line-height: 1.6;
			color: #5b6472;
		}
		.wj-page .wj-hscroll-hud {
			position: absolute;
			left: 0; right: 0; bottom: 1.5rem;
			z-index: 20;
			pointer-events: none;
		}
		.wj-page .wj-hscroll-hud-inner {
			max-width: 1100px;
			margin: 0 auto;
			padding: 0 1.5rem;
			display: flex;
			align-items: center;
			gap: 1rem;
			pointer-events: auto;
		}
		/* Reduced-motion / no-JS: stack stations vertically */
		.wj-page .wj-space.is-fallback {
			height: auto !important;
		}
		.wj-page .wj-space.is-fallback .wj-sticky {
			position: relative;
			top: auto;
			height: auto;
			min-height: 0;
			overflow: visible;
		}
		.wj-page .wj-space.is-fallback .wj-hscroll-panels {
			flex-direction: column !important;
			width: 100% !important;
			transform: none !important;
		}
		.wj-page .wj-space.is-fallback .wj-panel {
			width: 100%;
			min-width: 0;
			max-width: none;
			flex: none;
			height: auto;
			min-height: 70vh;
			padding: 3.5rem 1.25rem;
		}
		.wj-page .wj-space.is-fallback .wj-hscroll-hud { display: none; }
	</style>

	<div class="wj-space" id="wjSpace" data-wj-horizontal>
		<div class="wj-sticky" id="wjHScroll">
			<div class="wj-hscroll-hud" aria-hidden="true">
				<div class="wj-hscroll-hud-inner">
					<span class="wj-counter"><b id="wjCounterNum">01</b> / <?php echo esc_html( sprintf( '%02d', $total ) ); ?></span>
					<div class="wj-rail-track"><div class="wj-rail-fill" id="wjRailFill"></div></div>
					<div class="wj-dots" id="wjDots">
						<?php for ( $i = 0; $i < $total; $i++ ) : ?>
							<button type="button" class="wj-dot<?php echo 0 === $i ? ' is-active' : ''; ?>" data-wj-goto="<?php echo (int) $i; ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Station %d', 'advay-theme' ), $i + 1 ) ); ?>"></button>
						<?php endfor; ?>
					</div>
				</div>
			</div>

			<div class="wj-hscroll-panels" id="wjPanels">
				<?php foreach ( $stations as $i => $station ) : ?>
					<section class="wj-panel<?php echo 0 === $i ? ' is-active' : ''; ?>" data-wj-panel="<?php echo (int) $i; ?>" id="<?php echo esc_attr( $station['id'] ); ?>">
						<div class="wj-panel-inner">
							<p class="wj-scene-tag"><?php echo esc_html( $station['tag'] ); ?></p>
							<svg class="wj-scene-art" id="wjArt<?php echo (int) $i; ?>" viewBox="0 0 420 300" aria-hidden="true"></svg>
							<h2 class="wj-scene-title"><?php echo esc_html( $station['title'] ); ?></h2>
							<p class="wj-scene-desc"><?php echo esc_html( $station['desc'] ); ?></p>
						</div>
					</section>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

	<section class="wj-cta">
		<div class="container wj-cta-inner">
			<h2><?php echo esc_html( $recv_cta_heading ); ?></h2>
			<p><?php echo esc_html( $recv_cta_copy ); ?></p>
			<div class="wj-cta-actions">
				<a class="button button-primary" href="<?php echo esc_url( $recv_cta_p_url ); ?>">
					<?php echo esc_html( $recv_cta_p_label ); ?>
					<span class="btn-arrow" aria-hidden="true"></span>
				</a>
				<a class="button button-ghost" href="<?php echo esc_url( $recv_cta_s_url ); ?>">
					<?php echo esc_html( $recv_cta_s_label ); ?>
				</a>
			</div>
		</div>
	</section>
</main>

<?php
get_footer();
