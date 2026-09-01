<?php
/**
 * Homepage content helpers — ACF Free overrides with PHP defaults.
 *
 * @package Advay_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Hub “Who we are” facts (3).
 *
 * @return array<int, array{stat: string, text: string, icon: string}>
 */
function advay_home_hub_facts() {
	$defaults = array(
		array(
			'stat' => __( '8+ Years', 'advay-theme' ),
			'text' => __( 'of hands-on experience in eCommerce fulfillment and supply chain operations.', 'advay-theme' ),
			'icon' => 'experience',
		),
		array(
			'stat' => __( '5M+ Units', 'advay-theme' ),
			'text' => __( 'prepared and shipped for thousands of marketplace sellers across categories.', 'advay-theme' ),
			'icon' => 'units',
		),
		array(
			'stat' => __( '28-Hour TAT', 'advay-theme' ),
			'text' => __( 'industry-leading average turnaround time with 98.7% accuracy rate.', 'advay-theme' ),
			'icon' => 'tat',
		),
	);

	$front = advay_acf_front_id();
	foreach ( $defaults as $i => &$row ) {
		$n           = $i + 1;
		$row['stat'] = advay_get_acf( 'home_hub_fact_' . $n . '_stat', $row['stat'], $front );
		$row['text'] = advay_get_acf( 'home_hub_fact_' . $n . '_text', $row['text'], $front );
	}
	unset( $row );

	return $defaults;
}

/**
 * Hub inbound flow steps (3).
 *
 * @return array<int, array{label: string, text: string, icon: string}>
 */
function advay_home_hub_flow_inbound() {
	$defaults = array(
		array(
			'label' => __( 'Receive', 'advay-theme' ),
			'text'  => __( 'We receive and verify your inventory.', 'advay-theme' ),
			'icon'  => 'receive',
		),
		array(
			'label' => __( 'Inspect', 'advay-theme' ),
			'text'  => __( 'We inspect every unit to spec.', 'advay-theme' ),
			'icon'  => 'target',
		),
		array(
			'label' => __( 'Prep', 'advay-theme' ),
			'text'  => __( 'We prep marketplace-ready.', 'advay-theme' ),
			'icon'  => 'prep',
		),
	);

	$front = advay_acf_front_id();
	foreach ( $defaults as $i => &$row ) {
		$n            = $i + 1;
		$row['label'] = advay_get_acf( 'home_hub_flow_in_' . $n . '_label', $row['label'], $front );
		$row['text']  = advay_get_acf( 'home_hub_flow_in_' . $n . '_text', $row['text'], $front );
	}
	unset( $row );

	return $defaults;
}

/**
 * Hub outbound flow steps (3).
 *
 * @return array<int, array{label: string, text: string, icon: string}>
 */
function advay_home_hub_flow_outbound() {
	$defaults = array(
		array(
			'label' => __( 'Pack', 'advay-theme' ),
			'text'  => __( 'We pack and label marketplace-ready.', 'advay-theme' ),
			'icon'  => 'pack',
		),
		array(
			'label' => __( 'Ship', 'advay-theme' ),
			'text'  => __( 'We ship to Amazon, Walmart or others.', 'advay-theme' ),
			'icon'  => 'ship',
		),
		array(
			'label' => __( 'Report', 'advay-theme' ),
			'text'  => __( 'You get full visibility and reporting.', 'advay-theme' ),
			'icon'  => 'report',
		),
	);

	$front = advay_acf_front_id();
	foreach ( $defaults as $i => &$row ) {
		$n            = $i + 1;
		$row['label'] = advay_get_acf( 'home_hub_flow_out_' . $n . '_label', $row['label'], $front );
		$row['text']  = advay_get_acf( 'home_hub_flow_out_' . $n . '_text', $row['text'], $front );
	}
	unset( $row );

	return $defaults;
}

/**
 * Hub onboarding steps (4).
 *
 * @return array<int, array{num: string, title: string, text: string, icon: string}>
 */
function advay_home_hub_steps() {
	$defaults = array(
		array(
			'num'   => '01',
			'title' => __( 'Share your SKUs', 'advay-theme' ),
			'text'  => __( 'Send your packing list, FNSKUs or GTINs, and any special prep requirements.', 'advay-theme' ),
			'icon'  => 'sku',
		),
		array(
			'num'   => '02',
			'title' => __( 'Ship inbound', 'advay-theme' ),
			'text'  => __( 'Freight or parcel to our warehouse. We receive, count and flag exceptions.', 'advay-theme' ),
			'icon'  => 'inbound',
		),
		array(
			'num'   => '03',
			'title' => __( 'We prep to spec', 'advay-theme' ),
			'text'  => __( 'Label, bag, inspect, bundle or prep according to your requirements.', 'advay-theme' ),
			'icon'  => 'prep',
		),
		array(
			'num'   => '04',
			'title' => __( 'We forward', 'advay-theme' ),
			'text'  => __( 'Shipments leave for Amazon, Walmart or your marketplace of choice — with tracking.', 'advay-theme' ),
			'icon'  => 'forward',
		),
	);

	$front = advay_acf_front_id();
	foreach ( $defaults as $i => &$row ) {
		$n            = $i + 1;
		$row['title'] = advay_get_acf( 'home_hub_step_' . $n . '_title', $row['title'], $front );
		$row['text']  = advay_get_acf( 'home_hub_step_' . $n . '_text', $row['text'], $front );
	}
	unset( $row );

	return $defaults;
}

