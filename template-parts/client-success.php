<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$front = advay_acf_front_id();

$success_caption = advay_get_acf(
	'home_success_caption',
	__( 'Managing Director, Odi Ikpe', 'advay-theme' ),
	$front
);

$kicker    = advay_get_acf( 'home_success_kicker', __( 'Client success', 'advay-theme' ), $front );
$heading_1 = advay_get_acf( 'home_success_heading_1', __( 'Talk to a human who', 'advay-theme' ), $front );
$heading_2 = advay_get_acf( 'home_success_heading_2', __( 'knows your name.', 'advay-theme' ), $front );
$p1        = advay_get_acf( 'home_success_p1', __( 'At most 3PLs, you are just a number. Handed off between reps who do not know you, re-explaining your business every time.', 'advay-theme' ), $front );
$p2        = advay_get_acf( 'home_success_p2', __( 'Not here. You get a real, U.S.-based person who knows your account, with a direct line to the warehouse floor. Something is off? They get the right people on it, fast.', 'advay-theme' ), $front );

$md_url = advay_managing_director_url();

$success_cta_primary       = advay_get_acf( 'home_success_cta_primary', '', $front );
$success_cta_primary_label = advay_acf_link_title( $success_cta_primary, __( 'Book a call with our MD', 'advay-theme' ) );
$success_cta_primary_url   = advay_acf_book_call_link_url( $success_cta_primary, advay_book_call_url() );

$success_cta_secondary       = advay_get_acf( 'home_success_cta_secondary', '', $front );
$success_cta_secondary_label = advay_acf_link_title( $success_cta_secondary, __( 'Know more about our Managing Director', 'advay-theme' ) );
$success_cta_secondary_url   = advay_acf_link_url( $success_cta_secondary, $md_url );
?>
<section class="success-section" id="client-success" aria-labelledby="success-heading">
	<div class="container success-grid">
		<div class="success-copy">
			<p class="success-kicker"><?php echo esc_html( $kicker ); ?></p>
			<h2 id="success-heading">
				<?php echo esc_html( $heading_1 ); ?>
				<span><?php echo esc_html( $heading_2 ); ?></span>
			</h2>
			<p><?php echo esc_html( $p1 ); ?></p>
			<p><?php echo esc_html( $p2 ); ?></p>

			<div class="success-actions">
				<a class="button button-primary" href="<?php echo esc_url( $success_cta_primary_url ); ?>">
					<?php echo esc_html( $success_cta_primary_label ); ?>
					<span class="btn-arrow" aria-hidden="true"></span>
				</a>
				<a class="button button-primary" href="<?php echo esc_url( $success_cta_secondary_url ); ?>">
					<?php echo esc_html( $success_cta_secondary_label ); ?>
				</a>
			</div>
		</div>
		<figure class="success-frame">
			<?php
			get_template_part(
				'template-parts/md-feature-video',
				null,
				array(
					'wrapper_class' => 'success-media-video',
					'aria_label'    => $success_caption,
				)
			);
			?>
			<figcaption><?php echo esc_html( $success_caption ); ?></figcaption>
		</figure>
	</div>
</section>
