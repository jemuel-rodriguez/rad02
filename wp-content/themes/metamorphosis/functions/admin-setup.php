<?php

/**
 * 
 * TABLE OF CONTENTS
 * 
 * - Show Options Panel after activate
 * - Admin Backend
 *     - Setup Custom Navigation
 * - Theme Header ouput - wp_head()
 *     - Styles
 *     - Favicon
 *     - Localization
 *     - Date Format
 *     - prime_head_css
 * - Output CSS from standarized options
 *     - Text title
 *     - Custom.css
 * - Post Images from WP2.9+ integration
 * - Enqueue comment reply script 
 * 
 */

define('THEME_FRAMEWORK','primethemes');

/**
 * Add default options and show Options Panel after activate  */
 */
if (is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) {

    //Call action that sets
    add_action('admin_head','prime_option_setup');
    
    //Do redirect
    header( 'Location: '.admin_url().'admin.php?page=primethemes' ) ;
    
}

if (!function_exists('prime_option_setup')) {
    function prime_option_setup(){
    
        //Update EMPTY options
        $prime_array = array();
        add_option('prime_options',$prime_array);
    
        $template = get_option('prime_template');
        $saved_options = get_option('prime_options');
        
        foreach ($template as $option) {
            if ($option['type'] != 'heading'){
                $id = $option['id'];
                $std = $option['std'];
                $db_option = get_option($id);
                if (empty($db_option)){
                    if (is_array($option['type'])) {
                        foreach ($option['type'] as $child){
                            $c_id = $child['id'];
                            $c_std = $child['std'];
                            $db_option = get_option($c_id);
                            if (!empty($db_option)){
                                update_option($c_id,$db_option);
                                $prime_array[$id] = $db_option;
                            } else {
                                $prime_array[$c_id] = $c_std; 
                            }
                        }
                    } else {
                        update_option($id,$std);
                        $prime_array[$id] = $std;
                    }
                } else { //So just store the old values over again.
                    $prime_array[$id] = $db_option;
                }
            }
        }
        update_option('prime_options',$prime_array);
    }
}

/**
 * Admin Backend
 */
if (!function_exists('primethemes_admin_head')) {
    function primethemes_admin_head() { 
        
        //Setup Custom Navigation Menu
        if (function_exists('prime_custom_navigation_setup')) {
            prime_custom_navigation_setup();
        }
        
    }
}
add_action('admin_head', 'primethemes_admin_head'); 


/**
 * Theme Header output - wp_head()
 */
if (!function_exists('primethemes_wp_head')) {
    function primethemes_wp_head() { 
        
        //Styles
        $style = '';
        
        if ( isset( $_REQUEST['style'] ) ) {
            // Sanitize requested value.
            $requested_style = strtolower( strip_tags( trim( $_REQUEST['style'] ) ) );
            $style = $requested_style;
        } 
                    
        if ($style != '') {
            echo '<link href="'. get_bloginfo('template_directory') .'/styles/'. $style . '.css" rel="stylesheet" type="text/css" />'."\n"; 
        } else { 
            $style = get_option('prime_alt_stylesheet');
            if( $style != '' ) {
                // Sanitize value.
                $style = strtolower( strip_tags( trim( $style ) ) );
                echo '<link href="'. get_bloginfo('template_directory') .'/styles/'. $style .'" rel="stylesheet" type="text/css" />'."\n";         
            } else {
                echo '<link href="'. get_bloginfo('template_directory') .'/styles/default.css" rel="stylesheet" type="text/css" />'."\n";
            }             
        }  
         
        // Favicon
        if(get_option('prime_custom_favicon') != '') {
            echo '<link rel="shortcut icon" href="'.  get_option('prime_custom_favicon')  .'"/>'."\n";
        }    
                    
        // Localization
        load_theme_textdomain('primethemes');
        load_theme_textdomain('primethemes', get_template_directory() . '/lang');
        if (function_exists('load_child_theme_textdomain')) load_child_theme_textdomain('primethemes');

        // Output CSS from standarized options
        prime_head_css();   
        
        // Output shortcodes stylesheet
        if ( function_exists("prime_shortcode_stylesheet") && get_option('framework_prime_disable_shortcodes') <> "true" )
            prime_shortcode_stylesheet();

        // Custom.css insert
        echo '<link href="'. get_bloginfo('template_directory') .'/custom.css" rel="stylesheet" type="text/css" />'."\n";   
    }
}
add_action('wp_head', 'primethemes_wp_head');


/**
 * Output CSS from standarized options
 */
if (!function_exists('prime_head_css')) {
    function prime_head_css() {
    
        $output = '';
        $text_title = get_option('prime_texttitle');
        $custom_css = get_option('prime_custom_css');
    
        $template = get_option('prime_template');
        if (is_array($template)) {
            foreach($template as $option){
                if(isset($option['id'])){
                    if($option['id'] == 'prime_texttitle') {
                        // Add CSS to output
                        if ($text_title == "true") {
                            $output .= '#logo img { display:none; }' . "\n";
                            $output .= '#logo .site-title, #logo .site-description { display:block; } ' . "\n";
                        } 
                    }
                }
            }
        }
        
        if ($custom_css <> '') {
            $output .= $custom_css . "\n";
        }
        
        // Output styles
        if ($output <> '') {
            $output = strip_tags($output);
            $output = "<style type=\"text/css\">\n" . $output . "</style>\n";
            echo $output;
        }
    
    }
}

/**
 * Post Images from WP2.9+ integration
 */
if(function_exists('add_theme_support')){
    if(get_option('prime_post_image_support') == 'true'){
        add_theme_support( 'post-thumbnails' );
        // set height, width and crop if dynamic resize functionality isn't enabled
        if ( get_option('prime_pis_resize') <> "true" ) {
            $thumb_width = get_option('prime_thumb_w');
            $thumb_height = get_option('prime_thumb_h');
            $single_pic_width = get_option('prime_single_w');
            $single_pic_height = get_option('prime_single_h');
            $hard_crop = get_option('prime_pis_hard_crop');
            if($hard_crop == 'true') {$hard_crop = true; } else { $hard_crop = false;}
            set_post_thumbnail_size($thumb_width,$thumb_height, $hard_crop); // Normal post thumbnails
            add_image_size( 'single-post-thumbnail', $single_pic_width, $single_pic_height, $hard_crop );
        }
    }
}


/**
 * Enqueue comment reply script
 */
if (!function_exists('prime_comment_reply')) {
    function prime_comment_reply() {
        if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
    }
}
add_action('get_header', 'prime_comment_reply');


?>