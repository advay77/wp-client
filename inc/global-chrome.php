<?php
/**
 * Global chrome helpers — header / footer / mega marketing cards.
 *
 * Reads ElitePrep Content (ACF options). Empty fields keep hardcoded fallbacks.
 *
 * @package Advay_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Header primary CTA (Instant Quote).
 *
 * @return array{label: string, url: string}
 */
function advay_header_cta_primary() {
	$link = advay_get_acf( 'site_header_cta_primary', '', advay_acf_front_id() );

	return array(
		'label' => advay_acf_link_title( $link, __( 'Get an Instant Quote', 'advay-theme' ) ),
		'url'   => advay_acf_quote_link_url( $link, advay_quote_url() ),
	);
}

/**
 * Header secondary CTA (Book a call).
 *
 * @return array{label: string, url: string}
 */
function advay_header_cta_secondary() {
	$link = advay_get_acf( 'site_header_cta_secondary', '', advay_acf_front_id() );

	return array(
		'label' => advay_acf_link_title( $link, __( 'Book a call', 'advay-theme' ) ),
		'url'   => advay_acf_book_call_link_url( $link, advay_book_call_url() ),
	);
}

/**
 * Footer "Call the warehouse" CTA (above Book a call with MD).
 *
 * @return array{label: string, url: string}
 */
function advay_footer_call_warehouse_cta() {
	$link = advay_get_acf( 'home_cta_secondary', '', advay_acf_front_id() );

	return array(
		'label' => advay_acf_link_title( $link, __( 'Call the warehouse', 'advay-theme' ) ),
		'url'   => advay_acf_link_url( $link, advay_intake_phone_url() ),
	);
}

/**
 * Footer primary CTA.
 *
 * @return array{label: string, url: string}
 */
function advay_footer_cta() {
	$link = advay_get_acf( 'site_footer_cta', '', advay_acf_front_id() );

	return array(
		'label' => advay_acf_link_title( $link, __( 'Book a call with our MD', 'advay-theme' ) ),
		'url'   => advay_acf_book_call_link_url( $link, advay_book_call_url() ),
	);
}

/**
 * Footer brand tagline.
 *
 * @return string
 */
function advay_footer_tagline() {
	$default = get_bloginfo( 'description' );
	if ( ! is_string( $default ) || '' === trim( $default ) ) {
		$default = __( 'Amazon FBA, Walmart WFS, and TikTok Shop prep for sellers who need accuracy, speed, and a partner they can trust.', 'advay-theme' );
	}

	$value = advay_get_acf( 'site_footer_tagline', '', advay_acf_front_id() );
	if ( ! is_string( $value ) || '' === trim( $value ) ) {
		return $default;
	}

	return $value;
}

/**
 * Footer contact column — address / note line.
 *
 * @return string
 */
function advay_footer_contact_line() {
	$value = advay_get_acf( 'site_footer_contact_line', '', advay_acf_front_id() );
	if ( ! is_string( $value ) || '' === trim( $value ) ) {
		return __( 'Warehouse address on request', 'advay-theme' );
	}
	return $value;
}

/**
 * Floating dock — email CTA label (not the email address).
 *
 * @return string
 */
function advay_dock_email_cta_label() {
	$value = advay_get_acf( 'site_dock_email_cta_label', '', advay_acf_front_id() );
	if ( ! is_string( $value ) || '' === trim( $value ) ) {
		return __( 'Reach out to us via mail', 'advay-theme' );
	}
	return $value;
}

/**
 * Floating dock — Calendly / booking CTA label.
 *
 * @return string
 */
function advay_dock_calendly_label() {
	$value = advay_get_acf( 'site_dock_calendly_label', '', advay_acf_front_id() );
	if ( ! is_string( $value ) || '' === trim( $value ) ) {
		return __( 'Book a call with our MD', 'advay-theme' );
	}
	return $value;
}

/**
 * Company mega-menu marketing cards (fixed count = 2). Structure stays theme-owned.
 *
 * @return array<int, array{title: string, desc: string, url: string, img: string, alt: string}>
 */
function advay_mega_company_cards() {
	$front = advay_acf_front_id();

	$defaults = array(
		array(
			'title' => __( 'Our Story', 'advay-theme' ),
			'desc'  => __( 'Learn how ElitePrep Center has grown over the years.', 'advay-theme' ),
			'url'   => advay_our_story_url(),
			'img'   => advay_theme_image( 'images/svc-warehouse.jpg', advay_asset_uri( 'images/company-placeholder.svg' ) ),
			'alt'   => __( 'Warehouse trucks and inbound dock operations', 'advay-theme' ),
			'keys'  => array(
				'title' => 'mega_company_1_title',
				'desc'  => 'mega_company_1_desc',
				'image' => 'mega_company_1_image',
			),
		),
		array(
			'title' => __( 'Our Managing Director', 'advay-theme' ),
			'desc'  => __( 'Meet the man behind EPC and learn what drives the business forward.', 'advay-theme' ),
			'url'   => advay_managing_director_url(),
			'img'   => advay_theme_image(
				'images/client-success.jpg',
				advay_asset_uri( 'images/company-placeholder.svg' )
			),
			'alt'   => __( 'Managing Director at ElitePrep Center', 'advay-theme' ),
			'keys'  => array(
				'title' => 'mega_company_2_title',
				'desc'  => 'mega_company_2_desc',
				'image' => 'mega_company_2_image',
			),
		),
	);

	$cards = array();
	foreach ( $defaults as $row ) {
		$keys = $row['keys'];
		$img  = advay_get_acf( $keys['image'], null, $front );
		$src  = advay_acf_image_url( $img, $row['img'] );
		$alt  = advay_acf_image_alt( $img, $row['alt'] );

		$cards[] = array(
			'title' => (string) advay_get_acf( $keys['title'], $row['title'], $front ),
			'desc'  => (string) advay_get_acf( $keys['desc'], $row['desc'], $front ),
			'url'   => $row['url'],
			'img'   => $src,
			'alt'   => $alt,
		);
	}

	return $cards;
}
