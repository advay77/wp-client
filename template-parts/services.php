<?php
/**
 * Homepage hub — Who we are / What we do / How to get started.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$facts         = advay_home_hub_facts();
$flow_inbound  = advay_home_hub_flow_inbound();
$flow_outbound = advay_home_hub_flow_outbound();
$steps         = advay_home_hub_steps();

$front = advay_acf_front_id();
$hub_who_kicker   = advay_get_acf( 'home_hub_who_kicker', __( 'Who are we', 'advay-theme' ), $front );
$hub_who_heading  = advay_get_acf( 'home_hub_who_heading', __( 'Three facts that define us.', 'advay-theme' ), $front );
$hub_who_lead     = advay_get_acf( 'home_hub_who_lead', __( 'A fulfillment partner built on experience, precision, and performance.', 'advay-theme' ), $front );
$hub_what_kicker  = advay_get_acf( 'home_hub_what_kicker', __( 'What we do', 'advay-theme' ), $front );
$hub_what_heading = advay_get_acf( 'home_hub_what_heading', __( 'Every step from dock to fulfillment center.', 'advay-theme' ), $front );
$hub_what_lead    = advay_get_acf( 'home_hub_what_lead', __( 'You send inventory; we return marketplace-ready shipments and a clear paper trail.', 'advay-theme' ), $front );
$hub_how_kicker   = advay_get_acf( 'home_hub_how_kicker', __( 'How to get started', 'advay-theme' ), $front );
$hub_how_heading  = advay_get_acf( 'home_hub_how_heading', __( 'Four steps. No mystery.', 'advay-theme' ), $front );
$hub_how_lead     = advay_get_acf( 'home_hub_how_lead', __( 'Getting started is simple. Share your SKUs, send us your inventory, and we\'ll handle the rest.', 'advay-theme' ), $front );

$cta_who  = advay_get_acf( 'home_hub_cta_who', __( 'Know more about us', 'advay-theme' ), $front );
$cta_what = advay_get_acf( 'home_hub_cta_what', __( 'Explore what we do', 'advay-theme' ), $front );
$cta_how  = advay_get_acf( 'home_hub_cta_how', __( 'Start your onboarding', 'advay-theme' ), $front );
?>
<section class="home-hub" id="services" aria-labelledby="home-hub-heading">
	<div class="container">
		<article class="home-hub-card">
			<div class="home-hub-grid">
				<div class="home-hub-col home-hub-who">
					<p class="home-hub-kicker"><?php echo esc_html( $hub_who_kicker ); ?></p>
					<h2 id="home-hub-heading"><?php echo esc_html( $hub_who_heading ); ?></h2>
					<div class="home-hub-lead-slot">
						<p class="home-hub-lead"><?php echo esc_html( $hub_who_lead ); ?></p>
					</div>
					<a class="button button-primary home-hub-cta" href="<?php echo esc_url( advay_our_story_url() ); ?>">
						<?php echo esc_html( $cta_who ); ?>
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
					<p class="home-hub-kicker"><?php echo esc_html( $hub_what_kicker ); ?></p>
					<h2><?php echo esc_html( $hub_what_heading ); ?></h2>
					<div class="home-hub-lead-slot">
						<p class="home-hub-lead home-hub-sub"><?php echo esc_html( $hub_what_lead ); ?></p>
					</div>
					<a class="button button-primary home-hub-cta" href="<?php echo esc_url( advay_receiving_url() ); ?>">
						<?php echo esc_html( $cta_what ); ?>
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
					<p class="home-hub-kicker"><?php echo esc_html( $hub_how_kicker ); ?></p>
					<h2><?php echo esc_html( $hub_how_heading ); ?></h2>
					<div class="home-hub-lead-slot">
						<p class="home-hub-lead"><?php echo esc_html( $hub_how_lead ); ?></p>
					</div>
					<a class="button button-primary home-hub-cta" href="<?php echo esc_url( advay_onboarding_url() ); ?>">
						<?php echo esc_html( $cta_how ); ?>
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
