<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$front       = advay_acf_front_id();
$niche_cards = advay_home_fit_niche_cards();
$spec_cards  = advay_home_fit_spec_cards();

$fit_eyebrow = advay_get_acf( 'home_fit_eyebrow', __( 'Who we support', 'advay-theme' ), $front );
$fit_heading = advay_get_acf( 'home_fit_heading', __( 'Not every brand is a fit.', 'advay-theme' ), $front );
$fit_accent  = advay_get_acf( 'home_fit_heading_accent', __( 'Are you?', 'advay-theme' ), $front );
$fit_lead    = advay_get_acf( 'home_fit_lead', __( 'You\'re probably a fit if these sound like you.', 'advay-theme' ), $front );

$fit_cta       = advay_get_acf( 'home_fit_cta', '', $front );
$fit_cta_label = advay_acf_link_title( $fit_cta, __( 'Get a custom quote', 'advay-theme' ) );
$fit_cta_url   = advay_acf_link_url( $fit_cta, advay_contact_url() );
$fit_tab_niche = advay_get_acf( 'home_fit_tab_niche', __( 'Niche', 'advay-theme' ), $front );
$fit_tab_spec  = advay_get_acf( 'home_fit_tab_spec', __( 'Specification', 'advay-theme' ), $front );
?>
<section class="fit-section" id="fit-check" aria-labelledby="fit-heading">
	<div class="container">
		<header class="fit-head">
			<p class="eyebrow"><?php echo esc_html( $fit_eyebrow ); ?></p>
			<h2 id="fit-heading">
				<?php echo esc_html( $fit_heading ); ?>
				<span><?php echo esc_html( $fit_accent ); ?></span>
			</h2>
			<p class="fit-lead"><?php echo esc_html( $fit_lead ); ?></p>

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
					<?php echo esc_html( $fit_tab_niche ); ?>
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
					<?php echo esc_html( $fit_tab_spec ); ?>
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
								src="<?php echo esc_url( $card['src'] ); ?>"
								alt="<?php echo esc_attr( $card['alt'] ); ?>"
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
					<article class="fit-card fit-card--niche">
						<div class="fit-card-visual">
							<img
								src="<?php echo esc_url( $card['src'] ); ?>"
								alt="<?php echo esc_attr( $card['alt'] ); ?>"
								width="1536"
								height="1024"
								loading="lazy"
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

		<div class="fit-cta">
			<a class="button button-primary button-fit" href="<?php echo esc_url( $fit_cta_url ); ?>">
				<?php echo esc_html( $fit_cta_label ); ?>
				<span class="btn-arrow" aria-hidden="true"></span>
			</a>
		</div>
	</div>
</section>
