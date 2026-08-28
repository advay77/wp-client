<?php
/**
 * Our Story — company principles, mission, timeline, and gallery.
 *
 * @package Advay_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$values = array(
	array(
		'title' => __( 'Efficiency', 'advay-theme' ),
		'text'  => __( 'We aim to deliver your products as fast as possible.', 'advay-theme' ),
	),
	array(
		'title' => __( 'Attention to Detail', 'advay-theme' ),
		'text'  => __( 'We prep your purchases as if you had done it yourself.', 'advay-theme' ),
	),
	array(
		'title' => __( 'Communication', 'advay-theme' ),
		'text'  => __( 'Honest, authentic, and clear.', 'advay-theme' ),
	),
);

$milestones = array(
	array(
		'year'  => '2007',
		'title' => __( 'The Beginning', 'advay-theme' ),
		'text'  => __( 'Began my career in manufacturing and industrial engineering, developing a foundation in operations and continuous improvement.', 'advay-theme' ),
	),
	array(
		'year'  => '2009',
		'title' => __( 'Building the Foundation', 'advay-theme' ),
		'text'  => __( 'Joined Merck\'s management development program and progressed through manufacturing and supply chain roles, gaining experience across operations, planning, analytics, and global product supply.', 'advay-theme' ),
	),
	array(
		'year'  => '2016',
		'title' => __( 'Broadening the Lens', 'advay-theme' ),
		'text'  => __( 'Expanded from operations into enterprise leadership, combining technical expertise with an MBA from UNC Kenan-Flagler.', 'advay-theme' ),
	),
	array(
		'year'  => '2018',
		'title' => __( 'Global Supply Chain Leadership', 'advay-theme' ),
		'text'  => __( 'Led increasingly complex global vaccine supply chains, including GARDASIL®, across manufacturing and global markets.', 'advay-theme' ),
	),
	array(
		'year'  => '2022+',
		'title' => __( 'Leading at Scale', 'advay-theme' ),
		'text'  => __( 'Led major global supply chain programs, including Pfizer\'s North America COVID-19 vaccine supply chain, global vaccine donation execution, digital planning transformation, and launches across 80+ markets.', 'advay-theme' ),
	),
);

$gallery = array(
	array(
		'src' => advay_asset_uri( 'images/svc-warehouse.jpg' ),
		'alt' => __( 'ElitePrep warehouse aisles', 'advay-theme' ),
	),
	array(
		'src' => advay_asset_uri( 'images/client-success.jpg' ),
		'alt' => __( 'Operations team on the warehouse floor', 'advay-theme' ),
	),
	array(
		'src' => advay_asset_uri( 'images/founder3.jpeg' ),
		'alt' => __( 'Leadership at ElitePrep Center', 'advay-theme' ),
	),
	array(
		'src' => advay_asset_uri( 'images/founder4.jpeg' ),
		'alt' => __( 'Warehouse leadership team', 'advay-theme' ),
	),
	array(
		'src' => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=900&q=80',
		'alt' => __( 'Inbound cartons and receiving dock', 'advay-theme' ),
	),
	array(
		'src' => 'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?auto=format&fit=crop&w=900&q=80',
		'alt' => __( 'Prep and labeling station', 'advay-theme' ),
	),
);

get_header();
?>

<main id="main-content" class="os-page">
	<section class="os-intro" aria-labelledby="os-intro-heading">
		<div class="container os-intro-grid">
			<div class="os-intro-copy">
				<p class="eyebrow"><?php esc_html_e( 'Our Story', 'advay-theme' ); ?></p>
				<h1 id="os-intro-heading">
					<?php esc_html_e( 'ElitePrep Center is built on a simple idea:', 'advay-theme' ); ?>
					<strong>
						<span class="os-intro-accent"><?php esc_html_e( 'getting your units to market', 'advay-theme' ); ?></span>
						<?php esc_html_e( ' should feel effortless, not risky.', 'advay-theme' ); ?>
					</strong>
				</h1>
			</div>
			<div class="os-intro-aside">
				<p><?php esc_html_e( 'We focus on what happens before the errors — receiving, prep, and forward — not damage control after. Every brand deserves a clear paper trail from dock to fulfillment center.', 'advay-theme' ); ?></p>
			</div>
		</div>
	</section>

	<section class="os-values" aria-labelledby="os-values-heading">
		<div class="container">
			<div class="os-values-box">
				<p class="os-values-kicker" id="os-values-heading"><?php esc_html_e( 'Our values', 'advay-theme' ); ?></p>
				<ul class="os-values-list">
					<?php foreach ( $values as $value ) : ?>
						<li>
							<span class="os-values-check" aria-hidden="true"></span>
							<span>
								<strong><?php echo esc_html( $value['title'] ); ?></strong>
								<?php echo esc_html( $value['text'] ); ?>
							</span>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</section>

	<section class="os-mission" aria-labelledby="os-mission-heading">
		<div class="os-mission-bg" aria-hidden="true"></div>
		<div class="container os-mission-inner">
			<div class="os-mission-block os-mission-block--mission" data-os-reveal="left">
				<div class="os-mission-label-row">
					<p class="os-mission-label" id="os-mission-heading"><?php esc_html_e( 'Mission', 'advay-theme' ); ?></p>
					<span class="os-mission-line" aria-hidden="true"></span>
				</div>
				<p class="os-mission-text">
					<?php esc_html_e( 'To make marketplace prep seamless for growing brands — combining deep fulfillment expertise, human-first service, and compliant operations from one integrated warehouse.', 'advay-theme' ); ?>
				</p>
			</div>
			<div class="os-mission-block os-mission-block--vision" data-os-reveal="right">
				<div class="os-mission-label-row">
					<span class="os-mission-line" aria-hidden="true"></span>
					<p class="os-mission-label"><?php esc_html_e( 'Vision', 'advay-theme' ); ?></p>
				</div>
				<p class="os-mission-text">
					<?php esc_html_e( 'To be the most trusted prep partner for Amazon, Walmart, TikTok, and DTC sellers — driven by people, powered by precision, and united by a legacy of getting it right the first time.', 'advay-theme' ); ?>
				</p>
			</div>
		</div>
	</section>

	<section class="os-timeline" aria-labelledby="os-timeline-heading">
		<div class="container">
			<header class="os-timeline-head">
				<p class="eyebrow"><?php esc_html_e( 'Leadership journey', 'advay-theme' ); ?></p>
				<h2 id="os-timeline-heading"><?php esc_html_e( 'From vision to reality', 'advay-theme' ); ?></h2>
				<p><?php esc_html_e( 'Decades of supply chain leadership — from the factory floor to billion-unit programs — now applied to marketplace prep at ElitePrep.', 'advay-theme' ); ?></p>
			</header>
			<div class="os-timeline-shell">
				<div class="os-timeline-rail" aria-hidden="true">
					<span class="os-timeline-rail-line"></span>
				</div>
				<ol class="os-timeline-list">
					<?php foreach ( $milestones as $index => $milestone ) : ?>
						<li class="os-timeline-item">
							<div class="os-timeline-meta">
								<span class="os-timeline-year"><?php echo esc_html( $milestone['year'] ); ?></span>
								<span class="os-timeline-node" aria-hidden="true"><?php echo esc_html( str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
							</div>
							<article class="os-timeline-card">
								<h3><?php echo esc_html( $milestone['title'] ); ?></h3>
								<p><?php echo esc_html( $milestone['text'] ); ?></p>
							</article>
						</li>
					<?php endforeach; ?>
				</ol>
			</div>
		</div>
	</section>

	<section class="os-gallery" aria-label="<?php esc_attr_e( 'Life at ElitePrep', 'advay-theme' ); ?>">
		<div class="container os-gallery-head">
			<h2><?php esc_html_e( 'Life at ElitePrep', 'advay-theme' ); ?></h2>
			<p><?php esc_html_e( 'The people, the floor, and the work behind every shipment.', 'advay-theme' ); ?></p>
		</div>
		<div class="os-gallery-viewport" tabindex="0" data-os-gallery>
			<ul class="os-gallery-track">
				<?php
				$gallery_loop = array_merge( $gallery, $gallery, $gallery );
				foreach ( $gallery_loop as $index => $photo ) :
					?>
					<li class="os-gallery-slide"<?php echo $index >= count( $gallery ) ? ' aria-hidden="true"' : ''; ?>>
						<img
							src="<?php echo esc_url( $photo['src'] ); ?>"
							alt="<?php echo $index >= count( $gallery ) ? '' : esc_attr( $photo['alt'] ); ?>"
							loading="lazy"
							decoding="async"
							draggable="false"
						>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<section class="os-cta">
		<div class="container os-cta-inner">
			<h2><?php esc_html_e( 'Ready to prep with a team that gets it?', 'advay-theme' ); ?></h2>
			<div class="os-cta-actions">
				<a class="button button-primary" href="<?php echo esc_url( advay_onboarding_url() ); ?>">
					<?php esc_html_e( 'One-click onboarding', 'advay-theme' ); ?>
					<span class="btn-arrow" aria-hidden="true"></span>
				</a>
				<a class="button button-ghost" href="<?php echo esc_url( advay_contact_url() ); ?>">
					<?php esc_html_e( 'Book a call', 'advay-theme' ); ?>
				</a>
			</div>
		</div>
	</section>
</main>

<?php
get_footer();
