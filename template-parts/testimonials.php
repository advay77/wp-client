<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$clips = array(
	array(
		'chip'  => __( 'Ajayi Popcorn', 'advay-theme' ),
		'quote' => __( '“Seasonal spikes used to break us. ElitePrep scales with demand — every launch ships on time.”', 'advay-theme' ),
		'brand' => __( 'Ajayi Popcorn', 'advay-theme' ),
		'video' => advay_asset_uri( 'video/testimonials2.mp4' ),
	),
	array(
		'chip'  => __( 'No Knife Body', 'advay-theme' ),
		'quote' => __( '“Best decision we ever made — choosing ElitePrep.”', 'advay-theme' ),
		'brand' => __( 'No Knife Body', 'advay-theme' ),
		'video' => advay_asset_uri( 'video/testimonials.mp4' ),
	),
	array(
		'chip'  => __( 'Daka Vitamins', 'advay-theme' ),
		'quote' => __( '“Labeling and lot tracking used to slow every inbound. ElitePrep keeps our prep compliant and in stock.”', 'advay-theme' ),
		'brand' => __( 'Daka Vitamins', 'advay-theme' ),
		'video' => advay_asset_uri( 'video/testimonials3.mp4' ),
	),
);
?>
<section class="stories-section" id="testimonials" aria-labelledby="stories-heading">
	<div class="container">
		<header class="section-heading stories-heading">
			<p class="eyebrow"><?php esc_html_e( 'Success stories', 'advay-theme' ); ?></p>
			<h2 id="stories-heading"><?php esc_html_e( 'Brands that grow with ElitePrep Center.', 'advay-theme' ); ?></h2>
		</header>

		<div class="stories-grid stories-grid--videos">
			<?php foreach ( $clips as $clip ) : ?>
				<article class="story-media is-tall">
					<video muted loop playsinline preload="metadata">
						<source src="<?php echo esc_url( $clip['video'] ); ?>" type="video/mp4">
					</video>
					<div class="story-media-ui">
						<span class="story-chip"><?php echo esc_html( $clip['chip'] ); ?></span>
						<button type="button" class="story-mute" aria-label="<?php esc_attr_e( 'Toggle sound', 'advay-theme' ); ?>"></button>
					</div>
					<div class="story-media-copy">
						<p><?php echo esc_html( $clip['quote'] ); ?></p>
						<strong><?php echo esc_html( $clip['brand'] ); ?></strong>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
