<?php
/**
* Add bootstrap style and js for wp-admin
*
* @package ilentheme
* @since 1.5 core
* @date 21/09/2014
*
*/

 // Add actions
add_action('admin_enqueue_scripts', 'ilenframework_add_scripts_admin_bootstrap' );

// Enqueue Script Bootstrap
function ilenframework_add_scripts_admin_bootstrap(){
  global $IF_CONFIG;

  wp_enqueue_script( 'ilentheme-js-bootstrap-'.$IF_CONFIG->parameter['id'], $IF_CONFIG->parameter['url_framework'] . '/assets/js/bootstrap.min.js', array( 'jquery','jquery-ui-core'), '', true );
  wp_register_style( 'ilentheme-style-bootstrap-'.$IF_CONFIG->parameter['id'],  $IF_CONFIG->parameter['url_framework'] . '/assets/css/bootstrap.min.css' );
  wp_enqueue_style(  'ilentheme-style-bootstrap-'.$IF_CONFIG->parameter['id'] );
}
?>