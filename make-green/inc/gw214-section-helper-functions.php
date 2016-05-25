<?php 
/**
* MAKE tempate fucntions 
*/

/**
 * Get the data for the array section.
 *
 * @since  1.0.0.
 *
 * @param  array     $ttfmake_section_data    The section data.
 * @return array                              The data.
 */
function gw214_builder_get_hero_array($ttfmake_section_data)
{
  $hero_order  = array();
  $hero_blocks = array();
  $hero_array  = array();

  if ( ttfmake_builder_is_section_type( 'hero', $ttfmake_section_data ) ) {
    if ( isset( $ttfmake_section_data['hero-block-order'] ) ) {
      $hero_order = $ttfmake_section_data['hero-block-order'];
    }

    if ( isset( $ttfmake_section_data['hero-blocks'] ) ) {
      $hero_blocks = $ttfmake_section_data['hero-blocks'];
    }

    if ( ! empty( $hero_order ) && ! empty( $hero_blocks ) ) {
      foreach ( $hero_order as $order => $key ) {
        $hero_array[$order] = $hero_blocks[$key];
      }
    }
  }
  /**
   * Filter the data array for a hero section.
   *
   * @since 1.2.3.
   *
   * @param array    $hero_array            The ordered hero data.
   * @param array    $ttfmake_section_data    All of the data for the section.
   */
  return apply_filters( 'gw214_builder_get_hero_array', $hero_array, $ttfmake_section_data );
}

/**
 * Get the class for a hero section.
 *
 * @since  1.0.0.
 *
 * @param  array     $section_data    The section data.
 * @param  array     $sections                The list of sections.
 * @return string                             The class.
 */
function gw214_builder_get_hero_class( $section_data, $sections ) {
  $hero_class = '';

  if ( ttfmake_builder_is_section_type( 'hero', $section_data ) ) {
    $hero_class .= ' ' . ttfmake_get_builder_save()->section_classes( $section_data, $sections );
  }

  /**
   * Filter the class for the hero section.
   *
   * @since 1.2.3.
   *
   * @param string    $hero_class            The hero class.
   * @param array     $section_data    The section data.
   */
  return apply_filters( 'gw214_builder_hero_class', $hero_class, $section_data );
}

function gw214_builder_hero_block_class($block)
{
  $block_class = '';
  // Content position
  if ( isset( $block['alignment'] ) && '' !== $block['alignment'] ) {
    $block_class .= ' ' . sanitize_html_class( 'content-position-' . $block['alignment'] );
  }

  // text color
  if ( isset( $block['dark-text'] ) && '' !== $block['dark-text'] && 0 !== absint( $block['dark-text'] ) ){
    $block_class .= ' ' . sanitize_html_class( 'dark-text' );
  }

  // text shadow
  if ( isset( $block['text-shadow'] ) && '' !== $block['text-shadow'] && 0 !== absint( $block['text-shadow'] ) ) {
    $block_class .= ' ' . sanitize_html_class( 'text-shadow' );
  }


  /**
   * Allow developers to alter the class for the hero block.
   *
   * @since 1.2.3.
   *
   * @param string $block_class The hero classes.
   */
  return apply_filters( 'gw214_builder_hero_block_class', $block_class, $block );
}


/**
 * Get the CSS for a block.
 *
 * @since  1.0.0.
 *
 * @param  array     $block                   The block data.
 * @param  array     $ttfmake_section_data    The section data.
 * @return string                             The CSS.
 */
function gw214_builder_hero_block_style( $block, $ttfmake_section_data ) {
  $block_style = '';

  // Background color
  if ( isset( $block['background-color'] ) && '' !== $block['background-color'] ) {
    $block_style .= 'background-color:' . maybe_hash_hex_color( $block['background-color'] ) . ';';
  }

  // Background image
  if ( isset( $block['image-id'] ) && 0 !== ttfmake_sanitize_image_id( $block['image-id'] ) ) {
    $image_src = ttfmake_get_image_src( $block['image-id'], 'full' );
    if ( isset( $image_src[0] ) ) {
      $block_style .= 'background-image: url(\'' . addcslashes( esc_url_raw( $image_src[0] ), '"' ) . '\');';
    }

    // background-repeat 
    if ( isset( $block['background-repeat'] ) && '' !== $block['background-repeat'] &&  0 !== $block['background-repeat'] ) {
      $block_style .= 'background-repeat: repeat;';
    }else{
      $block_style .= 'background-repeat: no-repeat;';
    }
    // background-position 
    if ( isset( $block['background-position'] ) && '' !== $block['background-position'] ) {
      $block_style .= 'background-position:'. sanitize_text_field( $block['background-position'] ) . ';';
    }

  }

  /**
   * Allow developers to change the CSS for a Banner section.
   *
   * @since 1.2.3.
   *
   * @param string    $block_style             The CSS for the hero.
   * @param array     $block                   The block data.
   * @param array     $ttfmake_section_data    The section data.
   */
  return apply_filters( 'make_builder_hero_block_style', esc_attr( $block_style ), $block, $ttfmake_section_data );
}