<?php
/**
 * Single blog post — article + intake CTA.
 *
 * @package Advay_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main-content" class="blog-single-main">
	<?php
	while ( have_posts() ) :
		the_post();
		$cats = get_the_category();
		?>
		<div class="container content-wrap blog-single-shell">
			<nav class="blog-single-back" aria-label="<?php esc_attr_e( 'Blog', 'advay-theme' ); ?>">
				<a href="<?php echo esc_url( advay_blog_url() ); ?>">&larr; <?php esc_html_e( 'All blogs', 'advay-theme' ); ?></a>
			</nav>

			<article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-single' ); ?>>
				<header class="entry-header">
					<?php if ( $cats && ! is_wp_error( $cats ) ) : ?>
						<p class="blog-single-kicker"><?php echo esc_html( $cats[0]->name ); ?></p>
					<?php endif; ?>
					<h1><?php the_title(); ?></h1>
					<p class="blog-single-meta">
						<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
							<?php echo esc_html( get_the_date() ); ?>
						</time>
						<span aria-hidden="true">&middot;</span>
						<span><?php echo esc_html( advay_reading_time() ); ?></span>
					</p>
				</header>

				<?php if ( has_post_thumbnail() ) : ?>
					<figure class="entry-featured">
						<?php
						the_post_thumbnail(
							'large',
							array(
								'alt' => the_title_attribute( array( 'echo' => false ) ),
							)
						);
						?>
					</figure>
				<?php endif; ?>

				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</article>
		</div>
		<?php
		$related = advay_related_posts( get_the_ID(), 4 );
		if ( ! empty( $related ) ) :
			$related_heading = advay_get_acf(
				'blog_related_heading',
				__( 'Related articles', 'advay-theme' ),
				advay_acf_front_id()
			);
			?>
			<section class="blog-related" aria-labelledby="blog-related-heading">
				<div class="container">
					<h2 id="blog-related-heading"><?php echo esc_html( $related_heading ); ?></h2>
					<div class="blog-stream">
						<?php
						global $post;
						foreach ( $related as $related_post ) {
							$post = $related_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
							setup_postdata( $post );
							get_template_part( 'template-parts/blog-card', null, array( 'featured' => false ) );
						}
						wp_reset_postdata();
						?>
					</div>
				</div>
			</section>
			<?php
		endif;
		?>
		<?php
	endwhile;
	?>

	<?php get_template_part( 'template-parts/cta' ); ?>
</main>
<?php
get_footer();
