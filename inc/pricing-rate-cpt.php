<?php
/**
 * Pricing Rate CPT helpers — admin-managed rate table (no public URLs).
 *
 * CPT registration lives in mu-plugin: wp-content/mu-plugins/epc-content-types.php
 * so rates survive theme switches/rollbacks.
 *
 * /pricing/ page URL unchanged. Rows ordered by menu_order.
 *
 * @package Advay_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Category choices for rates.
 *
 * @return array<string, string>
 */
function advay_pricing_category_choices() {
	return array(
		'prep'     => __( 'Prep', 'advay-theme' ),
		'inbound'  => __( 'Inbound', 'advay-theme' ),
		'storage'  => __( 'Storage', 'advay-theme' ),
		'outbound' => __( 'Outbound', 'advay-theme' ),
		'labor'    => __( 'Labor & extras', 'advay-theme' ),
	);
}

/**
 * Stable migration key for a pricing row.
 *
 * @param string $cat     Category slug.
 * @param string $service Service title.
 * @return string
 */
function advay_pricing_row_key( $cat, $service ) {
	return sanitize_key( $cat . '_' . sanitize_title( wp_strip_all_tags( (string) $service ) ) );
}

/**
 * Hardcoded pricing defaults (legacy fallback — never deleted by migration).
 *
 * @return array<int, array<string, string>>
 */
