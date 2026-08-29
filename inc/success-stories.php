<?php
/**
 * Success story case study data.
 *
 * @package Advay_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registered success story slugs.
 *
 * @return string[]
 */
function advay_success_story_slugs() {
	return array_keys( advay_success_stories_data() );
}

/**
 * Whether a success story slug exists (CPT or PHP fallback data).
 *
 * @param string $slug Story slug.
 */
function advay_success_story_exists( $slug ) {
	$slug = sanitize_key( $slug );
	if ( isset( advay_success_stories_data()[ $slug ] ) ) {
		return true;
	}

	return function_exists( 'advay_get_success_story_post' ) && (bool) advay_get_success_story_post( $slug );
}

/**
 * Success story content by slug.
 *
 * Prefers published CPT + ACF fields; empty ACF fields fall back to PHP array
 * for the same slug. PHP data file is never deleted by this layer.
 *
 * @param string $slug Story slug.
 * @return array<string, mixed>
 */
function advay_get_success_story( $slug = 'ajayi-popcorn' ) {
	$slug    = sanitize_key( $slug );
	$stories = advay_success_stories_data();
	$fallback = isset( $stories[ $slug ] ) ? $stories[ $slug ] : $stories['ajayi-popcorn'];

	if ( function_exists( 'advay_get_success_story_post' ) ) {
		$post = advay_get_success_story_post( $slug );
		if ( $post ) {
			return advay_success_story_from_post( $post, $fallback );
		}
	}

	return $fallback;
}

/**
 * Build story array from CPT + ACF Free fields, merging empty fields with $fallback.
 *
 * @param WP_Post              $post     Success story post.
 * @param array<string, mixed> $fallback PHP defaults for this slug (may be empty).
 * @return array<string, mixed>
 */
