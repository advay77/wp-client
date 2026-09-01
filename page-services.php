<?php
/**
 * Services landing page (slug: services).
 */
get_header();

$amazon  = advay_asset_uri( 'images/logo-amazon.png' );
$walmart = advay_asset_uri( 'images/logo-walmart.png' );
$tiktok  = advay_asset_uri( 'images/logo-tiktok.png' );
$person  = file_exists( get_template_directory() . '/assets/images/client-success.jpg' )
	? advay_asset_uri( 'images/client-success.jpg' )
	: advay_asset_uri( 'images/logo.png' );
$warehouse = file_exists( get_template_directory() . '/assets/images/svc-warehouse.jpg' )
	? advay_asset_uri( 'images/svc-warehouse.jpg' )
	: $person;
$onboard = advay_onboarding_url();

$slug = 'services';
/* ACF image overrides (fall back to the built-in asset when unset). */
$mkt_img1 = advay_acf_image_url( advay_page_acf( $slug, 'services_market_photo_1', '' ), $person );
$mkt_img2 = advay_acf_image_url( advay_page_acf( $slug, 'services_market_photo_2', '' ), $warehouse );
$step_img1 = advay_acf_image_url( advay_page_acf( $slug, 'services_step_1_image', '' ), advay_asset_uri( 'images/svc-warehouse.jpg' ) );
$step_img2 = advay_acf_image_url( advay_page_acf( $slug, 'services_step_2_image', '' ), advay_asset_uri( 'images/client-success.jpg' ) );
$step_img3 = advay_acf_image_url( advay_page_acf( $slug, 'services_step_3_image', '' ), advay_asset_uri( 'images/svc-warehouse.jpg' ) );
?>

