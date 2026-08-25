<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$home = trailingslashit( home_url( '/' ) );
$pills = array(
	array(
		'label' => __( 'What we do', 'advay-theme' ),
		'url'   => $home . '#services',
		'icon'  => 'slash',
	),
	array(
		'label' => __( 'Testimonials', 'advay-theme' ),
		'url'   => $home . '#testimonials',
		'icon'  => 'ribbon',
	),
	array(
		'label' => __( 'Book a call with our MD', 'advay-theme' ),
		'url'   => $home . '#contact',
		'icon'  => 'call',
	),
);
?>
<section class="partner-section" id="company" aria-labelledby="partner-heading">
	<div class="container partner-inner">
		<span id="leadership" class="screen-reader-text"><?php esc_html_e( 'Leadership', 'advay-theme' ); ?></span>
		<h2 id="partner-heading" class="partner-title">
			<span><?php esc_html_e( 'Do it all with ElitePrep Center.', 'advay-theme' ); ?></span>
			<?php esc_html_e( 'Your partner in ecommerce acceleration.', 'advay-theme' ); ?>
		</h2>

		<nav class="partner-pills" aria-label="<?php esc_attr_e( 'Explore', 'advay-theme' ); ?>">
			<?php foreach ( $pills as $pill ) : ?>
				<a class="partner-pill" href="<?php echo esc_url( $pill['url'] ); ?>">
					<span class="pill-icon pill-icon-<?php echo esc_attr( $pill['icon'] ); ?>" aria-hidden="true"></span>
					<span class="pill-text"><?php echo esc_html( $pill['label'] ); ?></span>
				</a>
			<?php endforeach; ?>
		</nav>
	</div>
</section>
