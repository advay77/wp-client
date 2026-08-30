<?php
/**
 * Blogs mega panel — image-card dropdown.
 *
 * Shows three pinned articles. If a pinned post is missing, the panel
 * falls back to the most recent published posts.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$blog_url = advay_blog_url();
$cards    = array();

/**
 * The three articles pinned to the Blogs dropdown.
 * Edit this list to change what the mega panel shows.
 */
$pinned_slugs = array(
	'best-amazon-prep-center-new-jersey',
	'amazon-is-ending-commingling-what-sellers-need-to-know-before-march-31-2026',
	'what-is-a-3pl-how-it-can-help-grow-your-shopify-store',
);

$picked = array();
foreach ( $pinned_slugs as $slug ) {
	$post_obj = get_page_by_path( $slug, OBJECT, 'post' );
	if ( $post_obj && 'publish' === $post_obj->post_status ) {
		$picked[] = $post_obj;
	}
}

/* If a pinned post is missing, top up with the most recent published posts. */
if ( count( $picked ) < 3 ) {
	$fill = get_posts(
		array(
			'numberposts'      => 3,
			'post_status'      => 'publish',
			'suppress_filters' => false,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'post__not_in'     => wp_list_pluck( $picked, 'ID' ),
		)
	);
	foreach ( $fill as $post_obj ) {
		if ( count( $picked ) >= 3 ) {
			break;
		}
		if ( 'hello-world' === $post_obj->post_name ) {
			continue;
		}
		$picked[] = $post_obj;
	}
}

foreach ( $picked as $post_obj ) {
	$cats    = get_the_category( $post_obj->ID );
	$thumb   = has_post_thumbnail( $post_obj->ID ) ? get_the_post_thumbnail_url( $post_obj->ID, 'large' ) : advay_blog_fallback_image( $post_obj->ID );
	$cards[] = array(
		'label' => ( $cats && ! is_wp_error( $cats ) ) ? $cats[0]->name : __( 'Article', 'advay-theme' ),
		'title' => get_the_title( $post_obj->ID ),
		'url'   => get_permalink( $post_obj->ID ),
		'img'   => $thumb,
	);
}

$cards = array_slice( $cards, 0, 3 );
?>
<div class="mega-panel mega-blogs" role="region" aria-label="<?php esc_attr_e( 'Blogs', 'advay-theme' ); ?>">
	<div class="blogs-cards">
		<?php foreach ( $cards as $card ) : ?>
			<a class="blog-card" href="<?php echo esc_url( $card['url'] ); ?>">
				<span
					class="blog-thumb"
					<?php if ( ! empty( $card['img'] ) ) : ?>
						style="background-image:url('<?php echo esc_url( $card['img'] ); ?>')"
					<?php endif; ?>
				></span>
				<span class="blog-body">
					<em><?php echo esc_html( $card['label'] ); ?></em>
					<strong><?php echo esc_html( $card['title'] ); ?></strong>
					<span class="blog-more">
						<?php esc_html_e( 'Read More', 'advay-theme' ); ?>
						<span aria-hidden="true">&rarr;</span>
					</span>
				</span>
			</a>
		<?php endforeach; ?>
		<a class="blog-card blog-card--all" href="<?php echo esc_url( $blog_url ); ?>">
			<span class="blog-all-inner">
				<strong><?php esc_html_e( 'View all blogs', 'advay-theme' ); ?></strong>
				<span class="blog-more" aria-hidden="true">&rarr;</span>
			</span>
		</a>
	</div>
</div>
