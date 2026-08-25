<?php
/**
 * Blogs mega panel — image-card dropdown.
 *
 * Shows the most recent real posts first, then fills any remaining slots
 * with evergreen topic cards that link to the blog archive. Card images
 * use real theme assets; no invented post URLs are generated.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$blog_url = advay_blog_url();
$cards    = array();

$recent = get_posts(
	array(
		'numberposts'      => 3,
		'post_status'      => 'publish',
		'suppress_filters' => false,
	)
);

foreach ( $recent as $post_obj ) {
	$cats  = get_the_category( $post_obj->ID );
	$thumb = has_post_thumbnail( $post_obj->ID ) ? get_the_post_thumbnail_url( $post_obj->ID, 'medium_large' ) : '';
	$cards[] = array(
		'label' => ( $cats && ! is_wp_error( $cats ) ) ? $cats[0]->name : __( 'Article', 'advay-theme' ),
		'title' => get_the_title( $post_obj->ID ),
		'url'   => get_permalink( $post_obj->ID ),
		'img'   => $thumb,
	);
}

$topics = array(
	array(
		'label' => __( 'Guides', 'advay-theme' ),
		'title' => __( 'FBA & Walmart WFS prep playbooks', 'advay-theme' ),
		'url'   => $blog_url,
		'img'   => advay_asset_uri( 'images/brand-gainz.jpg' ),
	),
	array(
		'label' => __( 'Updates', 'advay-theme' ),
		'title' => __( 'Marketplace policy changes to watch', 'advay-theme' ),
		'url'   => $blog_url,
		'img'   => advay_asset_uri( 'images/brand-littlebay.jpg' ),
	),
	array(
		'label' => __( 'Stories', 'advay-theme' ),
		'title' => __( 'How lean brands scale with a 3PL', 'advay-theme' ),
		'url'   => $blog_url,
		'img'   => advay_asset_uri( 'images/brand-anola.jpg' ),
	),
);

while ( count( $cards ) < 3 && $topics ) {
	$cards[] = array_shift( $topics );
}
$cards = array_slice( $cards, 0, 3 );
?>
<div class="mega-panel mega-blogs" role="region" aria-label="<?php esc_attr_e( 'Blogs', 'advay-theme' ); ?>">
	<div class="blogs-intro">
		<strong><?php esc_html_e( 'From the blog', 'advay-theme' ); ?></strong>
		<p><?php esc_html_e( 'Prep playbooks, marketplace updates, and seller wins.', 'advay-theme' ); ?></p>
		<a class="blogs-all" href="<?php echo esc_url( $blog_url ); ?>">
			<?php esc_html_e( 'View all posts', 'advay-theme' ); ?>
			<span aria-hidden="true">&rarr;</span>
		</a>
	</div>
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
				</span>
				<span class="blog-more">
					<?php esc_html_e( 'Read More', 'advay-theme' ); ?>
					<span aria-hidden="true">&rarr;</span>
				</span>
			</a>
		<?php endforeach; ?>
	</div>
</div>
