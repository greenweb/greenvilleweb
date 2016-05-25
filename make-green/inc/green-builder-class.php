<?php 
if (!class_exists('GW214_Section_Definitions')) {
	/***/
	class GW214_Section_Definitions 
	{
		/**
		 * The one instance of GW214_Section_Definitions.
		 *
		 * @since 1
		 *
		 * @var   GW214_Section_Definitions
		 */
		private static $instance;

		/**
		 * Instantiate or return the one GW214_Section_Definitions instance.
		 *
		 * @since  1
		 *
		 * @return GW214_Section_Definitions
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function __construct() {
			// Register all of the sections via the section API
			$this->register_hero_section();

			// Add the section JS
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

			// Add additional templating
			add_action( 'admin_footer', array( $this, 'print_templates' ) );

		}

		public function register_hero_section()
		{
			ttfmake_add_section(
				'hero',
				_x( 'Hero', 'section name', 'gw214' ),
			 	get_stylesheet_directory_uri() . '/inc/gw214-builder/sections/css/images/hero.png',
				__( 'Create a hero block with a call to action.', 'gw214' ),
				array( $this, 'save_hero' ),
				'sections/builder-templates/hero',
				'sections/front-end-templates/hero',
				200,
				get_stylesheet_directory().'/inc/gw214-builder/',
				array(
					100 => array(
						'type'  => 'section_title',
						'name'  => 'title',
						'label' => __( 'Enter section title', 'gw214' ),
						'class' => 'ttfmake-configuration-title ttfmake-section-header-title-input',
					),
					200 => array(
						'type'        => 'select',
						'label'       => __( 'Section width', 'gw214' ),
						'name'        => 'width',
						'default'     => 'boxed',
						'description' => __( 'Not currently implemented', 'gw214' ),
						'options'     => array(
							'boxed'		=> __( 'Boxed', 'gw214' ),
							'full'   	=> __( '100%', 'gw214' )
						)
					),
					300 => array(
						'type'    => 'text',
						'label'   => __( 'Section height (px)', 'gw214' ),
						'name'    => 'height',
						'default' => 400
					),

				)
			);
		}

		/**
		 * Save the data for the hero section.
		 *
		 * @since  1.0.0.
		 *
		 * @param  array    $data    The data from the $_POST array for the section.
		 * @return array             The cleaned data.
		 */
		public function save_hero( $data ) {
			$clean_data = array();

			$clean_data['title']       = $clean_data['label'] = ( isset( $data['title'] ) ) ? apply_filters( 'title_save_pre', $data['title'] ) : '';

			if ( isset( $data['width'] ) && in_array( $data['width'], array( 'boxed', 'full' ) ) ) {
				$clean_data['width'] = $data['width'];
			}

			if ( isset( $data['height'] ) ) {
				$clean_data['height'] = absint( $data['height'] );
			}

			if ( isset( $data['responsive'] ) && in_array( $data['responsive'], array( 'aspect', 'balanced' ) ) ) {
				$clean_data['responsive'] = $data['responsive'];
			}
			
			if ( isset( $data['hero-block-order'] ) ) {
				$clean_data['hero-block-order'] = array_map( array( 'TTFMAKE_Builder_Save', 'clean_section_id' ), explode( ',', $data['hero-block-order'] ) );
			}

			if ( isset( $data['hero-blocks'] ) && is_array( $data['hero-blocks'] ) ) {
				foreach ( $data['hero-blocks'] as $id => $block ) {

					if ( isset( $block['content'] ) ) {
						$clean_data['hero-blocks'][ $id ]['content'] = sanitize_post_field( 'post_content', $block['content'], ( get_post() ) ? get_the_ID() : 0, 'db' );
					}

					if ( isset( $block['background-color'] ) ) {
						$clean_data['hero-blocks'][ $id ]['background-color'] = maybe_hash_hex_color( $block['background-color'] );
					}

					$clean_data['hero-blocks'][ $id ]['background-repeat'] = ( isset( $block['background-repeat'] ) && 1 === (int) $block['background-repeat'] ) ? 1 : 0;

					$clean_data['hero-blocks'][ $id ]['background-position'] = ( isset( $block['background-position'] ) && in_array( $block['background-position'], array( 'center', 'left', 'right' ) ) ) ? $block['background-position'] : 'center';

					$clean_data['hero-blocks'][ $id ]['darken'] = ( isset( $block['darken'] ) && 1 === (int) $block['darken'] ) ? 1 : 0;

					$clean_data['hero-blocks'][ $id ]['dark-text'] = ( isset( $block['dark-text'] ) && 1 === (int) $block['dark-text'] ) ? 1 : 0;
					
					$clean_data['hero-blocks'][ $id ]['text-shadow'] = ( isset( $block['text-shadow'] ) && 1 === (int) $block['text-shadow'] ) ? 1 : 0;

					if ( isset( $block['image-id'] ) ) {
						$clean_data['hero-blocks'][ $id ]['image-id'] = ttfmake_sanitize_image_id( $block['image-id'] );
					}

					$clean_data['hero-blocks'][ $id ]['alignment'] = ( isset( $block['alignment'] ) && in_array( $block['alignment'], array( 'none', 'left', 'right' ) ) ) ? $block['alignment'] : 'none';

					if ( isset( $block['state'] ) ) {
						$clean_data['hero-blocks'][ $id ]['state'] = ( in_array( $block['state'], array( 'open', 'closed' ) ) ) ? $block['state'] : 'open';
					}
				}
			}

			return $clean_data;
		}

		/**
		 * Enqueue the JS and CSS for the admin.
		 *
		 * @since  1.0.0.
		 *
		 * @param  string    $hook_suffix    The suffix for the screen.
		 * @return void
		 */
		public function admin_enqueue_scripts( $hook_suffix ) {
			// Only load resources if they are needed on the current page
			if ( ! in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) ) || ! ttfmake_post_type_supports_builder( get_post_type() ) ) {
				return;
			}

			wp_register_script(
				'ttfmake-sections/js/models/hero-block.js',
				get_stylesheet_directory_uri() . '/inc/gw214-builder/sections/js/models/hero-block.js',
				array(),
				'0.1',
				true
			);

			wp_register_script(
				'ttfmake-sections/js/views/hero-block.js',
				get_stylesheet_directory_uri() . '/inc/gw214-builder/sections/js/views/hero-block.js',
				array(),
				'0.1',
				true
			);

			wp_register_script(
				'ttfmake-sections/js/views/hero.js',
				get_stylesheet_directory_uri() . '/inc/gw214-builder/sections/js/views/hero.js',
				array(),
				'0.1',
				true
			);
			// Add the section CSS
			wp_enqueue_style(
				'gw214-sections.css',
				get_stylesheet_directory_uri() . '/inc/gw214-builder/sections/css/gw214-sections.css',
				array(),
				'0.1',
				'all'
			);

			add_filter( 'ttfmake_builder_js_dependencies', array( $this, 'add_gw214_js_dependencies' ) );
		}


		/**
		 * Append more JS to the list of JS deps.
		 *
		 * @since  1.0.0.
		 *
		 * @param  array    $deps    The current deps.
		 * @return array             The modified deps.
		 */
		public function add_gw214_js_dependencies( $deps ) {
			if ( ! is_array( $deps ) ) {
				$deps = array();
			}

			return array_merge( $deps, array(
				'ttfmake-sections/js/models/hero-block.js',
				'ttfmake-sections/js/views/hero-block.js',
				'ttfmake-sections/js/views/hero.js',
			) );
		}


		public function print_templates() {
			global $hook_suffix, $typenow, $ttfmake_is_js_template;
			$ttfmake_is_js_template = true;

			// Only show when adding/editing pages
			if ( ! ttfmake_post_type_supports_builder( $typenow ) || ! in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) )) {
				return;
			}

			// Define the templates to print
			$templates = array(
				array(
					'id' => 'hero-block',
					'builder_template' => 'sections/builder-templates/hero-block',
					'path' => 'inc/gw214-builder/',
				),
			);

			// Print the templates
			foreach ( $templates as $template ) : ?>
			<script type="text/html" id="tmpl-ttfmake-<?php echo $template['id']; ?>">
				<?php
				ob_start();
				ttfmake_get_builder_base()->load_section( $template, array() );
				$html = ob_get_clean();
				$html = str_replace(
					array(
						'temp',
					),
					array(
						'{{{ id }}}',
					),
					$html
				);
				echo $html;
				?>
			</script>
			<?php endforeach;
			unset( $GLOBALS['ttfmake_is_js_template'] );
		}

		public function the_builder_content( $content ) {
			/**
			 * Filter the content used for "post_content" when the builder is used to generate content.
			 *
			 * @since 1.2.3.
			 *
			 * @param string    $content    The post content.
			 */
			$content = apply_filters( 'make_the_builder_content', $content );
			$content = str_replace( ']]>', ']]&gt;', $content );
			echo $content;
		}


	}
}

/**
 * Instantiate or return the one GW214_Section_Definitions instance.
 *
 * @since  1.0.0.
 *
 * @return GW214_Section_Definitions
 */
function gw214_get_section_definitions() {
	return GW214_Section_Definitions::instance();
}
// Kick off the section definitions immediately
if ( is_admin() ) {
	add_action( 'after_setup_theme', 'gw214_get_section_definitions',12 );
}
include 'gw214-section-helper-functions.php';
 