function advay_pricing_rows_defaults() {
	return array(
		array( 'cat' => 'prep', 'service' => __( 'Item prep, 1–1,000 / month', 'advay-theme' ), 'type' => 'standard', 'volume' => '1–1,000', 'uom' => __( 'Unit', 'advay-theme' ), 'charge' => '$1.00', 'notes' => '' ),
		array( 'cat' => 'prep', 'service' => __( 'Item prep, 1,001–5,000 / month', 'advay-theme' ), 'type' => 'standard', 'volume' => '1,001–5,000', 'uom' => __( 'Unit', 'advay-theme' ), 'charge' => '$0.85', 'notes' => '' ),
		array( 'cat' => 'prep', 'service' => __( 'Item prep, 5,001+ / month', 'advay-theme' ), 'type' => 'standard', 'volume' => '5,001+', 'uom' => __( 'Unit', 'advay-theme' ), 'charge' => '$0.70', 'notes' => '' ),
		array( 'cat' => 'prep', 'service' => __( 'Bundle / multi-pack', 'advay-theme' ), 'type' => 'standard', 'volume' => 'N/A', 'uom' => __( 'Unit', 'advay-theme' ), 'charge' => '$0.75', 'notes' => __( 'In addition to item prep.', 'advay-theme' ) ),
		array( 'cat' => 'prep', 'service' => __( 'FNSKU labeling', 'advay-theme' ), 'type' => 'standard', 'volume' => 'N/A', 'uom' => __( 'Unit', 'advay-theme' ), 'charge' => '$0.25', 'notes' => '' ),
		array( 'cat' => 'prep', 'service' => __( 'Polybag', 'advay-theme' ), 'type' => 'standard', 'volume' => 'N/A', 'uom' => __( 'Unit', 'advay-theme' ), 'charge' => '$0.20', 'notes' => '' ),
		array( 'cat' => 'prep', 'service' => __( 'Suffocation warning', 'advay-theme' ), 'type' => 'standard', 'volume' => 'N/A', 'uom' => __( 'Unit', 'advay-theme' ), 'charge' => '$0.10', 'notes' => '' ),
		array( 'cat' => 'prep', 'service' => __( 'Inspection', 'advay-theme' ), 'type' => 'standard', 'volume' => 'N/A', 'uom' => __( 'Unit', 'advay-theme' ), 'charge' => '$0.35', 'notes' => '' ),
		array( 'cat' => 'prep', 'service' => __( 'Fragile / bubble wrap', 'advay-theme' ), 'type' => 'addon', 'volume' => 'N/A', 'uom' => __( 'Unit', 'advay-theme' ), 'charge' => '$0.55', 'notes' => __( 'Added per unit.', 'advay-theme' ) ),
		array( 'cat' => 'prep', 'service' => __( 'Inserts', 'advay-theme' ), 'type' => 'addon', 'volume' => 'N/A', 'uom' => __( 'Unit', 'advay-theme' ), 'charge' => '$0.30', 'notes' => '' ),
		array( 'cat' => 'prep', 'service' => __( 'Product photos', 'advay-theme' ), 'type' => 'addon', 'volume' => 'N/A', 'uom' => __( 'Unit', 'advay-theme' ), 'charge' => '$1.50', 'notes' => '' ),
		array( 'cat' => 'prep', 'service' => __( 'Relabel', 'advay-theme' ), 'type' => 'addon', 'volume' => 'N/A', 'uom' => __( 'Unit', 'advay-theme' ), 'charge' => '$0.40', 'notes' => '' ),
		array( 'cat' => 'prep', 'service' => __( 'Carton rebuild', 'advay-theme' ), 'type' => 'addon', 'volume' => 'N/A', 'uom' => __( 'Carton', 'advay-theme' ), 'charge' => '$1.50', 'notes' => '' ),
		array( 'cat' => 'inbound', 'service' => __( 'Carton receive', 'advay-theme' ), 'type' => 'standard', 'volume' => 'N/A', 'uom' => __( 'Carton', 'advay-theme' ), 'charge' => '$1.25', 'notes' => '' ),
		array( 'cat' => 'inbound', 'service' => __( 'Pallet receive', 'advay-theme' ), 'type' => 'standard', 'volume' => 'N/A', 'uom' => __( 'Pallet', 'advay-theme' ), 'charge' => '$12.00', 'notes' => '' ),
		array( 'cat' => 'inbound', 'service' => __( '20ft container unload', 'advay-theme' ), 'type' => 'addon', 'volume' => 'N/A', 'uom' => __( 'Container', 'advay-theme' ), 'charge' => '$315.00', 'notes' => '' ),
		array( 'cat' => 'inbound', 'service' => __( '40ft container unload', 'advay-theme' ), 'type' => 'addon', 'volume' => 'N/A', 'uom' => __( 'Container', 'advay-theme' ), 'charge' => '$475.00', 'notes' => '' ),
		array( 'cat' => 'inbound', 'service' => __( 'Truck unload', 'advay-theme' ), 'type' => 'addon', 'volume' => 'N/A', 'uom' => __( 'Truck', 'advay-theme' ), 'charge' => '$185.00', 'notes' => '' ),
		array( 'cat' => 'storage', 'service' => __( 'Pallet storage', 'advay-theme' ), 'type' => 'addon', 'volume' => 'N/A', 'uom' => __( 'Pallet', 'advay-theme' ), 'charge' => '$40.00', 'notes' => __( 'Billed monthly after inventory is on hand more than 30 days.', 'advay-theme' ) ),
		array( 'cat' => 'storage', 'service' => __( 'Carton storage', 'advay-theme' ), 'type' => 'addon', 'volume' => 'N/A', 'uom' => __( 'Carton', 'advay-theme' ), 'charge' => '$4.00', 'notes' => __( 'Billed monthly after 30 days.', 'advay-theme' ) ),
		array( 'cat' => 'outbound', 'service' => __( 'FBM pick & pack', 'advay-theme' ), 'type' => 'standard', 'volume' => 'N/A', 'uom' => __( 'Unit', 'advay-theme' ), 'charge' => '$2.50', 'notes' => '' ),
		array( 'cat' => 'outbound', 'service' => __( 'Carton outbound', 'advay-theme' ), 'type' => 'standard', 'volume' => 'N/A', 'uom' => __( 'Carton', 'advay-theme' ), 'charge' => '$3.50', 'notes' => '' ),
		array( 'cat' => 'outbound', 'service' => __( 'Pallet outbound', 'advay-theme' ), 'type' => 'standard', 'volume' => 'N/A', 'uom' => __( 'Pallet', 'advay-theme' ), 'charge' => '$18.00', 'notes' => '' ),
		array( 'cat' => 'labor', 'service' => __( 'Rush / weekend work', 'advay-theme' ), 'type' => 'addon', 'volume' => 'N/A', 'uom' => __( 'Hourly', 'advay-theme' ), 'charge' => '$90.00', 'notes' => __( 'Two-hour minimum.', 'advay-theme' ) ),
		array( 'cat' => 'labor', 'service' => __( 'Special project labor', 'advay-theme' ), 'type' => 'addon', 'volume' => 'N/A', 'uom' => __( '15 min', 'advay-theme' ), 'charge' => '$22.50', 'notes' => __( 'Billed in 15-minute increments.', 'advay-theme' ) ),
		array( 'cat' => 'labor', 'service' => __( 'Returns inspection', 'advay-theme' ), 'type' => 'addon', 'volume' => 'N/A', 'uom' => __( 'Unit', 'advay-theme' ), 'charge' => '$1.75', 'notes' => '' ),
		array( 'cat' => 'labor', 'service' => __( 'Disposal', 'advay-theme' ), 'type' => 'addon', 'volume' => 'N/A', 'uom' => __( 'Unit', 'advay-theme' ), 'charge' => '$0.50', 'notes' => '' ),
		array( 'cat' => 'labor', 'service' => __( 'High-volume program', 'advay-theme' ), 'type' => 'standard', 'volume' => 'N/A', 'uom' => __( 'Unit', 'advay-theme' ), 'charge' => __( 'Custom', 'advay-theme' ), 'notes' => __( 'Ask for a SKU-level quote.', 'advay-theme' ) ),
	);
}

