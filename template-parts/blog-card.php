<?php
/**
 * Blog card — compact Pattern-style with hover reveal.
 *
 * @package Advay_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$featured = ! empty( $args['featured'] );
$cats     = get_the_category();
$cat_name = ( $cats && ! is_wp_error( $cats ) ) ? $cats[0]->name : __( 'Insights', 'advay-theme' );
$fallback = advay_blog_fallback_image( get_the_ID() );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $featured ? 'blog-item is-featured' : 'blog-item' ); ?>>
	<a class="blog-item-link" href="<?php the_permalink(); ?>">
		<figure class="blog-item-thumb">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php
				the_post_thumbnail(
					'large',
					array(
						'alt'      => the_title_attribute( array( 'echo' => false ) ),
						'loading'  => 'lazy',
						'decoding' => 'async',
						'class'    => 'blog-item-img',
					)
				);
				?>
			<?php else : ?>
				<img class="blog-item-img" src="<?php echo esc_url( $fallback ); ?>" alt="" loading="lazy" decoding="async">
			<?php endif; ?>
			<span class="blog-item-badge">
				<?php echo esc_html( $cat_name ); ?>
				<span aria-hidden="true">&middot;</span>
				<?php echo esc_html( advay_reading_time() ); ?>
			</span>
		</figure>

		<div class="blog-item-body">
			<h2><?php the_title(); ?></h2>
			<div class="blog-item-reveal">
				<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), $featured ? 22 : 14 ) ); ?></p>
				<span class="blog-item-foot">
					<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
						<?php echo esc_html( get_the_date() ); ?>
					</time>
					<span class="blog-item-more">
						<?php esc_html_e( 'Read More', 'advay-theme' ); ?>
						<span aria-hidden="true">&rarr;</span>
					</span>
				</span>
			</div>
		</div>
	</a>
</article>
