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
		'title' => __( 'Lot tracking / compliance', 'advay-theme' ),
		'copy'  => __( 'We track what actually matters. Lot numbers, expiration dates, and recall-ready records, the details that protect your brand when it counts.', 'advay-theme' ),
	),
	array(
		'file'  => 'images/brandfit3.png',
		'title' => __( 'Switching / scaling', 'advay-theme' ),
		'copy'  => __( 'Outgrowing DIY, or done with the loser ones? Whether you\'re switching from a 3PL that\'s letting you down or scaling past in-house prep, we make the move seamless.', 'advay-theme' ),
	),
);
?>
<section class="fit-section" id="fit-check" aria-labelledby="fit-heading">
	<div class="container">
		<header class="fit-head">
			<p class="eyebrow"><?php esc_html_e( 'Who we support', 'advay-theme' ); ?></p>
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
			<a class="button button-primary button-fit" href="<?php echo esc_url( advay_contact_url() ); ?>">
				<?php esc_html_e( 'Get a custom quote', 'advay-theme' ); ?>
				<span class="btn-arrow" aria-hidden="true"></span>
			</a>
		</div>
	</div>
</section>
