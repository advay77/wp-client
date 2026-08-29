<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$clips = advay_home_testimonial_clips();
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
						<?php if ( ! empty( $clip['role'] ) ) : ?>
							<span><?php echo esc_html( $clip['role'] ); ?></span>
						<?php endif; ?>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
