<?php
/**
 * Homepage template.
 */
get_header();
?>

<main id="main-content">
	<?php get_template_part( 'template-parts/hero' ); ?>
	<?php get_template_part( 'template-parts/logo-slider' ); ?>
	<?php get_template_part( 'template-parts/partner' ); ?>
	<?php get_template_part( 'template-parts/services' ); ?>
	<?php get_template_part( 'template-parts/how-it-works' ); ?>
	<?php get_template_part( 'template-parts/client-success' ); ?>
	<?php get_template_part( 'template-parts/map' ); ?>
	<?php get_template_part( 'template-parts/trust' ); ?>
	<?php get_template_part( 'template-parts/testimonials' ); ?>
	<?php get_template_part( 'template-parts/fit-check' ); ?>
	<?php get_template_part( 'template-parts/cta' ); ?>
</main>

<?php
get_footer();
