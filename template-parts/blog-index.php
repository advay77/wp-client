<?php
/**
 * Shared blog listing layout.
 *
 * @package Advay_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$blog_url   = advay_blog_url();
$demo_mode  = ! empty( $args['demo'] );
$categories = get_categories(
	array(
		'hide_empty' => true,
	)
);

if ( ! $categories && $demo_mode ) {
	$categories = array_map(
		function ( $name ) {
			$term              = new stdClass();
			$term->term_id     = sanitize_title( $name );
			$term->name        = $name;
			$term->slug        = sanitize_title( $name );
			return $term;
		},
		advay_demo_blog_categories()
	);
}
?>
<div class="container blog-shell">
	<header class="blog-hero">
		<h1><?php esc_html_e( 'Blog', 'advay-theme' ); ?></h1>
		<p class="blog-hero-lead">
			<?php esc_html_e( 'Prep playbooks, marketplace updates, and seller wins from ElitePrep.', 'advay-theme' ); ?>
		</p>

		<div class="blog-toolbar">
			<label class="screen-reader-text" for="blog-category"><?php esc_html_e( 'Filter by category', 'advay-theme' ); ?></label>
			<select class="blog-category" id="blog-category" data-blog-category>
				<option value="<?php echo esc_url( $blog_url ); ?>" selected>
					<?php esc_html_e( 'All topics', 'advay-theme' ); ?>
				</option>
				<?php foreach ( $categories as $category ) : ?>
					<option value="<?php echo esc_url( $demo_mode ? $blog_url : get_category_link( $category->term_id ) ); ?>">
						<?php echo esc_html( $category->name ); ?>
					</option>
				<?php endforeach; ?>
			</select>

			<form class="blog-search" role="search" method="get" action="<?php echo esc_url( $blog_url ); ?>">
				<label class="screen-reader-text" for="blog-search-input"><?php esc_html_e( 'Search blog', 'advay-theme' ); ?></label>
				<input
					id="blog-search-input"
					type="search"
					name="s"
					value="<?php echo esc_attr( get_search_query() ); ?>"
					placeholder="<?php esc_attr_e( 'Search', 'advay-theme' ); ?>"
				>
				<button type="submit" aria-label="<?php esc_attr_e( 'Search', 'advay-theme' ); ?>">
					<span aria-hidden="true">&#128269;</span>
				</button>
			</form>
		</div>
	</header>

	<?php if ( ! $demo_mode && have_posts() ) : ?>
		<div class="blog-stream">
			<?php
			$index = 0;
			while ( have_posts() ) :
				the_post();
				$featured = ( 0 === $index && ! is_paged() && ! is_search() && ! is_category() );
				get_template_part( 'template-parts/blog-card', null, array( 'featured' => $featured ) );
				++$index;
			endwhile;
			?>
		</div>

		<nav class="blog-pagination" aria-label="<?php esc_attr_e( 'Blog pages', 'advay-theme' ); ?>">
			<?php
			the_posts_pagination(
				array(
					'mid_size'  => 1,
					'prev_text' => '&larr;',
					'next_text' => '&rarr;',
				)
			);
			?>
		</nav>
	<?php elseif ( $demo_mode ) : ?>
		<div class="blog-stream">
			<?php
			foreach ( advay_demo_blog_posts() as $index => $card ) :
				get_template_part(
					'template-parts/blog-card-demo',
					null,
					array(
						'card'     => $card,
						'featured' => 0 === $index,
					)
				);
			endforeach;
			?>
		</div>
	<?php else : ?>
		<p class="blog-empty"><?php esc_html_e( 'No posts yet. Check back soon.', 'advay-theme' ); ?></p>
	<?php endif; ?>
</div>
