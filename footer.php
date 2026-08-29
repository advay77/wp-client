<?php
$footer_cta = advay_footer_cta();
?>
<footer class="site-footer" id="site-footer">
	<div class="container">
		<div class="footer-top">
			<div class="footer-brand">
				<a class="footer-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<img src="<?php echo esc_url( advay_logo_url() ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" width="168" height="48">
				</a>
				<p class="footer-tagline">
					<?php echo esc_html( advay_footer_tagline() ); ?>
				</p>
			</div>
			<a class="button button-light footer-cta" href="<?php echo esc_url( $footer_cta['url'] ); ?>">
				<?php echo esc_html( $footer_cta['label'] ); ?>
				<span class="btn-arrow" aria-hidden="true"></span>
			</a>
		</div>

		<div class="footer-grid">
			<div class="footer-col">
				<h2 class="footer-heading"><?php esc_html_e( 'Explore', 'advay-theme' ); ?></h2>
				<nav aria-label="<?php esc_attr_e( 'Footer', 'advay-theme' ); ?>">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'container'      => false,
							'menu_class'     => 'footer-menu',
							'fallback_cb'    => 'advay_footer_menu_fallback',
							'depth'          => 1,
						)
					);
					?>
				</nav>
			</div>

			<div class="footer-col">
				<h2 class="footer-heading"><?php esc_html_e( 'Services', 'advay-theme' ); ?></h2>
				<ul class="footer-menu">
					<li><a href="<?php echo esc_url( advay_services_url( 'platforms' ) ); ?>"><?php esc_html_e( 'Amazon FBA prep', 'advay-theme' ); ?></a></li>
					<li><a href="<?php echo esc_url( advay_services_url( 'platforms' ) ); ?>"><?php esc_html_e( 'Walmart WFS prep', 'advay-theme' ); ?></a></li>
					<li><a href="<?php echo esc_url( advay_services_url( 'platforms' ) ); ?>"><?php esc_html_e( 'TikTok Shop prep', 'advay-theme' ); ?></a></li>
					<li><a href="<?php echo esc_url( advay_services_url() ); ?>"><?php esc_html_e( 'Receiving, labeling & forwarding', 'advay-theme' ); ?></a></li>
				</ul>
			</div>

			<div class="footer-col">
				<h2 class="footer-heading"><?php esc_html_e( 'Company', 'advay-theme' ); ?></h2>
				<ul class="footer-menu">
					<li><a href="<?php echo esc_url( advay_pricing_url() ); ?>"><?php esc_html_e( 'Pricing', 'advay-theme' ); ?></a></li>
					<li><a href="<?php echo esc_url( advay_onboarding_url() ); ?>"><?php esc_html_e( 'Onboarding', 'advay-theme' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/#how-it-works' ) ); ?>"><?php esc_html_e( 'How it works', 'advay-theme' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/#testimonials' ) ); ?>"><?php esc_html_e( 'Success stories', 'advay-theme' ); ?></a></li>
					<li><a href="<?php echo esc_url( advay_contact_url() ); ?>"><?php esc_html_e( 'Contact', 'advay-theme' ); ?></a></li>
				</ul>
			</div>

			<div class="footer-col">
				<h2 class="footer-heading"><?php esc_html_e( 'Contact', 'advay-theme' ); ?></h2>
				<ul class="footer-menu footer-contact">
					<li>
						<a href="<?php echo esc_url( advay_dock_phone_url() ); ?>">
							<?php echo esc_html( advay_dock_phone_label() ); ?>
						</a>
					</li>
					<li>
						<a href="<?php echo esc_url( advay_dock_email_url() ); ?>">
							<?php echo esc_html( advay_dock_email_label() ); ?>
						</a>
					</li>
					<li><?php echo esc_html( advay_footer_contact_line() ); ?></li>
				</ul>
			</div>
		</div>

		<div class="footer-bottom">
			<p class="copyright">
				&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
				<?php echo esc_html( get_bloginfo( 'name' ) ); ?>.
				<?php esc_html_e( 'All rights reserved.', 'advay-theme' ); ?>
			</p>
			<p class="footer-meta"><?php esc_html_e( 'Amazon FBA · Walmart WFS · TikTok Shop', 'advay-theme' ); ?></p>
			<nav class="legal-nav" aria-label="<?php esc_attr_e( 'Legal', 'advay-theme' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'legal',
						'container'      => false,
						'menu_class'     => 'legal-menu',
						'fallback_cb'    => '__return_false',
						'depth'          => 1,
					)
				);
				?>
			</nav>
		</div>
	</div>
</footer>

<?php
get_template_part( 'template-parts/contact-dock' );

if ( is_front_page() ) {
	get_template_part( 'template-parts/welcome-popup' );
}
wp_footer();
?>
</body>
</html>
