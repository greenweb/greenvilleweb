<?php
/**
 * @package gw214
 */

// Header Options
$subheader_class = ( make_get_thememod_value( 'header-show-social' ) || make_get_thememod_value( 'header-show-search' ) ) ? ' right-content' : '';
$menu_label      = get_theme_mod( 'navigation-mobile-label', make_get_thememod_default( 'navigation-mobile-label' ) );
$header_bar_menu = wp_nav_menu( array(
	'theme_location'  => 'header-bar',
	'container_class' => 'header-bar-menu',
	'depth'           => 1,
	'fallback_cb'     => false,
	'echo'            => false,
) );
?>

<header id="site-header" class="<?php echo esc_attr( ttfmake_get_site_header_class() ); ?>" role="banner">
	<?php // Only show Header Bar if it has content
	if (
		make_get_thememod_value( 'header-text' )
		||
		make_get_thememod_value( 'header-show-search' )
		||
		( make_has_socialicons() && make_get_thememod_value( 'header-show-social' ) )
		||
		! empty( $header_bar_menu )
	) : ?>
	<div class="header-bar<?php echo esc_attr( $subheader_class ); ?>">
		<div class="container">
			<?php // Search form
			if ( make_get_thememod_value( 'header-show-search' ) ) :
				get_search_form();
			endif; ?>
			<?php // Social links
			make_socialicons( 'header' ); ?>
			<?php // Header text; shown only if there is no header menu
			if ( ( make_get_thememod_value( 'header-text' ) || is_customize_preview() ) && empty( $header_bar_menu ) ) : ?>
				<span class="header-text">
				<?php echo make_get_thememod_value( 'header-text' ); ?>
				</span>
			<?php endif; ?>
			<?php echo $header_bar_menu; ?>
		</div>
	</div>
	<?php endif; ?>
	<div class="site-header-main">
		<div class="container">
			<div class="site-branding">
				<?php // Logo
				if ( make_has_logo() ) : ?>
					<?php make_logo(); ?>
				<?php endif; ?>
				<?php // Site title
				if ( get_bloginfo( 'name' ) ) : ?>
				<h1 class="site-title<?php if ( make_get_thememod_value( 'hide-site-title' ) ) echo ' screen-reader-text'; ?>">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
				</h1>
				<?php endif; ?>
				<?php // Tagline
				if ( get_bloginfo( 'description' ) ) : ?>
				<span class="site-description<?php if ( make_get_thememod_value( 'hide-tagline' ) ) echo ' screen-reader-text'; ?>">
					<?php bloginfo( 'description' ); ?>
				</span>
				<?php endif; ?>
			</div>

      <!-- Navigation -->
      <div id="cd-nav">
        <a href="#0" class="cd-nav-trigger"><?php echo esc_html( $menu_label ); ?><span></span></a>
        <nav id="cd-main-nav" class="gw214-navigation" role="navigation">
          <a class="skip-link screen-reader-text" href="#site-content"><?php _e( 'Skip to content', 'make' ); ?></a>
          <?php
          wp_nav_menu( array(
            'theme_location' => 'primary',
            'menu_class'      => 'menu at-top top-nav',
          ) );
          ?>
        </nav>
      </div>
      <!-- End Navigation -->
		</div>
		<div class="builder-banner-overlay"></div>
	</div>
</header>