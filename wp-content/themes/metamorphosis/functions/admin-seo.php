<?php
/**
 * SEO - primethemes_seo_page
 */

function primethemes_seo_page(){

    $themename =  get_option('prime_themename');      
    $manualurl =  get_option('prime_manual'); 
    $shortname =  'seo_prime'; 
    
    //Framework Version in Backend Head
    $prime_framework_version = get_option('prime_framework_version');
    
    //Version in Backend Head
    $theme_data = get_theme_data(TEMPLATEPATH . '/style.css');
    $local_version = $theme_data['Version'];
    
    //GET themes update RSS feed and do magic
    include_once(ABSPATH . WPINC . '/feed.php');

    $pos = strpos($manualurl, 'documentation');
    $theme_slug = str_replace("/", "", substr($manualurl, ($pos + 13))); //13 for the word documentation
    
    //add filter to make the rss read cache clear every 4 hours
    add_filter( 'wp_feed_cache_transient_lifetime', create_function( '$a', 'return 14400;' ) );
    
    $inner_pages = array(   'a' => 'Page title; Blog title',
                            'b' => 'Page title;',
                            'c' => 'Blog title; Page title;',
                            'd' => 'Page title; Blog description',
                            'e' => 'Blog title; Page title; Blog description'
                        );
    
    $seo_options = array();
    
    $seo_options[] = array( "name" => "General Settings",
                    "icon" => "general",
                    "type" => "heading");
                    
    $seo_options[] = array( "name" => "Please Read",
                    "type" => "info",
                    "std" => "Welcome to the primeSEO feature. <br /><small>Here we help you take control of your search engine readiness with some in-built theme options. Our themes do however support two of WordPress.org's most commonly used SEO plugins - <strong>All-in-One SEO</strong> and <strong>Headspace 2</strong>. Use the checkbox below to use 3rd party plugin data.</small>");

    $seo_options[] = array( "name" => "Use 3rd Party Plugin Data",
                    "desc" => "Meta data added to <strong>custom fields in posts and pages</strong> will be extracted and used where applicable. This typically does not include Homepages and Archives, and only Singular templates.", 
                    "id" => $shortname."_use_third_party_data",
                    "std" => "false",
                    "type" => "checkbox"); 
                    
    $seo_options[] = array( "name" => "Hide SEO custom fields",
                    "desc" => "Check this box to hide the input fields created in the post and page edit screens.", 
                    "id" => $shortname."_hide_fields",
                    "std" => "false",
                    "type" => "checkbox"); 
                
    $seo_options[] = array( "name" => "Page Title",
                    "icon" => "misc",
                    "type" => "heading");
                    
    $seo_options[] = array( "name" => "Separator",
                    "desc" => "Define a new separator character for your page titles.",
                    "id" => $shortname."_seperator",
                    "std" => "|",
                    "type" => "text");
                    
    $seo_options[] = array( "name" => "Blog Title",
                    "desc" => "NOTE: This is the same setting as per the SETTINGS > GENERAL tab in the WordPress backend.",
                    "id" => "blogname",
                    "std" => "",
                    "type" => "text");
                    
    $seo_options[] = array( "name" => "Blog Description",
                    "desc" => "NOTE: This is the same setting as per the SETTINGS > GENERAL tab in the WordPress backend.",
                    "id" => "blogdescription",
                    "std" => "",
                    "type" => "text");
                    
    $seo_options[] = array( "name" => "Enable prime_title()",
                    "desc" => "prime_title() makes use of WordPress's built in wp_title() function to control the output for your page titles. It's also recommended for use with plugins.",
                    "id" => $shortname."_wp_title",
                    "std" => "false",
                    "class" => "collapsed",
                    "type" => "checkbox"); 
                    
    $seo_options[] = array( "name" => "Disable Custom Titles",
                    "desc" => "If you prefer to have uniform titles across you theme. Alternatively they will be generated from custom fields and/or plugin data.",
                    "id" => $shortname."_wp_custom_field_title",
                    "std" => "false",
                    "class" => "hidden",
                    "type" => "checkbox"); 
                    
    $seo_options[] = array( "name" => "Paged Variable",
                    "desc" => "The name variable that will appear then paging through archives.",
                    "id" => $shortname."_paged_var",
                    "std" => "Page",
                    "class" => "hidden",
                    "type" => "text");
                    
    $seo_options[] = array( "name" => "Paged Variable Position",
                    "desc" => "Change the position where the paged variable will appear.",
                    "id" => $shortname."_paged_var_pos",
                    "std" => "before",
                    "class" => "hidden",
                    "options" => array( 'before' => 'Before',
                                        'after' => 'After'),
                    "type" => "select2");
                                                                
    $seo_options[] = array( "name" => "Homepage Title Layout",
                    "desc" => "Define the order the title, description and meta data appears in.",
                    "id" => $shortname."_home_layout",
                    "std" => "",
                    "class" => "hidden",
                    "options" => array( 'a' => 'Blog title; blog description',
                                        'b' => 'Blog title',
                                        'c' => 'Blog description'),
                    "type" => "select2");
                    
    $seo_options[] = array( "name" => "Single Title Layout",
                    "desc" => "Define the order the title, description and meta data appears in.",
                    "id" => $shortname."_single_layout",
                    "std" => "",
                    "class" => "hidden",
                    "options" => $inner_pages,
                    "type" => "select2");
                    
    $seo_options[] = array( "name" => "Page Title Layout",
                    "desc" => "Define the order the title, description and meta data appears in.",
                    "id" => $shortname."_page_layout",
                    "std" => "",
                    "class" => "hidden",
                    "options" => $inner_pages,
                    "type" => "select2");
                    
    $seo_options[] = array( "name" => "Archive Title Layout",
                    "desc" => "Define the order the title, description and meta data appears in.",
                    "id" => $shortname."_archive_layout",
                    "std" => "",
                    "class" => "hidden",
                    "options" => $inner_pages,
                    "type" => "select2");
                    
    $seo_options[] = array( "name" => "Indexing Meta",
                    "icon" => "misc",
                    "type" => "heading");
                    
    /*$seo_options[] = array( "name" => "Add Indexing Meta",
                    "desc" => "Add links to the header telling the search engine what the start, next, previous and home urls are.",
                    "id" => $shortname."_meta_basics",
                    "std" => "false",
                    "type" => "checkbox"); */
    
    $seo_options[] = array( "name" => "Archive Indexing",
                    "desc" => "Select which archives to index on your site. Aids in removing duplicate content from being indexed, preventing content dilution.",
                    "id" => $shortname."_meta_indexing",
                    "std" => "category",
                    "type" => "multicheck",
                    "options" => array( 'category' => 'Category Archives',
                                        'tag' => 'Tag Archives',
                                        'author' => 'Author Pages',
                                        'search' => 'Search Results',
                                        'date' => 'Date Archives')); 
                                        
    $seo_options[] = array( "name" => "Set meta for Posts & Pages to 'follow' by default",
                    "desc" => "By default the prime_meta(); adds a 'nofollow' meta to post and pages, meaning search engines will not index pages leading away from these pages.",
                    "id" => $shortname."_meta_single_follow",
                    "std" => "",
                    "type" => "checkbox");                  
    

    $seo_options[] = array( "name" => "Description Meta",
                    "icon" => "misc",
                    "type" => "heading");
                    
    $seo_options[] = array( "name" => "Homepage Description",
                    "desc" => "Choose where to populate your Homepage meta description from.",
                    "id" => $shortname."_meta_home_desc",
                    "std" => "a",
                    "options" => array( "a" => "Off",
                                        "b" => "From WP Site Description",
                                        "c" => "From Custom Homepage Description"),
                    "type" => "radio");
                                        
    $seo_options[] = array( "name" => "Custom Homepage Description",
                    "desc" => "Add a custom meta description to your homepage.",
                    "id" => $shortname."_meta_home_desc_custom",
                    "std" => "",
                    "type" => "textarea");
    
    $seo_options[] = array( "name" => "Single Page/Post Description",
                    "desc" => "Add your post/page description from custom fields. <strong>* See below</strong>",
                    "id" => $shortname."_meta_single_desc",
                    "std" => "a",
                    "options" => array( "a" => "Off *",
                                        "b" => "From Customs Field and/or Plugins",
                                        "c" => "Automatically from Post/Page Content",
                                        ),
                    "type" => "radio");
                    
    $seo_options[] = array( "name" => "Global Post/Page Descriptions",
                    "desc" => "Add a custom meta description to your posts and pages. This will only show if no other data is available from the selection above. Will still be added even if setting above is set to \"Off\".",
                    "id" => $shortname."_meta_single_desc_sitewide",
                    "std" => "",
                    "class" => "collapsed",
                    "type" => "checkbox");      
                    
    $seo_options[] = array( "name" => "Add Global Description",
                    "desc" => "Add your global decription.",
                    "id" => $shortname."_meta_single_desc_custom",
                    "std" => "",
                    "class" => "hidden",
                    "type" => "textarea");
                                        
    $seo_options[] = array( "name" => "Keyword Meta",
                    "icon" => "misc",
                    "type" => "heading");
                    
    $seo_options[] = array( "name" => "Homepage Keywords",
                    "desc" => "Choose where to populate your Homepage meta description from.",
                    "id" => $shortname."_meta_home_key",
                    "std" => "a",
                    "options" => array( "a" => "Off",
                                        "c" => "From Custom Homepage Keywords"),
                    "type" => "radio");
                                        
    $seo_options[] = array( "name" => "Custom Homepage Keywords",
                    "desc" => "Add a (comma separated) list of keywords to your homepage.",
                    "id" => $shortname."_meta_home_key_custom",
                    "std" => "",
                    "type" => "textarea");
    
    $seo_options[] = array( "name" => "Single Page/Post Keywords",
                    "desc" => "Add your post/page keywords from custom field. <strong>* See below</strong>",
                    "id" => $shortname."_meta_single_key",
                    "std" => "a",
                    "options" => array( "a" => "Off *",
                                        "b" => "From Custom Fields and/or Plugins",
                                        "c" => "Automatically from Post Tags &amp; Categories"),
                    "type" => "radio");
                    
    $seo_options[] = array( "name" => "Custom Post/Page Keywords",
                    "desc" => "Add a custom meta keywords to your posts and pages. This will only show if no other data is available from the selection above. Even if the option above is set to <strong>'Off'</strong>, will this keywords still be added to your site.",
                    "id" => $shortname."_meta_single_key_sitewide",
                    "std" => "",
                    "class" => "collapsed",
                    "type" => "checkbox");      
                    
    $seo_options[] = array( "name" => "Custom Post/Page Description",
                    "desc" => "Add a custom meta keywords to your posts and pages.",
                    "id" => $shortname."_meta_single_key_custom",
                    "std" => "",
                    "class" => "hidden",
                    "type" => "textarea");
                    
                    
    update_option('prime_seo_template',$seo_options);
                    
    
    ?>

    <div class="wrap" id="prime_container">
    <?php
    
        if(     class_exists('All_in_One_SEO_Pack')
            ||  class_exists('Headspace_Plugin')) { 
                
            echo "<div id='prime-seo-notice' class='prime-notice'><p><strong>3rd Party SEO Plugin(s) Detected</strong> - Some primeTheme SEO functionality has been disabled.</p></div>";
                        
        }
    
    ?>  
    <?php
    
        if ( get_option('blog_public') == 0 ) { 
                
            echo "<div id='prime-seo-notice-privacy' class='prime-notice'><p><strong>This site set to Private</strong> - SEO is disabled, change settings <a href='". admin_url() . "options-privacy.php'>here</a>.</p></div>";
                        
        }
    
    ?>  
    <div id="prime-popup-save" class="prime-save-popup"><div class="prime-save-save">Options Updated</div></div>
    <div id="prime-popup-reset" class="prime-save-popup"><div class="prime-save-reset">Options Reset</div></div>
        <form action="" enctype="multipart/form-data" id="primeform">
        <?php
            // Add nonce for added security.
            if ( function_exists( 'wp_nonce_field' ) ) { wp_nonce_field( 'primeframework-seo-options-update' ); } // End IF Statement
            
            $prime_nonce = '';
            
            if ( function_exists( 'wp_create_nonce' ) ) { $prime_nonce = wp_create_nonce( 'primeframework-seo-options-update' ); } // End IF Statement
            
            if ( $prime_nonce == '' ) {} else {
            
        ?>
            <input type="hidden" name="_ajax_nonce" value="<?php echo $prime_nonce; ?>" />
        <?php
            
            } // End IF Statement
        ?>
            <div id="header">
               <div class="logo">
                <?php if(get_option('framework_prime_backend_header_image')) { ?>
                <img alt="" src="<?php echo get_option('framework_prime_backend_header_image'); ?>"/>
                <?php } else { ?>
                <img alt="primeThemes" src="<?php echo bloginfo('template_url'); ?>/functions/images/logo.png"/>
                <?php } ?>
                </div>
                <div class="theme-info">
                    <span class="theme"><?php echo $themename; ?> <?php echo $local_version; ?></span>
                    <span class="framework">Framework <?php echo $prime_framework_version; ?></span>
                </div>
                <div class="clear"></div>
            </div>
            <div id="support-links">
        
                <ul>
                    <li class="changelog"><a title="Theme Changelog" href="<?php echo $manualurl; ?>#Changelog">View Changelog</a></li>
                    <li class="docs"><a title="Theme Documentation" href="<?php echo $manualurl; ?>">View Themedocs</a></li>
                    <li class="forum"><a href="http://forum.primethemes.com" target="_blank">Visit Forum</a></li>
                    <li class="right"><img style="display:none" src="<?php echo bloginfo('template_url'); ?>/functions/images/loading-top.gif" class="ajax-loading-img ajax-loading-img-top" alt="Working..." /><a href="#" id="expand_options">[+]</a> <input type="submit" value="Save All Changes" class="button submit-button" /></li>
                </ul>
        
            </div>
            <?php $return = primethemes_machine($seo_options); ?>
            <div id="main">
                <div id="prime-nav">
                    <ul>
                        <?php echo $return[1]; ?>
                    </ul>       
                </div>
                <div id="content">
                <?php echo $return[0]; ?>
                </div>
                <div class="clear"></div>
                
            </div>
            <div class="save_bar_top">
            <img style="display:none" src="<?php echo bloginfo('template_url'); ?>/functions/images/loading-bottom.gif" class="ajax-loading-img ajax-loading-img-bottom" alt="Working..." />
            <input type="submit" value="Save All Changes" class="button submit-button" />        
            </form>
            
            <form action="<?php echo wp_specialchars( $_SERVER['REQUEST_URI'] ) ?>" method="post" style="display:inline" id="primeform-reset">
            <?php
                // Add nonce for added security.
                if ( function_exists( 'wp_nonce_field' ) ) { wp_nonce_field( 'primeframework-seo-options-reset' ); } // End IF Statement
                
                $prime_nonce = '';
                
                if ( function_exists( 'wp_create_nonce' ) ) { $prime_nonce = wp_create_nonce( 'primeframework-seo-options-reset' ); } // End IF Statement
                
                if ( $prime_nonce == '' ) {} else {
                
            ?>
                <input type="hidden" name="_ajax_nonce" value="<?php echo $prime_nonce; ?>" />
            <?php
                
                } // End IF Statement
            ?>
            <span class="submit-footer-reset">
            <input name="reset" type="submit" value="Reset Options" class="button submit-button reset-button" onclick="return confirm('Click OK to reset. Any settings will be lost!');" />
            <input type="hidden" name="prime_save" value="reset" /> 
            </span>
            </form>

            
            </div>

    
    
    <div style="clear:both;"></div>    
    </div><!--wrap-->

<?php } ?>