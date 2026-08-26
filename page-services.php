<?php
/**
 * Services landing page (slug: services).
 */
get_header();

$amazon  = advay_asset_uri( 'images/amazon.svg' );
$walmart = advay_asset_uri( 'images/walmart.svg' );
$tiktok  = advay_asset_uri( 'images/tiktok.svg' );
$person  = file_exists( get_template_directory() . '/assets/images/client-success.jpg' )
	? advay_asset_uri( 'images/client-success.jpg' )
	: advay_asset_uri( 'images/logo.png' );
$warehouse = file_exists( get_template_directory() . '/assets/images/svc-warehouse.jpg' )
	? advay_asset_uri( 'images/svc-warehouse.jpg' )
	: $person;
?>

<main id="main-content" class="svc-page">
	<section class="svc-hero">
		<div class="svc-hero-media" aria-hidden="true">
			<video class="svc-hero-video" autoplay muted loop playsinline preload="metadata">
				<source src="<?php echo esc_url( advay_asset_uri( 'video/DTC.mp4' ) ); ?>" type="video/mp4">
			</video>
			<span class="svc-hero-overlay"></span>
		</div>
		<div class="container svc-hero-inner">
			<p class="svc-pill">
				<span class="svc-pill-ico" aria-hidden="true"></span>
				<?php esc_html_e( 'ElitePrep for marketplace prep', 'advay-theme' ); ?>
			</p>
			<h1><?php esc_html_e( 'Get more inventory into Amazon, Walmart, and TikTok.', 'advay-theme' ); ?></h1>
			<p class="lead"><?php esc_html_e( 'Receiving, labeling, kitting, and forwarding from Franklinville — built for FBA, WFS, and TikTok Shop, not a generic 3PL floor.', 'advay-theme' ); ?></p>
			<div class="svc-hero-actions">
				<a class="button button-primary" href="<?php echo esc_url( advay_contact_url() ); ?>"><?php esc_html_e( 'Get a custom quote', 'advay-theme' ); ?></a>
				<a class="svc-text-link" href="#why"><?php esc_html_e( 'See how it works', 'advay-theme' ); ?></a>
			</div>
			<div class="svc-tiles" id="platforms">
				<div class="svc-tile"><img src="<?php echo esc_url( $amazon ); ?>" alt="<?php esc_attr_e( 'Amazon', 'advay-theme' ); ?>"></div>
				<div class="svc-tile"><img src="<?php echo esc_url( $walmart ); ?>" alt="<?php esc_attr_e( 'Walmart', 'advay-theme' ); ?>"></div>
				<div class="svc-tile is-feature"><span><?php esc_html_e( 'Prep', 'advay-theme' ); ?></span></div>
				<div class="svc-tile"><img src="<?php echo esc_url( $tiktok ); ?>" alt="<?php esc_attr_e( 'TikTok Shop', 'advay-theme' ); ?>"></div>
				<div class="svc-tile"><span><?php esc_html_e( 'DTC', 'advay-theme' ); ?></span></div>
			</div>
		</div>
	</section>

	<section class="svc-why" id="why">
		<div class="container svc-why-grid">
			<div>
				<h2><?php esc_html_e( 'Why brands pick ElitePrep.', 'advay-theme' ); ?></h2>
				<p><?php esc_html_e( 'One warehouse, named owners, and lanes into the three marketplaces that actually move units.', 'advay-theme' ); ?></p>
			</div>
			<div class="svc-why-cards">
				<article id="receiving">
					<h3><?php esc_html_e( 'Receiving that matches the ASN', 'advay-theme' ); ?></h3>
					<p><?php esc_html_e( 'Carton counts, photos, and exception flags before anything hits a prep station.', 'advay-theme' ); ?></p>
				</article>
				<article id="labeling">
					<h3><?php esc_html_e( 'Labels built for FBA and WFS', 'advay-theme' ); ?></h3>
					<p><?php esc_html_e( 'FNSKU, GTIN, polybag, and dunnage to current inbound rules — not last year’s checklist.', 'advay-theme' ); ?></p>
				</article>
				<article id="kitting">
					<h3><?php esc_html_e( 'Kitting without the scramble', 'advay-theme' ); ?></h3>
					<p><?php esc_html_e( 'Bundles, inserts, and carton rebuilds when retail or TikTok needs a different pack-out.', 'advay-theme' ); ?></p>
				</article>
				<article>
					<h3><?php esc_html_e( 'A human who knows the account', 'advay-theme' ); ?></h3>
					<p><?php esc_html_e( 'You get a U.S.-based owner with a line to the floor, not a rotating ticket queue.', 'advay-theme' ); ?></p>
				</article>
			</div>
		</div>
	</section>

	<section class="svc-market">
		<div class="container">
			<h2><?php esc_html_e( 'Still forwarding from a spare room?', 'advay-theme' ); ?></h2>
			<div class="svc-photos">
				<figure>
					<img src="<?php echo esc_url( $person ); ?>" alt="<?php esc_attr_e( 'Client success lead on the warehouse floor', 'advay-theme' ); ?>">
					<figcaption><?php esc_html_e( 'Named ops owner, not a ticket bot.', 'advay-theme' ); ?></figcaption>
				</figure>
				<figure>
					<img src="<?php echo esc_url( $warehouse ); ?>" alt="<?php esc_attr_e( 'ElitePrep warehouse aisles', 'advay-theme' ); ?>">
					<figcaption><?php esc_html_e( 'Franklinville dock, 17 miles from Amazon.', 'advay-theme' ); ?></figcaption>
				</figure>
			</div>
			<ul class="svc-benefits">
				<li><?php esc_html_e( 'Minutes from Amazon, Walmart, and TikTok fulfillment — not a cross-country hop.', 'advay-theme' ); ?></li>
				<li><?php esc_html_e( 'Prep specs that change with FBA, WFS, and FBT, not a one-label-fits-all station.', 'advay-theme' ); ?></li>
				<li><?php esc_html_e( 'Photos and counts on every exception so chargebacks do not become a surprise.', 'advay-theme' ); ?></li>
				<li><?php esc_html_e( 'Month-to-month or a longer lane — you pick the terms.', 'advay-theme' ); ?></li>
			</ul>
			<div class="svc-apply">
				<p><?php esc_html_e( 'Ready to send the next inbound?', 'advay-theme' ); ?></p>
				<a href="<?php echo esc_url( advay_contact_url() ); ?>"><?php esc_html_e( 'Book a receiving window', 'advay-theme' ); ?></a>
			</div>
		</div>
	</section>

	<section class="svc-steps" id="outbound">
		<div class="container">
			<h2><?php esc_html_e( 'Prep with ElitePrep. It is simple.', 'advay-theme' ); ?></h2>
			<div class="svc-step-grid">
				<article>
					<header><?php esc_html_e( 'First, ship inbound', 'advay-theme' ); ?></header>
					<div class="svc-step-visual is-one"></div>
					<p><?php esc_html_e( 'Send cartons or a container to Franklinville. We check in against your list and flag misses the same day.', 'advay-theme' ); ?></p>
				</article>
				<article id="returns">
					<header><?php esc_html_e( 'Then, we prep to spec', 'advay-theme' ); ?></header>
					<div class="svc-step-visual is-two"></div>
					<p><?php esc_html_e( 'Label, bag, kit, and rebuild cartons for Amazon, Walmart, or TikTok — including returns that need a second pass.', 'advay-theme' ); ?></p>
				</article>
				<article>
					<header><?php esc_html_e( 'Finally, we forward', 'advay-theme' ); ?></header>
					<div class="svc-step-visual is-three"></div>
					<p><?php esc_html_e( 'Pallets and parcels leave for the FC with tracking. You stay in stock without running the warehouse.', 'advay-theme' ); ?></p>
				</article>
			</div>
		</div>
	</section>

	<section class="svc-final">
		<div class="container">
			<h2><?php esc_html_e( 'Send the next inbound. No long-term lock required.', 'advay-theme' ); ?></h2>
			<a class="button button-primary svc-final-btn" href="<?php echo esc_url( advay_contact_url() ); ?>"><?php esc_html_e( 'Get a custom quote', 'advay-theme' ); ?></a>
		</div>
	</section>
</main>

<?php
get_footer();
