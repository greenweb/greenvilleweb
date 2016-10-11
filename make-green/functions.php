<?php
/**
* @package gw214
*/

/**
* Dequeue the Make Theme's Global script.
*
* Hooked to the wp_print_scripts action, with a late priority (100),
* so that it is after the script was enqueued.
* See http://codex.wordpress.org/Function_Reference/wp_deregister_script
*/
function gw214_dequeue_script() {
   wp_dequeue_script( 'ttfmake-global' );
}
add_action( 'wp_print_scripts', 'gw214_dequeue_script', 100 );

/**
 * Proper way to enqueue scripts and styles
 */
function theme_name_scripts() {
  wp_enqueue_script( 'gw214-global', get_stylesheet_directory_uri() . '/js/min/global-min.js', array( 'jquery' ), '1.0.0', true );
}

add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );

add_filter( 'the_content', 'gw214_clear_floats_after_content' );

function gw214_clear_floats_after_content( $content ) {
  $clean_this_shit_up = '<div class="clear">&nbsp;</div>';
  return $content.$clean_this_shit_up;
}

add_action( 'wp_loaded' , 'gw214_remove_make_nag' );
function gw214_remove_make_nag( ) {
  if( has_action( 'edit_form_after_title', 'ttfmake_plus_quick_start' ) ){
    remove_action( 'edit_form_after_title', 'ttfmake_plus_quick_start' );
  }
  if( has_action( 'add_meta_boxes', 'ttfmake_add_plus_metabox' ) ){
    remove_action( 'add_meta_boxes', 'ttfmake_add_plus_metabox' );
  }
}

include 'inc/green-builder-class.php';
// Templating functions
function gw214_add_portfolio_views() {
  make_update_view_definition(
    'portfolio',
    array(
      'label'    => __( 'Portfolio', 'gw214' ),
      'callback' => 'gw214_is_portfolio',
      'priority' => 20
    )
  );
}

add_action( 'make_view_loaded', 'gw214_add_portfolio_views' );

function gw214_is_portfolio( )
{
  return is_singular( 'portfolio' );
}

/**
 * Must be called from with in the loop
 */
function gw214_the_sub_title($echo = true){

  $subtitle = get_post_meta( get_the_ID(), '_gw_make_subtitle', true);
  if($subtitle != ''){
    $return = "<h3 class='gw-subtitle'>{$subtitle}</h3>";
  }
  if ($echo) {
    echo $return;
  }
  return $return;
}

/**
 * Must be called from with in the loop
 */
function gw214_get_the_related_link( $echo = true, $link_type = 'button', $link_text = null ){
  $css_class = ''; $icon = ''; // delcaring these for later use
  if(is_null($link_text)) {
    $link_text = __('Project link','gw214');
  }
  $link = get_post_meta( get_the_ID(), '_gw_make_project_url', true);
  if (''==$link) {
    return false;  // no link
  }
  // function just needs the link
  if (!$echo OR 'false' === $echo OR '0' === $echo ) {
    return $link;
  }
  // return a button
  if ($link_type == 'button') {
    $css_class = 'ttfmake-button';
    $icon = '<i class="ttfmake-button-icon fa fa-link"></i>';
  }
  if(true == $echo) {
    echo '<a href="'.$link.'" class="'.$css_class.'" target="_blank">'.$icon.$link_text.'</a>';
  }
}


/**
 * Sets the post excerpt length to 40 words.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 */

function custom_portfolio_excerpt_length( $length ) {
  $post_type = get_post_type();
  if ('portfolio' == $post_type) return 70;
  return $length;
}
add_filter( 'excerpt_length', 'custom_portfolio_excerpt_length', 999 );

// EOF