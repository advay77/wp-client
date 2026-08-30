<?php
/**
 * Blog listing — served at /blog/ (Page slug blog, or rewrite fallback).
 *
 * Template Name: Blog
 * Template Post Type: page
 *
 * @package Advay_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();


$blog_query = new WP_Query(
	array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'nopaging'       => true,
	)
);
?>
<main id="main-content" class="blog-main">
	<?php get_template_part( 'template-parts/editor-zone' ); ?>
	<?php
	if ( $blog_query->have_posts() ) {
		global $wp_query;
		$prev_query = $wp_query;
		$wp_query   = $blog_query;
		get_template_part( 'template-parts/blog-index' );
		$wp_query = $prev_query;
		wp_reset_postdata();
	} else {
		get_template_part( 'template-parts/blog-index', null, array( 'demo' => true ) );
	}
	?>
</main>

<?php
get_footer();
