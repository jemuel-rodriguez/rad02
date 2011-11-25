<?php

// Register widgetized areas
function the_widgets_init() {
    if ( function_exists('register_sidebar') )
    register_sidebars(9,array('name' => 'Footer %d','before_widget' => '','after_widget' => '','before_title' => '<h3>','after_title' => '</h3>'));
    //register_sidebars(1,array('name' => 'Sidebar','before_widget' => '<div id="%1$s" class="block widget %2$s">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));
   }

add_action( 'init', 'the_widgets_init' );


//This is the function on how to add another sidebar
/*

    function base_sidebar(){
        register_sidebar( array(
    		'name' => __( 'Primary Widget Area', 'twentyten' ),
    		'id' => 'primary-widget-area',
    		'description' => __( 'The primary widget area', 'twentyten' ),
    		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
    		'after_widget' => '</li>',
    		'before_title' => '<h3 class="widget-title"><span class="side-image"></span>',
    		'after_title' => '</h3>',
    	) );
    }
    
    // Hook the base_sidebar to widget_init
    add_action('widget_init', 'base_sidebar');
    
*/

?>