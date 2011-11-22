<?php
function prime_options(){
// VARIABLES
$themename = "Meta-Morphosis";
$manualurl = 'http://www.primethemes.com/support/theme-documentation/meta-morphosis/';
$shortname = "prime";



$GLOBALS['template_path'] = get_bloginfo('template_directory');

//Access the WordPress Categories via an Array
$prime_categories = array();  
$prime_categories_obj = get_categories('hide_empty=0');
foreach ($prime_categories_obj as $prime_cat) {
    $prime_categories[$prime_cat->cat_ID] = $prime_cat->cat_name;}
$categories_tmp = array_unshift($prime_categories, "Select a category:");    
       
//Access the WordPress Pages via an Array
$prime_pages = array();
$prime_pages_obj = get_pages('sort_column=post_parent,menu_order');    
foreach ($prime_pages_obj as $prime_page) {
    $prime_pages[$prime_page->ID] = $prime_page->post_name; }
$prime_pages_tmp = array_unshift($prime_pages, "Select a page:");       


//Testing 
$options_select = array("one","two","three","four","five"); 
$options_radio = array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five"); 

//Stylesheets Reader
$alt_stylesheet_path = TEMPLATEPATH . '/styles/';
$alt_stylesheets = array();

if ( is_dir($alt_stylesheet_path) ) {
    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) { 
        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {
            if(stristr($alt_stylesheet_file, ".css") !== false) {
                $alt_stylesheets[] = $alt_stylesheet_file;
            }
        }    
    }
}

//More Options


$other_entries = array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");

$ad_template = "advertising";
$nav_template = "nav";
$image_template = "image";

$GLOBALS['template_path'] = get_bloginfo('template_directory');

//Access the WordPress Categories via an Array
$prime_categories = array();  
$prime_categories_obj = get_categories('hide_empty=0');
foreach ($prime_categories_obj as $prime_cat) {
    $prime_categories[$prime_cat->cat_ID] = $prime_cat->cat_name;}
$categories_tmp = array_unshift($prime_categories, "Select a category:");    
       
//Access the WordPress Pages via an Array
$prime_pages = array();
$prime_pages_obj = get_pages('sort_column=post_parent,menu_order');    
foreach ($prime_pages_obj as $prime_page) {
    $prime_pages[$prime_page->ID] = $prime_page->post_name; }
$prime_pages_tmp = array_unshift($prime_pages, "Select a page:");       


//Testing 
$options_select = array("one","two","three","four","five"); 
$options_radio = array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five"); 

//Stylesheets Reader
$alt_stylesheet_path = TEMPLATEPATH . '/styles/';
$alt_stylesheets = array();

if ( is_dir($alt_stylesheet_path) ) {
    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) { 
        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {
            if(stristr($alt_stylesheet_file, ".css") !== false) {
                $alt_stylesheets[] = $alt_stylesheet_file;
            }
        }    
    }
}

//More Options


$other_entries = array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");

// THIS IS THE DIFFERENT FIELDS
$options[] = array(	"name" => "General Settings",
					                "type" => "heading");
						
                        
$options[] = array(    "name" => "Theme Stylesheet",
                                    "desc" => "Select your themes alternative color scheme.",
                                    "id" => $shortname."_alt_stylesheet",
                                    "std" => "default.css",
                                    "type" => "select",
                                    "options" => $alt_stylesheets);

$options[] = array(    "name" => "Custom Logo",
                                    "desc" => "Upload a logo for your theme, or specify an image URL directly.",
                                    "id" => $shortname."_logo",
                                    "std" => "",
                                    "type" => "upload");    
                                                                                     
 $options[] = array(    "name" => "Custom Favicon",
                                        "desc" => "Upload a 16px x 16px <a href='http://www.faviconr.com/'>ico image</a> that will represent your website's favicon.",
                                        "id" => $shortname."_custom_favicon",
                                        "std" => "",
                                        "type" => "upload"); 
                                               
$options[] = array(    "name" => "Tracking Code",
                                    "desc" => "Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.",
                                    "id" => $shortname."_google_analytics",
                                    "std" => "",
                                    "type" => "textarea");        

$options[] = array(    "name" => "RSS URL",
                                    "desc" => "Enter your preferred RSS URL. (Feedburner or other)",
                                    "id" => $shortname."_feedburner_url",
                                    "std" => "",
                                    "type" => "text");

$options[] = array( "name" => "Custom CSS",
                                    "desc" => "Quickly add some CSS to your theme by adding it to this block.",
                                    "id" => $shortname."_custom_css",
                                    "std" => "",
                                    "type" => "textarea");
                                    
$options[] = array(        "name" => "Dynamic Images",
                                       "type" => "heading");    

$options[] = array(    "name" => "Enable Dynamic Image Resizer",
                                        "desc" => "This will enable the thumb.php script. It dynamicaly resizes images on your site.",
                                        "id" => $shortname."_resize",
                                        "std" => "true",
                                        "type" => "checkbox");    
                    
$options[] = array(    "name" => "Automatic Image Thumbs",
                                    "desc" => "If no image is specified in the 'image' custom field then the first uploaded post image is used.",
                                    "id" => $shortname."_auto_img",
                                    "std" => "false",
                                    "type" => "checkbox");    

$options[] = array(	"name" => "Layout Options",
					                "type" => "heading");	

$options[] = array( "name" => "Exclude Pages from Top Navigation",         
                                    "desc" => "Enter a comma-separated list of <a href='http://support.wordpress.com/pages/8/'>ID's</a> that you'd like to exclude from the top navigation. (e.g. 12,23,27,44)",       
                                    "id" => $shortname."_exclude_pages",
                                    "std" => "",
                                    "type" => "text");   

$options[] = array( "name" => "Exclude Categories main menu",
                                    "desc" => "Enter a comma-separated list of <a href='http://support.wordpress.com/pages/8/'>ID's</a> that you'd like to exclude from the top navigation. (e.g. 12,23,27,44)",       
                                    "id" => $shortname."_exclude_cats",
                                    "std" => "",
                                    "type" => "text");   

$options[] = array( "name" => "Featured posts",
                                    "desc" => "Enter the number of posts you want to show on homepage on the left featured column.",
                                    "id" => $shortname."_featured_posts",
                                    "std" => "5",
                                    "type" => "text");   


$prime_metaboxes = array(

        "image" => array (
            "name"        => "image",
            "std"     =>  "",
            "label"     => "Image",
            "type"         => "upload",
            "desc"      => "Upload file here..."
        ),
    );
    
        update_option('prime_template',$options);
        update_option('prime_themename',$themename);      
        update_option('prime_shortname',$shortname ); 
        update_option('prime_manual',$manualurl ); 
        
// Add extra metaboxes through function
if ( function_exists("prime_metaboxes_add") )
	$prime_metaboxes = prime_metaboxes_add($prime_metaboxes);
    
if ( get_option('prime_custom_template') != $prime_metaboxes) update_option('prime_custom_template',$prime_metaboxes);
 
 
    
}

add_action('init','prime_options')
 
    														    								
?>