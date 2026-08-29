<?php
/**
 * Success story — legacy rewrite fallback (PHP array when no CPT post).
 *
 * Served when /success-stories/{slug}/ matches advay_success_story and no
 * published success_story CPT exists for that slug.
 *
 * @package Advay_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$slug  = sanitize_key( (string) get_query_var( 'advay_success_story', 'ajayi-popcorn' ) );
$story = advay_get_success_story( $slug );

get_header();
require get_template_directory() . '/template-parts/success-story-page.php';
get_footer();
