<?php
/**
 * Floating contact dock — call, email, MD booking.
 *
 * @package Advay_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$dock_items = array(
	array(
		'class' => 'contact-dock-item--call',
		'url'   => advay_dock_phone_url(),
		'label' => sprintf(
			/* translators: %s: phone number */
			__( 'Call at %s', 'advay-theme' ),
			advay_dock_phone_label()
		),
		'icon'  => 'phone',
		'external' => false,
	),
	array(
		'class' => 'contact-dock-item--email',
		'url'   => advay_dock_email_url(),
		'label' => __( 'Reach out to us via mail', 'advay-theme' ),
		'icon'  => 'email',
		'external' => false,
	),
	array(
		'class' => 'contact-dock-item--meet',
		'url'   => advay_dock_calendly_url(),
		'label' => __( 'Book a call with our MD', 'advay-theme' ),
		'icon'  => 'meet',
		'external' => true,
	),
);
?>
<aside class="contact-dock" data-contact-dock aria-label="<?php esc_attr_e( 'Quick contact', 'advay-theme' ); ?>">
	<?php foreach ( $dock_items as $item ) : ?>
		<a
			class="contact-dock-item <?php echo esc_attr( $item['class'] ); ?>"
			href="<?php echo esc_url( $item['url'] ); ?>"
			<?php echo $item['external'] ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>
		>
			<span class="contact-dock-bubble" aria-hidden="true">
				<?php echo advay_contact_dock_icon( $item['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</span>
			<span class="contact-dock-label"><?php echo esc_html( $item['label'] ); ?></span>
		</a>
	<?php endforeach; ?>
</aside>
