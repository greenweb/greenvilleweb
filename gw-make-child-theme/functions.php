<?php
/**
 * @package Make Child
 */

/**
 *
 * The theme version.
 */
define( 'TTFMAKE_CHILD_VERSION', '1.1.0' );

/**
 * Turn off the parent theme styles.
 *
 * If you would like to use this child theme to style Make from scratch, rather
 * than simply overriding specific style rules, simply remove the '//' from the
 * 'add_filter' line below. This will tell the theme not to enqueue the parent
 * stylesheet along with the child one.
 */
//add_filter( 'make_enqueue_parent_stylesheet', '__return_false' );

/**
 * Add your custom theme functions here.
 */
function childtheme_update_choice_sets() {


	// Update an existing set
	make_update_choice_set(
		'header-layout',
		array(
			1  => __( 'Traditional', 'gw-make-child' ),
			2  => __( 'Centered', 'gw-make-child' ),
			3  => __( 'Navigation Below (Primary)', 'gw-make-child' ),
			4  => __( 'Header with Widgets', 'gw-make-child' )
		)
	);
}

add_action( 'make_choices_loaded', 'childtheme_update_choice_sets' );


/**
 * Register our sidebars and widgetized areas.
 *
 */
function header_widgets_init() {

	register_sidebar( array(
		'name'          => 'Header Widget',
		'id'            => 'header_widget',
		'before_widget' => '<div class="header-widget">',
		'after_widget'  => '</div>',
		'before_title'  => '',
		'after_title'   => '',
	) );

}
add_action( 'widgets_init', 'header_widgets_init' );