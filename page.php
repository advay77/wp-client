<?php
/**
 * Default page template — preserves editor content, titles, and featured images.
 */
get_header();
?>

<main id="main-content" class="content-main">
	<div class="container content-wrap">
		<?php
		while ( have_posts() ) :
			the_post();

			/*
			 * Elementor pages already include their own H1 in the canvas.
			 * Skip the theme H1 to avoid duplicate headings on production.
			 */
			$advay_is_elementor = false;
			if ( class_exists( '\Elementor\Plugin' ) && get_the_ID() ) {
				$advay_document = \Elementor\Plugin::$instance->documents->get( get_the_ID() );
				if ( $advay_document && method_exists( $advay_document, 'is_built_with_elementor' ) ) {
					$advay_is_elementor = (bool) $advay_document->is_built_with_elementor();
				}
			}
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php if ( ! $advay_is_elementor ) : ?>
					<header class="entry-header">
						<h1><?php the_title(); ?></h1>
					</header>
				<?php endif; ?>
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
			<?php
		endwhile;
		?>
	</div>
</main>

<?php
get_footer();
