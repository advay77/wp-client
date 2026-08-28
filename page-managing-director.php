<?php
/**
 * Managing Director — leadership profile page.
 *
 * @package Advay_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$portraits = advay_founder_portraits();
$hero_src  = advay_theme_image(
	'images/founder2.png',
	'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=900&q=80'
);
$about_src = advay_theme_image(
	'images/founder4.jpeg',
	'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=800&q=80'
);

if ( ! empty( $portraits ) ) {
	foreach ( $portraits as $photo ) {
		if ( false !== stripos( $photo['caption'], 'Managing Director' ) ) {
			$hero_src = $photo['src'];
			break;
		}
	}
}

$milestones = array(
	array(
		'year'  => '2007',
		'title' => __( 'The Beginning', 'advay-theme' ),
		'text'  => __( 'Began my career in manufacturing and industrial engineering, developing a foundation in operations and continuous improvement.', 'advay-theme' ),
		'img'   => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=600&q=80',
		'alt'   => __( 'Early manufacturing and engineering work', 'advay-theme' ),
	),
	array(
		'year'  => '2009',
		'title' => __( 'Building the Foundation', 'advay-theme' ),
		'text'  => __( 'Joined Merck\'s management development program and progressed through manufacturing and supply chain roles, gaining experience across operations, planning, analytics, and global product supply.', 'advay-theme' ),
		'img'   => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=600&q=80',
		'alt'   => __( 'Supply chain operations at scale', 'advay-theme' ),
	),
	array(
		'year'  => '2016',
		'title' => __( 'Broadening the Lens', 'advay-theme' ),
		'text'  => __( 'Expanded from operations into enterprise leadership, combining technical expertise with an MBA from UNC Kenan-Flagler.', 'advay-theme' ),
		'img'   => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=600&q=80',
		'alt'   => __( 'Strategic leadership and planning', 'advay-theme' ),
	),
	array(
		'year'  => '2018',
		'title' => __( 'Global Supply Chain Leadership', 'advay-theme' ),
		'text'  => __( 'Led increasingly complex global vaccine supply chains, including GARDASIL®, across manufacturing and global markets.', 'advay-theme' ),
		'img'   => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=600&q=80',
		'alt'   => __( 'Global pharmaceutical supply chain', 'advay-theme' ),
	),
	array(
		'year'  => '2022+',
		'title' => __( 'Leading at Scale', 'advay-theme' ),
		'text'  => __( 'Led major global supply chain programs, including Pfizer\'s North America COVID-19 vaccine supply chain, global vaccine donation execution, digital planning transformation, and launches across 80+ markets.', 'advay-theme' ),
		'img'   => advay_theme_image(
			'images/client-success.jpg',
			'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=600&q=80'
		),
		'alt'   => __( 'Leadership at ElitePrep Center', 'advay-theme' ),
	),
);

$ecosystem = array(
	array(
		'icon'  => 'brands',
		'label' => __( 'Brands', 'advay-theme' ),
	),
	array(
		'icon'  => 'manufacturing',
		'label' => __( 'Manufacturing', 'advay-theme' ),
	),
	array(
		'icon'  => 'supply',
		'label' => __( 'Supply Chain', 'advay-theme' ),
	),
	array(
		'icon'  => 'distribution',
		'label' => __( 'Distribution', 'advay-theme' ),
	),
	array(
		'icon'  => 'customers',
		'label' => __( 'Customers', 'advay-theme' ),
	),
);

$nav_links = array(
	array(
		'label' => __( 'Journey', 'advay-theme' ),
		'href'  => '#md-journey',
	),
	array(
		'label' => __( 'Business', 'advay-theme' ),
		'href'  => '#md-business-chain',
	),
	array(
		'label' => __( 'Brand', 'advay-theme' ),
		'href'  => '#md-brand',
	),
	array(
		'label' => __( 'Philosophy', 'advay-theme' ),
		'href'  => '#md-my-philosophy',
	),
	array(
		'label' => __( 'Impact', 'advay-theme' ),
		'href'  => '#md-legacy',
	),
	array(
		'label' => __( 'Connect', 'advay-theme' ),
		'href'  => '#md-connect',
	),
);

$impact_stats = array(
	array(
		'value' => '20+',
		'label' => __( 'Years in business', 'advay-theme' ),
	),
	array(
		'value' => '100+',
		'label' => __( 'Shipped to markets worldwide', 'advay-theme' ),
	),
	array(
		'value' => '5+',
		'label' => __( 'Billion-dollar product supply chains managed', 'advay-theme' ),
	),
	array(
		'value' => '2.5B+',
		'label' => __( 'Units shipped in career', 'advay-theme' ),
	),
);

$business_chain = array(
	array(
		'icon'  => 'sourcing',
		'label' => __( 'Sourcing', 'advay-theme' ),
	),
	array(
		'icon'  => 'manufacturing',
		'label' => __( 'Manufacturing', 'advay-theme' ),
	),
	array(
		'icon'  => 'quality',
		'label' => __( 'Quality Control', 'advay-theme' ),
	),
	array(
		'icon'  => 'warehousing',
		'label' => __( 'Warehousing', 'advay-theme' ),
	),
	array(
		'icon'  => 'distribution',
		'label' => __( 'Distribution', 'advay-theme' ),
	),
	array(
		'icon'  => 'market',
		'label' => __( 'Market', 'advay-theme' ),
	),
);

$philosophy_values = array(
	array(
		'icon'  => 'longterm',
		'title' => __( 'Build for the long term', 'advay-theme' ),
		'text'  => __( 'We don\'t chase trends.', 'advay-theme' ),
	),
	array(
		'icon'  => 'own',
		'title' => __( 'Own what matters', 'advay-theme' ),
		'text'  => __( 'Control creates quality.', 'advay-theme' ),
	),
	array(
		'icon'  => 'people',
		'title' => __( 'People build businesses', 'advay-theme' ),
		'text'  => __( 'Invest in people, always.', 'advay-theme' ),
	),
	array(
		'icon'  => 'curious',
		'title' => __( 'Stay curious', 'advay-theme' ),
		'text'  => __( 'Evolve. Adapt. Grow.', 'advay-theme' ),
	),
);

$legacy_pillars = array(
	array(
		'icon'  => 'empower',
		'label' => __( 'Empowering People', 'advay-theme' ),
	),
	array(
		'icon'  => 'community',
		'label' => __( 'Supporting Communities', 'advay-theme' ),
	),
	array(
		'icon'  => 'future',
		'label' => __( 'Building for Future Generations', 'advay-theme' ),
	),
);

$legacy_photos = array(
	array(
		'src' => advay_asset_uri( 'images/md-legacy-1.png' ),
		'alt' => __( 'Odi Ikpe at UNICEF Supply Division', 'advay-theme' ),
	),
	array(
		'src' => advay_asset_uri( 'images/md-legacy-2.png' ),
		'alt' => __( 'Odi Ikpe mentoring and community impact', 'advay-theme' ),
	),
	array(
		'src' => advay_asset_uri( 'images/md-legacy-3.png' ),
		'alt' => __( 'Odi Ikpe collaborating with the next generation', 'advay-theme' ),
	),
);

$future_cards = array(
	array(
		'icon'  => 'rocket',
		'title' => __( 'Expanding The Business', 'advay-theme' ),
	),
	array(
		'icon'  => 'ventures',
		'title' => __( 'Building New Ventures', 'advay-theme' ),
	),
	array(
		'icon'  => 'mentor',
		'title' => __( 'Developing The Next Generation', 'advay-theme' ),
	),
);

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

get_header();
?>

<main id="main-content" class="md-page">
	<header class="md-bar" aria-label="<?php esc_attr_e( 'Managing Director profile navigation', 'advay-theme' ); ?>">
		<div class="md-bar-inner">
			<a class="md-bar-name" href="<?php echo esc_url( advay_managing_director_url() ); ?>">
				<?php esc_html_e( 'Odi Ikpe', 'advay-theme' ); ?>
			</a>
			<nav class="md-bar-nav" aria-label="<?php esc_attr_e( 'On this page', 'advay-theme' ); ?>">
				<?php foreach ( $nav_links as $link ) : ?>
					<a href="<?php echo esc_url( $link['href'] ); ?>"><?php echo esc_html( $link['label'] ); ?></a>
				<?php endforeach; ?>
			</nav>
			<button class="md-bar-toggle" type="button" aria-expanded="false" aria-controls="md-mobile-nav">
				<span class="md-bar-toggle-bars" aria-hidden="true"></span>
				<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'advay-theme' ); ?></span>
			</button>
		</div>
		<nav class="md-bar-mobile" id="md-mobile-nav" hidden>
			<?php foreach ( $nav_links as $link ) : ?>
				<a href="<?php echo esc_url( $link['href'] ); ?>"><?php echo esc_html( $link['label'] ); ?></a>
			<?php endforeach; ?>
		</nav>
	</header>

	<section class="md-hero" aria-labelledby="md-hero-heading">
		<div class="md-hero-grid">
			<div class="md-hero-copy">
				<p class="md-kicker"><?php esc_html_e( 'Managing Director', 'advay-theme' ); ?></p>
				<h1 id="md-hero-heading">
					<?php esc_html_e( 'Building Businesses. Strengthening Supply Chains. Creating Lasting Impact.', 'advay-theme' ); ?>
				</h1>
				<p class="md-lead">
					<?php esc_html_e( 'Two decades of building brands, supply chains, and businesses that stand the test of time — now applied to marketplace prep at ElitePrep Center.', 'advay-theme' ); ?>
				</p>
				<div class="md-hero-actions">
					<a class="md-btn md-btn-solid" href="#md-journey">
						<?php esc_html_e( 'Explore the journey', 'advay-theme' ); ?>
					</a>
					<a class="md-btn md-btn-outline" href="#md-connect">
						<?php esc_html_e( 'Connect with me', 'advay-theme' ); ?>
					</a>
				</div>
			</div>
			<figure class="md-hero-photo">
				<img
					src="<?php echo esc_url( $hero_src ); ?>"
					alt="<?php esc_attr_e( 'Odi Ikpe, Managing Director of ElitePrep Center', 'advay-theme' ); ?>"
					width="640"
					height="760"
					loading="eager"
					decoding="async"
				>
			</figure>
		</div>
	</section>

	<section class="md-about" aria-labelledby="md-about-heading">
		<div class="md-about-grid">
			<figure class="md-about-photo">
				<img
					src="<?php echo esc_url( $about_src ); ?>"
					alt="<?php esc_attr_e( 'Odi Ikpe in conversation with the team', 'advay-theme' ); ?>"
					width="520"
					height="520"
					loading="lazy"
					decoding="async"
				>
			</figure>
			<div class="md-about-copy">
				<h2 id="md-about-heading"><?php esc_html_e( 'More Than a Managing Director.', 'advay-theme' ); ?></h2>
				<p>
					<?php esc_html_e( 'I am a builder at heart. Over the years, I have had the privilege of building businesses, creating thousands of jobs, working with incredible people, and solving real problems for customers.', 'advay-theme' ); ?>
				</p>
				<p class="md-about-closer"><?php esc_html_e( 'This is my journey.', 'advay-theme' ); ?></p>
			</div>
		</div>
	</section>

	<section class="md-journey" id="md-journey" aria-labelledby="md-journey-heading">
		<div class="container">
			<header class="md-section-head">
				<h2 id="md-journey-heading"><?php esc_html_e( 'The Journey So Far', 'advay-theme' ); ?></h2>
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

	<section class="md-ecosystem" id="md-business" aria-labelledby="md-ecosystem-heading">
		<div class="container">
			<header class="md-section-head md-section-head--center">
				<h2 id="md-ecosystem-heading"><?php esc_html_e( 'An Ecosystem Built With Purpose', 'advay-theme' ); ?></h2>
				<p><?php esc_html_e( 'From an idea to a full-fledged ecosystem that creates value at every step.', 'advay-theme' ); ?></p>
			</header>
			<div class="md-ecosystem-flow">
				<?php
				$last_index = count( $ecosystem ) - 1;
				foreach ( $ecosystem as $index => $step ) :
					?>
					<div class="md-eco-step">
						<span class="md-eco-icon" aria-hidden="true">
							<?php echo advay_md_ecosystem_icon( $step['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</span>
						<span class="md-eco-label"><?php echo esc_html( $step['label'] ); ?></span>
					</div>
					<?php if ( $index < $last_index ) : ?>
						<span class="md-eco-arrow" aria-hidden="true"></span>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="md-brand" id="md-brand" aria-labelledby="md-brand-heading">
		<div class="md-brand-grid">
			<figure class="md-brand-photo">
				<img
					src="<?php echo esc_url( advay_theme_image( 'images/svc-warehouse.jpg', 'https://images.unsplash.com/photo-1600880292203-757bb62b4baf?auto=format&fit=crop&w=900&q=80' ) ); ?>"
					alt="<?php esc_attr_e( 'ElitePrep Center warehouse operations', 'advay-theme' ); ?>"
					width="560"
					height="420"
					loading="lazy"
					decoding="async"
				>
			</figure>
			<div class="md-brand-copy">
				<h2 id="md-brand-heading"><?php esc_html_e( 'A Brand Built With Purpose', 'advay-theme' ); ?></h2>
				<p>
					<?php esc_html_e( 'ElitePrep Center is built on trust, quality, and a deep understanding of what growing brands need. Every shipment reflects our commitment to precision, compliance, and getting it right the first time.', 'advay-theme' ); ?>
				</p>
				<a class="md-btn md-btn-solid" href="<?php echo esc_url( advay_our_story_url() ); ?>">
					<?php esc_html_e( 'Explore the brand', 'advay-theme' ); ?>
				</a>
			</div>
		</div>
	</section>

	</section>

	<section class="md-business-chain" id="md-business-chain" aria-labelledby="md-business-chain-heading">
		<div class="container">
			<header class="md-section-head md-section-head--center">
				<h2 id="md-business-chain-heading"><?php esc_html_e( 'The Business Behind the Brand', 'advay-theme' ); ?></h2>
				<p><?php esc_html_e( 'A resilient supply chain. End-to-end control. Consistent quality.', 'advay-theme' ); ?></p>
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
			<h2 id="md-numbers-heading"><?php esc_html_e( 'By The Numbers', 'advay-theme' ); ?></h2>
			<ul class="md-numbers-grid">
				<?php foreach ( $impact_stats as $stat ) : ?>
					<li>
						<strong><?php echo esc_html( $stat['value'] ); ?></strong>
						<span><?php echo esc_html( $stat['label'] ); ?></span>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<section class="md-my-philosophy" id="md-my-philosophy" aria-labelledby="md-my-philosophy-heading">
		<div class="md-philosophy-grid">
			<div class="md-philosophy-quote">
				<h2 id="md-my-philosophy-heading"><?php esc_html_e( 'My Philosophy', 'advay-theme' ); ?></h2>
				<blockquote>
					<p><?php esc_html_e( 'Business is not just about numbers. It\'s about people, purpose, and creating long-term value.', 'advay-theme' ); ?></p>
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
				<h2 id="md-legacy-heading"><?php esc_html_e( 'Legacy & Impact', 'advay-theme' ); ?></h2>
				<p><?php esc_html_e( 'Creating opportunities. Empowering people. Giving back to the community.', 'advay-theme' ); ?></p>
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
				<h2 id="md-future-heading"><?php esc_html_e( 'The Story Isn\'t Finished', 'advay-theme' ); ?></h2>
				<p><?php esc_html_e( 'There is still so much to build. New ideas. New ventures. New impact.', 'advay-theme' ); ?></p>
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

	<section class="md-connect" id="md-connect" aria-labelledby="md-connect-heading">
		<div class="container md-connect-inner">
			<div class="md-connect-layout">
				<div class="md-connect-copy">
					<h2 id="md-connect-heading"><?php esc_html_e( 'Let\'s Talk.', 'advay-theme' ); ?></h2>
					<p><?php esc_html_e( 'I\'m always open to meaningful conversations about business, partnerships, ideas, and impact.', 'advay-theme' ); ?></p>
					<a class="md-btn md-btn-solid" href="<?php echo esc_url( advay_onboarding_url() ); ?>">
						<?php esc_html_e( 'Start a conversation', 'advay-theme' ); ?>
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
