<?php
/**
 * Plugin Name: Central College IT Services Plugin
 * Plugin URI: https://github.com/CentralCollege/itservices-wordpress-plugin
 * Description: Added features for the Central College IT Services department website on WordPress
 * Version: beta
 * Author: Gavin MacDonald '16
 * Author URI: http://www.central.edu
 */
 
// Add special styles for this plugin
function itservices_styles() {
	wp_enqueue_style( 'dashicons');
	wp_enqueue_style( 'itservices_styles', plugins_url('/css/styles.css', __FILE__));
}
add_action( 'wp_enqueue_scripts', 'itservices_styles' );

// Create Help desk post type
function it_create_post_type() {
	$labels = array(
		'name' => __( 'Help Desk Posts'),
		'singular_name' => __( 'Help Desk Post')
	);
	
	register_post_type( 'help_desk', 
		array(
			'labels' => $labels,
			'public' => true,
			'has_archive' => true,
			'show_in_menu' => true,
			'show_in_admin_bar' => true,
			'menu_position' => 5,
			'menu_icon' => 'dashicons-editor-help',
			'taxonomies' => array('category', 'post_tag'),
			'rewrite' => array('slug' => 'help-desk')
		)
	);
}
add_action('init', 'it_create_post_type');

//Flush rewrite rules on plugin initialization
function it_rewrite_flush(){
	it_create_post_type();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'it_rewrite_flush' );	

// Add unfiltered html for editor
function add_unfiltered_caps() {
	$role = get_role( 'editor' );
	$role -> add_cap('unfiltered_html');
}
add_action( 'init', 'add_unfiltered_caps');

// Add custom tinyMCE stylesheet
function add_it_editor_styles($mce_css) {
	if ( ! empty( $mce_css ) )
		$mce_css .= ',';
	
	$mce_css .= plugins_url('css/styles.css', __FILE__);
	return $mce_css;
}
?>