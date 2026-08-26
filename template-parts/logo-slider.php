<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$slides = advay_brand_logos();
if ( ! $slides ) {
	return;
}

/* Duplicate once so desktop (and mobile) always have overflow to scroll. */
$loop_slides = array_merge( $slides, $slides );
?>
<section class="logo-slider" aria-label="<?php esc_attr_e( 'Brand logos', 'advay-theme' ); ?>">
	<div class="logo-slider-inner">
		<div class="logo-slider-viewport" tabindex="0">
			<ul class="logo-slider-list">
				<?php foreach ( $loop_slides as $index => $slide ) : ?>
					<li<?php echo $index >= count( $slides ) ? ' aria-hidden="true"' : ''; ?>>
						<img
							src="<?php echo esc_url( $slide['src'] ); ?>"
							alt="<?php echo $index >= count( $slides ) ? '' : esc_attr( $slide['name'] ); ?>"
							decoding="async"
							draggable="false"
						>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<div class="logo-slider-bar">
			<button class="logo-slider-btn is-prev" type="button" aria-label="<?php esc_attr_e( 'Previous logos', 'advay-theme' ); ?>"></button>
			<div class="logo-slider-rail" aria-hidden="true">
				<span class="logo-slider-thumb"></span>
			</div>
			<button class="logo-slider-btn is-next" type="button" aria-label="<?php esc_attr_e( 'Next logos', 'advay-theme' ); ?>"></button>
		</div>
	</div>
</section>
