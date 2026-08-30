<?php
/**
 * ACF field groups + helpers for editable theme content.
 *
 * Fields are registered in PHP so they ship with the theme.
 * Empty fields fall back to existing hardcoded theme defaults.
 *
 * @package Advay_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ACF post_id for homepage + site contact fields.
 *
 * Uses the options store (editable under WP Admin → ElitePrep Content)
 * so fields work even when no static front page is set. Does not create pages.
 *
 * @return string
 */
function advay_acf_front_id() {
	return 'option';
}

/**
 * Read an ACF field with a typed fallback when ACF is missing or the field is empty.
 *
 * @param string     $key      Field name.
 * @param mixed      $fallback Default when empty.
 * @param int|false  $post_id  Post ID, or false for current. Use advay_acf_front_id() for homepage fields.
 * @return mixed
 */
function advay_get_acf( $key, $fallback = '', $post_id = false ) {
	if ( ! function_exists( 'get_field' ) ) {
		return $fallback;
	}

	$value = false === $post_id ? get_field( $key ) : get_field( $key, $post_id );

	if ( null === $value || false === $value || '' === $value ) {
		return $fallback;
	}

	if ( is_array( $value ) && empty( $value ) ) {
		return $fallback;
	}

	return $value;
}

/**
 * ACF image field → URL string (supports array / ID / URL return formats).
 *
 * @param mixed  $image    ACF image value.
 * @param string $fallback Fallback URL.
 * @param string $size     Image size when ID/array.
 * @return string
 */
function advay_acf_image_url( $image, $fallback = '', $size = 'full' ) {
	if ( empty( $image ) ) {
		return $fallback;
	}

	if ( is_numeric( $image ) ) {
		$url = wp_get_attachment_image_url( (int) $image, $size );
		return $url ? $url : $fallback;
	}

	if ( is_array( $image ) ) {
		if ( ! empty( $image['sizes'][ $size ] ) ) {
			return $image['sizes'][ $size ];
		}
		if ( ! empty( $image['url'] ) ) {
			return $image['url'];
		}
		if ( ! empty( $image['ID'] ) ) {
			$url = wp_get_attachment_image_url( (int) $image['ID'], $size );
			return $url ? $url : $fallback;
		}
	}

	if ( is_string( $image ) ) {
		return $image;
	}

	return $fallback;
}

/**
 * ACF image field → alt text.
 *
 * @param mixed  $image    ACF image value.
 * @param string $fallback Fallback alt.
 * @return string
 */
function advay_acf_image_alt( $image, $fallback = '' ) {
	if ( is_array( $image ) && isset( $image['alt'] ) && '' !== (string) $image['alt'] ) {
		return (string) $image['alt'];
	}

	$id = 0;
	if ( is_numeric( $image ) ) {
		$id = (int) $image;
	} elseif ( is_array( $image ) && ! empty( $image['ID'] ) ) {
		$id = (int) $image['ID'];
	}

	if ( $id ) {
		$alt = get_post_meta( $id, '_wp_attachment_image_alt', true );
		if ( is_string( $alt ) && '' !== $alt ) {
			return $alt;
		}
	}

	return $fallback;
}

/**
 * Normalize ACF link / URL field to an href string.
 *
 * @param mixed  $link     ACF link array or URL string.
 * @param string $fallback Fallback URL.
 * @return string
 */
function advay_acf_link_url( $link, $fallback = '' ) {
	$url = '';

	if ( ! empty( $link ) ) {
		if ( is_array( $link ) && ! empty( $link['url'] ) ) {
			$url = trim( (string) $link['url'] );
		} elseif ( is_string( $link ) ) {
			$url = trim( $link );
		}
	}

	if ( '' === $url || '#' === $url ) {
		return $fallback;
	}

	/* ACF often stores "#contact" — broken on inner pages without id="contact". */
	if ( '#' === substr( $url, 0, 1 ) ) {
		return rtrim( home_url( '/' ), '/' ) . $url;
	}

	return $url;
}

