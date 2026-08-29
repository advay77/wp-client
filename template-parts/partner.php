<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$home = trailingslashit( home_url( '/' ) );
$front = advay_acf_front_id();
$partner_line1 = advay_get_acf( 'home_partner_line1', __( 'Get it right with Elite Prep Center.', 'advay-theme' ), $front );
$partner_line2 = advay_get_acf( 'home_partner_line2', __( 'Your partner in compliant, marketplace-ready fulfillment.', 'advay-theme' ), $front );
$pills = array(
	array(
		'label' => advay_get_acf( 'home_pill_1_label', __( 'What we do', 'advay-theme' ), $front ),
		'url'   => $home . '#services',
		'icon'  => 'slash',
		'spy'   => 'services',
	),
	array(
		'label' => advay_get_acf( 'home_pill_2_label', __( 'Who we support', 'advay-theme' ), $front ),
		'url'   => $home . '#fit-check',
		'icon'  => 'support',
		'spy'   => 'fit-check',
	),
	array(
		'label' => advay_get_acf( 'home_pill_3_label', __( 'Success stories', 'advay-theme' ), $front ),
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
			<span><?php echo esc_html( $partner_line1 ); ?></span>
			<?php echo esc_html( $partner_line2 ); ?>
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
