<?php
/**
 * ACF Free — remaining homepage content fields (ElitePrep Content).
 *
 * @package Advay_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Build text field definition.
 *
 * @param string $key   Field key.
 * @param string $label Label.
 * @param string $name  Name.
 * @param string $type  text|textarea|url.
 * @param int    $rows  Textarea rows.
 * @return array<string, mixed>
 */
function advay_acf_text_field( $key, $label, $name, $type = 'text', $rows = 3 ) {
	$field = array(
		'key'   => $key,
		'label' => $label,
		'name'  => $name,
		'type'  => $type,
	);
	if ( 'textarea' === $type ) {
		$field['rows'] = $rows;
	}
	return $field;
}

/**
 * Build image field definition.
 *
 * @param string $key   Field key.
 * @param string $label Label.
 * @param string $name  Name.
 * @return array<string, mixed>
 */
function advay_acf_image_field( $key, $label, $name ) {
	return array(
		'key'           => $key,
		'label'         => $label,
		'name'          => $name,
		'type'          => 'image',
		'return_format' => 'array',
		'preview_size'  => 'medium',
		'library'       => 'all',
	);
}

/**
 * Register Phase 3C homepage field group.
 */
function advay_register_homepage_complete_acf_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	$fields = array();

	/* ---- Hero channels (4) ---- */
	$fields[] = array(
		'key'   => 'field_advay_tab_hero_channels',
		'label' => 'Hero channels',
		'type'  => 'tab',
	);
	$fields[] = array(
		'key'          => 'field_advay_hero_channels_note',
		'label'        => 'Note',
		'name'         => '',
		'type'         => 'message',
		'message'      => 'Each marketplace tab has its own label, heading, description, and optional video URL (home_hero_{channel}_*). Empty fields keep theme defaults. Legacy Amazon-only “Hero heading / description” and older hero_* field names still work as fallbacks.',
		'new_lines'    => '',
		'esc_html'     => 0,
	);

	$channels = array(
		'amazon'  => 'Amazon FBA',
		'walmart' => 'Walmart WFS',
		'tiktok'  => 'TikTok Shop',
		'dtc'     => 'DTC Fulfillment',
	);
	foreach ( $channels as $id => $label ) {
		$fields[] = advay_acf_text_field( 'field_home_hero_' . $id . '_label', $label . ' — tab label', 'home_hero_' . $id . '_label' );
		$fields[] = advay_acf_text_field( 'field_home_hero_' . $id . '_heading', $label . ' — heading', 'home_hero_' . $id . '_heading' );
		$fields[] = advay_acf_text_field( 'field_home_hero_' . $id . '_description', $label . ' — description', 'home_hero_' . $id . '_description', 'textarea', 4 );
		$fields[] = advay_acf_text_field( 'field_home_hero_' . $id . '_video', $label . ' — video URL', 'home_hero_' . $id . '_video', 'url' );
	}

	/* ---- Hub facts / flow / steps ---- */
	$fields[] = array(
		'key'   => 'field_advay_tab_hub_details',
		'label' => 'Hub details',
		'type'  => 'tab',
	);
	for ( $i = 1; $i <= 3; $i++ ) {
		$fields[] = advay_acf_text_field( 'field_home_hub_fact_' . $i . '_stat', 'Fact ' . $i . ' — stat', 'home_hub_fact_' . $i . '_stat' );
		$fields[] = advay_acf_text_field( 'field_home_hub_fact_' . $i . '_text', 'Fact ' . $i . ' — text', 'home_hub_fact_' . $i . '_text', 'textarea', 2 );
	}
	for ( $i = 1; $i <= 3; $i++ ) {
		$fields[] = advay_acf_text_field( 'field_home_hub_flow_in_' . $i . '_label', 'Inbound step ' . $i . ' — label', 'home_hub_flow_in_' . $i . '_label' );
		$fields[] = advay_acf_text_field( 'field_home_hub_flow_in_' . $i . '_text', 'Inbound step ' . $i . ' — text', 'home_hub_flow_in_' . $i . '_text', 'textarea', 2 );
	}
	for ( $i = 1; $i <= 3; $i++ ) {
		$fields[] = advay_acf_text_field( 'field_home_hub_flow_out_' . $i . '_label', 'Outbound step ' . $i . ' — label', 'home_hub_flow_out_' . $i . '_label' );
		$fields[] = advay_acf_text_field( 'field_home_hub_flow_out_' . $i . '_text', 'Outbound step ' . $i . ' — text', 'home_hub_flow_out_' . $i . '_text', 'textarea', 2 );
	}
	for ( $i = 1; $i <= 4; $i++ ) {
		$fields[] = advay_acf_text_field( 'field_home_hub_step_' . $i . '_title', 'Onboarding step ' . $i . ' — title', 'home_hub_step_' . $i . '_title' );
		$fields[] = advay_acf_text_field( 'field_home_hub_step_' . $i . '_text', 'Onboarding step ' . $i . ' — text', 'home_hub_step_' . $i . '_text', 'textarea', 2 );
	}
	$fields[] = advay_acf_text_field( 'field_home_hub_cta_who', 'Hub CTA — Who we are', 'home_hub_cta_who' );
	$fields[] = advay_acf_text_field( 'field_home_hub_cta_what', 'Hub CTA — What we do', 'home_hub_cta_what' );
	$fields[] = advay_acf_text_field( 'field_home_hub_cta_how', 'Hub CTA — How to start', 'home_hub_cta_how' );

	/* ---- Fit check ---- */
	$fields[] = array(
		'key'   => 'field_advay_tab_fit',
		'label' => 'Fit check',
		'type'  => 'tab',
	);
	$fields[] = advay_acf_text_field( 'field_home_fit_eyebrow', 'Fit — eyebrow', 'home_fit_eyebrow' );
	$fields[] = advay_acf_text_field( 'field_home_fit_heading', 'Fit — heading line 1', 'home_fit_heading' );
	$fields[] = advay_acf_text_field( 'field_home_fit_heading_accent', 'Fit — heading accent', 'home_fit_heading_accent' );
	$fields[] = advay_acf_text_field( 'field_home_fit_lead', 'Fit — lead', 'home_fit_lead', 'textarea', 2 );
	for ( $i = 1; $i <= 3; $i++ ) {
		$fields[] = advay_acf_text_field( 'field_home_fit_niche_' . $i . '_tag', 'Niche ' . $i . ' — tag', 'home_fit_niche_' . $i . '_tag' );
		$fields[] = advay_acf_text_field( 'field_home_fit_niche_' . $i . '_title', 'Niche ' . $i . ' — title', 'home_fit_niche_' . $i . '_title' );
		$fields[] = advay_acf_text_field( 'field_home_fit_niche_' . $i . '_copy', 'Niche ' . $i . ' — copy', 'home_fit_niche_' . $i . '_copy', 'textarea', 3 );
		$fields[] = advay_acf_image_field( 'field_home_fit_niche_' . $i . '_image', 'Niche ' . $i . ' — image', 'home_fit_niche_' . $i . '_image' );
	}
	for ( $i = 1; $i <= 2; $i++ ) {
		$fields[] = advay_acf_text_field( 'field_home_fit_spec_' . $i . '_tag', 'Spec ' . $i . ' — tag', 'home_fit_spec_' . $i . '_tag' );
		$fields[] = advay_acf_text_field( 'field_home_fit_spec_' . $i . '_title', 'Spec ' . $i . ' — title', 'home_fit_spec_' . $i . '_title' );
		$fields[] = advay_acf_text_field( 'field_home_fit_spec_' . $i . '_copy', 'Spec ' . $i . ' — copy', 'home_fit_spec_' . $i . '_copy', 'textarea', 3 );
		$fields[] = advay_acf_image_field( 'field_home_fit_spec_' . $i . '_image', 'Spec ' . $i . ' — image', 'home_fit_spec_' . $i . '_image' );
	}
	$fields[] = array(
		'key'           => 'field_home_fit_cta',
		'label'         => 'Fit CTA button',
		'name'          => 'home_fit_cta',
		'type'          => 'link',
		'return_format' => 'array',
	);

	/* ---- Founder portraits ---- */
	$fields[] = array(
		'key'   => 'field_advay_tab_founders',
		'label' => 'Founder portraits',
		'type'  => 'tab',
	);
	for ( $i = 1; $i <= 4; $i++ ) {
		$fields[] = advay_acf_image_field( 'field_home_founder_' . $i . '_image', 'Portrait ' . $i . ' — image', 'home_founder_' . $i . '_image' );
		$fields[] = advay_acf_text_field( 'field_home_founder_' . $i . '_caption', 'Portrait ' . $i . ' — caption', 'home_founder_' . $i . '_caption' );
	}

	/* ---- Logo slider ---- */
	$fields[] = array(
		'key'   => 'field_advay_tab_logos',
		'label' => 'Logo slider',
		'type'  => 'tab',
	);
	for ( $i = 1; $i <= 5; $i++ ) {
		$fields[] = advay_acf_text_field( 'field_home_logo_' . $i . '_name', 'Logo ' . $i . ' — name', 'home_logo_' . $i . '_name' );
		$fields[] = advay_acf_image_field( 'field_home_logo_' . $i . '_image', 'Logo ' . $i . ' — image', 'home_logo_' . $i . '_image' );
	}

	/* ---- Brands case studies ---- */
	$fields[] = array(
		'key'   => 'field_advay_tab_cs_panels',
		'label' => 'Brand case panels',
		'type'  => 'tab',
	);
	$fields[] = advay_acf_text_field( 'field_home_brands_see_all', 'See all case studies — label', 'home_brands_see_all_label' );
	for ( $i = 1; $i <= 4; $i++ ) {
		$fields[] = advay_acf_text_field( 'field_home_cs_' . $i . '_name', 'Brand ' . $i . ' — tab name', 'home_cs_' . $i . '_name' );
		$fields[] = advay_acf_image_field( 'field_home_cs_' . $i . '_logo', 'Brand ' . $i . ' — logo', 'home_cs_' . $i . '_logo' );
		$fields[] = advay_acf_text_field( 'field_home_cs_' . $i . '_quote', 'Brand ' . $i . ' — quote', 'home_cs_' . $i . '_quote', 'textarea', 3 );
		$fields[] = advay_acf_text_field( 'field_home_cs_' . $i . '_author', 'Brand ' . $i . ' — author', 'home_cs_' . $i . '_author' );
		$fields[] = advay_acf_text_field( 'field_home_cs_' . $i . '_role', 'Brand ' . $i . ' — role', 'home_cs_' . $i . '_role' );
		$fields[] = advay_acf_text_field( 'field_home_cs_' . $i . '_stat1_n', 'Brand ' . $i . ' — stat 1 value', 'home_cs_' . $i . '_stat1_n' );
		$fields[] = advay_acf_text_field( 'field_home_cs_' . $i . '_stat1_l', 'Brand ' . $i . ' — stat 1 label', 'home_cs_' . $i . '_stat1_l' );
		$fields[] = advay_acf_text_field( 'field_home_cs_' . $i . '_stat2_n', 'Brand ' . $i . ' — stat 2 value', 'home_cs_' . $i . '_stat2_n' );
		$fields[] = advay_acf_text_field( 'field_home_cs_' . $i . '_stat2_l', 'Brand ' . $i . ' — stat 2 label', 'home_cs_' . $i . '_stat2_l' );
	}

	/* ---- Map intro ---- */
	$fields[] = array(
		'key'   => 'field_advay_tab_map',
		'label' => 'Map intro',
		'type'  => 'tab',
	);
	$fields[] = advay_acf_text_field( 'field_home_map_eyebrow', 'Map — eyebrow', 'home_map_eyebrow' );
	$fields[] = advay_acf_text_field( 'field_home_map_heading', 'Map — heading', 'home_map_heading' );
	$fields[] = advay_acf_text_field( 'field_home_map_lead', 'Map — lead', 'home_map_lead', 'textarea', 3 );
	$fields[] = advay_acf_text_field( 'field_home_map_banner_title', 'Map banner — title', 'home_map_banner_title' );
	$fields[] = advay_acf_text_field( 'field_home_map_banner_addr', 'Map banner — address', 'home_map_banner_addr' );
	$fields[] = advay_acf_text_field( 'field_home_map_onboard_label', 'Map — onboarding button label', 'home_map_onboard_label' );
	$hub_ids = array(
		1 => 'Amazon hub',
		2 => 'Walmart hub',
		3 => 'TikTok hub',
	);
	foreach ( $hub_ids as $i => $hub_label ) {
		$fields[] = advay_acf_text_field( 'field_home_map_hub_' . $i . '_label', $hub_label . ' — name', 'home_map_hub_' . $i . '_label' );
		$fields[] = advay_acf_text_field( 'field_home_map_hub_' . $i . '_addr', $hub_label . ' — address', 'home_map_hub_' . $i . '_addr' );
		$fields[] = advay_acf_text_field( 'field_home_map_hub_' . $i . '_miles', $hub_label . ' — miles', 'home_map_hub_' . $i . '_miles' );
		$fields[] = advay_acf_text_field( 'field_home_map_hub_' . $i . '_drive', $hub_label . ' — drive time', 'home_map_hub_' . $i . '_drive' );
		$fields[] = advay_acf_text_field( 'field_home_map_hub_' . $i . '_market', $hub_label . ' — market label', 'home_map_hub_' . $i . '_market' );
		$fields[] = advay_acf_text_field( 'field_home_map_hub_' . $i . '_meta', $hub_label . ' — meta line', 'home_map_hub_' . $i . '_meta' );
	}

	/* ---- Fit UI chrome ---- */
	$fields[] = array(
		'key'   => 'field_advay_tab_fit_ui',
		'label' => 'Fit tabs / brands link',
		'type'  => 'tab',
	);
	$fields[] = advay_acf_text_field( 'field_home_fit_tab_niche', 'Fit tab — Niche', 'home_fit_tab_niche' );
	$fields[] = advay_acf_text_field( 'field_home_fit_tab_spec', 'Fit tab — Specification', 'home_fit_tab_spec' );
	$fields[] = advay_acf_text_field( 'field_home_brands_read_label', 'Brands — Read Case Study label', 'home_brands_read_label' );

	/* ---- Welcome popup ---- */
	$fields[] = array(
		'key'   => 'field_advay_tab_popup',
		'label' => 'Welcome popup',
		'type'  => 'tab',
	);
	$fields[] = advay_acf_text_field( 'field_home_popup_kicker', 'Popup — kicker', 'home_popup_kicker' );
	$fields[] = advay_acf_text_field( 'field_home_popup_visual_title', 'Popup — visual title', 'home_popup_visual_title' );
	$fields[] = advay_acf_text_field( 'field_home_popup_title', 'Popup — heading', 'home_popup_title' );
	$fields[] = advay_acf_text_field( 'field_home_popup_copy', 'Popup — copy', 'home_popup_copy', 'textarea', 3 );
	$fields[] = advay_acf_text_field( 'field_home_popup_lane_1', 'Popup lane 1', 'home_popup_lane_1' );
	$fields[] = advay_acf_text_field( 'field_home_popup_lane_2', 'Popup lane 2', 'home_popup_lane_2' );
	$fields[] = advay_acf_text_field( 'field_home_popup_lane_3', 'Popup lane 3', 'home_popup_lane_3' );
	$fields[] = array(
		'key'           => 'field_home_popup_cta_primary',
		'label'         => 'Popup — primary CTA',
		'name'          => 'home_popup_cta_primary',
		'type'          => 'link',
		'return_format' => 'array',
	);
	$fields[] = array(
		'key'           => 'field_home_popup_cta_secondary',
		'label'         => 'Popup — secondary CTA',
		'name'          => 'home_popup_cta_secondary',
		'type'          => 'link',
		'return_format' => 'array',
	);
	$fields[] = advay_acf_image_field( 'field_home_popup_image', 'Popup — image', 'home_popup_image' );

	/* ---- Partner pills + success CTAs ---- */
	$fields[] = array(
		'key'   => 'field_advay_tab_misc_cta',
		'label' => 'Pills & success CTAs',
		'type'  => 'tab',
	);
	$fields[] = advay_acf_text_field( 'field_home_pill_1', 'Partner pill 1 label', 'home_pill_1_label' );
	$fields[] = advay_acf_text_field( 'field_home_pill_2', 'Partner pill 2 label', 'home_pill_2_label' );
	$fields[] = advay_acf_text_field( 'field_home_pill_3', 'Partner pill 3 label', 'home_pill_3_label' );
	$fields[] = array(
		'key'           => 'field_home_success_cta_primary',
		'label'         => 'Client success — primary CTA',
		'name'          => 'home_success_cta_primary',
		'type'          => 'link',
		'return_format' => 'array',
	);
	$fields[] = array(
		'key'           => 'field_home_success_cta_secondary',
		'label'         => 'Client success — secondary CTA',
		'name'          => 'home_success_cta_secondary',
		'type'          => 'link',
		'return_format' => 'array',
	);

	acf_add_local_field_group(
		array(
			'key'                   => 'group_advay_homepage_complete',
			'title'                 => 'Homepage — Extended Content',
			'fields'                => $fields,
			'location'              => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'advay-site-content',
					),
				),
			),
			'menu_order'            => 2,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
			'show_in_rest'          => 0,
		)
	);
}
add_action( 'acf/init', 'advay_register_homepage_complete_acf_fields' );
