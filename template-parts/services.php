<?php
/**
 * Homepage hub — Who we are / What we do / How to get started.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$facts = array(
	array(
		'stat' => __( '8+ Years', 'advay-theme' ),
		'text' => __( 'of hands-on experience in eCommerce fulfillment and supply chain operations.', 'advay-theme' ),
		'icon' => 'experience',
	),
	array(
		'stat' => __( '5M+ Units', 'advay-theme' ),
		'text' => __( 'prepared and shipped for thousands of marketplace sellers across categories.', 'advay-theme' ),
		'icon' => 'units',
	),
	array(
		'stat' => __( '28-Hour TAT', 'advay-theme' ),
		'text' => __( 'industry-leading average turnaround time with 98.7% accuracy rate.', 'advay-theme' ),
		'icon' => 'tat',
	),
);

$flow_inbound = array(
	array(
		'label' => __( 'Receive', 'advay-theme' ),
		'text'  => __( 'We receive and verify your inventory.', 'advay-theme' ),
		'icon'  => 'receive',
	),
	array(
		'label' => __( 'Inspect', 'advay-theme' ),
		'text'  => __( 'We inspect every unit to spec.', 'advay-theme' ),
		'icon'  => 'target',
	),
	array(
		'label' => __( 'Prep', 'advay-theme' ),
		'text'  => __( 'We prep marketplace-ready.', 'advay-theme' ),
		'icon'  => 'prep',
	),
);

$flow_outbound = array(
	array(
		'label' => __( 'Pack', 'advay-theme' ),
		'text'  => __( 'We pack and label marketplace-ready.', 'advay-theme' ),
		'icon'  => 'pack',
	),
	array(
		'label' => __( 'Ship', 'advay-theme' ),
		'text'  => __( 'We ship to Amazon, Walmart or others.', 'advay-theme' ),
		'icon'  => 'ship',
	),
	array(
		'label' => __( 'Report', 'advay-theme' ),
		'text'  => __( 'You get full visibility and reporting.', 'advay-theme' ),
		'icon'  => 'report',
	),
);

$steps = array(
	array(
		'num'   => '01',
		'title' => __( 'Share your SKUs', 'advay-theme' ),
		'text'  => __( 'Send your packing list, FNSKUs or GTINs, and any special prep requirements.', 'advay-theme' ),
		'icon'  => 'sku',
	),
	array(
		'num'   => '02',
		'title' => __( 'Ship inbound', 'advay-theme' ),
		'text'  => __( 'Freight or parcel to our warehouse. We receive, count and flag exceptions.', 'advay-theme' ),
		'icon'  => 'inbound',
	),
	array(
		'num'   => '03',
		'title' => __( 'We prep to spec', 'advay-theme' ),
		'text'  => __( 'Label, bag, inspect, bundle or prep according to your requirements.', 'advay-theme' ),
		'icon'  => 'prep',
	),
	array(
		'num'   => '04',
		'title' => __( 'We forward', 'advay-theme' ),
		'text'  => __( 'Shipments leave for Amazon, Walmart or your marketplace of choice — with tracking.', 'advay-theme' ),
		'icon'  => 'forward',
	),
);
?>
<section class="home-hub" id="services" aria-labelledby="home-hub-heading">
	<div class="container">
		<article class="home-hub-card">
			<div class="home-hub-grid">
				<div class="home-hub-col home-hub-who">
					<p class="home-hub-kicker"><?php esc_html_e( 'Who are we', 'advay-theme' ); ?></p>
					<h2 id="home-hub-heading"><?php esc_html_e( 'Three facts that define us.', 'advay-theme' ); ?></h2>
					<div class="home-hub-lead-slot">
						<p class="home-hub-lead"><?php esc_html_e( 'A fulfillment partner built on experience, precision, and performance.', 'advay-theme' ); ?></p>
					</div>
					<a class="button button-primary home-hub-cta" href="<?php echo esc_url( advay_our_story_url() ); ?>">
						<?php esc_html_e( 'Know more about us', 'advay-theme' ); ?>
						<span class="btn-arrow" aria-hidden="true"></span>
					</a>
					<div class="home-hub-col-body">
						<ul class="home-hub-facts">
							<?php foreach ( $facts as $fact ) : ?>
								<li>
									<span class="home-hub-icon home-hub-icon--fact" aria-hidden="true">
										<?php echo advay_home_hub_icon( $fact['icon'], 20 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									</span>
									<span class="home-hub-fact-copy">
										<strong><?php echo esc_html( $fact['stat'] ); ?></strong>
										<?php echo esc_html( $fact['text'] ); ?>
									</span>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>

				<div class="home-hub-col home-hub-what">
					<p class="home-hub-kicker"><?php esc_html_e( 'What we do', 'advay-theme' ); ?></p>
					<h2><?php esc_html_e( 'Every step from dock to fulfillment center.', 'advay-theme' ); ?></h2>
					<div class="home-hub-lead-slot">
						<p class="home-hub-lead home-hub-sub"><?php esc_html_e( 'You send inventory; we return marketplace-ready shipments and a clear paper trail.', 'advay-theme' ); ?></p>
					</div>
					<a class="button button-primary home-hub-cta" href="<?php echo esc_url( advay_services_url() ); ?>">
						<?php esc_html_e( 'Explore what we do', 'advay-theme' ); ?>
						<span class="btn-arrow" aria-hidden="true"></span>
					</a>
					<div class="home-hub-col-body">
						<div class="home-hub-flow" aria-label="<?php esc_attr_e( 'Our process', 'advay-theme' ); ?>">
							<div class="home-hub-flow-row home-hub-flow-row--three">
								<?php foreach ( $flow_inbound as $item ) : ?>
									<div class="home-hub-flow-step">
										<span class="home-hub-icon home-hub-icon--flow" aria-hidden="true">
											<?php echo advay_home_hub_icon( $item['icon'], 20 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
										</span>
										<strong><?php echo esc_html( $item['label'] ); ?></strong>
										<span><?php echo esc_html( $item['text'] ); ?></span>
									</div>
								<?php endforeach; ?>
							</div>
							<div class="home-hub-flow-row home-hub-flow-row--three">
								<?php foreach ( $flow_outbound as $item ) : ?>
									<div class="home-hub-flow-step">
										<span class="home-hub-icon home-hub-icon--flow" aria-hidden="true">
											<?php echo advay_home_hub_icon( $item['icon'], 20 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
										</span>
										<strong><?php echo esc_html( $item['label'] ); ?></strong>
										<span><?php echo esc_html( $item['text'] ); ?></span>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>

				<div class="home-hub-col home-hub-start" id="how-it-works">
					<p class="home-hub-kicker"><?php esc_html_e( 'How to get started', 'advay-theme' ); ?></p>
					<h2><?php esc_html_e( 'Four steps. No mystery.', 'advay-theme' ); ?></h2>
					<div class="home-hub-lead-slot">
						<p class="home-hub-lead"><?php esc_html_e( 'Getting started is simple. Share your SKUs, send us your inventory, and we\'ll handle the rest.', 'advay-theme' ); ?></p>
					</div>
					<a class="button button-primary home-hub-cta" href="<?php echo esc_url( advay_onboarding_url() ); ?>">
						<?php esc_html_e( 'Start your onboarding', 'advay-theme' ); ?>
						<span class="btn-arrow" aria-hidden="true"></span>
					</a>
					<div class="home-hub-col-body">
						<div class="home-hub-steps">
							<?php foreach ( $steps as $step ) : ?>
								<article class="home-hub-step-card">
									<span class="home-hub-step-num"><?php echo esc_html( $step['num'] ); ?></span>
									<span class="home-hub-icon home-hub-icon--step" aria-hidden="true">
										<?php echo advay_home_hub_icon( $step['icon'], 18 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									</span>
									<h3><?php echo esc_html( $step['title'] ); ?></h3>
									<p><?php echo esc_html( $step['text'] ); ?></p>
								</article>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		</article>
	</div>
</section>
