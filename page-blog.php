<?php
/**
 * Blog listing — served at /blog/ via rewrite (no WP admin setup required).
 *
 * @package Advay_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$paged = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );

$blog_query = new WP_Query(
	array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => 8,
		'paged'          => $paged,
	)
);
?>
<main id="main-content" class="blog-main">
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
