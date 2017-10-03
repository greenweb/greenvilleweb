<?php
/**
 * @package GW Make
 */
?><!DOCTYPE html>
<!--[if lte IE 9]><html class="no-js IE9 IE" <?php language_attributes(); ?>><![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->
  <head>
    <?php wp_head(); ?>
  </head>

  <?php if (!is_front_page()) {
    $gw2017_body_class = (is_page()) ? "gw2017-interior-page" : "gw2017-interior" ;
  }else{
    $gw2017_body_class = "";
  } ?>
  <body <?php body_class($gw2017_body_class); ?>>
    <div id="site-wrapper" class="site-wrapper">
      <a class="skip-link screen-reader-text" href="#site-content"><?php esc_html_e( 'Skip to content', 'make' ); ?></a>

      <?php ttfmake_maybe_show_site_region( 'header' ); ?>

      <div id="site-content" class="site-content">
        <div class="container">