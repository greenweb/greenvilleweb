<?php
/**
 * @package Make
 */

$thumb_key    = 'layout-' . make_get_current_view() . '-featured-images';
$thumb_option = ttfmake_sanitize_choice( get_theme_mod( $thumb_key, make_get_thememod_default( $thumb_key ) ), $thumb_key );

// Header
ob_start();
#get_template_part( 'partials/portfolio', 'meta-top' );
#get_template_part( 'partials/entry', 'sticky' );
// if ( 'post-header' === $thumb_option ) :
	#get_template_part( 'partials/portfolio', 'thumbnail' );
// endif;
get_template_part( 'partials/portfolio', 'title' );
#get_template_part( 'partials/portfolio', 'meta-before-content' );
$entry_header = trim( ob_get_clean() );

// Footer
ob_start();
// get_template_part( 'partials/entry', 'meta-post-footer' );
// get_template_part( 'partials/entry', 'taxonomy' );
// get_template_part( 'partials/entry', 'sharing' );
$entry_footer = trim( ob_get_clean() );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( $entry_header ) : ?>
	<header class="entry-header">
		<?php echo $entry_header; ?>
	</header>
	<?php endif; ?>

	<section class="gw214-portfolio-entry-content">
		<?php #if ( 'thumbnail' === $thumb_option ) : ?>
			<?php #get_template_part( 'partials/entry', 'thumbnail' ); ?>
		<?php #endif; ?>
		<?php echo( str_replace( array('[',']'), '', get_the_excerpt() ) ); ?> <a href="<?php the_permalink() ?>"><span class="ttfmake-icon fa fa-rocket"></span> More</a>
	</section>

	<?php if ( $entry_footer ) : ?>
	<footer class="entry-footer">
		<?php echo $entry_footer; ?>
	</footer>
	<?php endif; ?>
</article>