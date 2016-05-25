<?php
/**
 * @package gw214
 */
?><!DOCTYPE html>
<!--[if lte IE 9]><html class="no-js IE9 IE" <?php language_attributes(); ?>><![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />

		<title><?php wp_title( '|', true, 'right' ); ?></title>

		<?php wp_head(); ?>
	</head>
	<?php if (!is_front_page()) {
		$gw214_body_class = (is_page()) ? "gw214-interior-page" : "gw214-interior" ;
	}else{
		$gw214_body_class = "";	
	} ?>
	<body <?php body_class($gw214_body_class); ?>>
		<div id="site-wrapper" class="site-wrapper">

			<?php ttfmake_maybe_show_site_region( 'header' ); ?>

			<div id="site-content" class="site-content">
				<div class="container">