/**
 * Quote / intake CTAs — ignore stale homepage anchors saved in ACF link fields.
 *
 * @param mixed  $link     ACF link array.
 * @param string $fallback Fallback URL (defaults to /quote/).
 * @return string
 */
function advay_acf_quote_link_url( $link, $fallback = '' ) {
	$fallback = $fallback ? $fallback : advay_quote_url();
	$url      = advay_acf_link_url( $link, $fallback );

	if ( $url === advay_contact_url() || '#contact' === $url ) {
		return $fallback;
	}

	return $url;
}

/**
 * Book-a-call CTAs — ignore stale homepage contact anchors in ACF.
 *
 * @param mixed  $link     ACF link array.
 * @param string $fallback Fallback URL (defaults to Calendly / contact page).
 * @return string
 */
function advay_acf_book_call_link_url( $link, $fallback = '' ) {
	$fallback = $fallback ? $fallback : advay_book_call_url();
	$url      = advay_acf_link_url( $link, $fallback );

	if ( $url === advay_contact_url() || '#contact' === $url ) {
		return $fallback;
	}

	return $url;
}

/**
 * Normalize ACF link field title (button label).
 *
 * @param mixed  $link     ACF link array.
 * @param string $fallback Fallback label.
 * @return string
 */
function advay_acf_link_title( $link, $fallback = '' ) {
	if ( is_array( $link ) && ! empty( $link['title'] ) ) {
		return $link['title'];
	}
	return $fallback;
}

/**
 * Register local ACF field groups.
 */
