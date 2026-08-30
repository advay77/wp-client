<?php
/**
 * Template Name: Our Story
 * Template Post Type: page
 *
 * Our Story — company principles, mission, timeline, and gallery.
 *
 * @package Advay_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$slug = 'about-us';

$values_defaults = array(
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

$values = array();
foreach ( $values_defaults as $i => $row ) {
	$n = $i + 1;
	$values[] = array(
		'title' => advay_page_acf( $slug, 'our_story_value_' . $n . '_title', $row['title'] ),
		'text'  => advay_page_acf( $slug, 'our_story_value_' . $n . '_text', $row['text'] ),
	);
}

$milestones_defaults = array(
	array(
		'year'  => '2017',
		'title' => __( 'The Beginning', 'advay-theme' ),
		'text'  => __( 'What began as marketplace selling from a home garage evolved into a vision for a better prep and fulfillment experience.', 'advay-theme' ),
	),
	array(
		'year'  => '2019',
		'title' => __( 'First Expansion', 'advay-theme' ),
		'text'  => __( 'Growing demand moved the operation into its first dedicated warehouse, creating the foundation for a professional prep center.', 'advay-theme' ),
	),
	array(
		'year'  => '2021',
		'title' => __( 'Supplement Specialization', 'advay-theme' ),
		'text'  => __( 'EPC onboarded its first dietary supplement client, beginning its specialization in lot-controlled and expiration-dated inventory.', 'advay-theme' ),
	),
	array(
		'year'  => '2022',
		'title' => __( 'Scaling Operations', 'advay-theme' ),
		'text'  => __( 'EPC expanded into a 25,000 sq. ft. facility, increasing its receiving, storage, prep, and fulfillment capacity.', 'advay-theme' ),
	),
	array(
		'year'  => '2026',
		'title' => __( 'The Next Chapter', 'advay-theme' ),
		'text'  => __( 'EPC evolved into a specialized multi-channel 3PL and gained recognition across the Amazon and Walmart partner ecosystems.', 'advay-theme' ),
	),
);

$milestones = array();
foreach ( $milestones_defaults as $i => $row ) {
	$n = $i + 1;
	$milestones[] = array(
		'year'  => advay_page_acf( $slug, 'our_story_milestone_' . $n . '_year', $row['year'] ),
		'title' => advay_page_acf( $slug, 'our_story_milestone_' . $n . '_title', $row['title'] ),
		'text'  => advay_page_acf( $slug, 'our_story_milestone_' . $n . '_text', $row['text'] ),
	);
}

$gallery_defaults = array(
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
		'src' => advay_theme_image( 'images/svc-warehouse.jpg', advay_asset_uri( 'images/company-placeholder.svg' ) ),
		'alt' => __( 'Inbound cartons and receiving dock', 'advay-theme' ),
	),
	array(
		'src' => advay_theme_image( 'images/client-success.jpg', advay_asset_uri( 'images/company-placeholder.svg' ) ),
		'alt' => __( 'Prep and labeling station', 'advay-theme' ),
	),
);

$gallery = array();
foreach ( $gallery_defaults as $i => $row ) {
	$n   = $i + 1;
	$img = advay_page_acf( $slug, 'our_story_gallery_' . $n, null );
	$src = advay_acf_image_url( $img, $row['src'] );
	$alt = advay_acf_image_alt( $img, $row['alt'] );
	if ( $src ) {
		$gallery[] = array(
			'src' => $src,
			'alt' => $alt,
		);
	}
}
if ( empty( $gallery ) ) {
	$gallery = $gallery_defaults;
}

$os_eyebrow        = advay_page_acf( $slug, 'our_story_eyebrow', __( 'Our Story', 'advay-theme' ) );
$os_heading        = advay_page_acf( $slug, 'our_story_heading', __( 'ElitePrep Center is built on a simple idea:', 'advay-theme' ) );
$os_heading_accent = advay_page_acf( $slug, 'our_story_heading_accent', __( 'getting your units to market', 'advay-theme' ) );
$os_heading_after  = advay_page_acf( $slug, 'our_story_heading_after', __( ' should feel effortless, not risky.', 'advay-theme' ) );
$os_aside          = advay_page_acf( $slug, 'our_story_aside', __( 'We focus on what happens before the errors — receiving, prep, and forward — not damage control after. Every brand deserves a clear paper trail from dock to fulfillment center.', 'advay-theme' ) );
$os_values_kicker  = advay_page_acf( $slug, 'our_story_values_kicker', __( 'Our values', 'advay-theme' ) );
$os_mission_label  = advay_page_acf( $slug, 'our_story_mission_label', __( 'Mission', 'advay-theme' ) );
$os_mission        = advay_page_acf( $slug, 'our_story_mission', __( 'To make fulfillment simple, fast, and reliable for growing brands, handling the operational complexity from warehouse to marketplace and customer, so founders can focus on building their brands and creating lasting wealth.', 'advay-theme' ) );
$os_vision_label   = advay_page_acf( $slug, 'our_story_vision_label', __( 'Vision', 'advay-theme' ) );
$os_vision         = advay_page_acf( $slug, 'our_story_vision', __( 'To help build a million consumer brands scale faster by becoming the supply chain partner behind their growth.', 'advay-theme' ) );
$os_tl_eyebrow     = advay_page_acf( $slug, 'our_story_timeline_eyebrow', __( 'Our journey', 'advay-theme' ) );
$os_tl_heading     = advay_page_acf( $slug, 'our_story_timeline_heading', __( 'From vision to reality', 'advay-theme' ) );
$os_tl_lead        = advay_page_acf( $slug, 'our_story_timeline_lead', __( 'From a home garage to a specialized multi-channel 3PL — the milestones that shaped ElitePrep Center.', 'advay-theme' ) );
$os_gal_heading    = advay_page_acf( $slug, 'our_story_gallery_heading', __( 'Life at ElitePrep', 'advay-theme' ) );
$os_gal_lead       = advay_page_acf( $slug, 'our_story_gallery_lead', __( 'The people, the floor, and the work behind every shipment.', 'advay-theme' ) );
$os_cta_heading    = advay_page_acf( $slug, 'our_story_cta_heading', __( 'Ready to prep with a team that gets it?', 'advay-theme' ) );
$os_cta_p          = advay_page_acf( $slug, 'our_story_cta_primary', '' );
$os_cta_s          = advay_page_acf( $slug, 'our_story_cta_secondary', '' );
$os_cta_p_label    = advay_acf_link_title( $os_cta_p, __( 'One-click onboarding', 'advay-theme' ) );
$os_cta_p_url      = advay_acf_link_url( $os_cta_p, advay_onboarding_url() );
$os_cta_s_label    = advay_acf_link_title( $os_cta_s, __( 'Book a call', 'advay-theme' ) );
$os_cta_s_url      = advay_acf_book_call_link_url( $os_cta_s, advay_book_call_url() );

get_header();
?>

<main id="main-content" class="os-page">
	<section class="os-intro" aria-labelledby="os-intro-heading">
		<div class="container os-intro-grid">
			<div class="os-intro-copy">
				<p class="eyebrow"><?php echo esc_html( $os_eyebrow ); ?></p>
				<h1 id="os-intro-heading">
					<?php echo esc_html( $os_heading ); ?>
					<strong>
						<span class="os-intro-accent"><?php echo esc_html( $os_heading_accent ); ?></span>
						<?php echo esc_html( $os_heading_after ); ?>
					</strong>
				</h1>
			</div>
			<div class="os-intro-aside">
				<p><?php echo esc_html( $os_aside ); ?></p>
			</div>
		</div>
	</section>

	<section class="os-values" aria-labelledby="os-values-heading">
		<div class="container">
			<div class="os-values-box">
				<p class="os-values-kicker" id="os-values-heading"><?php echo esc_html( $os_values_kicker ); ?></p>
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
					<p class="os-mission-label" id="os-mission-heading"><?php echo esc_html( $os_mission_label ); ?></p>
					<span class="os-mission-line" aria-hidden="true"></span>
				</div>
				<p class="os-mission-text">
					<?php echo esc_html( $os_mission ); ?>
				</p>
			</div>
			<div class="os-mission-block os-mission-block--vision" data-os-reveal="right">
				<div class="os-mission-label-row">
					<span class="os-mission-line" aria-hidden="true"></span>
					<p class="os-mission-label"><?php echo esc_html( $os_vision_label ); ?></p>
				</div>
				<p class="os-mission-text">
					<?php echo esc_html( $os_vision ); ?>
				</p>
			</div>
		</div>
	</section>

	<section class="os-timeline" aria-labelledby="os-timeline-heading">
		<div class="container">
			<header class="os-timeline-head">
				<p class="eyebrow"><?php echo esc_html( $os_tl_eyebrow ); ?></p>
				<h2 id="os-timeline-heading"><?php echo esc_html( $os_tl_heading ); ?></h2>
				<p><?php echo esc_html( $os_tl_lead ); ?></p>
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
			<h2><?php echo esc_html( $os_gal_heading ); ?></h2>
			<p><?php echo esc_html( $os_gal_lead ); ?></p>
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

	<?php get_template_part( 'template-parts/editor-zone' ); ?>

	<section class="os-cta">
		<div class="container os-cta-inner">
			<h2><?php echo esc_html( $os_cta_heading ); ?></h2>
			<div class="os-cta-actions">
				<a class="button button-primary" href="<?php echo esc_url( $os_cta_p_url ); ?>">
					<?php echo esc_html( $os_cta_p_label ); ?>
					<span class="btn-arrow" aria-hidden="true"></span>
				</a>
				<a class="button button-ghost" href="<?php echo esc_url( $os_cta_s_url ); ?>">
					<?php echo esc_html( $os_cta_s_label ); ?>
				</a>
			</div>
		</div>
	</section>
</main>

<?php
get_footer();
