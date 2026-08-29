<?php
/**
 * Marketing page CMS helpers (ACF Free on native Pages).
 *
 * Does not create Pages. Reads ACF from a published Page matching $slug
 * when present; otherwise returns the provided fallback.
 *
 * @package Advay_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Published Page ID for a path slug, or 0 if missing.
 *
 * @param string $slug Page path (e.g. receiving).
 * @return int
 */
function advay_cms_page_id( $slug ) {
	$slug = sanitize_title( $slug );
	if ( '' === $slug ) {
		return 0;
	}

	$page = get_page_by_path( $slug );
	if ( ! $page instanceof WP_Post ) {
		return 0;
	}
	if ( 'publish' !== $page->post_status ) {
		return 0;
	}

	return (int) $page->ID;
}

/**
 * ACF field for a marketing page slug with hardcoded fallback.
 *
 * @param string $slug     Page path slug.
 * @param string $key      Field name.
 * @param mixed  $fallback Default when page missing or field empty.
 * @return mixed
 */
function advay_page_acf( $slug, $key, $fallback = '' ) {
	$post_id = advay_cms_page_id( $slug );
	if ( ! $post_id ) {
		return $fallback;
	}

	return advay_get_acf( $key, $fallback, $post_id );
}

/**
 * WhatsApp URL from ElitePrep Content (no placeholder number).
 *
 * Empty when unset — callers should hide the link or render a non-link pill.
 *
 * @return string
 */
function advay_whatsapp_url() {
	$front = advay_acf_front_id();
	$value = advay_get_acf( 'site_whatsapp_url', '', $front );
	if ( ! is_string( $value ) || '' === trim( $value ) ) {
		$value = '';
	}
	return apply_filters( 'advay_contact_whatsapp_url', $value );
}
