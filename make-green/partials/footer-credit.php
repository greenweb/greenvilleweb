<?php
/**
 * @package gw214
 */

$footer_text = get_theme_mod( 'footer-text', false );
$footer_credit = apply_filters( 'ttfmake_show_footer_credit', true );
?>

<?php if ( $footer_text || ttfmake_is_preview() ) : ?>
<div class="footer-text">
	<?php echo ttfmake_sanitize_text( $footer_text ); ?>
</div>
<?php endif; ?>
