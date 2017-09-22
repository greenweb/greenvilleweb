<?php
/**
 * @package gw214
 */
ttfmake_load_section_header();

global $ttfmake_section_data, $ttfmake_is_js_template;
$section_name  = ttfmake_get_section_name( $ttfmake_section_data, $ttfmake_is_js_template );
$section_order = ( ! empty( $ttfmake_section_data['data']['hero-block-order'] ) ) ? $ttfmake_section_data['data']['hero-block-order'] : array();
?>

<div class="ttfmake-hero-blocks">
	<div class="ttfmake-hero-blocks-stage">
		<?php foreach ( $section_order as $key => $section_id  ) : ?>
			<?php if ( isset( $ttfmake_section_data['data']['hero-blocks'][ $section_id ] ) ) : ?>
				<?php global $ttfmake_block_id; $ttfmake_block_id = $section_id; ?>
				<?php get_template_part( '/inc/gw214-builder/sections/builder-templates/hero', 'block' ); ?>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
	<a href="#" class="ttfmake-add-block ttfmake-hero-add-item-link" title="<?php esc_attr_e( 'Add new block', 'gw214' ); ?>">
		<div class="ttfmake-hero-add-item">
			<span>
				<?php _e( 'Add Hero Box', 'gw214' ); ?>
			</span>
		</div>
	</a>

	<input type="hidden" value="<?php echo esc_attr( implode( ',', $section_order ) ); ?>" name="<?php echo $section_name; ?>[hero-block-order]" class="ttfmake-hero-block-order" />
</div>

<input type="hidden" class="ttfmake-section-state" name="<?php echo $section_name; ?>[state]" value="<?php if ( isset( $ttfmake_section_data['data']['state'] ) ) echo esc_attr( $ttfmake_section_data['data']['state'] ); else echo 'open'; ?>" />
<?php ttfmake_load_section_footer();