function advay_register_acf_field_groups() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_advay_homepage',
			'title'                 => 'Homepage Content',
			'fields'                => array(
				array(
					'key'   => 'field_advay_tab_hero',
					'label' => 'Hero',
					'type'  => 'tab',
					'placement' => 'top',
				),
				array(
					'key'          => 'field_advay_home_hero_heading',
					'label'        => 'Hero heading (primary / Amazon tab)',
					'name'         => 'home_hero_heading',
					'type'         => 'text',
					'instructions' => 'Overrides the first marketplace tab headline. Leave empty to keep the theme default.',
				),
				array(
					'key'          => 'field_advay_home_hero_description',
					'label'        => 'Hero description (primary / Amazon tab)',
					'name'         => 'home_hero_description',
					'type'         => 'textarea',
					'rows'         => 4,
					'instructions' => 'Overrides the first marketplace tab body copy.',
				),
				array(
					'key'           => 'field_advay_home_hero_image',
					'label'         => 'Hero poster image',
					'name'          => 'home_hero_image',
					'type'          => 'image',
					'return_format' => 'array',
					'preview_size'  => 'medium',
					'library'       => 'all',
					'instructions'  => 'Optional poster shown behind / before the hero video. Uses Media Library alt text.',
				),
				array(
					'key'           => 'field_advay_home_hero_cta',
					'label'         => 'Hero primary CTA',
					'name'          => 'home_hero_cta',
					'type'          => 'link',
					'return_format' => 'array',
					'instructions'  => 'Button label + URL for the primary hero CTA (defaults to Grow with ElitePrep → #contact).',
				),
				array(
					'key'           => 'field_advay_home_hero_cta_secondary',
					'label'         => 'Hero secondary CTA',
					'name'          => 'home_hero_cta_secondary',
					'type'          => 'link',
					'return_format' => 'array',
					'instructions'  => 'Button label + URL for the secondary hero CTA (defaults to Learn more → /receiving/).',
				),
				array(
					'key'   => 'field_advay_tab_partner',
					'label' => 'Partner intro',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_advay_home_partner_line1',
					'label' => 'Partner heading line 1',
					'name'  => 'home_partner_line1',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_advay_home_partner_line2',
					'label' => 'Partner heading line 2',
					'name'  => 'home_partner_line2',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_advay_tab_hub',
					'label' => 'Hub section',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_advay_home_hub_who_kicker',
					'label' => 'Who we are — kicker',
					'name'  => 'home_hub_who_kicker',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_advay_home_hub_who_heading',
					'label' => 'Who we are — heading',
					'name'  => 'home_hub_who_heading',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_advay_home_hub_who_lead',
					'label' => 'Who we are — description',
					'name'  => 'home_hub_who_lead',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'   => 'field_advay_home_hub_what_kicker',
					'label' => 'What we do — kicker',
					'name'  => 'home_hub_what_kicker',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_advay_home_hub_what_heading',
					'label' => 'What we do — heading',
					'name'  => 'home_hub_what_heading',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_advay_home_hub_what_lead',
					'label' => 'What we do — description',
					'name'  => 'home_hub_what_lead',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'   => 'field_advay_home_hub_how_kicker',
					'label' => 'How to get started — kicker',
					'name'  => 'home_hub_how_kicker',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_advay_home_hub_how_heading',
					'label' => 'How to get started — heading',
					'name'  => 'home_hub_how_heading',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_advay_home_hub_how_lead',
					'label' => 'How to get started — description',
					'name'  => 'home_hub_how_lead',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'   => 'field_advay_tab_success',
					'label' => 'Client success',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_advay_home_success_kicker',
					'label' => 'Kicker',
					'name'  => 'home_success_kicker',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_advay_home_success_heading_1',
					'label' => 'Heading line 1',
					'name'  => 'home_success_heading_1',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_advay_home_success_heading_2',
					'label' => 'Heading line 2 (accent)',
					'name'  => 'home_success_heading_2',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_advay_home_success_p1',
					'label' => 'Paragraph 1',
					'name'  => 'home_success_p1',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'   => 'field_advay_home_success_p2',
					'label' => 'Paragraph 2',
					'name'  => 'home_success_p2',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'           => 'field_advay_home_success_image',
					'label'         => 'Primary portrait image',
					'name'          => 'home_success_image',
					'type'          => 'image',
					'return_format' => 'array',
					'preview_size'  => 'medium',
					'library'       => 'all',
					'instructions'  => 'Replaces the first rotating portrait when set. Alt text comes from the Media Library.',
				),
				array(
					'key'   => 'field_advay_home_success_caption',
					'label' => 'Portrait caption',
					'name'  => 'home_success_caption',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_advay_tab_brands',
					'label' => 'Brands / case studies',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_advay_home_brands_title',
					'label' => 'Brands section heading',
					'name'  => 'home_brands_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_advay_tab_stories',
					'label' => 'Success stories intro',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_advay_home_stories_eyebrow',
					'label' => 'Eyebrow',
					'name'  => 'home_stories_eyebrow',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_advay_home_stories_heading',
					'label' => 'Heading',
					'name'  => 'home_stories_heading',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_advay_tab_cta',
					'label' => 'Bottom CTA',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_advay_home_cta_eyebrow',
					'label' => 'CTA eyebrow',
					'name'  => 'home_cta_eyebrow',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_advay_home_cta_heading',
					'label' => 'CTA heading',
					'name'  => 'home_cta_heading',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_advay_home_cta_copy',
					'label' => 'CTA description',
					'name'  => 'home_cta_copy',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'           => 'field_advay_home_cta_primary',
					'label'         => 'CTA primary button',
					'name'          => 'home_cta_primary',
					'type'          => 'link',
					'return_format' => 'array',
					'instructions'  => 'Defaults to Email intake (mailto).',
				),
				array(
					'key'           => 'field_advay_home_cta_secondary',
					'label'         => 'Footer — Call the warehouse',
					'name'          => 'home_cta_secondary',
					'type'          => 'link',
					'return_format' => 'array',
					'instructions'  => 'Footer button above “Book a call with our MD”. Defaults to Call the warehouse (tel).',
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'advay-site-content',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
			'show_in_rest'          => 0,
		)
	);

	acf_add_local_field_group(
		array(
			'key'                   => 'group_advay_site_contact',
			'title'                 => 'Site Contact Information',
			'fields'                => array(
				array(
					'key'   => 'field_advay_contact_prod_note',
					'label' => 'Production contact checklist',
					'type'  => 'message',
					'message' => '<strong>Verify this value before production launch.</strong> Do not invent phone numbers, WhatsApp links, emails, or Calendly URLs. Leave a field empty to keep the theme’s safe fallback (WhatsApp stays non-clickable when empty).',
				),
				array(
					'key'          => 'field_advay_contact_phone_label',
					'label'        => '[Production] Phone display label',
					'name'         => 'site_phone_label',
					'type'         => 'text',
					'instructions' => 'Verify this value before production launch. Shown in the floating contact dock (e.g. +1 (212) 814-8815).',
				),
				array(
					'key'          => 'field_advay_contact_phone_url',
					'label'        => '[Production] Phone dial URL',
					'name'         => 'site_phone_url',
					'type'         => 'text',
					'instructions' => 'Verify this value before production launch. Use tel: format, e.g. tel:+12128148815. Empty → theme dock fallback.',
				),
				array(
					'key'          => 'field_advay_contact_email_label',
					'label'        => '[Production] Email display label',
					'name'         => 'site_email_label',
					'type'         => 'email',
					'instructions' => 'Verify this value before production launch.',
				),
				array(
					'key'          => 'field_advay_contact_email_url',
					'label'        => '[Production] Email mailto URL',
					'name'         => 'site_email_url',
					'type'         => 'text',
					'instructions' => 'Verify this value before production launch. Use mailto: format, e.g. mailto:odi@eliteprepcenter.com',
				),
				array(
					'key'          => 'field_advay_contact_intake_email',
					'label'        => '[Production] Intake email mailto URL',
					'name'         => 'site_intake_email_url',
					'type'         => 'text',
					'instructions' => 'Verify this value before production launch. Used by homepage bottom CTA “Email intake” when that button link field is empty.',
				),
				array(
					'key'          => 'field_advay_contact_intake_phone',
					'label'        => '[Production] Intake phone tel URL',
					'name'         => 'site_intake_phone_url',
					'type'         => 'text',
					'instructions' => 'Verify this value before production launch. Used by homepage “Call the warehouse” when empty of CTA override. Leave empty to use the Phone dial URL / dock fallback (no invented placeholder).',
				),
				array(
					'key'          => 'field_advay_contact_calendly',
					'label'        => '[Production] Calendly / booking URL',
					'name'         => 'site_calendly_url',
					'type'         => 'url',
					'instructions' => 'Verify this value before production launch. Floating dock booking link.',
				),
				array(
					'key'          => 'field_advay_contact_whatsapp',
					'label'        => '[Production] WhatsApp URL',
					'name'         => 'site_whatsapp_url',
					'type'         => 'url',
					'instructions' => 'Verify this value before production launch. Full WhatsApp link (e.g. https://wa.me/1XXXXXXXXXX). Leave empty until verified — frontend will not invent a placeholder or fake wa.me link.',
				),
				array(
					'key'          => 'field_advay_dock_email_cta_label',
					'label'        => 'Dock email CTA label',
					'name'         => 'site_dock_email_cta_label',
					'type'         => 'text',
					'instructions' => 'Floating dock email bubble text (defaults to “Reach out to us via mail”).',
				),
				array(
					'key'          => 'field_advay_dock_calendly_label',
					'label'        => 'Dock booking CTA label',
					'name'         => 'site_dock_calendly_label',
					'type'         => 'text',
					'instructions' => 'Floating dock Calendly bubble text (defaults to “Book a call with our MD”).',
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'advay-site-content',
					),
				),
			),
			'menu_order'            => 1,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
			'show_in_rest'          => 0,
		)
	);

	acf_add_local_field_group(
		array(
			'key'                   => 'group_advay_site_chrome',
			'title'                 => 'Header, Footer & Mega Cards',
			'fields'                => array(
				array(
					'key'   => 'field_advay_tab_header_chrome',
					'label' => 'Header CTAs',
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_advay_header_cta_primary',
					'label'         => 'Header primary CTA',
					'name'          => 'site_header_cta_primary',
					'type'          => 'link',
					'return_format' => 'array',
					'instructions'  => 'Desktop + mobile primary button (defaults to Grow with ElitePrep → #contact). Navigation structure stays in Appearance → Menus.',
				),
				array(
					'key'           => 'field_advay_header_cta_secondary',
					'label'         => 'Header secondary CTA',
					'name'          => 'site_header_cta_secondary',
					'type'          => 'link',
					'return_format' => 'array',
					'instructions'  => 'Desktop + mobile secondary button (defaults to Book a call → #contact). Point at Calendly if preferred.',
				),
				array(
					'key'   => 'field_advay_tab_footer_chrome',
					'label' => 'Footer',
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_advay_footer_cta',
					'label'         => 'Footer CTA button',
					'name'          => 'site_footer_cta',
					'type'          => 'link',
					'return_format' => 'array',
					'instructions'  => 'Top footer button (defaults to Book a call with our MD → #contact).',
				),
				array(
					'key'          => 'field_advay_footer_tagline',
					'label'        => 'Footer tagline',
					'name'         => 'site_footer_tagline',
					'type'         => 'textarea',
					'rows'         => 3,
					'instructions' => 'Overrides the site tagline under the footer logo when set. Empty → WordPress Site Tagline / theme default.',
				),
				array(
					'key'          => 'field_advay_footer_contact_line',
					'label'        => 'Footer contact note',
					'name'         => 'site_footer_contact_line',
					'type'         => 'text',
					'instructions' => 'Contact column note (defaults to “Warehouse address on request”). Phone/email rows use Site Contact Information when present.',
				),
				array(
					'key'   => 'field_advay_tab_mega_company',
					'label' => 'Company mega cards',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_advay_mega_company_1_title',
					'label' => 'Company card 1 title',
					'name'  => 'mega_company_1_title',
					'type'  => 'text',
					'instructions' => 'Defaults to Our Story. Card URL stays /about-us/.',
				),
				array(
					'key'   => 'field_advay_mega_company_1_desc',
					'label' => 'Company card 1 description',
					'name'  => 'mega_company_1_desc',
					'type'  => 'textarea',
					'rows'  => 2,
				),
				array(
					'key'           => 'field_advay_mega_company_1_image',
					'label'         => 'Company card 1 image',
					'name'          => 'mega_company_1_image',
					'type'          => 'image',
					'return_format' => 'array',
					'preview_size'  => 'medium',
				),
				array(
					'key'   => 'field_advay_mega_company_2_title',
					'label' => 'Company card 2 title',
					'name'  => 'mega_company_2_title',
					'type'  => 'text',
					'instructions' => 'Defaults to Our Managing Director. Card URL stays /managing-director/.',
				),
				array(
					'key'   => 'field_advay_mega_company_2_desc',
					'label' => 'Company card 2 description',
					'name'  => 'mega_company_2_desc',
					'type'  => 'textarea',
					'rows'  => 2,
				),
				array(
					'key'           => 'field_advay_mega_company_2_image',
					'label'         => 'Company card 2 image',
					'name'          => 'mega_company_2_image',
					'type'          => 'image',
					'return_format' => 'array',
					'preview_size'  => 'medium',
				),
			),
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
add_action( 'acf/init', 'advay_register_acf_field_groups' );

/**
 * Register ACF Options page when Pro is available; otherwise use a Free-compatible admin screen.
 */
function advay_register_acf_options_page() {
	if ( function_exists( 'acf_add_options_page' ) ) {
		acf_add_options_page(
			array(
				'page_title' => __( 'ElitePrep Content', 'advay-theme' ),
				'menu_title' => __( 'ElitePrep Content', 'advay-theme' ),
				'menu_slug'  => 'advay-site-content',
				'capability' => 'edit_theme_options',
				'redirect'   => false,
				'position'   => 58,
				'icon_url'   => 'dashicons-edit-large',
			)
		);
	}
}
add_action( 'acf/init', 'advay_register_acf_options_page' );

/**
 * Free ACF fallback: admin page that saves field groups to the options store.
 */
function advay_register_site_content_menu() {
	if ( function_exists( 'acf_add_options_page' ) ) {
		return;
	}
	if ( ! function_exists( 'acf_form' ) ) {
		return;
	}

	$hook = add_menu_page(
		__( 'ElitePrep Content', 'advay-theme' ),
		__( 'ElitePrep Content', 'advay-theme' ),
		'edit_theme_options',
		'advay-site-content',
		'advay_render_site_content_page',
		'dashicons-edit-large',
		58
	);

	add_action( 'load-' . $hook, 'advay_site_content_form_head' );
}
add_action( 'admin_menu', 'advay_register_site_content_menu' );

/**
 * Load ACF form assets on the Free admin screen.
 */
function advay_site_content_form_head() {
	if ( function_exists( 'acf_form_head' ) ) {
		acf_form_head();
	}
}

/**
 * Render Free ACF Site Content editor.
 */
function advay_render_site_content_page() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'ElitePrep Content', 'advay-theme' ); ?></h1>
		<p><?php esc_html_e( 'Edit frequently changing homepage and contact content. Layout and design stay controlled by the theme.', 'advay-theme' ); ?></p>
		<div class="notice notice-info inline" style="margin:12px 0;padding:8px 12px;">
			<p><strong><?php esc_html_e( 'Homepage SEO (Rank Math):', 'advay-theme' ); ?></strong>
			<?php esc_html_e( 'Create a blank WordPress Page titled “Home”, then go to Settings → Reading → “A static page” and set Homepage to that page. Do not invent a second public URL — the site front stays /. The theme’s front-page.php continues to render the existing homepage design; Rank Math can then edit SEO on the Home page object. Leave “Posts page” as Blog if you use /blog/.', 'advay-theme' ); ?></p>
			<p><strong><?php esc_html_e( 'Production contacts:', 'advay-theme' ); ?></strong>
			<?php esc_html_e( 'Complete every [Production] field in Site Contact Information before go-live. Verify values — do not invent phone, WhatsApp, email, or Calendly data.', 'advay-theme' ); ?></p>
		</div>
		<?php
		if ( function_exists( 'acf_form' ) ) {
			acf_form(
				array(
					'post_id'      => 'option',
					'field_groups' => array(
						'group_advay_homepage',
						'group_advay_homepage_complete',
						'group_advay_site_contact',
						'group_advay_site_chrome',
					),
					'submit_value' => __( 'Save content', 'advay-theme' ),
					'updated_message' => __( 'Content saved.', 'advay-theme' ),
				)
			);
		}
		?>
	</div>
	<?php
}

