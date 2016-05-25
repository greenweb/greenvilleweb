<?php
/**
 * @package gw214
 */

global $ttfmake_section_data, $ttfmake_is_js_template, $ttfmake_block_id;
$section_name = 'ttfmake-section';
if ( true === $ttfmake_is_js_template ) {
	$section_name .= '[{{{ parentID }}}][hero-blocks][{{{ id }}}]';
} else {
	$section_name .= '[' . $ttfmake_section_data[ 'data' ][ 'id' ] . '][hero-blocks][' . $ttfmake_block_id . ']';
}

$content          	 = ( isset( $ttfmake_section_data['data']['hero-blocks'][ $ttfmake_block_id ]['content'] ) ) ? $ttfmake_section_data['data']['hero-blocks'][ $ttfmake_block_id ]['content'] : '';
$image_id         	 = ( isset( $ttfmake_section_data['data']['hero-blocks'][ $ttfmake_block_id ]['image-id'] ) ) ? $ttfmake_section_data['data']['hero-blocks'][ $ttfmake_block_id ]['image-id'] : 0;
$state            	 = ( isset( $ttfmake_section_data['data']['hero-blocks'][ $ttfmake_block_id ]['state'] ) ) ? $ttfmake_section_data['data']['hero-blocks'][ $ttfmake_block_id ]['state'] : 'open';

// Set up the combined section + block ID
$section_id  = ( isset( $ttfmake_section_data['data']['id'] ) ) ? $ttfmake_section_data['data']['id'] : '';
$combined_id = ( true === $ttfmake_is_js_template ) ? '{{{ parentID }}}-{{{ id }}}' : $section_id . '-' . $ttfmake_block_id;
$overlay_id  = 'ttfmake-overlay-' . $combined_id;
?>

<?php if ( true !== $ttfmake_is_js_template ) : ?>
<div class="ttfmake-hero-block" id="ttfmake-hero-block-<?php echo esc_attr( $ttfmake_block_id ); ?>" data-id="<?php echo esc_attr( $ttfmake_block_id ); ?>" data-section-type="hero-block">
<?php endif; ?>

	<div title="<?php esc_attr_e( 'Drag-and-drop this block into place', 'gw214' ); ?>" class="ttfmake-sortable-handle">
		<div class="sortable-background"></div>
	</div>

	<?php echo ttfmake_get_builder_base()->add_uploader( $section_name, ttfmake_sanitize_image_id( $image_id ), __( 'Set hero image', 'gw214' ) ); ?>

	<a href="#" class="configure-hero-block-link ttfmake-hero-block-configure ttfmake-overlay-open" title="<?php esc_attr_e( 'Configure block', 'gw214' ); ?>" data-overlay="#<?php echo $overlay_id; ?>">
		<span>
			<?php _e( 'Configure block', 'gw214' ); ?>
		</span>
	</a>
	<a href="#" class="edit-content-link edit-hero-block-link<?php if ( ! empty( $content ) ) : ?> item-has-content<?php endif; ?>" title="<?php esc_attr_e( 'Edit content', 'gw214' ); ?>" data-textarea="ttfmake-content-<?php echo $combined_id; ?>">
		<span>
			<?php _e( 'Edit content', 'gw214' ); ?>
		</span>
	</a>
	<a href="#" class="remove-hero-block-link ttfmake-hero-block-remove" title="<?php esc_attr_e( 'Delete block', 'gw214' ); ?>">
		<span>
			<?php _e( 'Delete block', 'gw214' ); ?>
		</span>
	</a>

	<?php ttfmake_get_builder_base()->add_frame( $combined_id, $section_name . '[content]', $content, false ); ?>

	<?php
	global $ttfmake_overlay_class, $ttfmake_overlay_id, $ttfmake_overlay_title;
	$ttfmake_overlay_class = 'ttfmake-configuration-overlay';
	$ttfmake_overlay_id    = $overlay_id;
	$ttfmake_overlay_title = __( 'Configure block', 'gw214' );

	get_template_part( '../make/inc/builder/core/templates/overlay', 'header' );

	$inputs = apply_filters( 'make_hero_block_configuration', array(
		100 => array(
			'type'    => 'select',
			'name'    => 'alignment',
			'label'   => __( 'Content position', 'gw214' ),
			'default' => 'none',
			'options' => array(
				'none'  => __( 'None', 'gw214' ),
				'left'  => __( 'Left', 'gw214' ),
				'right' => __( 'Right', 'gw214' ),
			),
		),
		200 => array(
			'type'    => 'checkbox',
			'label'   => __( 'Darken background to improve readability', 'gw214' ),
			'name'    => 'darken',
			'default' => 0
		),
		300 => array(
			'type'    => 'checkbox',
			'label'   => __( 'Repeat background image', 'gw214' ),
			'name'    => 'background-repeat',
			'class'   => 'gw214-hero-background-repeat',
			'default' => 0,
		),
		400 => array(
			'type'    => 'select',
			'name'    => 'background-position',
			'label'   => __( 'Background image position', 'gw214' ),
			'default' => 'right',
			'options' => array(
				'center'  => __( 'Center', 'gw214' ),
				'left'  => __( 'Left', 'gw214' ),
				'right' => __( 'Right', 'gw214' ),
			),
		),
		500 => array(
			'type'    => 'checkbox',
			'label'   => __( 'Dark text', 'gw214' ),
			'name'    => 'dark-text',
			'default' => 0
		),
		600 => array(
			'type'    => 'checkbox',
			'label'   => __( 'Text shadow', 'gw214' ),
			'name'    => 'text-shadow',
			'default' => 0
		),

		700 => array(
			'type'    => 'color',
			'label'   => __( 'Background color', 'gw214' ),
			'name'    => 'background-color',
			'class'   => 'gw214-hero-background-color gw214-configuration-color-picker',
			'default' => '',
		),
	) );

	// Sort the config in case 3rd party code added another input
	ksort( $inputs, SORT_NUMERIC );

	// Print the inputs
	$output = '';

	foreach ( $inputs as $input ) {
		if ( isset( $input['type'] ) && isset( $input['name'] ) ) {
			$section_data  = ( isset( $ttfmake_section_data['data']['hero-blocks'][ $ttfmake_block_id ] ) ) ? $ttfmake_section_data['data']['hero-blocks'][ $ttfmake_block_id ] : array();
			$output       .= ttfmake_create_input( $section_name, $input, $section_data );
		}
	}

	echo $output;

	get_template_part( '../make/inc/builder/core/templates/overlay', 'footer' );
	?>

	<input type="hidden" class="ttfmake-hero-block-state" name="<?php echo $section_name; ?>[state]" value="<?php echo esc_attr( $state ); ?>" />

	<?php if ( true !== $ttfmake_is_js_template ) : ?>
</div>
<?php endif; ?>
