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
		'class' => 'contact-dock-item--whatsapp',
		'url'   => advay_whatsapp_url(),
		'label' => advay_dock_whatsapp_label(),
		'icon'  => 'whatsapp',
		'external' => true,
	),
	array(
		'class' => 'contact-dock-item--email',
		'url'   => advay_dock_email_url(),
		'label' => advay_dock_email_cta_label(),
		'icon'  => 'email',
		'external' => false,
	),
	array(
		'class' => 'contact-dock-item--meet',
		'url'   => advay_dock_calendly_url(),
		'label' => advay_dock_calendly_label(),
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
