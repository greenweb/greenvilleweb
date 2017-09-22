<?php
/**
 * @package Make
 */

$taxonomy_view   = make_get_current_view();

$category_key    = 'layout-' . $taxonomy_view . '-show-categories';
$tag_key         = 'layout-' . $taxonomy_view . '-show-tags';
$category_option = true; #(bool) get_theme_mod( $category_key, make_get_thememod_default( $category_key ) );
$tag_option      = true; #(bool) get_theme_mod( $tag_key, make_get_thememod_default( $tag_key ) );
?>

<?php
$category_list   = get_the_term_list($post->ID , 'portfolio_category');
$tag_list        = get_the_term_list(  $post->ID , 'portfolio_tag' );  #'<ul class="post-tags"><li>', "</li>\n<li>", '</li></ul>'
$taxonomy_output = '';

// Categories
if ( $category_option && $category_list ) :
	$taxonomy_output .= __( '<i class="fa fa-file"></i> ', 'make' ) . '%1$s';
endif;

// Tags
if ( $tag_option && $tag_list ) :
	$taxonomy_output .= __( '<i class="fa fa-tag"></i> ', 'make' ) . '%2$s';
endif;

// Output
printf(
	$taxonomy_output,
	$category_list,
	$tag_list
);
?>