<?php
/**
 * Blog posts index (Posts page).
 */
get_header();
?>

<main id="main-content" class="content-main blog-main">
	<div class="container content-wrap">
		<header class="blog-page-header">
			<p class="eyebrow"><?php esc_html_e( 'Insights', 'advay-theme' ); ?></p>
			<h1><?php esc_html_e( 'Blog', 'advay-theme' ); ?></h1>
			<p class="blog-page-lead">
				<?php esc_html_e( 'Prep playbooks, marketplace updates, and seller wins from ElitePrep Center.', 'advay-theme' ); ?>
			</p>
		</header>

		<?php if ( have_posts() ) : ?>
			<div class="blog-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-card-page' ); ?>>
						<a class="blog-card-page-link" href="<?php the_permalink(); ?>">
							<?php if ( has_post_thumbnail() ) : ?>
								<figure class="blog-card-page-thumb">
									<?php
									the_post_thumbnail(
										'medium_large',
										array(
											'alt' => the_title_attribute( array( 'echo' => false ) ),
										)
									);
									?>
								</figure>
							<?php else : ?>
								<figure class="blog-card-page-thumb is-fallback" aria-hidden="true"></figure>
							<?php endif; ?>
							<div class="blog-card-page-body">
								<?php
								$cats = get_the_category();
								if ( $cats && ! is_wp_error( $cats ) ) :
									?>
									<span class="blog-card-page-cat"><?php echo esc_html( $cats[0]->name ); ?></span>
								<?php endif; ?>
								<h2><?php the_title(); ?></h2>
								<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
								<span class="blog-card-page-more">
									<?php esc_html_e( 'Read More', 'advay-theme' ); ?>
									<span aria-hidden="true">&rarr;</span>
								</span>
							</div>
						</a>
					</article>
				<?php endwhile; ?>
			</div>

			<nav class="blog-pagination" aria-label="<?php esc_attr_e( 'Blog pages', 'advay-theme' ); ?>">
				<?php
				the_posts_pagination(
					array(
						'mid_size'  => 1,
						'prev_text' => __( 'Previous', 'advay-theme' ),
						'next_text' => __( 'Next', 'advay-theme' ),
					)
				);
				?>
			</nav>
		<?php else : ?>
			<p class="blog-empty"><?php esc_html_e( 'No posts yet. Check back soon.', 'advay-theme' ); ?></p>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer();
