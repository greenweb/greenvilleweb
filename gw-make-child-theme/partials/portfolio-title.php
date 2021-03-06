<?php
/**
 * @package GW-MAKE
 */

$title_key    = 'layout-' . make_get_current_view() . '-hide-title';
$title_option = (bool) get_theme_mod( $title_key, make_get_thememod_default( $title_key ) );
?>

<?php if ( get_the_title() && ( ! is_page() || ! $title_option ) ) : ?>
<h1 class="entry-title">
	<?php if ( ! is_singular() ) : ?><a href="<?php the_permalink(); ?>" rel="bookmark"><?php endif; ?>
		<?php the_title(); ?>
	<?php if ( ! is_singular() ) : ?></a><?php endif; ?>
</h1>
<?php gw_the_sub_title(); ?>
<?php endif; ?>