<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$founders = advay_founder_portraits();
if ( empty( $founders ) ) {
	$photo = get_template_directory() . '/assets/images/client-success.jpg';
	$founders = array(
		array(
			'src'     => file_exists( $photo ) ? advay_asset_uri( 'images/client-success.jpg' ) : advay_asset_uri( 'images/client-success.png' ),
			'caption' => __( 'Director of Client Success, Cole Sweetser', 'advay-theme' ),
		),
	);
}

$md_url      = home_url( '/#company' );
$book_md_url = advay_onboarding_url();
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

			<div class="success-actions">
				<a class="button button-primary" href="<?php echo esc_url( $book_md_url ); ?>">
					<?php esc_html_e( 'Book a call with our MD', 'advay-theme' ); ?>
					<span class="btn-arrow" aria-hidden="true"></span>
				</a>
				<a class="button button-primary" href="<?php echo esc_url( $md_url ); ?>">
					<?php esc_html_e( 'Know more about our Managing Director', 'advay-theme' ); ?>
				</a>
			</div>
		</div>
		<figure class="success-frame" data-founder-rotate>
			<div class="success-photo-stack">
				<?php foreach ( $founders as $index => $person ) : ?>
					<img
						class="success-founder-photo<?php echo 0 === $index ? ' is-active' : ''; ?>"
						src="<?php echo esc_url( $person['src'] ); ?>"
						alt="<?php echo esc_attr( $person['caption'] ); ?>"
						loading="<?php echo 0 === $index ? 'eager' : 'lazy'; ?>"
						decoding="async"
						data-founder-photo
						data-founder-caption="<?php echo esc_attr( $person['caption'] ); ?>"
					>
				<?php endforeach; ?>
			</div>
			<figcaption><?php esc_html_e( 'Managing Director, Odi Ikpe', 'advay-theme' ); ?></figcaption>
		</figure>
	</div>
</section>
