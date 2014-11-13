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
// Create a widget
class it_services_spiceWorks extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'it_services', // Base ID
			__('IT Services - Help Desk', 'text_domain'), // Name
			array( 'description' => __( 'Adds a graphic widget for linking to SpiceWorks', 'text_domain' ), ) // Args
		);
	}
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		?>
        <div class="widget textwidget">
            <h2>Help Desk</h2>
            <p>Need help with technology? Use our online system to submit a help desk ticket.</p>
            <p>&nbsp;</p>
            <p><a href="https://itshelp.central.edu/portal" class="helpDeskButton" target="_blank">submit a ticket now!</a></p>
            <p align="center">or call us at 641-628-7010</p>
            <p>&nbsp;</p>
            <p>After-hours outage? Contact the Info Booth at 641-628-9000.</p>
		</div>
        <?php
		/*$title = apply_filters( 'widget_title', $instance['title'] );

		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
		echo __( 'Hello, World!', 'text_domain' );
		echo $args['after_widget'];*/
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		//Do Nothing
		?>
        <p>There are no options for this widget.</p>
        <?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		//Do nothing
	}
}
function register_spiceWorks_widget() {
    register_widget( 'it_services_spiceWorks' );
}
add_action( 'widgets_init', 'register_spiceWorks_widget' );
?>