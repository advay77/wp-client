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
		'spy'   => 'services',
	),
	array(
		'label' => __( 'Who we support', 'advay-theme' ),
		'url'   => $home . '#fit-check',
		'icon'  => 'support',
		'spy'   => 'fit-check',
	),
	array(
		'label' => __( 'Success stories', 'advay-theme' ),
		'url'   => $home . '#testimonials',
		'icon'  => 'ribbon',
		'spy'   => 'testimonials',
	),
);
?>
<section class="partner-section" id="company" aria-labelledby="partner-heading">
	<div class="container partner-inner">
		<span id="leadership" class="screen-reader-text"><?php esc_html_e( 'Leadership', 'advay-theme' ); ?></span>
		<h2 id="partner-heading" class="partner-title">
			<span><?php esc_html_e( 'Get it right with Elite Prep Center.', 'advay-theme' ); ?></span>
			<?php esc_html_e( 'Your partner in compliant, marketplace-ready fulfillment.', 'advay-theme' ); ?>
		</h2>
	</div>
</section>

<div class="partner-pills-dock" data-partner-dock>
	<nav class="partner-pills" data-partner-pills aria-label="<?php esc_attr_e( 'Explore', 'advay-theme' ); ?>">
		<?php foreach ( $pills as $index => $pill ) : ?>
			<a
				class="partner-pill<?php echo 0 === $index ? ' is-active' : ''; ?>"
				href="<?php echo esc_url( $pill['url'] ); ?>"
				data-spy-target="<?php echo esc_attr( $pill['spy'] ); ?>"
			>
				<span class="pill-icon pill-icon-<?php echo esc_attr( $pill['icon'] ); ?>" aria-hidden="true"></span>
				<span class="pill-text"><?php echo esc_html( $pill['label'] ); ?></span>
			</a>
		<?php endforeach; ?>
	</nav>
</div>
