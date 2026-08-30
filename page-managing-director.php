<?php
/**
 * Template Name: Managing Director
 * Template Post Type: page
 *
 * Managing Director — leadership profile page.
 *
 * @package Advay_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$slug = 'managing-director';

$portraits = advay_founder_portraits();
$hero_src  = advay_theme_image(
	'images/founder2.png',
	advay_asset_uri( 'images/company-placeholder.svg' )
);
$about_src = advay_theme_image(
	'images/founder4.jpeg',
	advay_asset_uri( 'images/company-placeholder.svg' )
);

if ( ! empty( $portraits ) ) {
	foreach ( $portraits as $photo ) {
		if ( false !== stripos( $photo['caption'], 'Managing Director' ) ) {
			$hero_src = $photo['src'];
			break;
		}
	}
}

$hero_img_acf = advay_page_acf( $slug, 'md_hero_image', null );
$hero_src     = advay_acf_image_url( $hero_img_acf, $hero_src );
$about_img_acf = advay_page_acf( $slug, 'md_about_image', null );
$about_src     = advay_acf_image_url( $about_img_acf, $about_src );

$milestones_defaults = array(
	array(
		'year'  => '2007',
		'title' => __( 'The Beginning', 'advay-theme' ),
		'text'  => __( 'Began my career in manufacturing and industrial engineering, developing a foundation in operations and continuous improvement.', 'advay-theme' ),
		'img'   => advay_theme_image( 'images/svc-warehouse.jpg', advay_asset_uri( 'images/company-placeholder.svg' ) ),
		'alt'   => __( 'Early manufacturing and engineering work', 'advay-theme' ),
	),
	array(
		'year'  => '2009',
		'title' => __( 'Building the Foundation', 'advay-theme' ),
		'text'  => __( 'Joined Merck\'s management development program and progressed through manufacturing and supply chain roles, gaining experience across operations, planning, analytics, and global product supply.', 'advay-theme' ),
		'img'   => advay_theme_image( 'images/brandfit2.png', advay_asset_uri( 'images/company-placeholder.svg' ) ),
		'alt'   => __( 'Supply chain operations at scale', 'advay-theme' ),
	),
	array(
		'year'  => '2016',
		'title' => __( 'Broadening the Lens', 'advay-theme' ),
		'text'  => __( 'Expanded from operations into enterprise leadership, combining technical expertise with an MBA from UNC Kenan-Flagler.', 'advay-theme' ),
		'img'   => advay_theme_image( 'images/client-success.jpg', advay_asset_uri( 'images/company-placeholder.svg' ) ),
		'alt'   => __( 'Strategic leadership and planning', 'advay-theme' ),
	),
	array(
		'year'  => '2018',
		'title' => __( 'Global Supply Chain Leadership', 'advay-theme' ),
		'text'  => __( 'Led increasingly complex global vaccine supply chains, including GARDASIL®, across manufacturing and global markets.', 'advay-theme' ),
		'img'   => advay_theme_image( 'images/md-legacy-1.png', advay_asset_uri( 'images/company-placeholder.svg' ) ),
		'alt'   => __( 'Global pharmaceutical supply chain', 'advay-theme' ),
	),
	array(
		'year'  => '2022+',
		'title' => __( 'Leading at Scale', 'advay-theme' ),
		'text'  => __( 'Led major global supply chain programs, including Pfizer\'s North America COVID-19 vaccine supply chain, global vaccine donation execution, digital planning transformation, and launches across 80+ markets.', 'advay-theme' ),
		'img'   => advay_theme_image(
			'images/client-success.jpg',
			advay_asset_uri( 'images/company-placeholder.svg' )
		),
		'alt'   => __( 'Leadership at ElitePrep Center', 'advay-theme' ),
	),
);

$milestones = array();
foreach ( $milestones_defaults as $i => $row ) {
	$n   = $i + 1;
	$img = advay_page_acf( $slug, 'md_milestone_' . $n . '_image', null );
	$milestones[] = array(
		'year'  => advay_page_acf( $slug, 'md_milestone_' . $n . '_year', $row['year'] ),
		'title' => advay_page_acf( $slug, 'md_milestone_' . $n . '_title', $row['title'] ),
		'text'  => advay_page_acf( $slug, 'md_milestone_' . $n . '_text', $row['text'] ),
		'img'   => advay_acf_image_url( $img, $row['img'] ),
		'alt'   => advay_acf_image_alt( $img, $row['alt'] ),
	);
}

$impact_defaults = array(
	array(
		'icon'     => 'chart-bars',
		'value'    => '20+',
		'label'    => __( 'Years in business', 'advay-theme' ),
		'sublabel' => '',
	),
	array(
		'icon'     => 'arrow-circle',
		'value'    => '100+',
		'label'    => __( 'Shipped to markets worldwide', 'advay-theme' ),
		'sublabel' => '',
	),
	array(
		'icon'     => 'clock-circle',
		'value'    => '5+',
		'label'    => __( 'Billion-dollar product supply chains managed', 'advay-theme' ),
		'sublabel' => '',
	),
	array(
		'icon'     => 'dollar-circle',
		'value'    => '2.5B+',
		'label'    => __( 'Units shipped in career', 'advay-theme' ),
		'sublabel' => '',
	),
);
$impact_stats = array();
foreach ( $impact_defaults as $i => $row ) {
	$n = $i + 1;
	$impact_stats[] = array(
		'icon'     => $row['icon'],
		'value'    => advay_page_acf( $slug, 'md_stat_' . $n . '_value', $row['value'] ),
		'label'    => advay_page_acf( $slug, 'md_stat_' . $n . '_label', $row['label'] ),
		'sublabel' => $row['sublabel'],
	);
}

$business_chain_defaults = array(
	array( 'icon' => 'sourcing', 'label' => __( 'Sourcing', 'advay-theme' ) ),
	array( 'icon' => 'manufacturing', 'label' => __( 'Manufacturing', 'advay-theme' ) ),
	array( 'icon' => 'quality', 'label' => __( 'Quality Control', 'advay-theme' ) ),
	array( 'icon' => 'warehousing', 'label' => __( 'Warehousing', 'advay-theme' ) ),
	array( 'icon' => 'distribution', 'label' => __( 'Distribution', 'advay-theme' ) ),
	array( 'icon' => 'market', 'label' => __( 'Market', 'advay-theme' ) ),
);
$business_chain = array();
foreach ( $business_chain_defaults as $i => $row ) {
	$n = $i + 1;
	$business_chain[] = array(
		'icon'  => $row['icon'],
		'label' => advay_page_acf( $slug, 'md_chain_' . $n . '_label', $row['label'] ),
	);
}

$philosophy_defaults = array(
	array( 'icon' => 'longterm', 'title' => __( 'Build for the long term', 'advay-theme' ), 'text' => __( 'We don\'t chase trends.', 'advay-theme' ) ),
	array( 'icon' => 'own', 'title' => __( 'Own what matters', 'advay-theme' ), 'text' => __( 'Control creates quality.', 'advay-theme' ) ),
	array( 'icon' => 'people', 'title' => __( 'People build businesses', 'advay-theme' ), 'text' => __( 'Invest in people, always.', 'advay-theme' ) ),
	array( 'icon' => 'curious', 'title' => __( 'Stay curious', 'advay-theme' ), 'text' => __( 'Evolve. Adapt. Grow.', 'advay-theme' ) ),
);
$philosophy_values = array();
foreach ( $philosophy_defaults as $i => $row ) {
	$n = $i + 1;
	$philosophy_values[] = array(
		'icon'  => $row['icon'],
		'title' => advay_page_acf( $slug, 'md_philosophy_' . $n . '_title', $row['title'] ),
		'text'  => advay_page_acf( $slug, 'md_philosophy_' . $n . '_text', $row['text'] ),
	);
}

$legacy_pillar_defaults = array(
	array( 'icon' => 'empower', 'label' => __( 'Empowering People', 'advay-theme' ) ),
	array( 'icon' => 'community', 'label' => __( 'Supporting Communities', 'advay-theme' ) ),
	array( 'icon' => 'future', 'label' => __( 'Building for Future Generations', 'advay-theme' ) ),
);
$legacy_pillars = array();
foreach ( $legacy_pillar_defaults as $i => $row ) {
	$n = $i + 1;
	$legacy_pillars[] = array(
		'icon'  => $row['icon'],
		'label' => advay_page_acf( $slug, 'md_legacy_pillar_' . $n, $row['label'] ),
	);
}

$legacy_photo_defaults = array(
	array( 'src' => advay_asset_uri( 'images/md-legacy-1.png' ), 'alt' => __( 'Odi Ikpe with the team on the operations floor', 'advay-theme' ) ),
	array( 'src' => advay_asset_uri( 'images/md-legacy-2.png' ), 'alt' => __( 'Odi Ikpe at UNICEF Supply Division', 'advay-theme' ) ),
	array( 'src' => advay_asset_uri( 'images/md-legacy-3.png' ), 'alt' => __( 'Odi Ikpe collaborating with the next generation', 'advay-theme' ) ),
);
$legacy_photos = array();
foreach ( $legacy_photo_defaults as $i => $row ) {
	$n   = $i + 1;
	$img = advay_page_acf( $slug, 'md_legacy_photo_' . $n, null );
	$legacy_photos[] = array(
		'src' => advay_acf_image_url( $img, $row['src'] ),
		'alt' => advay_acf_image_alt( $img, $row['alt'] ),
	);
}

$future_defaults = array(
	array( 'icon' => 'rocket', 'title' => __( 'Expanding The Business', 'advay-theme' ) ),
	array( 'icon' => 'ventures', 'title' => __( 'Building New Ventures', 'advay-theme' ) ),
	array( 'icon' => 'mentor', 'title' => __( 'Developing The Next Generation', 'advay-theme' ) ),
);
$future_cards = array();
foreach ( $future_defaults as $i => $row ) {
	$n = $i + 1;
	$future_cards[] = array(
		'icon'  => $row['icon'],
		'title' => advay_page_acf( $slug, 'md_future_' . $n . '_title', $row['title'] ),
	);
}

$md_slider = array();
foreach ( $portraits as $photo ) {
	if ( false !== stripos( $photo['caption'], 'Managing Director' ) ) {
		$md_slider[] = $photo;
	}
}
if ( empty( $md_slider ) ) {
	$md_slider[] = array(
		'src'     => $hero_src,
		'caption' => __( 'Managing Director, Odi Ikpe', 'advay-theme' ),
	);
	if ( $about_src !== $hero_src ) {
		$md_slider[] = array(
			'src'     => $about_src,
			'caption' => __( 'Managing Director, Odi Ikpe', 'advay-theme' ),
		);
	}
}

$md_kicker         = advay_page_acf( $slug, 'md_kicker', __( 'Managing Director', 'advay-theme' ) );
$md_heading        = advay_page_acf( $slug, 'md_heading', __( 'Building Businesses. Strengthening Supply Chains. Creating Lasting Impact.', 'advay-theme' ) );
$md_lead           = advay_page_acf( $slug, 'md_lead', __( 'Two decades of building brands, supply chains, and businesses that stand the test of time — now applied to marketplace prep at ElitePrep Center.', 'advay-theme' ) );
$md_hero_cta_1     = advay_page_acf( $slug, 'md_hero_cta_1', '' );
$md_hero_cta_2     = advay_page_acf( $slug, 'md_hero_cta_2', '' );
$md_hero_cta_1_l   = advay_acf_link_title( $md_hero_cta_1, __( 'Explore the journey', 'advay-theme' ) );
$md_hero_cta_1_u   = advay_acf_link_url( $md_hero_cta_1, '#md-journey' );
$md_hero_cta_2_l   = advay_acf_link_title( $md_hero_cta_2, __( 'Connect with me', 'advay-theme' ) );
$md_hero_cta_2_u   = advay_acf_link_url( $md_hero_cta_2, '#md-connect' );
$md_about_heading  = advay_page_acf( $slug, 'md_about_heading', __( 'More Than a Managing Director.', 'advay-theme' ) );
$md_about_p1       = advay_page_acf( $slug, 'md_about_p1', __( 'I am a builder at heart. Over the years, I have had the privilege of building businesses, creating thousands of jobs, working with incredible people, and solving real problems for customers.', 'advay-theme' ) );
$md_about_closer   = advay_page_acf( $slug, 'md_about_closer', __( 'This is my journey.', 'advay-theme' ) );
$md_journey_heading = advay_page_acf( $slug, 'md_journey_heading', __( 'The Journey So Far', 'advay-theme' ) );
$md_brand_heading  = advay_page_acf( $slug, 'md_brand_heading', __( 'A Brand Built With Purpose', 'advay-theme' ) );
$md_brand_text     = advay_page_acf( $slug, 'md_brand_text', __( 'ElitePrep Center is built on trust, quality, and a deep understanding of what growing brands need. Every shipment reflects our commitment to precision, compliance, and getting it right the first time.', 'advay-theme' ) );
$md_brand_img_acf  = advay_page_acf( $slug, 'md_brand_image', null );
$md_brand_src      = advay_acf_image_url(
	$md_brand_img_acf,
	advay_theme_image( 'images/svc-warehouse.jpg', advay_asset_uri( 'images/company-placeholder.svg' ) )
);
$md_brand_cta      = advay_page_acf( $slug, 'md_brand_cta', '' );
$md_brand_cta_l    = advay_acf_link_title( $md_brand_cta, __( 'Explore the brand', 'advay-theme' ) );
$md_brand_cta_u    = advay_acf_link_url( $md_brand_cta, advay_our_story_url() );
$md_chain_heading  = advay_page_acf( $slug, 'md_chain_heading', __( 'The Business Behind the Brand', 'advay-theme' ) );
$md_chain_lead     = advay_page_acf( $slug, 'md_chain_lead', __( 'A resilient supply chain. End-to-end control. Consistent quality.', 'advay-theme' ) );
$md_numbers_heading = advay_page_acf( $slug, 'md_numbers_heading', __( 'By The Numbers', 'advay-theme' ) );
$md_numbers_footer  = advay_page_acf(
	$slug,
	'md_numbers_footer',
	__( 'The result wasn\'t just more volume. It built resilient supply chains, trusted brands, and teams that scale with confidence.', 'advay-theme' )
);
$md_phil_heading   = advay_page_acf( $slug, 'md_philosophy_heading', __( 'My Philosophy', 'advay-theme' ) );
$md_phil_quote     = advay_page_acf( $slug, 'md_philosophy_quote', __( 'Business is not just about numbers. It\'s about people, purpose, and creating long-term value.', 'advay-theme' ) );
$md_legacy_heading = advay_page_acf( $slug, 'md_legacy_heading', __( 'Legacy & Impact', 'advay-theme' ) );
$md_legacy_text    = advay_page_acf( $slug, 'md_legacy_text', __( 'Creating opportunities. Empowering people. Giving back to the community.', 'advay-theme' ) );
$md_future_heading = advay_page_acf( $slug, 'md_future_heading', __( 'The Story Isn\'t Finished', 'advay-theme' ) );
$md_future_lead    = advay_page_acf( $slug, 'md_future_lead', __( 'There is still so much to build. New ideas. New ventures. New impact.', 'advay-theme' ) );
$md_connect_heading = advay_page_acf( $slug, 'md_connect_heading', __( 'Let\'s Talk.', 'advay-theme' ) );
$md_connect_text   = advay_page_acf( $slug, 'md_connect_text', __( 'I\'m always open to meaningful conversations about business, partnerships, ideas, and impact.', 'advay-theme' ) );
$md_connect_cta    = advay_page_acf( $slug, 'md_connect_cta', '' );
$md_connect_cta_l  = advay_acf_link_title( $md_connect_cta, __( 'Start a conversation', 'advay-theme' ) );
$md_connect_cta_u  = advay_acf_link_url( $md_connect_cta, advay_onboarding_url() );

get_header();
?>

<main id="main-content" class="md-page">
	<section class="md-hero" aria-labelledby="md-hero-heading">
		<div class="md-hero-grid">
			<div class="md-hero-copy">
				<p class="md-kicker"><?php echo esc_html( $md_kicker ); ?></p>
				<h1 id="md-hero-heading">
					<?php echo esc_html( $md_heading ); ?>
				</h1>
				<p class="md-lead">
					<?php echo esc_html( $md_lead ); ?>
				</p>
				<div class="md-hero-actions">
					<a class="md-btn md-btn-solid" href="<?php echo esc_url( $md_hero_cta_1_u ); ?>">
						<?php echo esc_html( $md_hero_cta_1_l ); ?>
					</a>
					<a class="md-btn md-btn-outline" href="<?php echo esc_url( $md_hero_cta_2_u ); ?>">
						<?php echo esc_html( $md_hero_cta_2_l ); ?>
					</a>
				</div>
			</div>
			<figure class="md-hero-photo">
				<?php
				get_template_part(
					'template-parts/md-feature-video',
					null,
					array(
						'wrapper_class' => 'md-hero-video-wrap',
						'video_class'   => 'md-hero-video',
						'aria_label'    => __( 'Odi Ikpe, Managing Director of ElitePrep Center', 'advay-theme' ),
					)
				);
				?>
			</figure>
		</div>
	</section>

	<section class="md-about" aria-labelledby="md-about-heading">
		<div class="md-about-grid">
			<figure class="md-about-photo">
				<img
					src="<?php echo esc_url( $about_src ); ?>"
					alt="<?php echo esc_attr( advay_acf_image_alt( $about_img_acf, __( 'Odi Ikpe in conversation with the team', 'advay-theme' ) ) ); ?>"
					width="520"
					height="520"
					loading="lazy"
					decoding="async"
				>
			</figure>
			<div class="md-about-copy">
				<h2 id="md-about-heading"><?php echo esc_html( $md_about_heading ); ?></h2>
				<p>
					<?php echo esc_html( $md_about_p1 ); ?>
				</p>
				<p class="md-about-closer"><?php echo esc_html( $md_about_closer ); ?></p>
			</div>
		</div>
	</section>

	<section class="md-journey" id="md-journey" aria-labelledby="md-journey-heading">
		<div class="container">
			<header class="md-section-head">
				<h2 id="md-journey-heading"><?php echo esc_html( $md_journey_heading ); ?></h2>
			</header>
			<div class="md-timeline">
				<div class="md-timeline-rail" aria-hidden="true"></div>
				<ol class="md-timeline-list">
					<?php foreach ( $milestones as $milestone ) : ?>
						<li class="md-timeline-item">
							<span class="md-timeline-year"><?php echo esc_html( $milestone['year'] ); ?></span>
							<h3><?php echo esc_html( $milestone['title'] ); ?></h3>
							<p><?php echo esc_html( $milestone['text'] ); ?></p>
							<figure class="md-timeline-thumb">
								<img
									src="<?php echo esc_url( $milestone['img'] ); ?>"
									alt="<?php echo esc_attr( $milestone['alt'] ); ?>"
									width="220"
									height="140"
									loading="lazy"
									decoding="async"
								>
							</figure>
						</li>
					<?php endforeach; ?>
				</ol>
			</div>
		</div>
	</section>

	<section class="md-brand" id="md-brand" aria-labelledby="md-brand-heading">
		<div class="md-brand-grid">
			<figure class="md-brand-photo">
				<img
					src="<?php echo esc_url( $md_brand_src ); ?>"
					alt="<?php echo esc_attr( advay_acf_image_alt( $md_brand_img_acf, __( 'ElitePrep Center warehouse operations', 'advay-theme' ) ) ); ?>"
					width="560"
					height="420"
					loading="lazy"
					decoding="async"
				>
			</figure>
			<div class="md-brand-copy">
				<h2 id="md-brand-heading"><?php echo esc_html( $md_brand_heading ); ?></h2>
				<p>
					<?php echo esc_html( $md_brand_text ); ?>
				</p>
				<a class="md-btn md-btn-solid" href="<?php echo esc_url( $md_brand_cta_u ); ?>">
					<?php echo esc_html( $md_brand_cta_l ); ?>
				</a>
			</div>
		</div>
	</section>

	<section class="md-business-chain" id="md-business-chain" aria-labelledby="md-business-chain-heading">
		<div class="container">
			<header class="md-section-head md-section-head--center">
				<h2 id="md-business-chain-heading"><?php echo esc_html( $md_chain_heading ); ?></h2>
				<p><?php echo esc_html( $md_chain_lead ); ?></p>
			</header>
			<div class="md-chain-flow">
				<?php
				$chain_last = count( $business_chain ) - 1;
				foreach ( $business_chain as $index => $step ) :
					?>
					<div class="md-chain-step">
						<span class="md-eco-icon" aria-hidden="true">
							<?php echo advay_md_ecosystem_icon( $step['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</span>
						<span class="md-eco-label"><?php echo esc_html( $step['label'] ); ?></span>
					</div>
					<?php if ( $index < $chain_last ) : ?>
						<span class="md-eco-arrow" aria-hidden="true"></span>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="md-numbers" id="md-numbers" aria-labelledby="md-numbers-heading">
		<div class="container">
			<header class="md-numbers-head">
				<h2 id="md-numbers-heading"><?php echo esc_html( $md_numbers_heading ); ?></h2>
			</header>
			<ul class="md-numbers-grid">
				<?php foreach ( $impact_stats as $stat ) : ?>
					<li>
						<span class="md-numbers-icon" aria-hidden="true">
							<?php echo advay_home_hub_icon( $stat['icon'], 34 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</span>
						<strong class="md-numbers-value"><?php echo esc_html( $stat['value'] ); ?></strong>
						<span class="md-numbers-label"><?php echo esc_html( $stat['label'] ); ?></span>
						<?php if ( ! empty( $stat['sublabel'] ) ) : ?>
							<em class="md-numbers-sublabel"><?php echo esc_html( $stat['sublabel'] ); ?></em>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
			<?php if ( $md_numbers_footer ) : ?>
				<p class="md-numbers-footer"><?php echo esc_html( $md_numbers_footer ); ?></p>
			<?php endif; ?>
		</div>
	</section>

	<section class="md-my-philosophy" id="md-my-philosophy" aria-labelledby="md-my-philosophy-heading">
		<div class="md-philosophy-grid">
			<div class="md-philosophy-quote">
				<h2 id="md-my-philosophy-heading"><?php echo esc_html( $md_phil_heading ); ?></h2>
				<blockquote>
					<p><?php echo esc_html( $md_phil_quote ); ?></p>
				</blockquote>
			</div>
			<div class="md-philosophy-values">
				<?php foreach ( $philosophy_values as $value ) : ?>
					<article class="md-value-card">
						<span class="md-value-icon" aria-hidden="true">
							<?php echo advay_md_ecosystem_icon( $value['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</span>
						<div>
							<h3><?php echo esc_html( $value['title'] ); ?></h3>
							<p><?php echo esc_html( $value['text'] ); ?></p>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="md-legacy" id="md-legacy" aria-labelledby="md-legacy-heading">
		<div class="md-legacy-grid">
			<div class="md-legacy-copy">
				<h2 id="md-legacy-heading"><?php echo esc_html( $md_legacy_heading ); ?></h2>
				<p><?php echo esc_html( $md_legacy_text ); ?></p>
				<ul class="md-legacy-pillars">
					<?php foreach ( $legacy_pillars as $pillar ) : ?>
						<li>
							<span class="md-legacy-icon" aria-hidden="true">
								<?php echo advay_md_ecosystem_icon( $pillar['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</span>
							<span><?php echo esc_html( $pillar['label'] ); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
			<figure class="md-legacy-photo" data-md-legacy-slider>
				<div class="md-slider-stack md-legacy-slider-stack">
					<?php foreach ( $legacy_photos as $index => $photo ) : ?>
						<img
							class="md-slider-photo<?php echo 0 === $index ? ' is-active' : ''; ?>"
							src="<?php echo esc_url( $photo['src'] ); ?>"
							alt="<?php echo esc_attr( $photo['alt'] ); ?>"
							width="560"
							height="420"
							loading="<?php echo 0 === $index ? 'eager' : 'lazy'; ?>"
							decoding="async"
							data-md-slide
						>
					<?php endforeach; ?>
				</div>
			</figure>
		</div>
	</section>

	<section class="md-future" aria-labelledby="md-future-heading">
		<div class="container">
			<header class="md-section-head md-section-head--center">
				<h2 id="md-future-heading"><?php echo esc_html( $md_future_heading ); ?></h2>
				<p><?php echo esc_html( $md_future_lead ); ?></p>
			</header>
			<div class="md-future-grid">
				<?php foreach ( $future_cards as $card ) : ?>
					<article class="md-future-card">
						<span class="md-future-icon" aria-hidden="true">
							<?php echo advay_md_ecosystem_icon( $card['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</span>
						<h3><?php echo esc_html( $card['title'] ); ?></h3>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php get_template_part( 'template-parts/editor-zone' ); ?>

	<section class="md-connect" id="md-connect" aria-labelledby="md-connect-heading">
		<div class="container md-connect-inner">
			<div class="md-connect-layout">
				<div class="md-connect-copy">
					<h2 id="md-connect-heading"><?php echo esc_html( $md_connect_heading ); ?></h2>
					<p><?php echo esc_html( $md_connect_text ); ?></p>
					<a class="md-btn md-btn-solid" href="<?php echo esc_url( $md_connect_cta_u ); ?>">
						<?php echo esc_html( $md_connect_cta_l ); ?>
					</a>
				</div>
				<figure class="md-connect-slider" data-md-slider>
					<div class="md-slider-stack">
						<?php foreach ( $md_slider as $index => $slide ) : ?>
							<img
								class="md-slider-photo<?php echo 0 === $index ? ' is-active' : ''; ?>"
								src="<?php echo esc_url( $slide['src'] ); ?>"
								alt="<?php echo esc_attr( $slide['caption'] ); ?>"
								width="420"
								height="520"
								loading="<?php echo 0 === $index ? 'eager' : 'lazy'; ?>"
								decoding="async"
								data-md-slide
							>
						<?php endforeach; ?>
					</div>
				</figure>
			</div>
		</div>
	</section>
</main>

<?php
get_footer();