/**
 * Fit-check niche cards (3).
 *
 * @return array<int, array{file: string, tag: string, title: string, copy: string, src: string, alt: string}>
 */
function advay_home_fit_niche_cards() {
	$defaults = array(
		array(
			'file'  => 'images/niche1.png',
			'tag'   => __( 'Health & Wellness', 'advay-theme' ),
			'title' => __( 'Health & Wellness', 'advay-theme' ),
			'copy'  => __( 'Health & wellness runs on credibility. ElitePrep helps you scale without compromising the trust you\'ve built.', 'advay-theme' ),
		),
		array(
			'file'  => 'images/niche2.png',
			'tag'   => __( 'Beauty', 'advay-theme' ),
			'title' => __( 'Beauty', 'advay-theme' ),
			'copy'  => __( 'Beauty is built on identity. ElitePrep makes sure yours shines on every marketplace.', 'advay-theme' ),
		),
		array(
			'file'  => 'images/niche3.png',
			'tag'   => __( 'Packaged Food', 'advay-theme' ),
			'title' => __( 'Packaged Food', 'advay-theme' ),
			'copy'  => __( 'Packaged food lives and dies by shelf life. Elite Prep Center keeps your lot tracking and expiration dates airtight.', 'advay-theme' ),
		),
	);

	$front = advay_acf_front_id();
	foreach ( $defaults as $i => &$card ) {
		$n            = $i + 1;
		$card['tag']  = advay_get_acf( 'home_fit_niche_' . $n . '_tag', $card['tag'], $front );
		$card['title'] = advay_get_acf( 'home_fit_niche_' . $n . '_title', $card['title'], $front );
		$card['copy'] = advay_get_acf( 'home_fit_niche_' . $n . '_copy', $card['copy'], $front );
		$img          = advay_get_acf( 'home_fit_niche_' . $n . '_image', null, $front );
		$fallback_src = advay_asset_uri( $card['file'] );
		$card['src']  = advay_acf_image_url( $img, $fallback_src );
		$card['alt']  = advay_acf_image_alt( $img, $card['title'] );
	}
	unset( $card );

	return $defaults;
}

/**
 * Fit-check specification cards (2).
 *
 * @return array<int, array{file: string, tag: string, title: string, copy: string, src: string, alt: string}>
 */
function advay_home_fit_spec_cards() {
	$defaults = array(
		array(
			'file'  => 'images/brandfit2.png',
			'tag'   => __( 'Lot tracking / compliance', 'advay-theme' ),
			'title' => __( 'Lot tracking / compliance', 'advay-theme' ),
			'copy'  => __( 'We track what actually matters. Lot numbers, expiration dates, and recall-ready records, the details that protect your brand when it counts.', 'advay-theme' ),
		),
		array(
			'file'  => 'images/brandfit3.png',
			'tag'   => __( 'Switching / scaling', 'advay-theme' ),
			'title' => __( 'Switching / scaling', 'advay-theme' ),
			'copy'  => __( 'Outgrowing DIY, or done with the loser ones? Whether you\'re switching from a 3PL that\'s letting you down or scaling past in-house prep, we make the move seamless.', 'advay-theme' ),
		),
	);

	$front = advay_acf_front_id();
	foreach ( $defaults as $i => &$card ) {
		$n             = $i + 1;
		$card['tag']   = advay_get_acf( 'home_fit_spec_' . $n . '_tag', $card['tag'], $front );
		$card['title'] = advay_get_acf( 'home_fit_spec_' . $n . '_title', $card['title'], $front );
		$card['copy']  = advay_get_acf( 'home_fit_spec_' . $n . '_copy', $card['copy'], $front );
		$img           = advay_get_acf( 'home_fit_spec_' . $n . '_image', null, $front );
		$fallback_src  = advay_asset_uri( $card['file'] );
		$card['src']   = advay_acf_image_url( $img, $fallback_src );
		$card['alt']   = advay_acf_image_alt( $img, $card['title'] );
	}
	unset( $card );

	return $defaults;
}

/**
 * Brands case-study tabs (4 fixed).
 *
 * @return array<int, array<string, mixed>>
 */
