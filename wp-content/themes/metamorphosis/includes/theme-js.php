<?php
if (!is_admin()) add_action( 'wp_print_scripts', 'primethemes_add_javascript' );
function primethemes_add_javascript( ) {
	wp_enqueue_script('jquery');    
	wp_enqueue_script( 'easing', get_bloginfo('template_directory').'/includes/js/jquery.easing.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'widgetSlider', get_bloginfo('template_directory').'/includes/js/loopedSlider.js', array( 'jquery' ) );	
}
?>