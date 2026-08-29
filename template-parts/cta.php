<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$front = advay_acf_front_id();

$cta_eyebrow = advay_get_acf( 'home_cta_eyebrow', __( 'Intake', 'advay-theme' ), $front );
$cta_heading = advay_get_acf( 'home_cta_heading', __( 'Send your next inbound to a warehouse that prep is built for.', 'advay-theme' ), $front );
$cta_copy    = advay_get_acf( 'home_cta_copy', __( 'Share SKU counts, marketplace, and timing. We will reply with capacity, pricing structure, and a receiving plan.', 'advay-theme' ), $front );

$cta_primary       = advay_get_acf( 'home_cta_primary', '', $front );
$cta_primary_label = advay_acf_link_title( $cta_primary, __( 'Email intake', 'advay-theme' ) );
$cta_primary_url   = advay_acf_link_url( $cta_primary, advay_intake_email_url() );

$cta_secondary       = advay_get_acf( 'home_cta_secondary', '', $front );
$cta_secondary_label = advay_acf_link_title( $cta_secondary, __( 'Call the warehouse', 'advay-theme' ) );
$cta_secondary_url   = advay_acf_link_url( $cta_secondary, advay_intake_phone_url() );
?>
<section class="cta-section" id="contact" aria-labelledby="cta-heading">
	<div class="container cta-inner">
		<div>
			<p class="eyebrow"><?php echo esc_html( $cta_eyebrow ); ?></p>
			<h2 id="cta-heading"><?php echo esc_html( $cta_heading ); ?></h2>
			<p class="cta-copy"><?php echo esc_html( $cta_copy ); ?></p>
		</div>
		<div class="cta-actions">
			<a class="button button-light" href="<?php echo esc_url( $cta_primary_url ); ?>">
				<?php echo esc_html( $cta_primary_label ); ?>
				<span class="btn-arrow" aria-hidden="true"></span>
			</a>
			<a class="button button-ghost-light" href="<?php echo esc_url( $cta_secondary_url ); ?>">
				<?php echo esc_html( $cta_secondary_label ); ?>
				<span class="btn-arrow" aria-hidden="true"></span>
			</a>
		</div>
	</div>
</section>
