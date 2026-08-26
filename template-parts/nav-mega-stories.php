<?php
/**
 * Success stories mega — lifestyle photo cards (no brand logos).
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cs_url = advay_blog_url();
$home   = trailingslashit( home_url( '/' ) );

$stories = array(
	array(
		'alt' => __( 'Brand fulfillment success story', 'advay-theme' ),
		'src' => 'https://images.unsplash.com/photo-1513364776144-60967b0f800f?auto=format&fit=crop&w=800&q=80',
	),
	array(
		'alt' => __( 'Small business scaling with prep partner', 'advay-theme' ),
		'src' => 'https://images.unsplash.com/photo-1503951914875-452162b0f3f1?auto=format&fit=crop&w=800&q=80',
	),
	array(
		'alt' => __( 'Marketplace seller growth story', 'advay-theme' ),
		'src' => 'https://images.unsplash.com/photo-1469334031218-e382a71b716b?auto=format&fit=crop&w=800&q=80',
	),
	array(
		'alt' => __( 'Warehouse prep and shipping success', 'advay-theme' ),
		'src' => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=800&q=80',
	),
);
?>
<div class="mega-panel mega-stories" role="region" aria-label="<?php esc_attr_e( 'Success stories', 'advay-theme' ); ?>">
	<div class="stories-mega-intro">
		<strong><?php esc_html_e( 'Unlock the exponential power of together.', 'advay-theme' ); ?></strong>
		<a class="button button-primary stories-mega-cta" href="<?php echo esc_url( $cs_url ); ?>">
			<?php esc_html_e( 'View all case studies', 'advay-theme' ); ?>
			<span class="btn-arrow" aria-hidden="true"></span>
		</a>
	</div>
	<div class="stories-mega-cards">
		<?php foreach ( $stories as $story ) : ?>
			<a class="st-card" href="<?php echo esc_url( $home . '#testimonials' ); ?>">
				<img src="<?php echo esc_url( $story['src'] ); ?>" alt="<?php echo esc_attr( $story['alt'] ); ?>">
				<span class="st-overlay">
					<span class="st-more"><?php esc_html_e( 'Read More', 'advay-theme' ); ?></span>
				</span>
			</a>
		<?php endforeach; ?>
	</div>
</div>
