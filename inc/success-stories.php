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
 * Whether a success story slug exists.
 *
 * @param string $slug Story slug.
 */
function advay_success_story_exists( $slug ) {
	$slug = sanitize_key( $slug );
	return isset( advay_success_stories_data()[ $slug ] );
}

/**
 * Success story content by slug.
 *
 * @param string $slug Story slug.
 * @return array<string, mixed>
 */
function advay_get_success_story( $slug = 'no-knife-body' ) {
	$slug    = sanitize_key( $slug );
	$stories = advay_success_stories_data();

	return isset( $stories[ $slug ] ) ? $stories[ $slug ] : $stories['no-knife-body'];
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
			'headline_highlight' => __( 'marketplace-ready shipments in weeks.', 'advay-theme' ),
			'lead'               => __( 'A growing body-care brand needed FBA prep they could trust — without slowing every launch or risking compliance.', 'advay-theme' ),
			'video'              => advay_asset_uri( 'video/testimonials.mp4' ),
			'before_heading'     => __( 'Before working together', 'advay-theme' ),
			'strategies_heading' => __( 'What we changed', 'advay-theme' ),
			'insight_lead'       => __( 'They didn\'t need more ads. They needed a ', 'advay-theme' ),
			'insight_bold'       => __( 'growth system', 'advay-theme' ),
			'insight_tail'       => __( ' built around their brand, customers, and unit economics.', 'advay-theme' ),
			'quote'              => __( 'Best decision we ever made — choosing ElitePrep.', 'advay-theme' ),
			'founder'            => __( 'No Knife Body team', 'advay-theme' ),
			'founder_role'       => __( 'Founder', 'advay-theme' ),
			'founder_image'      => advay_asset_uri( 'images/md-portrait.jpg' ),
			'founder_caption'    => __( 'Managing Director, Odi Ikpe', 'advay-theme' ),
			'results_summary'    => __( 'The result wasn\'t just more revenue. It created a predictable growth engine and a brand customers love and trust.', 'advay-theme' ),
			'before'             => array(
				__( 'Sales had plateaued for 8+ months', 'advay-theme' ),
				__( 'High customer acquisition cost with low returns', 'advay-theme' ),
				__( 'No clear positioning or offer differentiation', 'advay-theme' ),
				__( 'Ad campaigns weren\'t converting', 'advay-theme' ),
			),
			'after'              => array(
				__( 'Standardized prep with compliant labels every time', 'advay-theme' ),
				__( '28-hour average turnaround from dock to ready-to-ship', 'advay-theme' ),
				__( 'Clear reporting and photo documentation on every lot', 'advay-theme' ),
				__( 'Direct access to client success and the MD when needed', 'advay-theme' ),
			),
			'transform_before'   => array(
				__( 'Reactive prep with no standard workflow', 'advay-theme' ),
				__( 'Slow turnaround blocking launches', 'advay-theme' ),
				__( 'Compliance issues creating chargeback risk', 'advay-theme' ),
				__( 'No visibility into shipment status', 'advay-theme' ),
			),
			'transform_after'    => array(
				__( 'Standardized prep process across all SKUs', 'advay-theme' ),
				__( '28-hour average turnaround time', 'advay-theme' ),
				__( 'Zero prep-related chargebacks', 'advay-theme' ),
				__( 'Real-time reporting and direct MD access', 'advay-theme' ),
			),
			'strategies'         => array(
				array(
					'icon'  => 'target',
					'title' => __( 'Clarified positioning & offer', 'advay-theme' ),
					'text'  => __( 'Refined their brand message and created an irresistible offer for their target audience.', 'advay-theme' ),
				),
				array(
					'icon'  => 'funnel',
					'title' => __( 'Built a full-funnel growth system', 'advay-theme' ),
					'text'  => __( 'Optimized their ads, landing pages, email flows, and remarketing for maximum conversions.', 'advay-theme' ),
				),
				array(
					'icon'  => 'growth',
					'title' => __( 'Improved LTV & retention', 'advay-theme' ),
					'text'  => __( 'Introduced retention flows and subscription model to increase repeat purchases.', 'advay-theme' ),
				),
			),
			'results'            => array(
				array(
					'icon'     => 'chart-bars',
					'value'    => '$120K → $480K',
					'label'    => __( 'Monthly revenue', 'advay-theme' ),
					'sublabel' => __( 'in 6 months', 'advay-theme' ),
				),
				array(
					'icon'  => 'arrow-circle',
					'value' => '300%',
					'label' => __( 'Revenue growth', 'advay-theme' ),
				),
				array(
					'icon'  => 'clock-circle',
					'value' => '6 MONTHS',
					'label' => __( 'Time to result', 'advay-theme' ),
				),
				array(
					'icon'  => 'dollar-circle',
					'value' => '4.2X',
					'label' => __( 'Return on ad spend', 'advay-theme' ),
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
