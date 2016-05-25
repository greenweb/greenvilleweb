<?php
/**
 * @package gw214
 */
get_header();
global $post;
?>
<?php 
	// Don't need this but lets leave in the option
	ttfmake_maybe_show_sidebar( 'left' );
?>
<main id="site-main" class="site-main" role="main">
<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<?php
			/**
			 * Allow for changing the template partial.
			 *
			 * @since 1.2.3.
			 *
			 * @param string     $type    The default template type to use.
			 * @param WP_Post    $post    The post object for the current post.
			 */
			// $template_type = apply_filters( 'make_template_content_single', 'portfolio', $post );
			// get_template_part( 'partials/content', $template_type );
			get_template_part( 'partials/content', 'portfolio' );
		?>
		<?php get_template_part( 'partials/nav', 'post' ); ?>
	<?php endwhile; ?>
<?php endif; ?>
</main>
<?php ttfmake_maybe_show_sidebar( 'right' ); ?>
<?php get_footer(); ?>