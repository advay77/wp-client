<?php
/**
 * Success Story custom post type helpers + URL bridge.
 *
 * CPT registration lives in mu-plugin: wp-content/mu-plugins/epc-content-types.php
 * so posts survive theme switches/rollbacks.
 *
 * Public URLs remain /success-stories/{slug}/.
 * The legacy theme rewrite still matches first (priority top). When a published
 * success_story CPT exists for that slug, the request is converted into a native
 * CPT single query so Rank Math and templates see a real post object. Otherwise
 * the legacy PHP-array template continues to serve the URL.
 *
 * @package Advay_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Published success_story post by slug, or null.
 *
 * @param string $slug Post name.
 * @return WP_Post|null
 */
function advay_get_success_story_post( $slug ) {
	$slug = sanitize_key( $slug );
	if ( '' === $slug ) {
		return null;
	}

	$posts = get_posts(
		array(
			'name'             => $slug,
			'post_type'        => 'success_story',
			'post_status'      => 'publish',
			'numberposts'      => 1,
			'suppress_filters' => true,
		)
	);

	return ! empty( $posts[0] ) ? $posts[0] : null;
}

/**
 * Bridge legacy rewrite → native CPT single when a post exists.
 *
 * Theme rule (top): success-stories/{slug} → advay_success_story={slug}
 * If CPT post exists: convert to post_type=success_story&name={slug}
 * Else: leave query var for page-success-story.php (PHP array fallback).
 *
 * @param array<string, mixed> $query_vars Request vars.
 * @return array<string, mixed>
 */
function advay_success_story_request_bridge( $query_vars ) {
	if ( empty( $query_vars['advay_success_story'] ) ) {
		return $query_vars;
	}

	$slug = sanitize_key( (string) $query_vars['advay_success_story'] );
	if ( '' === $slug ) {
		return $query_vars;
	}

	$post = advay_get_success_story_post( $slug );
	if ( ! $post ) {
		return $query_vars;
	}

	unset( $query_vars['advay_success_story'] );
	$query_vars['post_type']     = 'success_story';
	$query_vars['name']          = $slug;
	$query_vars['success_story'] = $slug;

	return $query_vars;
}
add_filter( 'request', 'advay_success_story_request_bridge' );