function advay_success_story_from_post( $post, $fallback = array() ) {
	$post_id = (int) $post->ID;
	$fb      = is_array( $fallback ) ? $fallback : array();

	$brand = advay_get_acf( 'ss_brand', isset( $fb['brand'] ) ? $fb['brand'] : $post->post_title, $post_id );

	$hero_fallback = isset( $fb['hero_image'] ) ? $fb['hero_image'] : '';
	$founder_fb    = isset( $fb['founder_image'] ) ? $fb['founder_image'] : $hero_fallback;
	$thumb         = get_the_post_thumbnail_url( $post_id, 'full' );
	if ( $thumb ) {
		$hero_fallback = $hero_fallback ? $hero_fallback : $thumb;
		$founder_fb    = $founder_fb ? $founder_fb : $thumb;
	}

	$story = array(
		'brand'              => $brand,
		'headline_prefix'    => advay_get_acf( 'ss_headline_prefix', isset( $fb['headline_prefix'] ) ? $fb['headline_prefix'] : '', $post_id ),
		'headline_highlight' => advay_get_acf( 'ss_headline_highlight', isset( $fb['headline_highlight'] ) ? $fb['headline_highlight'] : '', $post_id ),
		'lead'               => advay_get_acf( 'ss_lead', isset( $fb['lead'] ) ? $fb['lead'] : '', $post_id ),
		'video'              => advay_get_acf( 'ss_video_url', isset( $fb['video'] ) ? $fb['video'] : '', $post_id ),
		'before_heading'     => advay_get_acf( 'ss_before_heading', isset( $fb['before_heading'] ) ? $fb['before_heading'] : '', $post_id ),
		'strategies_heading' => advay_get_acf( 'ss_strategies_heading', isset( $fb['strategies_heading'] ) ? $fb['strategies_heading'] : '', $post_id ),
		'insight_lead'       => advay_get_acf( 'ss_insight_lead', isset( $fb['insight_lead'] ) ? $fb['insight_lead'] : '', $post_id ),
		'insight_bold'       => advay_get_acf( 'ss_insight_bold', isset( $fb['insight_bold'] ) ? $fb['insight_bold'] : '', $post_id ),
		'insight_tail'       => advay_get_acf( 'ss_insight_tail', isset( $fb['insight_tail'] ) ? $fb['insight_tail'] : '', $post_id ),
		'quote'              => advay_get_acf( 'ss_quote', isset( $fb['quote'] ) ? $fb['quote'] : '', $post_id ),
		'founder'            => advay_get_acf( 'ss_founder', isset( $fb['founder'] ) ? $fb['founder'] : '', $post_id ),
		'founder_role'       => advay_get_acf( 'ss_founder_role', isset( $fb['founder_role'] ) ? $fb['founder_role'] : '', $post_id ),
		'founder_caption'    => advay_get_acf( 'ss_founder_caption', isset( $fb['founder_caption'] ) ? $fb['founder_caption'] : '', $post_id ),
		'results_summary'    => advay_get_acf( 'ss_results_summary', isset( $fb['results_summary'] ) ? $fb['results_summary'] : '', $post_id ),
		'hero_image'         => advay_acf_image_url( advay_get_acf( 'ss_hero_image', null, $post_id ), $hero_fallback ),
		'founder_image'      => advay_acf_image_url( advay_get_acf( 'ss_founder_image', null, $post_id ), $founder_fb ),
		'before'             => array(),
		'transform_before'   => array(),
		'transform_after'    => array(),
		'strategies'         => array(),
		'results'            => array(),
	);

	$fb_before = isset( $fb['before'] ) && is_array( $fb['before'] ) ? $fb['before'] : array();
	for ( $i = 1; $i <= 2; $i++ ) {
		$default = isset( $fb_before[ $i - 1 ] ) ? $fb_before[ $i - 1 ] : '';
		$item    = advay_get_acf( 'ss_before_' . $i, $default, $post_id );
		if ( '' !== (string) $item ) {
			$story['before'][] = $item;
		}
	}
	if ( empty( $story['before'] ) && $fb_before ) {
		$story['before'] = $fb_before;
	}

	$fb_tb = isset( $fb['transform_before'] ) && is_array( $fb['transform_before'] ) ? $fb['transform_before'] : array();
	for ( $i = 1; $i <= 4; $i++ ) {
		$default = isset( $fb_tb[ $i - 1 ] ) ? $fb_tb[ $i - 1 ] : '';
		$item    = advay_get_acf( 'ss_transform_before_' . $i, $default, $post_id );
		if ( '' !== (string) $item ) {
			$story['transform_before'][] = $item;
		}
	}
	if ( empty( $story['transform_before'] ) && $fb_tb ) {
		$story['transform_before'] = $fb_tb;
	}

	$fb_ta = isset( $fb['transform_after'] ) && is_array( $fb['transform_after'] ) ? $fb['transform_after'] : array();
	for ( $i = 1; $i <= 4; $i++ ) {
		$default = isset( $fb_ta[ $i - 1 ] ) ? $fb_ta[ $i - 1 ] : '';
		$item    = advay_get_acf( 'ss_transform_after_' . $i, $default, $post_id );
		if ( '' !== (string) $item ) {
			$story['transform_after'][] = $item;
		}
	}
	if ( empty( $story['transform_after'] ) && $fb_ta ) {
		$story['transform_after'] = $fb_ta;
	}

	$fb_strategies = isset( $fb['strategies'] ) && is_array( $fb['strategies'] ) ? $fb['strategies'] : array();
	for ( $i = 1; $i <= 5; $i++ ) {
		$fb_step = isset( $fb_strategies[ $i - 1 ] ) ? $fb_strategies[ $i - 1 ] : array();
		$title   = advay_get_acf( 'ss_strategy_' . $i . '_title', isset( $fb_step['title'] ) ? $fb_step['title'] : '', $post_id );
		$text    = advay_get_acf( 'ss_strategy_' . $i . '_text', isset( $fb_step['text'] ) ? $fb_step['text'] : '', $post_id );
		$icon    = advay_get_acf( 'ss_strategy_' . $i . '_icon', isset( $fb_step['icon'] ) ? $fb_step['icon'] : 'target', $post_id );
		if ( '' === (string) $title && '' === (string) $text ) {
			continue;
		}
		$story['strategies'][] = array(
			'icon'  => $icon ? $icon : 'target',
			'title' => $title,
			'text'  => $text,
		);
	}
	if ( empty( $story['strategies'] ) && $fb_strategies ) {
		$story['strategies'] = $fb_strategies;
	}

	$fb_results = isset( $fb['results'] ) && is_array( $fb['results'] ) ? $fb['results'] : array();
	for ( $i = 1; $i <= 4; $i++ ) {
		$fb_stat = isset( $fb_results[ $i - 1 ] ) ? $fb_results[ $i - 1 ] : array();
		$value   = advay_get_acf( 'ss_result_' . $i . '_value', isset( $fb_stat['value'] ) ? $fb_stat['value'] : '', $post_id );
		$label   = advay_get_acf( 'ss_result_' . $i . '_label', isset( $fb_stat['label'] ) ? $fb_stat['label'] : '', $post_id );
		$icon    = advay_get_acf( 'ss_result_' . $i . '_icon', isset( $fb_stat['icon'] ) ? $fb_stat['icon'] : 'chart-bars', $post_id );
		$sub     = advay_get_acf( 'ss_result_' . $i . '_sublabel', isset( $fb_stat['sublabel'] ) ? $fb_stat['sublabel'] : '', $post_id );
		if ( '' === (string) $value && '' === (string) $label ) {
			continue;
		}
		$stat = array(
			'icon'  => $icon ? $icon : 'chart-bars',
			'value' => $value,
			'label' => $label,
		);
		if ( '' !== (string) $sub ) {
			$stat['sublabel'] = $sub;
		}
		$story['results'][] = $stat;
	}
	if ( empty( $story['results'] ) && $fb_results ) {
		$story['results'] = $fb_results;
	}

	return $story;
}

/**
 * Homepage testimonial slugs (video row — 3 brands).
 *
 * @return string[]
 */
