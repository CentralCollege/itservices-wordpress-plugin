<?php
/**
 * Plugin Name: Central College IT Services Plugin
 * Plugin URI: https://github.com/CentralCollege/itservices-wordpress-plugin
 * Description: Added features for the Central College IT Services department website on WordPress
 * Version: beta
 * Author: Jordan Bohr '15 | Gavin MacDonald '16 | Jacob Oyen '04 
 * Author URI: http://www.central.edu
 */
 
// Add special styles for this plugin
function itservices_styles() {
	wp_enqueue_style( 'itservices_styles', plugins_url('css/styles.css'));
}

add_action( 'wp_enqueue_scripts', 'itservices_styles' );
 
 
?>