<?php
get_header();
?>

<main id="main-content" class="content-main">
	<div class="container content-wrap">
		<?php if ( have_posts() ) : ?>
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<h1><?php the_title(); ?></h1>
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
			<?php endwhile; ?>
		<?php else : ?>
			<h1><?php esc_html_e( 'No content found.', 'advay-theme' ); ?></h1>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer();
