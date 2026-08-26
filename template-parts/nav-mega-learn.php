<?php
/**
 * Blogs mega panel — image-card dropdown.
 *
 * Shows the most recent real posts first, then fills remaining slots
 * with evergreen demo cards from the theme.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$blog_url = advay_blog_url();
$cards    = array();

$recent = get_posts(
	array(
		'numberposts'      => 4,
		'post_status'      => 'publish',
		'suppress_filters' => false,
		/* Prefer seeded demos over the default Hello World post. */
		'orderby'          => 'date',
		'order'            => 'DESC',
	)
);

foreach ( $recent as $post_obj ) {
	/* Skip the default WordPress sample post when we have real demos. */
	if ( 'hello-world' === $post_obj->post_name && count( $recent ) > 1 ) {
		continue;
	}

	$cats  = get_the_category( $post_obj->ID );
	$thumb = has_post_thumbnail( $post_obj->ID ) ? get_the_post_thumbnail_url( $post_obj->ID, 'medium_large' ) : advay_blog_fallback_image( $post_obj->ID );
	$cards[] = array(
		'label' => ( $cats && ! is_wp_error( $cats ) ) ? $cats[0]->name : __( 'Article', 'advay-theme' ),
		'title' => get_the_title( $post_obj->ID ),
		'url'   => get_permalink( $post_obj->ID ),
		'img'   => $thumb,
	);
}

foreach ( advay_demo_blog_posts() as $demo ) {
	if ( count( $cards ) >= 3 ) {
		break;
	}
	/* Avoid duplicating a post already pulled from get_posts(). */
	$already = false;
	foreach ( $cards as $existing_card ) {
		if ( isset( $existing_card['title'] ) && $existing_card['title'] === $demo['title'] ) {
			$already = true;
			break;
		}
	}
	if ( $already ) {
		continue;
	}

	$seeded = get_page_by_path( $demo['slug'], OBJECT, 'post' );
	$cards[] = array(
		'label' => $demo['category'],
		'title' => $demo['title'],
		'url'   => $seeded ? get_permalink( $seeded ) : $blog_url,
		'img'   => advay_asset_uri( $demo['image'] ),
	);
}

$cards = array_slice( $cards, 0, 4 );
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
					<span class="blog-more">
						<?php esc_html_e( 'Read More', 'advay-theme' ); ?>
						<span aria-hidden="true">&rarr;</span>
					</span>
				</span>
			</a>
		<?php endforeach; ?>
	</div>
</div>
