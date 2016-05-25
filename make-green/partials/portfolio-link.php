<?php
/**
 * @package gw214
 */
?>
<?php if ( is_singular() ) : ?>
	<p class="gw214-portfolio-link"><?php gw214_get_the_related_link(true,'button'); ?></p>
<?php endif; ?>