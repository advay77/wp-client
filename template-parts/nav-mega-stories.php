<?php
/**
 * Success stories mega — lifestyle photo cards with brand names.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$stories = array(
	array(
		'brand' => __( 'Ajayi Popcorn', 'advay-theme' ),
		'slug'  => 'ajayi-popcorn',
		'alt'   => __( 'Ajayi Popcorn success story', 'advay-theme' ),
		'src'   => 'https://images.unsplash.com/photo-1513364776144-60967b0f800f?auto=format&fit=crop&w=800&q=80',
	),
	array(
		'brand' => __( 'Daka Vitamins', 'advay-theme' ),
		'slug'  => 'daka-vitamins',
		'alt'   => __( 'Daka Vitamins success story', 'advay-theme' ),
		'src'   => 'https://images.unsplash.com/photo-1503951914875-452162b0f3f1?auto=format&fit=crop&w=800&q=80',
	),
	array(
		'brand' => __( 'No Knife Body', 'advay-theme' ),
		'slug'  => 'no-knife-body',
		'alt'   => __( 'No Knife Body success story', 'advay-theme' ),
		'src'   => 'https://images.unsplash.com/photo-1469334031218-e382a71b716b?auto=format&fit=crop&w=800&q=80',
	),
	array(
		'brand' => __( 'Gainz & Airplanes', 'advay-theme' ),
		'slug'  => 'gainz-airplanes',
		'alt'   => __( 'Gainz & Airplanes success story', 'advay-theme' ),
		'src'   => 'https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?auto=format&fit=crop&w=800&q=80',
	),
);
?>
<div class="mega-panel mega-stories" role="region" aria-label="<?php esc_attr_e( 'Success stories', 'advay-theme' ); ?>">
	<div class="stories-mega-cards">
		<?php foreach ( $stories as $story ) : ?>
			<a class="st-card" href="<?php echo esc_url( advay_success_story_url( $story['slug'] ) ); ?>">
				<img src="<?php echo esc_url( $story['src'] ); ?>" alt="<?php echo esc_attr( $story['alt'] ); ?>">
				<span class="st-overlay">
					<span class="st-brand"><?php echo esc_html( $story['brand'] ); ?></span>
					<span class="st-more"><?php esc_html_e( 'Read More', 'advay-theme' ); ?></span>
				</span>
			</a>
		<?php endforeach; ?>
	</div>
</div>