/**
 * Map a pricing_rate post to the row shape used by page-pricing.php.
 *
 * @param WP_Post $post Rate post.
 * @return array<string, string>
 */
function advay_pricing_row_from_post( $post ) {
	$post_id = (int) $post->ID;
	$cat     = advay_get_acf( 'pricing_category', 'prep', $post_id );
	$type    = advay_get_acf( 'pricing_type', 'standard', $post_id );
	if ( ! in_array( $cat, array( 'prep', 'inbound', 'storage', 'outbound', 'labor' ), true ) ) {
		$cat = 'prep';
	}
	if ( ! in_array( $type, array( 'standard', 'addon' ), true ) ) {
		$type = 'standard';
	}

	return array(
		'cat'     => $cat,
		'service' => $post->post_title,
		'type'    => $type,
		'volume'  => (string) advay_get_acf( 'pricing_volume', 'N/A', $post_id ),
		'uom'     => (string) advay_get_acf( 'pricing_uom', __( 'Unit', 'advay-theme' ), $post_id ),
		'charge'  => (string) advay_get_acf( 'pricing_charge', '', $post_id ),
		'notes'   => (string) advay_get_acf( 'pricing_notes', '', $post_id ),
	);
}

/**
 * Published pricing_rate posts as rate rows (menu_order ASC).
 *
 * @return array<int, array<string, string>>
 */
function advay_pricing_rows_from_cpt() {
	$posts = get_posts(
		array(
			'post_type'        => 'pricing_rate',
			'post_status'      => 'publish',
			'posts_per_page'   => -1,
			'orderby'          => array(
				'menu_order' => 'ASC',
				'title'      => 'ASC',
			),
			'suppress_filters' => true,
		)
	);

	if ( empty( $posts ) ) {
		return array();
	}

	$rows = array();
	foreach ( $posts as $post ) {
		$rows[] = advay_pricing_row_from_post( $post );
	}
	return $rows;
}

/**
 * Register ACF Free fields for pricing_rate.
 */
function advay_register_pricing_rate_acf_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_advay_pricing_rate',
			'title'                 => 'Pricing Rate Details',
			'fields'                => array(
				array(
					'key'           => 'field_pricing_category',
					'label'         => 'Category',
					'name'          => 'pricing_category',
					'type'          => 'select',
					'choices'       => advay_pricing_category_choices(),
					'default_value' => 'prep',
					'required'      => 1,
				),
				array(
					'key'           => 'field_pricing_type',
					'label'         => 'Type',
					'name'          => 'pricing_type',
					'type'          => 'select',
					'choices'       => array(
						'standard' => 'Standard',
						'addon'    => 'Add-on',
					),
					'default_value' => 'standard',
					'required'      => 1,
				),
				array(
					'key'   => 'field_pricing_volume',
					'label' => 'Volume band',
					'name'  => 'pricing_volume',
					'type'  => 'text',
					'instructions' => 'e.g. 1–1,000 or N/A',
				),
				array(
					'key'   => 'field_pricing_uom',
					'label' => 'Unit of measure',
					'name'  => 'pricing_uom',
					'type'  => 'text',
					'instructions' => 'e.g. Unit, Carton, Pallet',
				),
				array(
					'key'   => 'field_pricing_charge',
					'label' => 'Charge',
					'name'  => 'pricing_charge',
					'type'  => 'text',
					'instructions' => 'Displayed price, e.g. $1.00 or Custom',
				),
				array(
					'key'   => 'field_pricing_notes',
					'label' => 'Notes',
					'name'  => 'pricing_notes',
					'type'  => 'textarea',
					'rows'  => 2,
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'pricing_rate',
					),
				),
			),
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
		)
	);
}
add_action( 'acf/init', 'advay_register_pricing_rate_acf_fields' );