function advay_home_testimonial_slugs() {
	return array(
		'no-knife-body',
		'ajayi-popcorn',
		'daka-vitamins',
	);
}

/**
 * Featured success stories in display order (nav mega hover cards).
 *
 * @return string[]
 */
function advay_success_story_featured_slugs() {
	return array(
		'ajayi-popcorn',
		'daka-vitamins',
		'gainz-airplanes',
		'littlebay-caribbean-kitchen',
	);
}

/**
 * Card image for a success story (nav mega hover cards).
 *
 * @param string $slug Story slug.
 */
function advay_success_story_card_image( $slug ) {
	$slug = sanitize_key( $slug );

	$card_map = array(
		'ajayi-popcorn'               => 'images/stories/ajayi-popcorn-card.png',
		'daka-vitamins'               => 'images/stories/daka-vitamins-card.jpg',
		'gainz-airplanes'             => 'images/stories/gainz-airplanes-card.png',
		'littlebay-caribbean-kitchen' => 'images/stories/littlebay-caribbean-kitchen-card.jpg',
	);

	if ( isset( $card_map[ $slug ] ) ) {
		$path = get_template_directory() . '/assets/' . ltrim( $card_map[ $slug ], '/' );
		if ( file_exists( $path ) ) {
			return advay_asset_uri( $card_map[ $slug ] );
		}
	}

	if ( function_exists( 'advay_get_success_story_post' ) ) {
		$post = advay_get_success_story_post( $slug );
		if ( $post ) {
			$thumb = get_the_post_thumbnail_url( $post, 'medium_large' );
			if ( $thumb ) {
				return $thumb;
			}
			$acf_hero = advay_acf_image_url( advay_get_acf( 'ss_hero_image', null, $post->ID ), '' );
			if ( $acf_hero ) {
				return $acf_hero;
			}
		}
	}

	$map = array(
		'no-knife-body'               => array(
			'images/founders/no-knife-body.png',
			'',
		),
		'ajayi-popcorn'               => array( 'images/stories/ajayi-popcorn-card.png', '' ),
		'daka-vitamins'               => array( 'images/stories/daka-vitamins-card.jpg', '' ),
		'gainz-airplanes'             => array( 'images/stories/gainz-airplanes-card.png', '' ),
		'littlebay-caribbean-kitchen' => array( 'images/stories/littlebay-caribbean-kitchen-card.jpg', '' ),
	);

	if ( ! isset( $map[ $slug ] ) ) {
		return advay_theme_image( 'images/company-placeholder.svg' );
	}

	return advay_theme_image( $map[ $slug ][0], $map[ $slug ][1] );
}

/**
 * Success story cards for the nav mega menu.
 *
 * @return array<int, array{brand: string, slug: string, alt: string, src: string}>
 */
function advay_success_story_nav_cards() {
	$cards = array();

	foreach ( advay_success_story_featured_slugs() as $slug ) {
		$story = advay_get_success_story( $slug );
		$cards[] = array(
			'brand' => $story['brand'],
			'slug'  => $slug,
			'alt'   => sprintf(
				/* translators: %s: brand name */
				__( '%s success story', 'advay-theme' ),
				$story['brand']
			),
			'src'   => advay_success_story_card_image( $slug ),
		);
	}

	return $cards;
}

/**
 * Homepage testimonial video clips (3-column row).
 *
 * @return array<int, array{slug: string, chip: string, quote: string, brand: string, role: string, video: string}>
 */
function advay_home_testimonial_clips() {
	$clips  = array();
	$videos = array(
		'no-knife-body' => advay_asset_uri( 'video/testimonials.mp4' ),
		'ajayi-popcorn' => advay_asset_uri( 'video/testimonials2.mp4' ),
		'daka-vitamins' => advay_asset_uri( 'video/testimonials3.mp4' ),
	);

	foreach ( advay_home_testimonial_slugs() as $slug ) {
		$story = advay_get_success_story( $slug );
		$video = '';
		if ( ! empty( $story['video'] ) ) {
			$video = $story['video'];
		} elseif ( isset( $videos[ $slug ] ) ) {
			$video = $videos[ $slug ];
		} else {
			$video = advay_story_video( $slug );
		}
		$clips[] = array(
			'slug'  => $slug,
			'chip'  => $story['brand'],
			'quote' => '“' . $story['quote'] . '”',
			'brand' => $story['founder'],
			'role'  => $story['founder_role'],
			'video' => $video,
		);
	}

	return $clips;
}

/**
 * All success stories keyed by slug.
 *
 * @return array<string, array<string, mixed>>
 */
