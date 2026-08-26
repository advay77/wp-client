<?php
/**
 * Static demo blog card when no WP posts exist yet.
 *
 * @package Advay_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$card     = isset( $args['card'] ) ? $args['card'] : array();
$featured = ! empty( $args['featured'] );
$image    = isset( $card['image'] ) ? (string) $card['image'] : '';
$img_url  = ( 0 === strpos( $image, 'http' ) ) ? $image : advay_asset_uri( $image );
?>
<article class="<?php echo esc_attr( $featured ? 'blog-item is-featured' : 'blog-item' ); ?>">
	<a class="blog-item-link" href="<?php echo esc_url( $card['url'] ); ?>">
		<figure class="blog-item-thumb">
			<img
				src="<?php echo esc_url( $img_url ); ?>"
				alt=""
				loading="<?php echo $featured ? 'eager' : 'lazy'; ?>"
				decoding="async"
			>
			<span class="blog-item-badge">
				<?php echo esc_html( $card['category'] ); ?>
				<span aria-hidden="true">&middot;</span>
				<?php echo esc_html( $card['read_time'] ); ?>
			</span>
		</figure>
		<div class="blog-item-body">
			<h2><?php echo esc_html( $card['title'] ); ?></h2>
			<div class="blog-item-reveal">
				<p><?php echo esc_html( wp_trim_words( $card['excerpt'], $featured ? 22 : 14 ) ); ?></p>
				<span class="blog-item-foot">
					<time><?php echo esc_html( $card['date'] ); ?></time>
					<span class="blog-item-more">
						<?php esc_html_e( 'Read More', 'advay-theme' ); ?>
						<span aria-hidden="true">&rarr;</span>
					</span>
				</span>
			</div>
		</div>
	</a>
</article>
