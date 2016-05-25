<?php
/**
 * @package gw214
 */


$thumb_key    = 'layout-' . make_get_current_view() . '-featured-images';
// echo $thumb_key;
$thumb_option = ttfmake_sanitize_choice( get_theme_mod( $thumb_key, make_get_thememod_default( $thumb_key ) ), $thumb_key );

// Header
ob_start();
if ( 'post-header' === $thumb_option ) :
	get_template_part( 'partials/entry', 'thumbnail' );
endif;
get_template_part( 'partials/portfolio', 'title' );
get_template_part( 'partials/entry', 'meta-before-content' );
$entry_header = trim( ob_get_clean() );

// Footer
ob_start();
get_template_part( 'partials/portfolio', 'link' );
get_template_part( 'partials/entry', 'meta-post-footer' );
get_template_part( 'partials/portfolio', 'taxonomy' );
get_template_part( 'partials/entry', 'sharing' );
$entry_footer = trim( ob_get_clean() );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( $entry_header ) : ?>
	<header class="entry-header">
		<?php echo $entry_header; ?>
	</header>
	<?php endif; ?>
	<div class="entry-content">
		<?php if ( 'thumbnail' === $thumb_option ) : ?>
			<?php get_template_part( 'partials/entry', 'thumbnail' ); ?>
		<?php endif; ?>
		<?php get_template_part( 'partials/entry', 'content' ); ?>
		<?php get_template_part( 'partials/entry', 'pagination' ); ?>
	</div>
	<?php if ( $entry_footer ) : ?>
	<footer class="entry-footer">
		<?php echo $entry_footer; ?>
	</footer>
	<?php endif; ?>
</article>
