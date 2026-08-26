<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$niche_cards = array(
	array(
		'file'  => 'images/brandfit1.png',
		'tag'   => __( 'Health & Wellness', 'advay-theme' ),
		'title' => __( 'Health & Wellness', 'advay-theme' ),
		'copy'  => __( 'Health & wellness runs on credibility. ElitePrep helps you scale without compromising the trust you\'ve built.', 'advay-theme' ),
	),
	array(
		'file'  => 'images/niche-beauty.jpg',
		'tag'   => __( 'Beauty', 'advay-theme' ),
		'title' => __( 'Beauty', 'advay-theme' ),
		'copy'  => __( 'Beauty is built on identity. ElitePrep makes sure yours shines on every marketplace.', 'advay-theme' ),
	),
	array(
		'file'  => 'images/niche-packaged-food.jpg',
		'tag'   => __( 'Packaged Food', 'advay-theme' ),
		'title' => __( 'Packaged Food', 'advay-theme' ),
		'copy'  => __( 'Packaged food lives and dies by shelf life. Elite Prep Center keeps your lot tracking and expiration dates airtight.', 'advay-theme' ),
	),
);

$spec_cards = array(
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

			<div class="fit-tabs" role="tablist" aria-label="<?php esc_attr_e( 'Fit categories', 'advay-theme' ); ?>">
				<button
					type="button"
					class="fit-tab is-active"
					role="tab"
					id="fit-tab-niche"
					aria-selected="true"
					aria-controls="fit-panel-niche"
					data-fit-tab="niche"
				>
					<?php esc_html_e( 'Niche', 'advay-theme' ); ?>
				</button>
				<button
					type="button"
					class="fit-tab"
					role="tab"
					id="fit-tab-spec"
					aria-selected="false"
					aria-controls="fit-panel-spec"
					data-fit-tab="spec"
				>
					<?php esc_html_e( 'Specification', 'advay-theme' ); ?>
				</button>
			</div>
		</header>

		<div
			class="fit-panel is-active"
			id="fit-panel-niche"
			role="tabpanel"
			aria-labelledby="fit-tab-niche"
			data-fit-panel="niche"
		>
			<div class="fit-cards fit-cards--niche">
				<?php foreach ( $niche_cards as $i => $card ) : ?>
					<article class="fit-card fit-card--niche">
						<div class="fit-card-visual">
							<img
								src="<?php echo esc_url( advay_asset_uri( $card['file'] ) ); ?>"
								alt=""
								width="1536"
								height="1024"
								loading="<?php echo 0 === $i ? 'eager' : 'lazy'; ?>"
								decoding="async"
							>
							<span class="fit-card-tag"><?php echo esc_html( $card['tag'] ); ?></span>
						</div>
						<div class="fit-card-body">
							<h3 class="screen-reader-text"><?php echo esc_html( $card['title'] ); ?></h3>
							<p><?php echo esc_html( $card['copy'] ); ?></p>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>

		<div
			class="fit-panel"
			id="fit-panel-spec"
			role="tabpanel"
			aria-labelledby="fit-tab-spec"
			data-fit-panel="spec"
			hidden
		>
			<div class="fit-cards fit-cards--spec">
				<?php foreach ( $spec_cards as $i => $card ) : ?>
					<article class="fit-card">
						<div class="fit-card-visual">
							<img
								src="<?php echo esc_url( advay_asset_uri( $card['file'] ) ); ?>"
								alt=""
								width="1536"
								height="1024"
								loading="lazy"
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
		</div>

		<div class="fit-cta">
			<a class="button button-primary button-fit" href="<?php echo esc_url( advay_contact_url() ); ?>">
				<?php esc_html_e( 'Get a custom quote', 'advay-theme' ); ?>
				<span class="btn-arrow" aria-hidden="true"></span>
			</a>
		</div>
	</div>
</section>