<main id="main-content" class="svc-page">
	<section class="svc-hero">
		<div class="svc-hero-media" aria-hidden="true">
			<video class="svc-hero-video" autoplay muted loop playsinline preload="metadata">
				<source src="<?php echo esc_url( advay_asset_uri( 'video/amazon.mp4' ) ); ?>" type="video/mp4">
			</video>
			<span class="svc-hero-overlay"></span>
		</div>
		<div class="container svc-hero-inner">
			<p class="svc-pill">
				<span class="svc-pill-ico" aria-hidden="true"></span>
				<?php echo esc_html( advay_page_acf( $slug, 'services_pill', __( 'ElitePrep for marketplace prep', 'advay-theme' ) ) ); ?>
			</p>
			<h1><?php echo esc_html( advay_page_acf( $slug, 'services_heading', __( 'Get more inventory into Amazon, Walmart, TikTok, and DTC.', 'advay-theme' ) ) ); ?></h1>
			<p class="lead"><?php echo esc_html( advay_page_acf( $slug, 'services_lead', __( 'Receiving, labeling, kitting, and forwarding from Franklinville — built for FBA, WFS, TikTok Shop, and DTC, not a generic 3PL floor.', 'advay-theme' ) ) ); ?></p>
			<div class="svc-hero-actions">
				<a class="button button-primary" href="<?php echo esc_url( advay_quote_url() ); ?>"><?php echo esc_html( advay_page_acf( $slug, 'services_hero_cta_label', __( 'Get a custom quote', 'advay-theme' ) ) ); ?></a>
				<a class="svc-text-link" href="#why"><?php echo esc_html( advay_page_acf( $slug, 'services_see_link', __( 'See how it works', 'advay-theme' ) ) ); ?></a>
			</div>
			<div class="svc-tiles" id="platforms">
				<a class="svc-tile svc-tile--amazon" id="amazon" href="<?php echo esc_url( advay_platform_url( 'amazon' ) ); ?>">
					<img src="<?php echo esc_url( $amazon ); ?>" alt="<?php esc_attr_e( 'Amazon', 'advay-theme' ); ?>">
					<span class="svc-tile-more"><?php esc_html_e( 'Learn more', 'advay-theme' ); ?></span>
				</a>
				<a class="svc-tile svc-tile--walmart" id="walmart" href="<?php echo esc_url( advay_platform_url( 'walmart' ) ); ?>">
					<img src="<?php echo esc_url( $walmart ); ?>" alt="<?php esc_attr_e( 'Walmart', 'advay-theme' ); ?>">
					<span class="svc-tile-more"><?php esc_html_e( 'Learn more', 'advay-theme' ); ?></span>
				</a>
				<a class="svc-tile svc-tile--tiktok" id="tiktok" href="<?php echo esc_url( advay_platform_url( 'tiktok' ) ); ?>">
					<img src="<?php echo esc_url( $tiktok ); ?>" alt="<?php esc_attr_e( 'TikTok Shop', 'advay-theme' ); ?>">
					<span class="svc-tile-more"><?php esc_html_e( 'Learn more', 'advay-theme' ); ?></span>
				</a>
				<a class="svc-tile svc-tile-dtc" id="dtc" href="<?php echo esc_url( advay_platform_url( 'dtc' ) ); ?>">
					<span><?php esc_html_e( 'DTC', 'advay-theme' ); ?></span>
					<span class="svc-tile-more"><?php esc_html_e( 'Learn more', 'advay-theme' ); ?></span>
				</a>
			</div>
		</div>
	</section>

	<section class="svc-why" id="why">
		<div class="container svc-why-grid">
			<div>
				<h2><?php echo esc_html( advay_page_acf( $slug, 'services_why_heading', __( 'Why brands pick ElitePrep.', 'advay-theme' ) ) ); ?></h2>
				<p><?php echo esc_html( advay_page_acf( $slug, 'services_why_intro', __( 'One warehouse, named owners, and lanes into the marketplaces that actually move units — plus DTC.', 'advay-theme' ) ) ); ?></p>
			</div>
			<div class="svc-why-cards">
				<article id="receiving">
					<h3><?php echo esc_html( advay_page_acf( $slug, 'services_why_card_1_title', __( 'Receiving that matches the ASN', 'advay-theme' ) ) ); ?></h3>
					<p><?php echo esc_html( advay_page_acf( $slug, 'services_why_card_1_desc', __( 'Carton counts, photos, and exception flags before anything hits a prep station.', 'advay-theme' ) ) ); ?></p>
				</article>
				<article id="labeling">
					<h3><?php echo esc_html( advay_page_acf( $slug, 'services_why_card_2_title', __( 'Labels built for FBA and WFS', 'advay-theme' ) ) ); ?></h3>
					<p><?php echo esc_html( advay_page_acf( $slug, 'services_why_card_2_desc', __( 'FNSKU, GTIN, polybag, and dunnage to current inbound rules — not last year’s checklist.', 'advay-theme' ) ) ); ?></p>
				</article>
				<article id="kitting">
					<h3><?php echo esc_html( advay_page_acf( $slug, 'services_why_card_3_title', __( 'Kitting without the scramble', 'advay-theme' ) ) ); ?></h3>
					<p><?php echo esc_html( advay_page_acf( $slug, 'services_why_card_3_desc', __( 'Bundles, inserts, and carton rebuilds when retail or TikTok needs a different pack-out.', 'advay-theme' ) ) ); ?></p>
				</article>
				<article>
					<h3><?php echo esc_html( advay_page_acf( $slug, 'services_why_card_4_title', __( 'A human who knows the account', 'advay-theme' ) ) ); ?></h3>
					<p><?php echo esc_html( advay_page_acf( $slug, 'services_why_card_4_desc', __( 'You get a U.S.-based owner with a line to the floor, not a rotating ticket queue.', 'advay-theme' ) ) ); ?></p>
				</article>
			</div>
		</div>
	</section>

	<section class="svc-market">
		<div class="container">
			<h2><?php echo esc_html( advay_page_acf( $slug, 'services_market_heading', __( 'Still forwarding from a spare room?', 'advay-theme' ) ) ); ?></h2>
			<div class="svc-photos">
				<figure>
					<img src="<?php echo esc_url( $mkt_img1 ); ?>" alt="<?php esc_attr_e( 'Client success lead on the warehouse floor', 'advay-theme' ); ?>">
					<figcaption><?php echo esc_html( advay_page_acf( $slug, 'services_market_caption_1', __( 'Named ops owner, not a ticket bot.', 'advay-theme' ) ) ); ?></figcaption>
				</figure>
				<figure>
					<img src="<?php echo esc_url( $mkt_img2 ); ?>" alt="<?php esc_attr_e( 'ElitePrep warehouse aisles', 'advay-theme' ); ?>">
					<figcaption><?php echo esc_html( advay_page_acf( $slug, 'services_market_caption_2', __( 'Franklinville dock, 17 miles from Amazon.', 'advay-theme' ) ) ); ?></figcaption>
				</figure>
			</div>
			<ul class="svc-benefits">
				<li><?php echo esc_html( advay_page_acf( $slug, 'services_market_benefit_1', __( 'Minutes from Amazon, Walmart, and TikTok fulfillment — not a cross-country hop.', 'advay-theme' ) ) ); ?></li>
				<li><?php echo esc_html( advay_page_acf( $slug, 'services_market_benefit_2', __( 'Prep specs that change with FBA, WFS, FBT, and DTC — not a one-label-fits-all station.', 'advay-theme' ) ) ); ?></li>
				<li><?php echo esc_html( advay_page_acf( $slug, 'services_market_benefit_3', __( 'Photos and counts on every exception so chargebacks do not become a surprise.', 'advay-theme' ) ) ); ?></li>
				<li><?php echo esc_html( advay_page_acf( $slug, 'services_market_benefit_4', __( 'Month-to-month or a longer lane — you pick the terms.', 'advay-theme' ) ) ); ?></li>
			</ul>
			<div class="svc-apply">
				<p><?php echo esc_html( advay_page_acf( $slug, 'services_market_ready', __( 'Ready to send the next inbound?', 'advay-theme' ) ) ); ?></p>
				<a href="<?php echo esc_url( advay_receiving_url() ); ?>"><?php echo esc_html( advay_page_acf( $slug, 'services_market_ready_label', __( 'Book a receiving window', 'advay-theme' ) ) ); ?></a>
			</div>
		</div>
	</section>

	<section class="svc-steps" id="outbound">
		<div class="container">
			<div class="svc-steps-head">
				<h2><?php echo esc_html( advay_page_acf( $slug, 'services_steps_heading', __( 'Prep with ElitePrep. It is simple.', 'advay-theme' ) ) ); ?></h2>
				<a class="button button-primary svc-onboard-btn" href="<?php echo esc_url( $onboard ); ?>">
					<?php echo esc_html( advay_page_acf( $slug, 'services_steps_btn_label', __( 'One-click onboarding', 'advay-theme' ) ) ); ?>
					<span class="btn-arrow" aria-hidden="true"></span>
				</a>
			</div>
			<div class="svc-step-grid">
				<article>
					<header><?php echo esc_html( advay_page_acf( $slug, 'services_step_1_heading', __( 'First, ship inbound', 'advay-theme' ) ) ); ?></header>
					<div class="svc-step-visual is-one">
						<img
							src="<?php echo esc_url( $step_img1 ); ?>"
							alt="<?php esc_attr_e( 'Inbound cartons arriving at warehouse', 'advay-theme' ); ?>"
							loading="lazy"
							decoding="async"
							width="900"
							height="600"
						>
					</div>
					<p><?php echo esc_html( advay_page_acf( $slug, 'services_step_1_desc', __( 'Send cartons or a container to Franklinville. We check in against your list and flag misses the same day.', 'advay-theme' ) ) ); ?></p>
				</article>
				<article id="returns">
					<header><?php echo esc_html( advay_page_acf( $slug, 'services_step_2_heading', __( 'Then, we prep to spec', 'advay-theme' ) ) ); ?></header>
					<div class="svc-step-visual is-two">
						<img
							src="<?php echo esc_url( $step_img2 ); ?>"
							alt="<?php esc_attr_e( 'Products being labeled and prepped for shipping', 'advay-theme' ); ?>"
							loading="lazy"
							decoding="async"
							width="900"
							height="600"
						>
					</div>
					<p><?php echo esc_html( advay_page_acf( $slug, 'services_step_2_desc', __( 'Label, bag, kit, and rebuild cartons for Amazon, Walmart, TikTok, or DTC — including returns that need a second pass.', 'advay-theme' ) ) ); ?></p>
				</article>
				<article>
					<header><?php echo esc_html( advay_page_acf( $slug, 'services_step_3_heading', __( 'Finally, we forward', 'advay-theme' ) ) ); ?></header>
					<div class="svc-step-visual is-three">
						<img
							src="<?php echo esc_url( $step_img3 ); ?>"
							alt="<?php esc_attr_e( 'Outbound freight ready for fulfillment centers', 'advay-theme' ); ?>"
							loading="lazy"
							decoding="async"
						>
					</div>
					<p><?php echo esc_html( advay_page_acf( $slug, 'services_step_3_desc', __( 'Pallets and parcels leave for the FC with tracking. You stay in stock without running the warehouse.', 'advay-theme' ) ) ); ?></p>
				</article>
			</div>
		</div>
	</section>

	<?php get_template_part( 'template-parts/editor-zone' ); ?>

	<section class="svc-final">
		<div class="container">
			<h2><?php echo esc_html( advay_page_acf( $slug, 'services_final_heading', __( 'Send the next inbound. No long-term lock required.', 'advay-theme' ) ) ); ?></h2>
			<a class="button button-primary svc-final-btn" href="<?php echo esc_url( advay_quote_url() ); ?>"><?php echo esc_html( advay_page_acf( $slug, 'services_final_btn_label', __( 'Get a custom quote', 'advay-theme' ) ) ); ?></a>
		</div>
	</section>
</main>

<?php
get_footer();
