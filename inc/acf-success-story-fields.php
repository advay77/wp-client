<?php
/**
 * ACF Free field group for success_story CPT.
 *
 * Fixed-count slots (no Repeaters) matching the PHP array shape in
 * inc/success-stories.php.
 *
 * @package Advay_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Icon choices shared by strategy / result cards.
 *
 * @return array<string, string>
 */
function advay_success_story_icon_choices() {
	return array(
		'receive'       => 'Receive',
		'target'        => 'Target',
		'funnel'        => 'Funnel',
		'growth'        => 'Growth',
		'arrow-circle'  => 'Arrow circle',
		'clock-circle'  => 'Clock circle',
		'chart-bars'    => 'Chart bars',
		'dollar-circle' => 'Dollar circle',
		'warn-triangle' => 'Warn triangle',
		'insight-head'  => 'Insight',
		'box'           => 'Box',
		'shield'        => 'Shield',
		'forward'       => 'Forward',
	);
}

/**
 * Register Success Story ACF Free fields.
 */
function advay_register_success_story_acf_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	$icons  = advay_success_story_icon_choices();
	$fields = array(
		array(
			'key'   => 'field_ss_tab_hero',
			'label' => 'Hero',
			'type'  => 'tab',
		),
		array(
			'key'   => 'field_ss_brand',
			'label' => 'Brand name',
			'name'  => 'ss_brand',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_ss_headline_prefix',
			'label' => 'Headline prefix',
			'name'  => 'ss_headline_prefix',
			'type'  => 'text',
			'instructions' => 'Text before the accent span.',
		),
		array(
			'key'   => 'field_ss_headline_highlight',
			'label' => 'Headline highlight',
			'name'  => 'ss_headline_highlight',
			'type'  => 'text',
			'instructions' => 'Accented part of the H1.',
		),
		array(
			'key'   => 'field_ss_lead',
			'label' => 'Hero description',
			'name'  => 'ss_lead',
			'type'  => 'textarea',
			'rows'  => 4,
		),
		array(
			'key'           => 'field_ss_hero_image',
			'label'         => 'Hero image',
			'name'          => 'ss_hero_image',
			'type'          => 'image',
			'return_format' => 'array',
			'preview_size'  => 'medium',
			'library'       => 'all',
			'instructions'  => 'Used when no video URL is set. Also set Featured Image for nav cards.',
		),
		array(
			'key'          => 'field_ss_video_url',
			'label'        => 'Testimonial video URL',
			'name'         => 'ss_video_url',
			'type'         => 'url',
			'instructions' => 'Full URL to the MP4 (theme asset or Media Library file URL). Leave empty for image-only hero.',
		),
		array(
			'key'   => 'field_ss_tab_before',
			'label' => 'Before EPC',
			'type'  => 'tab',
		),
		array(
			'key'   => 'field_ss_before_heading',
			'label' => 'Before section heading',
			'name'  => 'ss_before_heading',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_ss_before_1',
			'label' => 'Before item 1',
			'name'  => 'ss_before_1',
			'type'  => 'textarea',
			'rows'  => 2,
		),
		array(
			'key'   => 'field_ss_before_2',
			'label' => 'Before item 2',
			'name'  => 'ss_before_2',
			'type'  => 'textarea',
			'rows'  => 2,
		),
		array(
			'key'   => 'field_ss_insight_lead',
			'label' => 'Insight — lead',
			'name'  => 'ss_insight_lead',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_ss_insight_bold',
			'label' => 'Insight — bold phrase',
			'name'  => 'ss_insight_bold',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_ss_insight_tail',
			'label' => 'Insight — tail',
			'name'  => 'ss_insight_tail',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_ss_tab_strategy',
			'label' => 'What EPC did',
			'type'  => 'tab',
		),
		array(
			'key'   => 'field_ss_strategies_heading',
			'label' => 'Strategy section heading',
			'name'  => 'ss_strategies_heading',
			'type'  => 'text',
		),
	);

	for ( $i = 1; $i <= 5; $i++ ) {
		$fields[] = array(
			'key'     => 'field_ss_strategy_' . $i . '_icon',
			'label'   => sprintf( 'Strategy %d — icon', $i ),
			'name'    => 'ss_strategy_' . $i . '_icon',
			'type'    => 'select',
			'choices' => $icons,
			'default_value' => 'target',
			'allow_null' => 0,
		);
		$fields[] = array(
			'key'   => 'field_ss_strategy_' . $i . '_title',
			'label' => sprintf( 'Strategy %d — title', $i ),
			'name'  => 'ss_strategy_' . $i . '_title',
			'type'  => 'text',
		);
		$fields[] = array(
			'key'   => 'field_ss_strategy_' . $i . '_text',
			'label' => sprintf( 'Strategy %d — text', $i ),
			'name'  => 'ss_strategy_' . $i . '_text',
			'type'  => 'textarea',
			'rows'  => 3,
		);
	}

	$fields[] = array(
		'key'   => 'field_ss_tab_results',
		'label' => 'Results',
		'type'  => 'tab',
	);
	$fields[] = array(
		'key'   => 'field_ss_results_summary',
		'label' => 'Results summary',
		'name'  => 'ss_results_summary',
		'type'  => 'textarea',
		'rows'  => 3,
	);

	for ( $i = 1; $i <= 4; $i++ ) {
		$fields[] = array(
			'key'     => 'field_ss_result_' . $i . '_icon',
			'label'   => sprintf( 'Result %d — icon', $i ),
			'name'    => 'ss_result_' . $i . '_icon',
			'type'    => 'select',
			'choices' => $icons,
			'default_value' => 'chart-bars',
		);
		$fields[] = array(
			'key'   => 'field_ss_result_' . $i . '_value',
			'label' => sprintf( 'Result %d — value', $i ),
			'name'  => 'ss_result_' . $i . '_value',
			'type'  => 'text',
		);
		$fields[] = array(
			'key'   => 'field_ss_result_' . $i . '_label',
			'label' => sprintf( 'Result %d — label', $i ),
			'name'  => 'ss_result_' . $i . '_label',
			'type'  => 'text',
		);
		$fields[] = array(
			'key'   => 'field_ss_result_' . $i . '_sublabel',
			'label' => sprintf( 'Result %d — sublabel (optional)', $i ),
			'name'  => 'ss_result_' . $i . '_sublabel',
			'type'  => 'text',
		);
	}

	$fields[] = array(
		'key'   => 'field_ss_tab_quote',
		'label' => 'Quote / founder',
		'type'  => 'tab',
	);
	$fields[] = array(
		'key'   => 'field_ss_quote',
		'label' => 'Quote',
		'name'  => 'ss_quote',
		'type'  => 'textarea',
		'rows'  => 3,
	);
	$fields[] = array(
		'key'   => 'field_ss_founder',
		'label' => 'Founder / attribution name',
		'name'  => 'ss_founder',
		'type'  => 'text',
	);
	$fields[] = array(
		'key'   => 'field_ss_founder_role',
		'label' => 'Founder role',
		'name'  => 'ss_founder_role',
		'type'  => 'text',
	);
	$fields[] = array(
		'key'   => 'field_ss_founder_caption',
		'label' => 'Portrait caption',
		'name'  => 'ss_founder_caption',
		'type'  => 'text',
	);
	$fields[] = array(
		'key'           => 'field_ss_founder_image',
		'label'         => 'Founder / portrait image',
		'name'          => 'ss_founder_image',
		'type'          => 'image',
		'return_format' => 'array',
		'preview_size'  => 'medium',
		'library'       => 'all',
	);

	$fields[] = array(
		'key'   => 'field_ss_tab_transform',
		'label' => 'Transformation',
		'type'  => 'tab',
	);

	for ( $i = 1; $i <= 4; $i++ ) {
		$fields[] = array(
			'key'   => 'field_ss_transform_before_' . $i,
			'label' => sprintf( 'Before column — item %d', $i ),
			'name'  => 'ss_transform_before_' . $i,
			'type'  => 'text',
		);
	}
	for ( $i = 1; $i <= 4; $i++ ) {
		$fields[] = array(
			'key'   => 'field_ss_transform_after_' . $i,
			'label' => sprintf( 'After column — item %d', $i ),
			'name'  => 'ss_transform_after_' . $i,
			'type'  => 'text',
		);
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_advay_success_story',
			'title'                 => 'Success Story Content',
			'fields'                => $fields,
			'location'              => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'success_story',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
		)
	);
}
add_action( 'acf/init', 'advay_register_success_story_acf_fields' );
