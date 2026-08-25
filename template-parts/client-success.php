<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$photo = get_template_directory() . '/assets/images/client-success.jpg';
$src   = file_exists( $photo ) ? advay_asset_uri( 'images/client-success.jpg' ) : advay_asset_uri( 'images/client-success.png' );
?>
<section class="success-section" id="client-success" aria-labelledby="success-heading">
	<div class="container success-grid">
		<div class="success-copy">
			<p class="success-kicker"><?php esc_html_e( 'Client success', 'advay-theme' ); ?></p>
			<h2 id="success-heading">
				<?php esc_html_e( 'Talk to a human who', 'advay-theme' ); ?>
				<span><?php esc_html_e( 'knows your name.', 'advay-theme' ); ?></span>
			</h2>
			<p><?php esc_html_e( 'At most 3PLs, you are just a number. Handed off between reps who do not know you, re-explaining your business every time.', 'advay-theme' ); ?></p>
			<p><?php esc_html_e( 'Not here. You get a real, U.S.-based person who knows your account, with a direct line to the warehouse floor. Something is off? They get the right people on it, fast.', 'advay-theme' ); ?></p>
		</div>
		<figure class="success-frame">
			<img src="<?php echo esc_url( $src ); ?>" alt="<?php esc_attr_e( 'Director of Client Success on the warehouse floor', 'advay-theme' ); ?>">
			<figcaption><?php esc_html_e( 'Director of Client Success, Cole Sweetser', 'advay-theme' ); ?></figcaption>
		</figure>
	</div>
</section>
