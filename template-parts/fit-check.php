<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$states = array(
	array(
		'file'  => 'images/brandfit1.png',
		'title' => __( 'You sell products that go in or on the body', 'advay-theme' ),
		'copy'  => __( 'supplements, skincare, haircare, oral care, body care, or packaged food — where trust and safety aren’t optional', 'advay-theme' ),
	),
	array(
		'file'  => 'images/brandfit2.png',
		'title' => __( 'You need real lot tracking and expiration-date accuracy', 'advay-theme' ),
		'copy'  => __( 'not a 3PL that treats compliance as an afterthought', 'advay-theme' ),
	),
	array(
		'file'  => 'images/brandfit3.png',
		'title' => __( 'You’re ready to fix a broken fulfillment setup or scale a growing one', 'advay-theme' ),
		'copy'  => __( 'whether that means switching from a 3PL that’s dropping the ball, or outgrowing DIY prep', 'advay-theme' ),
	),
);
?>
<section class="fit-section" id="fit-check" aria-labelledby="fit-heading" data-fit-story>
	<div class="fit-wash" aria-hidden="true"></div>

	<div class="fit-pin" data-fit-pin>
		<div class="fit-stage">
			<div class="fit-left">
				<p class="eyebrow"><?php esc_html_e( 'How we work with', 'advay-theme' ); ?></p>
				<h2 id="fit-heading">
					<?php esc_html_e( 'Not every brand is a fit.', 'advay-theme' ); ?>
					<span><?php esc_html_e( 'Are you?', 'advay-theme' ); ?></span>
				</h2>
				<p class="fit-lead"><?php esc_html_e( 'You\'re probably a fit if these sound like you.', 'advay-theme' ); ?></p>

				<div class="fit-progress" aria-hidden="true">
					<span class="fit-progress-count"><b data-fit-index>01</b> / 03</span>
					<span class="fit-progress-bars">
						<?php for ( $i = 0; $i < 3; $i++ ) : ?>
							<span class="fit-bar<?php echo 0 === $i ? ' is-on' : ''; ?>" data-fit-bar="<?php echo esc_attr( $i ); ?>"></span>
						<?php endfor; ?>
					</span>
				</div>
			</div>

			<div class="fit-visual">
				<?php foreach ( $states as $i => $state ) : ?>
					<img
						class="fit-visual-img<?php echo 0 === $i ? ' is-active' : ''; ?>"
						src="<?php echo esc_url( advay_asset_uri( $state['file'] ) ); ?>"
						alt="<?php echo esc_attr( $state['title'] ); ?>"
						width="1536"
						height="1024"
						loading="<?php echo 0 === $i ? 'eager' : 'lazy'; ?>"
						decoding="async"
						data-fit-image="<?php echo esc_attr( $i ); ?>"
					>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

	<div class="fit-after">
		<div class="fit-after-inner">
			<p class="fit-note"><?php esc_html_e( 'Tell us what you ship and you will get a straight answer: a custom quote if we are a fit, a referral to a better-matched 3PL if we are not.', 'advay-theme' ); ?></p>
			<a class="button button-primary button-fit" href="<?php echo esc_url( advay_contact_url() ); ?>">
				<?php esc_html_e( 'Get a custom quote', 'advay-theme' ); ?>
				<span class="btn-arrow" aria-hidden="true"></span>
			</a>
		</div>
	</div>
</section>
