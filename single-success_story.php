<?php
/**
 * Single Success Story (CPT) — same design as legacy page-success-story.php.
 *
 * @package Advay_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post = get_queried_object();
$slug = ( $post instanceof WP_Post ) ? $post->post_name : 'no-knife-body';
$story = advay_get_success_story( $slug );

get_header();
require get_template_directory() . '/template-parts/success-story-page.php';
get_footer();
