
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
	wp_enqueue_style( 'dashicons');
	wp_enqueue_style( 'itservices_styles', plugins_url('/css/styles.css', __FILE__));
}
add_action( 'wp_enqueue_scripts', 'itservices_styles' );


add_action('init', 'it_create_post_type' );
// Add help desk post type
function it_create_post_type() {
	register_post_type( 'help_desk', 
		array(
			'labels' => array(
					'name'=> _( 'Help Desk Posts'),
					'singular_name' => _( 'Help Desk Post')
			),
		'public' => true,
		'has_archive' => true,
		'show_in_menu' => true,
		'show_in_admin_bar' => true,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-editor-help',
		'taxonomies' => array('categories', 'tags'),
		'rewrite' => array('slug' => 'help-desk')
		)
	);
}

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
	function add_it_editor_styles() {
		add_editor_style('it-custom-editor-style.css');
	}
	add_action('init', 'add_it_editor_styles');
	
	// Add formats dropdown to tinyMCE
	function cui_it_mce_buttons( $buttons ) {
		array_unshift( $buttons, 'styleselect' );
		return $buttons;
	}
	// Register our callback to the appropriate filter
	add_filter('mce_buttons', 'cui_mce_buttons');
	

	// Callback function to filter the MCE settings
	function add_it_tinyMCE_formats( $init_array ) {  
 		$style_formats = array(  
 			array(  
 				'title' => 'dashicon',  
				'selector' => 'p,div',  
				'block' => 'p',
				'selector' => 'p',
 				'classes' => 'dashicon',
 				'wrapper' => true,
				)
				);  
		$init_array['style_formats'] = json_encode( $style_formats );
		return $init_array;  
	} 
	// Attach callback to 'tiny_mce_before_init' 
	add_filter( 'tiny_mce_before_init', 'add_it_tinyMCE_formats' );
?>