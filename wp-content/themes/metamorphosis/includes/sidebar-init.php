<?php

// Register widgetized areas
function the_widgets_init() {
    if ( function_exists('register_sidebar') )
    register_sidebars(9,array('name' => 'Footer %d','before_widget' => '','after_widget' => '','before_title' => '<h3>','after_title' => '</h3>'));
    //register_sidebars(1,array('name' => 'Sidebar','before_widget' => '<div id="%1$s" class="block widget %2$s">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));
   }

add_action( 'init', 'the_widgets_init' );


?>