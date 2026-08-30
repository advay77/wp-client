<?php
/**
 * ACF Free field groups for Phase 4 marketing pages.
 *
 * Attached via Page Template. Editors must create the WP Page (matching slug)
 * and assign the corresponding template — the theme never auto-creates Pages.
 *
 * @package Advay_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Location rule: Page Template equals theme file.
 *
 * @param string $template Relative template file (e.g. page-receiving.php).
 * @return array<int, array<int, array<string, string>>>
 */
function advay_acf_location_page_template( $template ) {
	return array(
		array(
			array(
				'param'    => 'page_template',
				'operator' => '==',
				'value'    => $template,
			),
		),
	);
}

/**
 * Register Phase 4 page field groups.
 */
function advay_register_marketing_page_acf_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	/* ---------- Receiving ---------- */
	$recv = array(
		array( 'key' => 'field_recv_tab_intro', 'label' => 'Intro', 'type' => 'tab' ),
		advay_acf_text_field( 'field_recv_eyebrow', 'Eyebrow', 'receiving_eyebrow' ),
		advay_acf_text_field( 'field_recv_heading', 'Heading', 'receiving_heading' ),
		advay_acf_text_field( 'field_recv_lede', 'Description', 'receiving_lede', 'textarea', 3 ),
		advay_acf_text_field( 'field_recv_scroll_hint', 'Scroll hint', 'receiving_scroll_hint' ),
		advay_acf_text_field( 'field_recv_video', 'Intro video URL', 'receiving_video_url', 'url' ),
		array( 'key' => 'field_recv_tab_stations', 'label' => 'Stations', 'type' => 'tab' ),
	);
	for ( $i = 1; $i <= 5; $i++ ) {
		$recv[] = advay_acf_text_field( 'field_recv_st_' . $i . '_tag', 'Station ' . $i . ' — label', 'receiving_station_' . $i . '_tag' );
		$recv[] = advay_acf_text_field( 'field_recv_st_' . $i . '_title', 'Station ' . $i . ' — title', 'receiving_station_' . $i . '_title' );
		$recv[] = advay_acf_text_field( 'field_recv_st_' . $i . '_description', 'Station ' . $i . ' — description', 'receiving_station_' . $i . '_description', 'textarea', 3 );
	}
	$recv[] = array( 'key' => 'field_recv_tab_cta', 'label' => 'CTA', 'type' => 'tab' );
	$recv[] = advay_acf_text_field( 'field_recv_cta_heading', 'CTA heading', 'receiving_cta_heading' );
	$recv[] = advay_acf_text_field( 'field_recv_cta_copy', 'CTA copy', 'receiving_cta_copy', 'textarea', 2 );
	$recv[] = array(
		'key'           => 'field_recv_cta_primary',
		'label'         => 'Primary CTA',
		'name'          => 'receiving_cta_primary',
		'type'          => 'link',
		'return_format' => 'array',
	);
	$recv[] = array(
		'key'           => 'field_recv_cta_secondary',
		'label'         => 'Secondary CTA',
		'name'          => 'receiving_cta_secondary',
		'type'          => 'link',
		'return_format' => 'array',
	);

	acf_add_local_field_group(
		array(
			'key'      => 'group_advay_receiving',
			'title'    => 'Receiving Page Content',
			'fields'   => $recv,
			'location' => advay_acf_location_page_template( 'page-receiving.php' ),
			'active'   => true,
		)
	);

	/* ---------- Onboarding ---------- */
	$ob = array(
		array( 'key' => 'field_ob_tab_hero', 'label' => 'Hero', 'type' => 'tab' ),
		advay_acf_text_field( 'field_ob_eyebrow', 'Eyebrow', 'onboarding_eyebrow' ),
		advay_acf_text_field( 'field_ob_heading', 'Heading', 'onboarding_heading' ),
		advay_acf_text_field( 'field_ob_lead', 'Lead', 'onboarding_lead', 'textarea', 3 ),
		array( 'key' => 'field_ob_tab_steps', 'label' => 'Steps', 'type' => 'tab' ),
	);
	for ( $i = 1; $i <= 4; $i++ ) {
		$ob[] = advay_acf_text_field( 'field_ob_step_' . $i . '_label', 'Step ' . $i . ' — short label', 'onboarding_step_' . $i . '_label' );
		$ob[] = advay_acf_text_field( 'field_ob_step_' . $i . '_title', 'Step ' . $i . ' — title', 'onboarding_step_' . $i . '_title' );
		$ob[] = advay_acf_text_field( 'field_ob_step_' . $i . '_text', 'Step ' . $i . ' — description', 'onboarding_step_' . $i . '_text', 'textarea', 3 );
		$ob[] = advay_acf_text_field( 'field_ob_step_' . $i . '_drawer', 'Step ' . $i . ' — drawer label', 'onboarding_step_' . $i . '_drawer_label' );
		for ( $j = 1; $j <= 3; $j++ ) {
			$ob[] = advay_acf_text_field( 'field_ob_step_' . $i . '_item_' . $j, 'Step ' . $i . ' — drawer item ' . $j, 'onboarding_step_' . $i . '_item_' . $j, 'textarea', 2 );
		}
	}
	/* Step 1 contact pill labels (URLs from global contact helpers). */
	$ob[] = array( 'key' => 'field_ob_tab_pills', 'label' => 'Step 1 contact pills', 'type' => 'tab' );
	$ob[] = advay_acf_text_field( 'field_ob_pill_call', 'Call pill label', 'onboarding_pill_call_label' );
	$ob[] = advay_acf_text_field( 'field_ob_pill_email', 'Email pill label', 'onboarding_pill_email_label' );
	$ob[] = advay_acf_text_field( 'field_ob_pill_wa', 'WhatsApp pill label', 'onboarding_pill_whatsapp_label' );
	$ob[] = advay_acf_text_field( 'field_ob_pill_form', 'Form pill label', 'onboarding_pill_form_label' );
	$ob[] = advay_acf_text_field( 'field_ob_pill_book', 'Book MD pill label', 'onboarding_pill_book_label' );
	$ob[] = array( 'key' => 'field_ob_tab_final', 'label' => 'Final CTA', 'type' => 'tab' );
	$ob[] = advay_acf_text_field( 'field_ob_final_heading', 'Final heading', 'onboarding_final_heading' );
	$ob[] = advay_acf_text_field( 'field_ob_final_copy', 'Final copy', 'onboarding_final_copy', 'textarea', 2 );
	$ob[] = array(
		'key'           => 'field_ob_final_primary',
		'label'         => 'Primary CTA',
		'name'          => 'onboarding_final_primary',
		'type'          => 'link',
		'return_format' => 'array',
	);
	$ob[] = array(
		'key'           => 'field_ob_final_secondary',
		'label'         => 'Secondary CTA',
		'name'          => 'onboarding_final_secondary',
		'type'          => 'link',
		'return_format' => 'array',
	);

	acf_add_local_field_group(
		array(
			'key'      => 'group_advay_onboarding',
			'title'    => 'Onboarding Page Content',
			'fields'   => $ob,
			'location' => advay_acf_location_page_template( 'page-onboarding.php' ),
			'active'   => true,
		)
	);

	/* ---------- Our Story ---------- */
	$os = array(
		array( 'key' => 'field_os_tab_intro', 'label' => 'Intro', 'type' => 'tab' ),
		advay_acf_text_field( 'field_os_eyebrow', 'Eyebrow', 'our_story_eyebrow' ),
		advay_acf_text_field( 'field_os_heading', 'Heading (before accent)', 'our_story_heading' ),
		advay_acf_text_field( 'field_os_heading_accent', 'Heading accent', 'our_story_heading_accent' ),
		advay_acf_text_field( 'field_os_heading_after', 'Heading (after accent)', 'our_story_heading_after' ),
		advay_acf_text_field( 'field_os_aside', 'Intro aside', 'our_story_aside', 'textarea', 4 ),
		array( 'key' => 'field_os_tab_values', 'label' => 'Values', 'type' => 'tab' ),
		advay_acf_text_field( 'field_os_values_kicker', 'Values kicker', 'our_story_values_kicker' ),
	);
	for ( $i = 1; $i <= 3; $i++ ) {
		$os[] = advay_acf_text_field( 'field_os_value_' . $i . '_title', 'Value ' . $i . ' — title', 'our_story_value_' . $i . '_title' );
		$os[] = advay_acf_text_field( 'field_os_value_' . $i . '_text', 'Value ' . $i . ' — text', 'our_story_value_' . $i . '_text', 'textarea', 2 );
	}
	$os[] = array( 'key' => 'field_os_tab_mv', 'label' => 'Mission & Vision', 'type' => 'tab' );
	$os[] = advay_acf_text_field( 'field_os_mission_label', 'Mission label', 'our_story_mission_label' );
	$os[] = advay_acf_text_field( 'field_os_mission', 'Mission text', 'our_story_mission', 'textarea', 4 );
	$os[] = advay_acf_text_field( 'field_os_vision_label', 'Vision label', 'our_story_vision_label' );
	$os[] = advay_acf_text_field( 'field_os_vision', 'Vision text', 'our_story_vision', 'textarea', 4 );
	$os[] = array( 'key' => 'field_os_tab_timeline', 'label' => 'Timeline', 'type' => 'tab' );
	$os[] = advay_acf_text_field( 'field_os_tl_eyebrow', 'Timeline eyebrow', 'our_story_timeline_eyebrow' );
	$os[] = advay_acf_text_field( 'field_os_tl_heading', 'Timeline heading', 'our_story_timeline_heading' );
	$os[] = advay_acf_text_field( 'field_os_tl_lead', 'Timeline lead', 'our_story_timeline_lead', 'textarea', 3 );
	for ( $i = 1; $i <= 5; $i++ ) {
		$os[] = advay_acf_text_field( 'field_os_ms_' . $i . '_year', 'Milestone ' . $i . ' — year', 'our_story_milestone_' . $i . '_year' );
		$os[] = advay_acf_text_field( 'field_os_ms_' . $i . '_title', 'Milestone ' . $i . ' — title', 'our_story_milestone_' . $i . '_title' );
		$os[] = advay_acf_text_field( 'field_os_ms_' . $i . '_text', 'Milestone ' . $i . ' — text', 'our_story_milestone_' . $i . '_text', 'textarea', 3 );
	}
	$os[] = array( 'key' => 'field_os_tab_gallery', 'label' => 'Gallery', 'type' => 'tab' );
	$os[] = advay_acf_text_field( 'field_os_gal_heading', 'Gallery heading', 'our_story_gallery_heading' );
	$os[] = advay_acf_text_field( 'field_os_gal_lead', 'Gallery lead', 'our_story_gallery_lead', 'textarea', 2 );
	for ( $i = 1; $i <= 6; $i++ ) {
		$os[] = advay_acf_image_field( 'field_os_gal_' . $i, 'Gallery image ' . $i, 'our_story_gallery_' . $i );
	}
	$os[] = array( 'key' => 'field_os_tab_cta', 'label' => 'CTA', 'type' => 'tab' );
	$os[] = advay_acf_text_field( 'field_os_cta_heading', 'CTA heading', 'our_story_cta_heading' );
	$os[] = array(
		'key'           => 'field_os_cta_primary',
		'label'         => 'Primary CTA',
		'name'          => 'our_story_cta_primary',
		'type'          => 'link',
		'return_format' => 'array',
	);
	$os[] = array(
		'key'           => 'field_os_cta_secondary',
		'label'         => 'Secondary CTA',
		'name'          => 'our_story_cta_secondary',
		'type'          => 'link',
		'return_format' => 'array',
	);

	acf_add_local_field_group(
		array(
			'key'      => 'group_advay_our_story',
			'title'    => 'Our Story Page Content',
			'fields'   => $os,
			'location' => advay_acf_location_page_template( 'page-our-story.php' ),
			'active'   => true,
		)
	);

	/* ---------- Managing Director ---------- */
	$md = array(
		array( 'key' => 'field_md_tab_hero', 'label' => 'Hero', 'type' => 'tab' ),
		advay_acf_text_field( 'field_md_kicker', 'Kicker', 'md_kicker' ),
		advay_acf_text_field( 'field_md_heading', 'Heading', 'md_heading', 'textarea', 2 ),
		advay_acf_text_field( 'field_md_lead', 'Lead', 'md_lead', 'textarea', 3 ),
		advay_acf_image_field( 'field_md_hero_image', 'Hero portrait', 'md_hero_image' ),
		array(
			'key'           => 'field_md_hero_cta_1',
			'label'         => 'Hero CTA 1',
			'name'          => 'md_hero_cta_1',
			'type'          => 'link',
			'return_format' => 'array',
		),
		array(
			'key'           => 'field_md_hero_cta_2',
			'label'         => 'Hero CTA 2',
			'name'          => 'md_hero_cta_2',
			'type'          => 'link',
			'return_format' => 'array',
		),
		array( 'key' => 'field_md_tab_about', 'label' => 'About', 'type' => 'tab' ),
		advay_acf_text_field( 'field_md_about_heading', 'About heading', 'md_about_heading' ),
		advay_acf_text_field( 'field_md_about_p1', 'About paragraph 1', 'md_about_p1', 'textarea', 4 ),
		advay_acf_text_field( 'field_md_about_closer', 'About closer', 'md_about_closer' ),
		advay_acf_image_field( 'field_md_about_image', 'About image', 'md_about_image' ),
		array( 'key' => 'field_md_tab_journey', 'label' => 'Journey', 'type' => 'tab' ),
		advay_acf_text_field( 'field_md_journey_heading', 'Journey heading', 'md_journey_heading' ),
	);
	for ( $i = 1; $i <= 5; $i++ ) {
		$md[] = advay_acf_text_field( 'field_md_ms_' . $i . '_year', 'Milestone ' . $i . ' — year', 'md_milestone_' . $i . '_year' );
		$md[] = advay_acf_text_field( 'field_md_ms_' . $i . '_title', 'Milestone ' . $i . ' — title', 'md_milestone_' . $i . '_title' );
		$md[] = advay_acf_text_field( 'field_md_ms_' . $i . '_text', 'Milestone ' . $i . ' — text', 'md_milestone_' . $i . '_text', 'textarea', 3 );
		$md[] = advay_acf_image_field( 'field_md_ms_' . $i . '_image', 'Milestone ' . $i . ' — image', 'md_milestone_' . $i . '_image' );
	}
	$md[] = array( 'key' => 'field_md_tab_brand', 'label' => 'Brand', 'type' => 'tab' );
	$md[] = advay_acf_text_field( 'field_md_brand_heading', 'Brand heading', 'md_brand_heading' );
	$md[] = advay_acf_text_field( 'field_md_brand_text', 'Brand text', 'md_brand_text', 'textarea', 4 );
	$md[] = advay_acf_image_field( 'field_md_brand_image', 'Brand image', 'md_brand_image' );
	$md[] = array(
		'key'           => 'field_md_brand_cta',
		'label'         => 'Brand CTA',
		'name'          => 'md_brand_cta',
		'type'          => 'link',
		'return_format' => 'array',
	);
	$md[] = array( 'key' => 'field_md_tab_chain', 'label' => 'Business chain', 'type' => 'tab' );
	$md[] = advay_acf_text_field( 'field_md_chain_heading', 'Chain heading', 'md_chain_heading' );
	$md[] = advay_acf_text_field( 'field_md_chain_lead', 'Chain lead', 'md_chain_lead', 'textarea', 2 );
	for ( $i = 1; $i <= 6; $i++ ) {
		$md[] = advay_acf_text_field( 'field_md_chain_' . $i, 'Chain step ' . $i . ' label', 'md_chain_' . $i . '_label' );
	}
	$md[] = array( 'key' => 'field_md_tab_numbers', 'label' => 'Numbers', 'type' => 'tab' );
	$md[] = advay_acf_text_field( 'field_md_numbers_heading', 'Numbers heading', 'md_numbers_heading' );
	$md[] = advay_acf_text_field( 'field_md_numbers_footer', 'Numbers footer text', 'md_numbers_footer', 'textarea', 3 );
	for ( $i = 1; $i <= 4; $i++ ) {
		$md[] = advay_acf_text_field( 'field_md_stat_' . $i . '_value', 'Stat ' . $i . ' — value', 'md_stat_' . $i . '_value' );
		$md[] = advay_acf_text_field( 'field_md_stat_' . $i . '_label', 'Stat ' . $i . ' — label', 'md_stat_' . $i . '_label' );
	}
	$md[] = array( 'key' => 'field_md_tab_philosophy', 'label' => 'Philosophy', 'type' => 'tab' );
	$md[] = advay_acf_text_field( 'field_md_phil_heading', 'Philosophy heading', 'md_philosophy_heading' );
	$md[] = advay_acf_text_field( 'field_md_phil_quote', 'Philosophy quote', 'md_philosophy_quote', 'textarea', 3 );
	for ( $i = 1; $i <= 4; $i++ ) {
		$md[] = advay_acf_text_field( 'field_md_phil_' . $i . '_title', 'Value ' . $i . ' — title', 'md_philosophy_' . $i . '_title' );
		$md[] = advay_acf_text_field( 'field_md_phil_' . $i . '_text', 'Value ' . $i . ' — text', 'md_philosophy_' . $i . '_text' );
	}
	$md[] = array( 'key' => 'field_md_tab_legacy', 'label' => 'Legacy', 'type' => 'tab' );
	$md[] = advay_acf_text_field( 'field_md_legacy_heading', 'Legacy heading', 'md_legacy_heading' );
	$md[] = advay_acf_text_field( 'field_md_legacy_text', 'Legacy text', 'md_legacy_text', 'textarea', 2 );
	for ( $i = 1; $i <= 3; $i++ ) {
		$md[] = advay_acf_text_field( 'field_md_legacy_p_' . $i, 'Legacy pillar ' . $i, 'md_legacy_pillar_' . $i );
		$md[] = advay_acf_image_field( 'field_md_legacy_img_' . $i, 'Legacy photo ' . $i, 'md_legacy_photo_' . $i );
	}
	$md[] = array( 'key' => 'field_md_tab_future', 'label' => 'Future', 'type' => 'tab' );
	$md[] = advay_acf_text_field( 'field_md_future_heading', 'Future heading', 'md_future_heading' );
	$md[] = advay_acf_text_field( 'field_md_future_lead', 'Future lead', 'md_future_lead', 'textarea', 2 );
	for ( $i = 1; $i <= 3; $i++ ) {
		$md[] = advay_acf_text_field( 'field_md_future_' . $i, 'Future card ' . $i . ' title', 'md_future_' . $i . '_title' );
	}
	$md[] = array( 'key' => 'field_md_tab_connect', 'label' => 'Connect', 'type' => 'tab' );
	$md[] = advay_acf_text_field( 'field_md_connect_heading', 'Connect heading', 'md_connect_heading' );
	$md[] = advay_acf_text_field( 'field_md_connect_text', 'Connect text', 'md_connect_text', 'textarea', 3 );
	$md[] = array(
		'key'           => 'field_md_connect_cta',
		'label'         => 'Connect CTA',
		'name'          => 'md_connect_cta',
		'type'          => 'link',
		'return_format' => 'array',
	);

	acf_add_local_field_group(
		array(
			'key'      => 'group_advay_managing_director',
			'title'    => 'Managing Director Page Content',
			'fields'   => $md,
			'location' => advay_acf_location_page_template( 'page-managing-director.php' ),
			'active'   => true,
		)
	);

	/* ---------- Quote (Instant Quote) ---------- */
	$quote = array(
		array( 'key' => 'field_quote_tab_hero', 'label' => 'Hero', 'type' => 'tab' ),
		advay_acf_text_field( 'field_quote_eyebrow', 'Eyebrow', 'quote_eyebrow' ),
		advay_acf_text_field( 'field_quote_heading', 'Heading (H1)', 'quote_heading' ),
		advay_acf_text_field( 'field_quote_lead', 'Supporting line', 'quote_lead', 'textarea', 3 ),
		array( 'key' => 'field_quote_tab_points', 'label' => 'Reassurance points', 'type' => 'tab' ),
	);
	for ( $i = 1; $i <= 3; $i++ ) {
		$quote[] = advay_acf_text_field( 'field_quote_pt_' . $i . '_value', 'Point ' . $i . ' — headline', 'quote_point_' . $i . '_value' );
		$quote[] = advay_acf_text_field( 'field_quote_pt_' . $i . '_label', 'Point ' . $i . ' — label', 'quote_point_' . $i . '_label' );
		$quote[] = advay_acf_text_field( 'field_quote_pt_' . $i . '_note', 'Point ' . $i . ' — note', 'quote_point_' . $i . '_note' );
	}
	$quote[] = array( 'key' => 'field_quote_tab_form', 'label' => 'Form', 'type' => 'tab' );
	$quote[] = advay_acf_text_field( 'field_quote_form_intro', 'Form intro line', 'quote_form_intro', 'textarea', 2 );
	$quote[] = array( 'key' => 'field_quote_tab_alt', 'label' => 'Talk instead', 'type' => 'tab' );
	$quote[] = advay_acf_text_field( 'field_quote_alt_heading', 'Alternate path heading', 'quote_alt_heading' );
	$quote[] = advay_acf_text_field( 'field_quote_alt_lead', 'Alternate path lead', 'quote_alt_lead', 'textarea', 2 );

	acf_add_local_field_group(
		array(
			'key'      => 'group_advay_quote',
			'title'    => 'Quote Page Content',
			'fields'   => $quote,
			'location' => advay_acf_location_page_template( 'page-quote.php' ),
			'active'   => true,
		)
	);

	$pricing_fields = array(
		array(
			'key'   => 'field_pricing_hl_tab',
			'label' => 'Hero highlights',
			'type'  => 'tab',
		),
		array(
			'key'   => 'field_pricing_hl_note',
			'label' => 'Note',
			'type'  => 'message',
			'message' => 'These four cards sit above the rate table. Leave a field empty to keep the current hardcoded default. Does not change Pricing Rates CPT rows.',
		),
	);

	for ( $i = 1; $i <= 4; $i++ ) {
		$pricing_fields[] = array(
			'key'   => 'field_pricing_hl_' . $i . '_value',
			'label' => 'Highlight ' . $i . ' value',
			'name'  => 'pricing_highlight_' . $i . '_value',
			'type'  => 'text',
			'instructions' => 'Large figure (e.g. $1.00).',
		);
		$pricing_fields[] = array(
			'key'   => 'field_pricing_hl_' . $i . '_label',
			'label' => 'Highlight ' . $i . ' eyebrow',
			'name'  => 'pricing_highlight_' . $i . '_label',
			'type'  => 'text',
			'instructions' => 'Small label above the figure (e.g. Item prep from).',
		);
		$pricing_fields[] = array(
			'key'   => 'field_pricing_hl_' . $i . '_note',
			'label' => 'Highlight ' . $i . ' note',
			'name'  => 'pricing_highlight_' . $i . '_note',
			'type'  => 'text',
			'instructions' => 'Supporting line under the figure.',
		);
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_advay_pricing_page',
			'title'    => 'Pricing Page Highlights',
			'fields'   => $pricing_fields,
			'location' => advay_acf_location_page_template( 'page-pricing.php' ),
			'active'   => true,
		)
	);
}
add_action( 'acf/init', 'advay_register_marketing_page_acf_fields' );