/**
 * Remind admins if ACF is missing.
 */
function advay_acf_admin_notice() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	if ( ! function_exists( 'get_field' ) ) {
		echo '<div class="notice notice-warning"><p>';
		echo esc_html__( 'Advay Theme: Install and activate Advanced Custom Fields to edit homepage and contact content (WP Admin → ElitePrep Content).', 'advay-theme' );
		echo '</p></div>';
	}
}
add_action( 'admin_notices', 'advay_acf_admin_notice' );

/**
 * Reading settings: recommend a static front page for Rank Math homepage SEO.
 * Does not create pages or change settings automatically.
 */
function advay_front_page_seo_admin_notice() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || ! in_array( $screen->id, array( 'options-reading', 'dashboard', 'toplevel_page_advay-site-content' ), true ) ) {
		return;
	}

	if ( 'page' === get_option( 'show_on_front' ) && (int) get_option( 'page_on_front' ) > 0 ) {
		return;
	}

	echo '<div class="notice notice-warning"><p>';
	echo esc_html__( 'Advay Theme: Homepage is still “Your latest posts”. For Rank Math SEO on the homepage, create a blank Page (e.g. Home), then Settings → Reading → A static page → set it as Homepage. Public URL stays / and front-page.php keeps the current design.', 'advay-theme' );
	echo ' <a href="' . esc_url( admin_url( 'options-reading.php' ) ) . '">' . esc_html__( 'Open Reading settings', 'advay-theme' ) . '</a>';
	echo '</p></div>';
}
add_action( 'admin_notices', 'advay_front_page_seo_admin_notice' );
