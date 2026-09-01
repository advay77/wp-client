<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$clips = advay_home_testimonial_clips();
$front = advay_acf_front_id();
$stories_eyebrow = advay_get_acf( 'home_stories_eyebrow', __( 'Success stories', 'advay-theme' ), $front );
$stories_heading = advay_get_acf( 'home_stories_heading', __( 'Brands that grow with ElitePrep Center.', 'advay-theme' ), $front );
?>
<section class="stories-section" id="testimonials" aria-labelledby="stories-heading">
	<div class="container">
		<header class="section-heading stories-heading">
			<p class="eyebrow"><?php echo esc_html( $stories_eyebrow ); ?></p>
			<h2 id="stories-heading"><?php echo esc_html( $stories_heading ); ?></h2>
		</header>

		<div class="stories-grid stories-grid--videos">
			<?php foreach ( $clips as $clip ) : ?>
				<article class="story-media is-tall">
					<video muted loop playsinline preload="metadata"<?php echo ! empty( $clip['poster'] ) ? ' poster="' . esc_url( $clip['poster'] ) . '"' : ''; ?>>
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