function advay_home_brands_case_studies() {
	$defaults = array(
		array(
			'name'     => 'Daka Vitamins',
			'slug'     => 'daka-vitamins',
			'file'     => 'images/brand-daka.png',
			'initials' => 'DV',
			'quote'    => __( 'Vitamin labeling and lot tracking used to slow every inbound. EPC keeps our FBA prep compliant so supplements stay in stock without account risk.', 'advay-theme' ),
			'author'   => __( 'Brian McNeill', 'advay-theme' ),
			'role'     => __( 'Founder, Daka Vitamins', 'advay-theme' ),
			'stats'    => array(
				array( 'n' => '99.8%', 'l' => __( 'Label accuracy', 'advay-theme' ) ),
				array( 'n' => '0', 'l' => __( 'Compliance holds', 'advay-theme' ) ),
			),
		),
		array(
			'name'     => 'Gainz & Airplanes',
			'slug'     => 'gainz-airplanes',
			'file'     => 'images/brand-gainz.jpg',
			'initials' => 'GA',
			'quote'    => __( 'Supplement prep has zero room for labeling errors. EPC\'s inspection and FNSKU process keeps our Amazon account clean and in stock.', 'advay-theme' ),
			'author'   => __( 'Devon Cross', 'advay-theme' ),
			'role'     => __( 'Founder, Gainz & Airplanes', 'advay-theme' ),
			'stats'    => array(
				array( 'n' => '99.6%', 'l' => __( 'Prep accuracy', 'advay-theme' ) ),
				array( 'n' => '0', 'l' => __( 'Stranded inventory events', 'advay-theme' ) ),
			),
		),
		array(
			'name'     => 'Little Caribbean Kitchen',
			'slug'     => 'littlebay-caribbean-kitchen',
			'file'     => 'images/brand-littlebay.jpg',
			'initials' => 'LC',
			'quote'    => __( 'We went from packing orders on the kitchen table to same-day dispatch. EPC handles receiving, prep, and shipping so we can focus on the food.', 'advay-theme' ),
			'author'   => __( 'Marlon Bay', 'advay-theme' ),
			'role'     => __( 'Founder, Little Caribbean Kitchen', 'advay-theme' ),
			'stats'    => array(
				array( 'n' => __( '24 hrs', 'advay-theme' ), 'l' => __( 'Order turnaround', 'advay-theme' ) ),
				array( 'n' => '3×', 'l' => __( 'Orders shipped / month', 'advay-theme' ) ),
			),
		),
		array(
			'name'     => 'Ajayi Popcorn',
			'slug'     => 'ajayi-popcorn',
			'file'     => 'images/brand-ajayi.jpg',
			'initials' => 'AP',
			'quote'    => __( 'Seasonal snack spikes used to break us. Now EPC scales fulfillment up and down with demand — no missed launches.', 'advay-theme' ),
			'author'   => __( 'Bolu Ajayi', 'advay-theme' ),
			'role'     => __( 'Founder, Ajayi Popcorn', 'advay-theme' ),
			'stats'    => array(
				array( 'n' => __( '2 Days', 'advay-theme' ), 'l' => __( 'Nationwide shipping', 'advay-theme' ) ),
				array( 'n' => '$1M+', 'l' => __( 'Peak-season volume', 'advay-theme' ) ),
			),
		),
	);

	$front = advay_acf_front_id();
	foreach ( $defaults as $i => &$brand ) {
		$n = $i + 1;

		/* Success Story CPT is source of truth for quote / attribution when present. */
		if ( function_exists( 'advay_get_success_story' ) && ! empty( $brand['slug'] ) ) {
			$story = advay_get_success_story( $brand['slug'] );
			if ( ! empty( $story['brand'] ) ) {
				$brand['name'] = $story['brand'];
			}
			if ( ! empty( $story['quote'] ) ) {
				$brand['quote'] = $story['quote'];
			}
			if ( ! empty( $story['founder'] ) ) {
				$brand['author'] = $story['founder'];
			}
			if ( ! empty( $story['founder_role'] ) ) {
				$brand['role'] = $story['founder_role'];
			}
		}

		$brand['name']   = advay_get_acf( 'home_cs_' . $n . '_name', $brand['name'], $front );
		$brand['quote']  = advay_get_acf( 'home_cs_' . $n . '_quote', $brand['quote'], $front );
		$brand['author'] = advay_get_acf( 'home_cs_' . $n . '_author', $brand['author'], $front );
		$brand['role']   = advay_get_acf( 'home_cs_' . $n . '_role', $brand['role'], $front );
		$brand['stats'][0]['n'] = advay_get_acf( 'home_cs_' . $n . '_stat1_n', $brand['stats'][0]['n'], $front );
		$brand['stats'][0]['l'] = advay_get_acf( 'home_cs_' . $n . '_stat1_l', $brand['stats'][0]['l'], $front );
		$brand['stats'][1]['n'] = advay_get_acf( 'home_cs_' . $n . '_stat2_n', $brand['stats'][1]['n'], $front );
		$brand['stats'][1]['l'] = advay_get_acf( 'home_cs_' . $n . '_stat2_l', $brand['stats'][1]['l'], $front );
		$logo = advay_get_acf( 'home_cs_' . $n . '_logo', null, $front );
		$path = get_template_directory() . '/assets/' . $brand['file'];
		$fallback = file_exists( $path ) ? advay_asset_uri( $brand['file'] ) : '';
		$brand['logo_src'] = advay_acf_image_url( $logo, $fallback );
	}
	unset( $brand );

	return $defaults;
}
