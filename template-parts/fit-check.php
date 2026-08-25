<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cards = array(
	array(
		'file'  => 'images/brandfit1.png',
		'title' => __( 'You sell products that go in or on the body', 'advay-theme' ),
		'copy'  => __( 'Supplements, skincare, haircare, oral care, body care, or packaged food — where trust and safety aren’t optional.', 'advay-theme' ),
	),
	array(
		'file'  => 'images/brandfit2.png',
		'title' => __( 'You need real lot tracking and expiration-date accuracy', 'advay-theme' ),
		'copy'  => __( 'Not a 3PL that treats compliance as an afterthought.', 'advay-theme' ),
	),
	array(
		'file'  => 'images/brandfit3.png',
		'title' => __( 'You’re ready to fix a broken fulfillment setup or scale a growing one', 'advay-theme' ),
		'copy'  => __( 'Whether that means switching from a 3PL that’s dropping the ball, or outgrowing DIY prep.', 'advay-theme' ),
	),
);
?>
<section class="fit-section" id="fit-check" aria-labelledby="fit-heading">
	<div class="container">
		<header class="fit-head">
			<p class="eyebrow"><?php esc_html_e( 'How we work with', 'advay-theme' ); ?></p>
			<h2 id="fit-heading">
				<?php esc_html_e( 'Not every brand is a fit.', 'advay-theme' ); ?>
				<span><?php esc_html_e( 'Are you?', 'advay-theme' ); ?></span>
			</h2>
			<p class="fit-lead"><?php esc_html_e( 'You\'re probably a fit if these sound like you.', 'advay-theme' ); ?></p>
		</header>

		<div class="fit-cards">
			<?php foreach ( $cards as $i => $card ) : ?>
				<article class="fit-card">
					<div class="fit-card-visual">
						<img
							src="<?php echo esc_url( advay_asset_uri( $card['file'] ) ); ?>"
							alt=""
							width="1536"
							height="1024"
							loading="<?php echo 0 === $i ? 'eager' : 'lazy'; ?>"
							decoding="async"
						>
					</div>
					<div class="fit-card-body">
						<span class="fit-card-num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
						<h3><?php echo esc_html( $card['title'] ); ?></h3>
						<p><?php echo esc_html( $card['copy'] ); ?></p>
					</div>
				</article>
			<?php endforeach; ?>
		</div>

		<div class="fit-cta">
			<p class="fit-note"><?php esc_html_e( 'Tell us what you ship and you will get a straight answer: a custom quote if we are a fit, a referral to a better-matched 3PL if we are not.', 'advay-theme' ); ?></p>
			<a class="button button-primary button-fit" href="<?php echo esc_url( advay_contact_url() ); ?>">
				<?php esc_html_e( 'Get a custom quote', 'advay-theme' ); ?>
				<span class="btn-arrow" aria-hidden="true"></span>
			</a>
		</div>
	</div>
</section>
