<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
if ( function_exists( 'wp_body_open' ) ) {
	wp_body_open();
}

$header_primary   = advay_header_cta_primary();
$header_secondary = advay_header_cta_secondary();
?>

<a class="skip-link" href="#main-content"><?php esc_html_e( 'Skip to content', 'advay-theme' ); ?></a>

<header class="site-header" id="top">
	<div class="container header-inner">
		<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<img
				src="<?php echo esc_url( advay_logo_url() ); ?>"
				alt="<?php echo esc_attr( get_bloginfo( 'name' ) ? get_bloginfo( 'name' ) : __( 'ElitePrep Center', 'advay-theme' ) ); ?>"
				width="168"
				height="48"
			>
		</a>

		<nav class="primary-nav" id="site-navigation" aria-label="<?php esc_attr_e( 'Primary', 'advay-theme' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'menu',
					'fallback_cb'    => 'advay_primary_menu_fallback',
					'depth'          => 1,
				)
			);
			?>
			<div class="nav-mobile-actions" id="nav-mobile-actions">
				<a class="button button-header header-cta-mobile is-secondary" href="<?php echo esc_url( $header_secondary['url'] ); ?>">
					<?php echo esc_html( $header_secondary['label'] ); ?>
				</a>
				<a class="button button-header header-cta-mobile" href="<?php echo esc_url( $header_primary['url'] ); ?>">
					<?php echo esc_html( $header_primary['label'] ); ?>
				</a>
			</div>
		</nav>

		<div class="header-partners" aria-label="<?php esc_attr_e( 'Partner certifications', 'advay-theme' ); ?>">
			<span class="header-partner">
				<img
					src="<?php echo esc_url( advay_asset_uri( 'images/logo-amazon-spn.png' ) ); ?>"
					alt="<?php esc_attr_e( 'Amazon SPN', 'advay-theme' ); ?>"
					width="110"
					height="28"
					decoding="async"
				>
			</span>
			<span class="header-partner">
				<img
					src="<?php echo esc_url( advay_asset_uri( 'images/logo-walmart-marketplace.png' ) ); ?>"
					alt="<?php esc_attr_e( 'Walmart Marketplace Approved Solution Provider', 'advay-theme' ); ?>"
					width="110"
					height="36"
					decoding="async"
				>
			</span>
		</div>

		<div class="header-actions">
			<a class="button button-header header-cta is-secondary" href="<?php echo esc_url( $header_secondary['url'] ); ?>">
				<?php echo esc_html( $header_secondary['label'] ); ?>
			</a>
			<a class="button button-header header-cta" href="<?php echo esc_url( $header_primary['url'] ); ?>">
				<?php echo esc_html( $header_primary['label'] ); ?>
			</a>
			<button
				class="menu-toggle"
				type="button"
				aria-expanded="false"
				aria-controls="site-navigation"
			>
				<span class="menu-toggle-bars" aria-hidden="true"></span>
				<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'advay-theme' ); ?></span>
			</button>
		</div>
	</div>
</header>