function advay_success_stories_data() {
	static $stories = null;

	if ( null !== $stories ) {
		return $stories;
	}

	$stories = array(
		'no-knife-body' => array(
			'brand'              => __( 'No Knife Body', 'advay-theme' ),
			'headline_prefix'    => __( 'From prep chaos to', 'advay-theme' ),
			'headline_highlight' => __( 'marketplace-ready body-care shipments.', 'advay-theme' ),
			'lead'               => __( 'No Knife Body built a loyal following for clean body-care — and needed FBA prep that protected compliance without slowing every restock or launch.', 'advay-theme' ),
			'video'              => advay_asset_uri( 'video/testimonials.mp4' ),
			'before_heading'     => __( 'Before EPC', 'advay-theme' ),
			'strategies_heading' => __( 'What EPC did', 'advay-theme' ),
			'insight_lead'       => __( 'They didn\'t need another warehouse. They needed a ', 'advay-theme' ),
			'insight_bold'       => __( 'prep partner', 'advay-theme' ),
			'insight_tail'       => __( ' that understood body-care packaging, labeling, and marketplace requirements.', 'advay-theme' ),
			'quote'              => __( 'Better service for our customers and more precious family time for me.', 'advay-theme' ),
			'founder'            => __( 'No Knife Body', 'advay-theme' ),
			'founder_role'       => __( 'Founder', 'advay-theme' ),
			'founder_image'      => advay_theme_image( 'images/founders/no-knife-body.png' ),
			'hero_image'         => advay_theme_image( 'images/founders/no-knife-body.png' ),
			'founder_caption'    => __( 'Founder, No Knife Body', 'advay-theme' ),
			'results_summary'    => __( 'No Knife Body moved from reactive prep to a repeatable FBA workflow — compliant labels, faster turnarounds, and fewer listing interruptions.', 'advay-theme' ),
			'before'             => array(
				__( 'Growing body-care catalog with inconsistent prep standards across SKUs and inbound lots.', 'advay-theme' ),
				__( 'Needed a partner that understood FBA labeling, poly-bagging, and marketplace compliance for personal-care products.', 'advay-theme' ),
			),
			'transform_before'   => array(
				__( 'Reactive prep with no standard workflow', 'advay-theme' ),
				__( 'Slow turnaround blocking restocks and launches', 'advay-theme' ),
				__( 'Labeling and packaging errors creating compliance risk', 'advay-theme' ),
				__( 'Limited visibility into shipment and prep status', 'advay-theme' ),
			),
			'transform_after'    => array(
				__( 'Standardized prep process across all body-care SKUs', 'advay-theme' ),
				__( '28-hour average turnaround from dock to ready-to-ship', 'advay-theme' ),
				__( 'Zero prep-related chargebacks on recent inbound', 'advay-theme' ),
				__( 'Photo documentation and direct access when issues arise', 'advay-theme' ),
			),
			'strategies'         => array(
				array(
					'icon'  => 'receive',
					'title' => __( 'Receiving, storage & prep', 'advay-theme' ),
					'text'  => __( 'Managed inbound receiving, storage, inspection, and prep for body-care SKUs at EPC\'s New Jersey facility.', 'advay-theme' ),
				),
				array(
					'icon'  => 'target',
					'title' => __( 'FBA labeling & compliance', 'advay-theme' ),
					'text'  => __( 'Standardized FNSKU labeling, poly-bagging, and packaging checks aligned with Amazon requirements.', 'advay-theme' ),
				),
				array(
					'icon'  => 'funnel',
					'title' => __( 'Body-care prep workflows', 'advay-theme' ),
					'text'  => __( 'Built repeatable workflows for lot tracking, expiration-sensitive handling, and multi-SKU inbound.', 'advay-theme' ),
				),
				array(
					'icon'  => 'growth',
					'title' => __( 'Marketplace readiness support', 'advay-theme' ),
					'text'  => __( 'Provided operational support for shipment creation, carton content accuracy, and prep documentation.', 'advay-theme' ),
				),
				array(
					'icon'  => 'arrow-circle',
					'title' => __( 'Scalable fulfillment model', 'advay-theme' ),
					'text'  => __( 'Created a model that scales with restocks and new launches without adding internal warehouse overhead.', 'advay-theme' ),
				),
			),
			'results'            => array(
				array(
					'icon'  => 'clock-circle',
					'value' => '28 HR',
					'label' => __( 'Average prep turnaround', 'advay-theme' ),
				),
				array(
					'icon'  => 'chart-bars',
					'value' => '99.8%',
					'label' => __( 'Label accuracy', 'advay-theme' ),
				),
				array(
					'icon'  => 'arrow-circle',
					'value' => '0',
					'label' => __( 'Prep-related chargebacks', 'advay-theme' ),
				),
				array(
					'icon'     => 'dollar-circle',
					'value'    => __( 'LIVE', 'advay-theme' ),
					'label'    => __( 'Listings protected', 'advay-theme' ),
					'sublabel' => __( 'compliant inbound flow', 'advay-theme' ),
				),
			),
		),
		'ajayi-popcorn' => array(
			'brand'              => __( 'Ajayi Popcorn', 'advay-theme' ),
			'headline_prefix'    => __( 'From Nigeria to the U.S. with', 'advay-theme' ),
			'headline_highlight' => __( 'fulfillment ready in weeks.', 'advay-theme' ),
			'lead'               => __( 'Ajayi Popcorn built a strong following at home and needed a U.S. partner to turn market-entry strategy into an executable supply chain.', 'advay-theme' ),
			'video'              => advay_asset_uri( 'video/testimonials2.mp4' ),
			'before_heading'     => __( 'Before EPC', 'advay-theme' ),
			'strategies_heading' => __( 'What EPC did', 'advay-theme' ),
			'insight_lead'       => __( 'They didn\'t need another consultant. They needed a ', 'advay-theme' ),
			'insight_bold'       => __( 'U.S. execution partner', 'advay-theme' ),
			'insight_tail'       => __( ' that could turn strategy into warehouse-ready operations.', 'advay-theme' ),
			'quote'              => __( 'Seasonal spikes used to break us. ElitePrep scales with demand — every launch ships on time.', 'advay-theme' ),
			'founder'            => __( 'Tunde Ajayi', 'advay-theme' ),
			'founder_role'       => __( 'Founder, Ajayi Popcorn', 'advay-theme' ),
			'founder_image'      => advay_theme_image( 'images/founders/ajayi-popcorn.jpg' ),
			'hero_image'         => advay_theme_image( 'images/founders/ajayi-popcorn.jpg' ),
			'founder_caption'    => __( 'Tunde Ajayi, Founder', 'advay-theme' ),
			'results_summary'    => __( 'Ajayi entered the U.S. with fulfillment live — without leasing space, hiring warehouse staff, or building systems from scratch.', 'advay-theme' ),
			'before'             => array(
				__( 'Strong following in Nigeria, but no U.S. infrastructure or local operating expertise to enter the market efficiently.', 'advay-theme' ),
				__( 'Needed a U.S.-based partner that understood e-commerce and marketplace operations to execute their growth strategy.', 'advay-theme' ),
			),
			'transform_before'   => array(
				__( 'No U.S. warehousing or fulfillment infrastructure', 'advay-theme' ),
				__( 'Market-entry strategy without local execution capability', 'advay-theme' ),
				__( 'Unclear path for marketplace and DTC fulfillment', 'advay-theme' ),
				__( 'Risk of slow, costly internal build-out', 'advay-theme' ),
			),
			'transform_after'    => array(
				__( 'U.S. fulfillment live within weeks', 'advay-theme' ),
				__( '24-hour order prep turnaround for U.S. inventory', 'advay-theme' ),
				__( '$50K+ in upfront infrastructure costs avoided', 'advay-theme' ),
				__( 'One centralized operation for inventory, prep, and fulfillment', 'advay-theme' ),
			),
			'strategies'         => array(
				array(
					'icon'  => 'target',
					'title' => __( 'U.S. warehousing & fulfillment', 'advay-theme' ),
					'text'  => __( 'Established Ajayi Popcorn\'s U.S. infrastructure without building their own operation.', 'advay-theme' ),
				),
				array(
					'icon'  => 'receive',
					'title' => __( 'Receiving, storage & prep', 'advay-theme' ),
					'text'  => __( 'Managed inventory receiving, storage, order preparation, and outbound fulfillment from EPC\'s New Jersey facility.', 'advay-theme' ),
				),
				array(
					'icon'  => 'funnel',
					'title' => __( 'Marketplace & DTC workflows', 'advay-theme' ),
					'text'  => __( 'Built workflows supporting both marketplace and direct-to-consumer fulfillment as U.S. channels expanded.', 'advay-theme' ),
				),
				array(
					'icon'  => 'growth',
					'title' => __( 'Marketplace compliance support', 'advay-theme' ),
					'text'  => __( 'Provided operational support for U.S. marketplace requirements, labeling, packaging, and shipment preparation.', 'advay-theme' ),
				),
				array(
					'icon'  => 'arrow-circle',
					'title' => __( 'Scalable fulfillment model', 'advay-theme' ),
					'text'  => __( 'Created a model that let Ajayi focus on brand building while EPC managed physical execution.', 'advay-theme' ),
				),
			),
			'results'            => array(
				array(
					'icon'  => 'clock-circle',
					'value' => __( 'WEEKS', 'advay-theme' ),
					'label' => __( 'U.S. operation live', 'advay-theme' ),
				),
				array(
					'icon'  => 'arrow-circle',
					'value' => '24 HR',
					'label' => __( 'Order prep turnaround', 'advay-theme' ),
				),
				array(
					'icon'     => 'dollar-circle',
					'value'    => '$50K+',
					'label'    => __( 'Infrastructure saved', 'advay-theme' ),
					'sublabel' => __( 'vs. building in-house', 'advay-theme' ),
				),
				array(
					'icon'  => 'chart-bars',
					'value' => '1',
					'label' => __( 'Centralized U.S. operation', 'advay-theme' ),
				),
			),
		),
		'gainz-airplanes' => array(
			'brand'              => __( 'Gainz & Airplanes', 'advay-theme' ),
			'headline_prefix'    => __( 'From bold concept to', 'advay-theme' ),
			'headline_highlight' => __( 'launch-ready supplement fulfillment.', 'advay-theme' ),
			'lead'               => __( 'Gainz & Airplanes set out to build a premium pre-workout for serious lifters — and needed infrastructure that matched the ambition of the brand.', 'advay-theme' ),
			'hero_image'         => advay_theme_image( 'images/founders/gainz-airplanes.jpg' ),
			'before_heading'     => __( 'Before EPC', 'advay-theme' ),
			'strategies_heading' => __( 'What EPC did', 'advay-theme' ),
			'insight_lead'       => __( 'They didn\'t need a warehouse that ships boxes. They needed a ', 'advay-theme' ),
			'insight_bold'       => __( 'supplement-ready partner', 'advay-theme' ),
			'insight_tail'       => __( ' that understood product execution and marketplace requirements.', 'advay-theme' ),
			'quote'              => __( 'Supplement prep has zero room for labeling errors. EPC\'s inspection and FNSKU process keeps our Amazon account clean and in stock.', 'advay-theme' ),
			'founder'            => __( 'Devon Cross', 'advay-theme' ),
			'founder_role'       => __( 'Founder, Gainz & Airplanes', 'advay-theme' ),
			'founder_image'      => advay_theme_image( 'images/founders/gainz-airplanes.jpg' ),
			'founder_caption'    => __( 'Devon Cross, Founder', 'advay-theme' ),
			'results_summary'    => __( 'Gainz & Airplanes launched with a scalable backend — without leasing space, hiring fulfillment staff, or building internal systems.', 'advay-theme' ),
			'before'             => array(
				__( 'A premium pre-workout concept built around a bold brand philosophy — but no operational infrastructure to scale it.', 'advay-theme' ),
				__( 'Needed a partner that understood supplements, marketplace requirements, and fulfillment — not just a warehouse that ships finished inventory.', 'advay-theme' ),
			),
			'transform_before'   => array(
				__( 'Launch-ready concept without fulfillment infrastructure', 'advay-theme' ),
				__( 'No lot or expiration tracking processes in place', 'advay-theme' ),
				__( 'High-value supplement needed specialized handling', 'advay-theme' ),
				__( 'Founders would need to operate their own warehouse to launch', 'advay-theme' ),
			),
			'transform_after'    => array(
				__( 'One integrated warehousing, prep, and fulfillment partner', 'advay-theme' ),
				__( '24-hour fulfillment capability for customer orders', 'advay-theme' ),
				__( 'Thousands saved by outsourcing vs. building internally', 'advay-theme' ),
				__( 'Launch-ready U.S. infrastructure without operating a warehouse', 'advay-theme' ),
			),
			'strategies'         => array(
				array(
					'icon'  => 'target',
					'title' => __( 'Launch-ready product model', 'advay-theme' ),
					'text'  => __( 'Helped translate the brand concept into a launch-ready pre-workout product and operating model.', 'advay-theme' ),
				),
				array(
					'icon'  => 'funnel',
					'title' => __( 'Supplement fulfillment strategy', 'advay-theme' ),
					'text'  => __( 'Supported a fulfillment strategy appropriate for a high-value supplement product.', 'advay-theme' ),
				),
				array(
					'icon'  => 'receive',
					'title' => __( 'Lot & expiration tracking', 'advay-theme' ),
					'text'  => __( 'Established receiving, lot and expiration tracking, inventory management, storage, and order fulfillment.', 'advay-theme' ),
				),
				array(
					'icon'  => 'growth',
					'title' => __( 'DTC & marketplace prep', 'advay-theme' ),
					'text'  => __( 'Prepared inventory for direct-to-consumer and marketplace distribution so founders could focus on growth.', 'advay-theme' ),
				),
				array(
					'icon'  => 'arrow-circle',
					'title' => __( 'Scalable launch backend', 'advay-theme' ),
					'text'  => __( 'Provided infrastructure to launch without investing in warehouse, labor, systems, or fulfillment build-out.', 'advay-theme' ),
				),
			),
			'results'            => array(
				array(
					'icon'  => 'chart-bars',
					'value' => '1',
					'label' => __( 'Integrated partner', 'advay-theme' ),
				),
				array(
					'icon'  => 'clock-circle',
					'value' => '24 HR',
					'label' => __( 'Fulfillment capability', 'advay-theme' ),
				),
				array(
					'icon'     => 'dollar-circle',
					'value'    => '$10K+',
					'label'    => __( 'Startup costs avoided', 'advay-theme' ),
					'sublabel' => __( 'vs. internal build', 'advay-theme' ),
				),
				array(
					'icon'  => 'arrow-circle',
					'value' => __( 'LAUNCH', 'advay-theme' ),
					'label' => __( 'Ready U.S. infrastructure', 'advay-theme' ),
				),
			),
		),
		'daka-vitamins' => array(
			'brand'              => __( 'Daka Vitamins', 'advay-theme' ),
			'headline_prefix'    => __( 'From mission to market with', 'advay-theme' ),
			'headline_highlight' => __( 'one coordinated supply chain.', 'advay-theme' ),
			'lead'               => __( 'Daka Vitamins set out to build supplements for underserved communities — and needed a partner that could connect product development through customer fulfillment.', 'advay-theme' ),
			'video'              => advay_asset_uri( 'video/testimonials3.mp4' ),
			'before_heading'     => __( 'Before EPC', 'advay-theme' ),
			'strategies_heading' => __( 'What EPC did', 'advay-theme' ),
			'insight_lead'       => __( 'They didn\'t need a traditional 3PL. They needed an ', 'advay-theme' ),
			'insight_bold'       => __( 'end-to-end operating partner', 'advay-theme' ),
			'insight_tail'       => __( ' from formulation through marketplace-ready fulfillment.', 'advay-theme' ),
			'quote'              => __( 'Labeling and lot tracking used to slow every inbound. ElitePrep keeps our prep compliant and in stock.', 'advay-theme' ),
			'founder'            => __( 'Ada Okoro', 'advay-theme' ),
			'founder_role'       => __( 'Founder, Daka Vitamins', 'advay-theme' ),
			'founder_image'      => advay_theme_image( 'images/founders/daka-vitamins.jpg' ),
			'hero_image'         => advay_theme_image( 'images/founders/daka-vitamins.jpg' ),
			'founder_caption'    => __( 'Ada Okoro, Founder', 'advay-theme' ),
			'results_summary'    => __( 'Daka launched with a concept-to-customer model — no internal warehouse, no fragmented vendors, and one team coordinating the full chain.', 'advay-theme' ),
			'before'             => array(
				__( 'A mission to serve nutritional needs of Black consumers and underserved communities — without a commercially viable supply chain to launch.', 'advay-theme' ),
				__( 'Needed more than a 3PL: a partner to coordinate product development, manufacturing, packaging, inventory, marketplace readiness, and fulfillment.', 'advay-theme' ),
			),
			'transform_before'   => array(
				__( 'Vision without a defined product pipeline or supply chain', 'advay-theme' ),
				__( 'No lot traceability or expiration management in place', 'advay-theme' ),
				__( 'Fragmented path from manufacturing to customer', 'advay-theme' ),
				__( 'Would require internal warehouse and fulfillment build-out to launch', 'advay-theme' ),
			),
			'transform_after'    => array(
				__( 'Concept-to-customer chain under one operating model', 'advay-theme' ),
				__( 'Multiple supplement concepts in a defined product pipeline', 'advay-theme' ),
				__( '24-hour DTC fulfillment capability established', 'advay-theme' ),
				__( 'Zero internal warehouse infrastructure required to grow', 'advay-theme' ),
			),
			'strategies'         => array(
				array(
					'icon'  => 'target',
					'title' => __( 'Product portfolio & GTM chain', 'advay-theme' ),
					'text'  => __( 'Helped translate Daka\'s mission into a defined supplement portfolio and go-to-market supply chain.', 'advay-theme' ),
				),
				array(
					'icon'  => 'funnel',
					'title' => __( 'Manufacturing to finished goods', 'advay-theme' ),
					'text'  => __( 'Coordinated the path from formulation and manufacturing through finished-goods inventory.', 'advay-theme' ),
				),
				array(
					'icon'  => 'receive',
					'title' => __( 'Lot traceability & control', 'advay-theme' ),
					'text'  => __( 'Developed lot traceability, expiration-date management, receiving, storage, and inventory control.', 'advay-theme' ),
				),
				array(
					'icon'  => 'growth',
					'title' => __( 'DTC & Amazon readiness', 'advay-theme' ),
					'text'  => __( 'Established infrastructure for DTC and marketplace fulfillment, including Amazon readiness.', 'advay-theme' ),
				),
				array(
					'icon'  => 'arrow-circle',
					'title' => __( 'End-to-end operating model', 'advay-theme' ),
					'text'  => __( 'Built manufacturing → warehousing → fulfillment → customer under one coordinated model.', 'advay-theme' ),
				),
			),
			'results'            => array(
				array(
					'icon'  => 'chart-bars',
					'value' => __( '1 MODEL', 'advay-theme' ),
					'label' => __( 'Concept to customer', 'advay-theme' ),
				),
				array(
					'icon'  => 'arrow-circle',
					'value' => 'MULTI',
					'label' => __( 'Product pipeline', 'advay-theme' ),
				),
				array(
					'icon'  => 'clock-circle',
					'value' => '24 HR',
					'label' => __( 'DTC fulfillment', 'advay-theme' ),
				),
				array(
					'icon'  => 'dollar-circle',
					'value' => '0',
					'label' => __( 'Internal warehouse needed', 'advay-theme' ),
				),
			),
		),
		'littlebay-caribbean-kitchen' => array(
			'brand'              => __( 'Littlebay Caribbean Kitchen', 'advay-theme' ),
			'headline_prefix'    => __( 'From kitchen concept to', 'advay-theme' ),
			'headline_highlight' => __( 'food truck and drink lineup launch.', 'advay-theme' ),
			'lead'               => __( 'Chef Kwane wanted an affordable way to bring Caribbean-inspired flavors to a broader audience — without the cost and risk of a traditional restaurant.', 'advay-theme' ),
			'hero_image'         => advay_theme_image( 'images/founders/littlebay.png' ),
			'before_heading'     => __( 'Before EPC', 'advay-theme' ),
			'strategies_heading' => __( 'What EPC did', 'advay-theme' ),
			'insight_lead'       => __( 'He didn\'t need consulting slides. He needed an ', 'advay-theme' ),
			'insight_bold'       => __( 'execution partner', 'advay-theme' ),
			'insight_tail'       => __( ' to develop strategy, build the model, and launch new product lines.', 'advay-theme' ),
			'quote'              => __( 'We went from packing orders on the kitchen table to same-day dispatch. EPC handles receiving, prep, and shipping so we can focus on the food.', 'advay-theme' ),
			'founder'            => __( 'Chef Kwane', 'advay-theme' ),
			'founder_role'       => __( 'Founder, Littlebay Caribbean Kitchen', 'advay-theme' ),
			'founder_image'      => advay_theme_image( 'images/founders/littlebay.png' ),
			'founder_caption'    => __( 'Chef Kwane, Founder', 'advay-theme' ),
			'results_summary'    => __( 'Littlebay entered the market with lower capital risk — a food truck channel, a drink lineup, and a model built to scale beyond one location.', 'advay-theme' ),
			'before'             => array(
				__( 'Wanted an affordable way to bring Caribbean-inspired food to a broader audience without opening a traditional restaurant.', 'advay-theme' ),
				__( 'Needed an execution partner to develop strategy, build the operating model, and identify opportunities to grow the Littlebay brand.', 'advay-theme' ),
			),
			'transform_before'   => array(
				__( 'Concept stage with high brick-and-mortar startup risk', 'advay-theme' ),
				__( 'No go-to-market channel selected', 'advay-theme' ),
				__( 'Single product category with limited revenue streams', 'advay-theme' ),
				__( 'No operational model for testing demand at scale', 'advay-theme' ),
			),
			'transform_after'    => array(
				__( 'Lower-cost market entry vs. traditional restaurant', 'advay-theme' ),
				__( 'Food truck channel launched and operating', 'advay-theme' ),
				__( 'Drink lineup added as a second revenue stream', 'advay-theme' ),
				__( 'Flexible model for events, locations, and future retail', 'advay-theme' ),
			),
			'strategies'         => array(
				array(
					'icon'  => 'target',
					'title' => __( 'Go-to-market evaluation', 'advay-theme' ),
					'text'  => __( 'Evaluated market-entry options and identified a food truck as the best balance of cost, flexibility, and customer access.', 'advay-theme' ),
				),
				array(
					'icon'  => 'funnel',
					'title' => __( 'Food truck launch model', 'advay-theme' ),
					'text'  => __( 'Helped move Littlebay from concept to execution with a food truck operating model and launch strategy.', 'advay-theme' ),
				),
				array(
					'icon'  => 'growth',
					'title' => __( 'Drink lineup expansion', 'advay-theme' ),
					'text'  => __( 'Helped develop and launch Littlebay\'s drink lineup — a new product category and revenue stream beyond prepared food.', 'advay-theme' ),
				),
				array(
					'icon'  => 'receive',
					'title' => __( 'Beverage supply-chain support', 'advay-theme' ),
					'text'  => __( 'Supported operational and supply-chain requirements to move beverage products from concept toward commercial launch.', 'advay-theme' ),
				),
				array(
					'icon'  => 'arrow-circle',
					'title' => __( 'Flexible brand platform', 'advay-theme' ),
					'text'  => __( 'Created a platform to test demand, build the brand, and introduce new products without restaurant overhead.', 'advay-theme' ),
				),
			),
			'results'            => array(
				array(
					'icon'     => 'dollar-circle',
					'value'    => __( 'LOWER', 'advay-theme' ),
					'label'    => __( 'Market entry cost', 'advay-theme' ),
					'sublabel' => __( 'vs. brick-and-mortar', 'advay-theme' ),
				),
				array(
					'icon'  => 'arrow-circle',
					'value' => __( 'LIVE', 'advay-theme' ),
					'label' => __( 'Food truck channel', 'advay-theme' ),
				),
				array(
					'icon'  => 'chart-bars',
					'value' => __( 'NEW', 'advay-theme' ),
					'label' => __( 'Drink lineup launched', 'advay-theme' ),
				),
				array(
					'icon'  => 'clock-circle',
					'value' => __( 'SCALE', 'advay-theme' ),
					'label' => __( 'Multi-product model', 'advay-theme' ),
				),
			),
		),
	);

	return $stories;
}
