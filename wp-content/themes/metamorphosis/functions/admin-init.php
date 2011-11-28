<?php 

/**
 * primeThemes Framework Version & Theme Version
 */
function prime_version_init(){

    $prime_framework_version = '3.7.03';
    
    if ( get_option('prime_framework_version') <> $prime_framework_version ) 
        update_option('prime_framework_version',$prime_framework_version);
    
}
add_action('init','prime_version_init');

function prime_version(){
    
    $theme_data = get_theme_data(TEMPLATEPATH . '/style.css');
    $theme_version = $theme_data['Version'];
    $prime_framework_version = get_option('prime_framework_version');

    echo '<meta name="generator" content="'. get_option('prime_themename').' '. $theme_version .'" />' ."\n";
    echo '<meta name="generator" content="primeFramework '. $prime_framework_version .'" />' ."\n";
   
}
// Add or remove Generator meta tags
if ( get_option('framework_prime_disable_generator') == "true" )
    remove_action('wp_head', 'wp_generator');
else 
    add_action('wp_head','prime_version');

/**
 * Load the required Framework Files
 */

$functions_path = TEMPLATEPATH . '/functions/';

require_once ($functions_path . 'admin-functions.php');             // Custom functions and plugins
require_once ($functions_path . 'admin-setup.php');                 // Options panel variables and functions
require_once ($functions_path . 'admin-custom.php');                // Custom fields 
require_once ($functions_path . 'admin-interface.php');             // Admin Interfaces (options,framework, seo)
require_once ($functions_path . 'admin-framework-settings.php');    // Framework Settings
require_once ($functions_path . 'admin-seo.php');                   // Framework SEO controls
require_once ($functions_path . 'admin-sbm.php');                   // Framework Sidebar Manager
require_once ($functions_path . 'admin-medialibrary-uploader.php'); // Framework Media Library Uploader Functions // 2010-11-05.
require_once ($functions_path . 'admin-hooks.php');                 // Definition of primeHooks
if (get_option('framework_prime_primenav') == "true")
    require_once ($functions_path . 'admin-custom-nav.php');        // prime Custom Navigation
require_once ($functions_path . 'admin-shortcodes.php');            // prime Shortcodes
require_once ($functions_path . 'admin-shortcode-generator.php');   // Framework Shortcode generator // 2011-01-21.
?>