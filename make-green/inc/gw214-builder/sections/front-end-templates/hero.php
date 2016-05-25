<?php
/**
 * @package Make
 */

global $ttfmake_section_data, $ttfmake_sections;
$hero_blocks = gw214_builder_get_hero_array( $ttfmake_section_data );
$block_height = absint( $ttfmake_section_data['height'] );
if ( 0 === $block_height ) {
	$block_height = 600;
}
$block_ratio = ( $block_height / 960 ) * 100;
?>

<style type="text/css">
	#builder-section-<?php echo esc_attr( $ttfmake_section_data['id'] ); ?> .builder-hero-block {
		padding-bottom: <?php echo $block_height; ?>px;
	}
	@media screen and (min-width: 600px) and (max-width: 960px) {
		#builder-section-<?php echo esc_attr( $ttfmake_section_data['id'] ); ?> .builder-hero-block {
			padding-bottom: <?php echo $block_ratio; ?>%;
		}
	}
</style>

<section id="builder-section-<?php echo esc_attr( $ttfmake_section_data['id'] ); ?>" class="builder-section <?php echo esc_attr( gw214_builder_get_hero_class( $ttfmake_section_data, $ttfmake_sections ) ); ?>">
	<div class="builder-section-content">
		<?php if ( ! empty( $hero_blocks ) ) : foreach ( $hero_blocks as $block ) : ?>
		<div class="builder-hero-block<?php echo gw214_builder_hero_block_class( $block ); ?>" style="<?php echo gw214_builder_hero_block_style( $block, $ttfmake_section_data ); ?>">
			<div class="builder-hero-content">
				<div class="builder-hero-inner-content">
					<?php gw214_get_section_definitions()->the_builder_content( $block['content'] ); ?>
				</div>
			</div>
			<?php if ( 0 !== absint( $block['darken'] ) ) : ?>
			<div class="builder-hero-overlay"></div>
			<?php endif; ?>
		</div>
		<?php endforeach; endif; ?>
	</div>
</section>