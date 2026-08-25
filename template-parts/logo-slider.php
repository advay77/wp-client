<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$logos = array(
	array( 'name' => 'Little Bay Caribbean Kitchen', 'file' => 'images/brand-littlebay.jpg' ),
	array( 'name' => 'Gainz & Airplanes', 'file' => 'images/brand-gainz.jpg' ),
	array( 'name' => "Anola's Creations", 'file' => 'images/brand-anola.jpg' ),
	array( 'name' => 'Boluwaji Popcorn', 'file' => 'images/brand-ajayi.jpg' ),
	array( 'name' => 'Daka', 'file' => 'images/brand-daka.png' ),
	array( 'name' => 'No Knife', 'file' => 'images/brand-noknife.png' ),
);

$slides = array();
foreach ( $logos as $logo ) {
	$path = get_template_directory() . '/assets/' . $logo['file'];
	if ( file_exists( $path ) ) {
		$slides[] = array(
			'name' => $logo['name'],
			'src'  => advay_asset_uri( $logo['file'] ),
		);
	}
}

if ( ! $slides ) {
	return;
}
?>
<section class="logo-slider" aria-label="<?php esc_attr_e( 'Brand logos', 'advay-theme' ); ?>">
	<div class="logo-slider-inner">
		<div class="logo-slider-viewport">
			<ul class="logo-slider-list">
				<?php foreach ( $slides as $slide ) : ?>
					<li>
						<img
							src="<?php echo esc_url( $slide['src'] ); ?>"
							alt="<?php echo esc_attr( $slide['name'] ); ?>"
							decoding="async"
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
