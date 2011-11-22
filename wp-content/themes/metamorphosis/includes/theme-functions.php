<?php

// Category News Boxes
function get_exclude_categories($label) {
    
    $include = array();
    $counter = 0;
    $cats = get_categories('hide_empty=0');
    
    foreach ($cats as $cat) {
        
        $counter++;
        
        if ( get_option( $label.$cat->cat_ID ) ) {
            
                $exclude[] = $cat->cat_ID;
            }
        }
        if(!empty($exclude)){
        $exclude = implode(',',$exclude);
        }
    return $exclude;

}

function is_sidebar_active( $index = 1){
 $sidebars = wp_get_sidebars_widgets();
 $key  = (string) 'sidebar-'.$index;
    
    if(empty($sidebars[$key])) return false;
    else return true;
    
}

/*===================================================================================*/
/* WordPress 3.0 New Features Support */
/*===================================================================================*/

if ( function_exists('wp_nav_menu') ) {
	add_theme_support( 'nav-menus' );
	register_nav_menus( array( 'primary-menu' => __( 'Primary Menu' ), 'secondary-menu' => __( 'Secondary Menu' ) ) );
}

?>