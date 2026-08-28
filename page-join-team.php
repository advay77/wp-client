<?php
/**
 * Join Our Team — vision and mission.
 *
 * @package Advay_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="main-content" class="os-page jt-page">
	<section class="os-intro" aria-labelledby="jt-intro-heading">
		<div class="container os-intro-grid">
			<div class="os-intro-copy">
				<p class="eyebrow"><?php esc_html_e( 'Join our team', 'advay-theme' ); ?></p>
				<h1 id="jt-intro-heading">
					<?php esc_html_e( 'Help brands scale with fulfillment that actually works.', 'advay-theme' ); ?>
				</h1>
			</div>
			<div class="os-intro-aside">
				<p><?php esc_html_e( 'We are building the operations engine behind fast-growing consumer brands — from warehouse floor to marketplace shelf. If you care about precision, pace, and people, you will fit here.', 'advay-theme' ); ?></p>
			</div>
		</div>
	</section>

	<section class="os-mission jt-mission" aria-labelledby="jt-vision-heading">
		<div class="os-mission-bg" aria-hidden="true"></div>
		<div class="container os-mission-inner">
			<div class="os-mission-block">
				<p class="os-mission-label" id="jt-vision-heading"><?php esc_html_e( 'Vision', 'advay-theme' ); ?></p>
				<p class="os-mission-text">
					<?php esc_html_e( 'To help build a million consumer brands scale faster by becoming the supply chain partner behind their growth.', 'advay-theme' ); ?>
				</p>
			</div>
			<div class="os-mission-block">
				<p class="os-mission-label"><?php esc_html_e( 'Mission', 'advay-theme' ); ?></p>
				<p class="os-mission-text">
					<?php esc_html_e( 'To make fulfillment simple, fast, and reliable for growing brands, handling the operational complexity from warehouse to marketplace and customer, so founders can focus on building their brands and creating lasting wealth.', 'advay-theme' ); ?>
				</p>
			</div>
		</div>
	</section>

	<section class="os-cta">
		<div class="container os-cta-inner">
			<h2><?php esc_html_e( 'Interested in joining ElitePrep?', 'advay-theme' ); ?></h2>
			<div class="os-cta-actions">
				<a class="button button-primary" href="<?php echo esc_url( advay_intake_email_url() ); ?>">
					<?php esc_html_e( 'Email us', 'advay-theme' ); ?>
					<span class="btn-arrow" aria-hidden="true"></span>
				</a>
				<a class="button button-ghost" href="<?php echo esc_url( advay_contact_url() ); ?>">
					<?php esc_html_e( 'Talk to the team', 'advay-theme' ); ?>
				</a>
			</div>
		</div>
	</section>
</main>

<?php
get_footer();
