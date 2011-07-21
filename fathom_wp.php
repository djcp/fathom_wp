<?php
/**
 * @package Fathom
 * @author Dan Collis-Puro
 * @version 1.1
 */
/*
Plugin Name: Fathom Presentations for Wordpress
Plugin URI: http://www.collispuro.com
Description: This plugin helps you create Fathom.js driven presentations using Wordpress.
Author: Dan Collis-Puro
Version: 1.1
Author URI: http://collispuro.com
*/

global $wpdb;

require_once('includes/fathom_class.php');

$fathom = new Fathom($wpdb);

// Install, deactivate.
register_activation_hook(__FILE__,array( $fathom,'fathom_install' ));
register_deactivation_hook(__FILE__,array( $cat_sub,'fathom_deactivate' ));

add_action('init', array( $fathom, 'register_slide_custom_type'));

add_action( 'admin_menu', array( $fathom, 'admin_menu' ) );


?>
