<?php
/**
 * primeThemes - Sidebar Manager
 * Version - V.1.05
 * ---
 * Installation: Make sure all dynamic_sidebar are converted to prime_sidebar,
 * and all is_active_sidebars are converted to prime_active_sidebar.
 * Usage: A new admit panel is created where you can create, edit and 
 * delete sidebars for your theme.
 * Author: Foxinni (http://foxinni.com)
 * 
 */


//Delete Options
//delete_option('sbm_prime_sbm_options');

//Created a function that adds a filter to sidebar delegation
function prime_sidebar($id = 1){
    
    $id = apply_filters( 'prime_inject_sidebar', $id ); 
    dynamic_sidebar($id);

}

//Created a function that adds a filter to active sidebar delegation
function prime_active_sidebar($id){
    
    $id = apply_filters( 'prime_inject_sidebar', $id );
    if(is_active_sidebar($id))
        return true;
    
    return false;

}
//Function to return the correct sidebar ID on the correct template
function prime_sbm_sidebar($current_sidebar_id){
    
    //Load Settings
    $prime_sbm_options = get_option('sbm_prime_sbm_options');
    
    $_is_replaced = false;
    
    if(is_int($current_sidebar_id)){ $current_sidebar_id = "sidebar-" . $current_sidebar_id; }
    
    if(!empty($prime_sbm_options['sidebars'])){
        
        foreach($prime_sbm_options['sidebars'] as $sidebar){

            $id = $sidebar['conditionals']['id'];
            $type = $sidebar['conditionals']['conditional'];
            $sidebar_id = $sidebar['conditionals']['sidebar_id'];
            $sidebar_replace = $sidebar['conditionals']['sidebar_replace'];
            $sidebar_source = $sidebar['conditionals']['source'];
            
            if(!empty($sidebar_source)) { 
                $sidebar_id = $sidebar_source;
                $sidebar_replace = $prime_sbm_options['sidebars'][$sidebar_id]['conditionals']['sidebar_replace'];              
            } // End IF Statement
            
            //For query posts in the wild
            wp_reset_query();
            
            /**
             * Support for custom post types, if using WordPress 3.0+.
             */
            
            global $wp_version, $post;
            
            $_post_types = array();
            
            if ( $wp_version >= '3.0' ) {
            
                $_args = array(
                            'show_ui' => true, 
                            'public' => true, 
                            'publicly_queryable' => true, 
                            '_builtin' => false
                            );
                
                $_post_types = get_post_types( $_args, 'object' );
                
                // Set certain post types that aren't allowed to have custom sidebars.
                
                $_disallowed_types = array( 'slide' );
                
                // Make the array pluggable.
                
                $_disallowed_types = apply_filters( 'primeframework_sbm_disallowed_posttypes', $_disallowed_types );
            
                if ( count( $_post_types ) ) {
                
                    foreach ( $_post_types as $k => $v ) {
                    
                        if ( in_array( $k, $_disallowed_types ) ) {
                        
                            unset( $_post_types[$k] );
                        
                        } // End IF Statement
                    
                    } // End FOREACH Loop
                
                } // End IF Statement
            
            } // End IF Statement
            
            if ( ( $type == 'custom_post_type' || $id == 'singular' ) && in_array( $post->post_type, array_keys( $_post_types ) ) ) {
            
                if( $post->post_type == $id && $sidebar_id == 'prime_sbm_custom_post_type_' . $id . '_' . $current_sidebar_id ) {
                            
                    if($sidebar_replace == $current_sidebar_id) {
                        
                        $current_sidebar_id = $sidebar_id;
                        
                        // Set this to prevent the system from conflicting with the template hierarchy.
                        $_is_replaced = true;
                
                    } // End IF Statement
                
                } else {
                
                    if ( is_singular() && $sidebar_id == 'prime_sbm_hierarchy_singular_' . $current_sidebar_id ) {
                    
                        $current_sidebar_id = $sidebar_id;
                        
                        // Set this to prevent the system from conflicting with the template hierarchy.
                        $_is_replaced = true;
                    
                    } // End IF Statement
                        
                } // End IF Statement
                
            } else {
            
                    //Find conditionals return required sidebar
                    if( $type == 'page' && $id == $post->ID ){
                        
                        if( is_page( $post->ID ) && ! is_archive() && ! is_home() )
                            
                            if($sidebar_replace == $current_sidebar_id)
                                $current_sidebar_id = $sidebar_id;
                                
                                // Set this to prevent the system from conflicting with the template hierarchy.
                                $_is_replaced = true;
                                
                    } // End IF Statement
                    
                    if( $type == 'category'/* && ! is_home() && ! $_is_replaced && ! is_singular()*/ ) {
                    
                        if( is_category($id) || ( is_single() && in_category( $id ) ) )
                            if($sidebar_replace == $current_sidebar_id)
                                $current_sidebar_id = $sidebar_id;
                                
                                // Set this to prevent the system from conflicting with the template hierarchy.
                                $_is_replaced = true;
                                
                    } // End IF Statement
                    
                    if( $type == 'post_tag'/* && ! is_home() && ! $_is_replaced*/ ) {
                        $tag_data = get_tag($id);
                        if(is_tag($tag_data->slug))
                            if($sidebar_replace == $current_sidebar_id)
                                $current_sidebar_id = $sidebar_id;
                                
                                // Set this to prevent the system from conflicting with the template hierarchy.
                                $_is_replaced = true;
                                
                    } // End IF Statement
                    
                    if( $type == 'page_template'/* && ! is_home() && ! $_is_replaced*/ ) {
                        if(is_page_template($id))
                            if($sidebar_replace == $current_sidebar_id)
                                $current_sidebar_id = $sidebar_id;
                                
                                // Set this to prevent the system from conflicting with the template hierarchy.
                                $_is_replaced = true;
                                
                    } // End IF Statement
                    
                    if( $type == 'hierarchy'/* && ! $_is_replaced*/ ) {
                    
                        if($id == 'front_page')
                            if(is_front_page())
                                if($sidebar_replace == $current_sidebar_id)
                                    $current_sidebar_id = $sidebar_id;
                        if($id == 'home')
                            if(is_home())
                                if($sidebar_replace == $current_sidebar_id)
                                    $current_sidebar_id = $sidebar_id;
                        if($id == 'single')
                            if(is_single())
                                if($sidebar_replace == $current_sidebar_id)
                                    $current_sidebar_id = $sidebar_id;
                        if($id == 'page')
                            if(is_page())
                                if($sidebar_replace == $current_sidebar_id)
                                    $current_sidebar_id = $sidebar_id;
                        if($id == 'singular')
                            if(is_singular())
                                if($sidebar_replace == $current_sidebar_id)
                                    $current_sidebar_id = $sidebar_id;
                        if($id == 'date')
                            if(is_date())
                                if($sidebar_replace == $current_sidebar_id)
                                    $current_sidebar_id = $sidebar_id;
                        if($id == 'archive')
                            if(is_archive())
                                if($sidebar_replace == $current_sidebar_id)
                                    $current_sidebar_id = $sidebar_id;
                        if($id == 'category')
                            if(is_category())
                                if($sidebar_replace == $current_sidebar_id)
                                    $current_sidebar_id = $sidebar_id;
                        if($id == 'tag')
                            if(is_tag())
                                if($sidebar_replace == $current_sidebar_id)
                                    $current_sidebar_id = $sidebar_id;
                        if($id == 'tax')
                            if(is_tax())
                                if($sidebar_replace == $current_sidebar_id)
                                    $current_sidebar_id = $sidebar_id;
                        if($id == 'author')
                            if(is_author())
                                if($sidebar_replace == $current_sidebar_id)
                                    $current_sidebar_id = $sidebar_id;              
                        if($id == 'search')
                            if(is_search())
                                if($sidebar_replace == $current_sidebar_id)
                                    $current_sidebar_id = $sidebar_id;                          
                        if($id == 'paged')
                            if(is_paged())
                                if($sidebar_replace == $current_sidebar_id)
                                    $current_sidebar_id = $sidebar_id;  
                        if($id == 'attach')
                            if(is_attach())
                                if($sidebar_replace == $current_sidebar_id)
                                    $current_sidebar_id = $sidebar_id;          
                        if($id == '404')
                            if(is_404())
                                if($sidebar_replace == $current_sidebar_id)
                                    $current_sidebar_id = $sidebar_id;                          
                                                                        
                    } // End IF Statement
                    
                    if ($type == '') {
                        $type_tax = $sidebar['conditionals']['type'];
                        if ($type_tax != '') {
                            // CUSTOM TAXONOMIES
                            $wp_custom_taxonomy_args = array('_builtin' => false );
                            $prime_wp_custom_taxonomies = array();  
                            $prime_wp_custom_taxonomies = get_taxonomies($wp_custom_taxonomy_args,'objects'); 
                            $sentinel = false;  
                            foreach ($prime_wp_custom_taxonomies as $prime_wp_custom_taxonomy) {
                                // checks for match to taxonomy
                                if ($type_tax == $prime_wp_custom_taxonomy->name) {
                                    $term_list = get_the_terms( 0, $prime_wp_custom_taxonomy->name  );
                                    $term_results = '';
                                    if ($term_list) {
                                        foreach ($term_list as $term_item) {
                                            if ( (is_tax($prime_wp_custom_taxonomy->name, $term_item->slug)) && ($id == $term_item->term_id) ) { $sentinel = true; } // End IF Statement
                                        } // End FOREACH Loop   
                                    } // End IF Statement
                                } // End IF Statement
                            } // End FOREACH Loop
                            if ($sentinel) {
                                if($sidebar_replace == $current_sidebar_id) {
                                    $current_sidebar_id = $sidebar_id;
                                } // End IF Statement
                            } // End IF Statement
                        } // End IF Statement
                    } // End IF Statement
                    
            } // End Custom Post Type IF Statement
            
        } // End FOREACH Loop
    } // End IF Statement
    
    return $current_sidebar_id;
    
} // End prime_sbm_sidebar()

//Adding the filter that injects the right sidebar ID back into the prime_sidebar function.
add_filter('prime_inject_sidebar','prime_sbm_sidebar');

// Register new widgetized areas via plugin
if (!function_exists('prime_sbm_widgets_init')) {
    function prime_sbm_widgets_init() {
        if ( !function_exists('register_sidebars') )
            return;
    
        $prime_sbm_options = get_option('sbm_prime_sbm_options');
        if(!empty($prime_sbm_options['sidebars'])){
            foreach($prime_sbm_options['sidebars'] as $sidebars){
                if(empty($sidebars['conditionals']['source']))
                    register_sidebar($sidebars['setup']);
            }
        }
    }
}

add_action( 'init', 'prime_sbm_widgets_init' );

/**
 * Sidebar Manager - Reset Function
 */

function primethemes_sbm_reset () {

    update_option( 'sbm_prime_sbm_options', '' );

} // End primethemes_sbm_reset()

function primethemes_sbm_page(){

    global $wp_registered_sidebars;
    
    // If the user wants to reset the script, we reset the script.
    if ( isset( $_POST['prime_save'] ) && $_POST['prime_save'] == 'sbm_reset' ) {
    
        primethemes_sbm_reset();
    
    } // End IF Statement
    
    //Load SBM settings
    $init_array = array('sidebars' => array(),'settings' => array('infobox' => 'show'));
    add_option('sbm_prime_sbm_options',$init_array);
    $prime_sbm_options = get_option('sbm_prime_sbm_options');
    
    //Error checking
    if(!empty($prime_sbm_options['sidebars'])){
        foreach($prime_sbm_options['sidebars'] as $key => $options){
            if(empty($key)){ unset($prime_sbm_options['sidebars'][$key]); }
        }
    
    }
    
    //delete_option('sbm_prime_sbm_options');
    $themename =  get_option('prime_themename');      
    $manualurl =  get_option('prime_manual'); 
    
    //Framework Version in Backend Head
    $prime_framework_version = get_option('prime_framework_version');    
    
    //Version in Backend Head
    $theme_data = get_theme_data(TEMPLATEPATH . '/style.css');
    $local_version = $theme_data['Version'];        
    
    //Outout for original sidebars, and new sidebars
    $init_sidebars = '';
    $init_sidebars = '';
    $new_sidebars = '';
    $counter = 0;
    foreach($wp_registered_sidebars as $sidebar){ 
        if(!strstr($sidebar['id'],'prime_sbm_')){
            $counter++;
            if($counter == 1) { $init_sidebars = $sidebar['name']; }
            $init_sidebars .= '<option value="'.$sidebar['id'].'">'.$sidebar['name'].'</option>';
        } else {
            $new_sidebars .= '<option value="'.$sidebar['id'].'">'.$sidebar['name'].'</option>';
        }
    }; 
    
    //Start script output
    ?>
    <script type="text/javascript">
    /**
     *  Below is the IE fix for .live('submit')  error
     */
    
    /**
     * Patch (plugin) for jQuery bug 6359: "live('submit') does nothing in IE if
     * live('click') was called before. same with delegate."
     *
     * The workaround is to ensure that live('click') calls happen *after*
     * live('submit') calls. Fixing live() fixes delegate(), which calls live().
     *
     * This plugin uses setTimeout(..., 0) to effect the workaround. That is, it
     * defers live('click') calls to a future execution context. It should work
     * around the issue in most cases.
     *
     * @author Jonathan Aquino
     * @see http://dev.jquery.com/ticket/6359
     * @see TEZLA-538
     */
    (function($) {
            var originalLive = jQuery.fn.live;
            jQuery.fn.live = function(types) {
                var self = this;
                var args = arguments;
                if (types == 'click') {
                    setTimeout(function() {
                        originalLive.apply(self, args);
                    }, 0);
                } else {
                    originalLive.apply(self, args);
                }
            };
    })(jQuery);

    //Accordian for the template selecting
    function initMenus() {
    
        jQuery('#prime-sbm-menu ul ul').hide();
        
        jQuery('#prime-sbm-menu ul ul:first').show();

        
        jQuery('#prime-sbm-menu ul#prime-sbm-menu_ul li a').click(
            function() {
                var checkElement = jQuery(this).next();
                var parent = this.parentNode.parentNode.id;

                
                if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
                jQuery('#' + parent + ' > li a span').text('[+]');
                    jQuery('#' + parent + ' ul:visible').slideUp('normal');
                    checkElement.slideDown('normal');
                    checkElement.parent().find('a span').text('[-]');
                    
                }
                return false;
            });
        }
    
    jQuery(document).ready(function() { 
    
        initMenus();

        function prime_sbm_title(sidebar,name,type){
        
            if ( type == 'custom_post_type' ) {
            
                type = 'Custom Post Type';
            
            } // End IF Statement
            
            var message = name+', '+type+' ('+sidebar+')';      
            return message;
        }
        
        function prime_sbm_description(sidebar,name,type){
            if(type == 'post_tag') type = 'tag template';
            if(type == 'page_template') type = 'page template';
            if(type == 'hierarchy') type = 'template hierarchy';
            if(type == 'custom_post_type') type = 'custom post type';
                
            var message = 'This sidebar will replace the '+sidebar+' sidebar on the '+name+' '+type+'.';        
            return message;
        }
        
        jQuery('.item-edit').click(function(){
            jQuery(this).parent().parent().parent().next('.menu-item-settings').slideToggle();
            return false;
        })
            
        jQuery('#prime-sbm-toggle-info').live('click',function(){
            var info = jQuery('#prime-sbm-builder-meta');
            if(info.css('display') == 'none'){
                info.fadeIn();
            } else {
                info.fadeOut();
            }
            return false;
        }); 
        jQuery('#prime-sbm-builder-source').val(0);
        jQuery('#prime-sbm-tab-new').live('click',function(){
            
            jQuery('.nav-tabs .nav-tab').removeClass('nav-tab-active');
            jQuery(this).addClass('nav-tab-active');
            jQuery('#prime-sbm-builder-part-assign').hide(); 
            jQuery('#prime-sbm-builder-part-create').show();
            jQuery('#prime-sbm-builder-source').val(0);
            jQuery('#prime-sbm-label-sb-name span').text("Sidebar Name");
            jQuery('#prime-sbm-label-sb-desc').show();
            return false;
        });
        
        jQuery('#prime-sbm-tab-existing').live('click',function(){
            
            jQuery('.nav-tabs .nav-tab').removeClass('nav-tab-active');
            jQuery(this).addClass('nav-tab-active');
            jQuery('#prime-sbm-builder-part-create').hide();
            jQuery('#prime-sbm-builder-part-assign').show(); 
            jQuery('#prime-sbm-builder-source').val(1);
            jQuery('#prime-sbm-label-sb-name span').text("Sidebar Alias");
            jQuery('#prime-sbm-label-sb-desc').hide();
            return false;
        });
        
        jQuery('#prime-sbm-menu ul#prime-sbm-menu_ul ul li').click(function(){
        
            var template_data = jQuery(this).children('span').text();
            var ajax_url = '<?php echo admin_url("admin-ajax.php"); ?>';
            var data = {
                type: 'prime_sbm_get_links',
                action: 'prime_sbm_post_action',
                data:template_data
            };
            
            jQuery.post(ajax_url, data, function(response) {
            
                //GET LINKS             
                var response = response.split('|');
                var type    = response[0];
                var name    = response[1];
                var slug    = response[2];
                var id      = response[3];
                var other   = response[4];
                var cond    = response[5];
                
                //When user changes sidebar to replace
                jQuery('#sidebar_replace').live('change',function(){
                    var sidebar = "";
                    jQuery(this).children("option:selected").each(function(){
                        sidebar = jQuery(this).text();
                    });
                    generatedTitle = prime_sbm_title(sidebar,name,type);
                    generatedMessage = prime_sbm_description(sidebar,name,type);
                    jQuery('#sidebar-title').val(generatedTitle);
                    jQuery('#sidebar-description').val(generatedMessage);
       
                })
                
                var html = '';
                var class_name = '';

                generatedTitle = prime_sbm_title('<?php echo $init_sidebars; ?>',name,type);
                generatedMessage = prime_sbm_description('<?php echo $init_sidebars; ?>',name,type);
                
                jQuery('#prime-sbm-get-links').show();
                
                //Add Values to Template Info
                var name_input = jQuery('#prime-sbm-get-links-inner #template-info-name');
                name_input.val(name);
                name_input.prev('label').html('<span>Name:</span> '+name);
    
                var type_input = jQuery('#prime-sbm-get-links-inner #template-info-type');
                type_input.val(type);
                type_input.val(type).prev().html('<span>Type:</span> '+type);

                var slug_input = jQuery('#prime-sbm-get-links-inner #template-info-slug');
                slug_input.val(slug);
                slug_input.prev().html('<span>Slug:</span> '+slug);

                var id_input = jQuery('#prime-sbm-get-links-inner #template-info-id');
                id_input.val(id);
                id_input.prev().html('<span>ID:</span> '+id);

                if(other != ''){
                    var other_input = jQuery('#prime-sbm-get-links-inner #template-info-other');
                    other_input.val(other);
                    other_input.prev().html('<span>URL:</span> <small><a href="'+ other +'">'+ other +'</a></small>');
                } else {
                    var other_input = jQuery('#prime-sbm-get-links-inner #template-info-other');
                    other_input.val('n/a');
                    other_input.prev().html('<span>URL:</span> n/a');

                }
                
                //Add Values to Sidebar Builder
                jQuery('#prime-sbm-get-links-inner #sidebar-title').val(generatedTitle);
                jQuery('#prime-sbm-get-links-inner #sidebar-description').val(generatedMessage);
                jQuery('#prime-sbm-get-links-inner #prime-sbm-builder-conditional').val(cond);

                
                html += '<label id="prime-sbm-label-sb-desc"><span>Sidebar description</span> <textarea id="sidebar-description" name="sidebar-description" style="width:230px">'+generatedMessage+'</textarea></label>';
                html += '<input id="prime-sbm-builder-conditional" type="hidden" name="conditional" value="'+cond+'" />';
                            
                var success = jQuery('#prime-popup-save');
                var loading = jQuery('.ajax-loading-img');
                loading.fadeOut();  
                jQuery('#prime-sbm-tip-1').hide(); //Fade tip out
                
            });
            return false; 
        });
        
        //Now to save your new sidebar
        
        jQuery("#prime-sbm-get-links").live("submit",function(){
            
            var sidebarTitle = jQuery('#sidebar-title').val();
            if(sidebarTitle == ''){ alert('Please add a Sidebar Name!'); return false; }
            
            function newValues() {
              var serializedValues = jQuery("#prime-sbm-get-links").serialize();
              return serializedValues;
            }
            jQuery(":checkbox, :radio").click(newValues);
            jQuery("select").change(newValues);
            jQuery('.ajax-loading-img').fadeIn();
            var serializedReturn = newValues();
             
            var ajax_url = '<?php echo admin_url("admin-ajax.php"); ?>';
        
            var data = {
                type: 'prime_sbm_add_sidebar',
                action: 'prime_sbm_post_action',
                data: serializedReturn
            };
            
            jQuery.post(ajax_url, data, function(response) {
                
                //Split response up
                var response = response.split('|');
                
                //Only stage is used in this case
                var type    = response[0];
                var slug    = response[1];
                var name    = response[2];
                var id      = response[3];
                var other   = response[4]; //URL's mostly
                var cond    = response[5];
                var stage   = response[6];
                var sbName  = response[7];
                var sbId    = response[8];
                var source  = response[9];
                
                var success = jQuery('#prime-popup-save');
                var loading = jQuery('.ajax-loading-img');
                loading.fadeOut();  
                if(stage == 2){ 
                    location.reload();
                }
            });
            return false; 
        }); 
    
        //Delete a sidebar  
        jQuery('#prime-sbm-sidebars .menu-item .submitdelete').live('click',function(){
        
            var id = jQuery(this).parent().parent().parent().parent().attr('id');
            var ajax_url = '<?php echo admin_url("admin-ajax.php"); ?>';
            var data = {
                type: 'prime_sbm_delete-sidebar',
                action: 'prime_sbm_post_action',
                data: id
            };
            if(id == ''){
                alert('And error has occured: No ID found.'); die();
            }
            
            jQuery.post(ajax_url, data, function(response) {
                //Split response up
                var response = response.split('|');
                
                //Only stage is used in this case
                var ids     = response[0];
                var pos     = response[1];
                
                jQuery(ids).fadeOut('slow',function(){ jQuery(this).remove();});
                if(jQuery(id).hasClass('menu-item-depth-0')){
                    jQuery(this).next('.menu-item-depth-1').fadeOut('slow',function(){ jQuery(this).remove();});
                }
                
                jQuery('#sidebar_to_sourceback option').each(function(){
                    //alert(jQuery(this).val() + ', Pos: ' + pos);
                    if(jQuery(this).val() == pos){ jQuery(this).remove();}
                });
                //alert(jQuery('#sidebar_to_sourceback option').length);
                if(jQuery('#sidebar_to_sourceback option').length == 0){
                    //alert('its done');
                    jQuery('#prime-sbm-tab-existing').remove();
                    jQuery('#prime-sbm-tab-new').click();
                };      
            });
            return false; 
        });
        
        //Cancel a sidebar
        jQuery('#prime-sbm-sidebars .menu-item .submitcancel').live('click',function(){
            jQuery(this).parent().parent().slideUp();
            return false;
        })
        
        //Edit a sidebar    
        jQuery('#prime-sbm-sidebars .menu-item .submitsave').live('click',function(){
        
            var clicked = jQuery(this);         
            var id = clicked.parent().parent().attr('id');

                function newValues() {
                    var serializedValues = clicked.parent().parent().parent().parent().find('form').serialize();
                    return serializedValues;
                }
                jQuery(":checkbox, :radio").click(newValues);
                jQuery("select").change(newValues);
                jQuery('.ajax-loading-img').fadeIn();
                var serializedReturn = newValues();
                
                var ajax_url = '<?php echo admin_url("admin-ajax.php"); ?>';
        
                var data = {
                    type: 'prime_sbm_save-sidebar',
                    action: 'prime_sbm_post_action',
                    data: serializedReturn
                };
                
                jQuery.post(ajax_url, data, function(response) {
                
                    var response = response.split('|');
                    var name    = response[0];
                    var sidebar = response[1];
                
                    var loading = jQuery('.ajax-loading-img');
                    loading.fadeOut();
                    clicked.parent().parent().parent().parent().find('.item-title').text(name); 
                    clicked.parent().parent().parent().parent().find('.item-type').text(sidebar);                           
                    clicked.parent().parent().slideUp();                    
                                    
                });
       
            return false;   
            
        
        });
        
        //Delete a sidebar  
        jQuery('.sbm-content .btn-close').live('click',function(){
        
            var ajax_url = '<?php echo admin_url("admin-ajax.php"); ?>';
            var data = {
                type: 'prime_sbm_dismiss_intro',
                action: 'prime_sbm_post_action',
                data: ''
            };

            jQuery.post(ajax_url, data, function(response) {
                jQuery('.sbm-content .info-box').slideUp('slow',function(){ jQuery(this).remove();});
            });
            return false; 
        });

});
</script>

<div class="wrap" id="prime_container">    
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
                 <li class="right"><img style="display:none" src="<?php echo bloginfo('template_url'); ?>/functions/images/loading-top.gif" class="ajax-loading-img ajax-loading-img-top" alt="Working..." /><?php /* <a href="#" id="expand_options">[+]</a> <input type="submit" value="Save All Changes" class="button submit-button" /> */ ?></li>
             </ul>
     
         </div>
         <div id="main">
            <div id="content" class="sbm-content">
                <?php 
                if(isset($prime_sbm_options['settings']['infobox'])){
                if($prime_sbm_options['settings']['infobox'] == 'show'){ ?>
                <div class="info-box">
                    
                    <h2>primeThemes Sidebar Manager</h2>
                    
                    <p>You're one step closer to having total control over your theme. This Sidebar Manager is available only to themes running
                    version 3.0.0 of the primeFramework. If you can see this message you're framework is up-to-date. Good Job!</p>
                    
                    <p>If you have not downloaded the latest version of this theme, but rather updated it from the theme options backend, <strong>you will need to upgrade 
                    your theme manually</strong> if you're want to make use of this Sidebar Manager feature. Please take note of the following:</p>
                    
                    <p><strong>Manual Installation:</strong> Replace all the <code>dynamic_sidebar</code> functions with the new
                    <code>prime_sidebar</code> and replace all <code>is_active_sidebar</code> with the new <code>prime_active_sidebar</code>. These are typically found in the 
                    <code>sidebar.php</code> &amp; <code>footer.php</code> files.</p>
                    
                    <a class="btn-close" href="#" title="#"><img src="<?php echo bloginfo('template_url'); ?>/functions/images/ico-close.png" alt="Close" /></a>
                
                </div>
                <?php }} ?>
                
                <div id="sbm-sidebar">
            
                    <div id="prime-sbm-menu" class="postbox">
                        <h3>Choose a Template</h3>
                        <ul id="prime-sbm-menu_ul">
                        <?php $pages = get_pages(array('sort_order' => 'ASC')); ?>
                        <?php if(!empty($pages)){ ?>
                        <li><a href="#">Pages <span>[-]</span></a>
                            <ul>
                                <?php
                                foreach ($pages as $page) {
                                    if(array_key_exists ('prime_sbm_page_'.$page->ID,$prime_sbm_options['sidebars'])){ continue; }
                                    echo '<li>' . $page->post_title . '<span>type=page&name='. urlencode(  $page->post_title ) .'&slug='.$page->post_name.'&id='. $page->ID.'&other=null</span></li>';
                                    } ?>
                            </ul>
                        </li>
                        <?php } 
                        
                        $page_templates = get_page_templates();
                        if(!empty($page_templates)){
                        ?>
                        <li><a href="#">Page Templates <span>[+]</span></a>
                            <ul>
                            <?php
                            foreach($page_templates as $name => $template){ 
                                //$template = str_replace('.','',$template);
                                //if(array_key_exists('prime_sbm_page_template_'.$template,$prime_sbm_options['sidebars'])){ continue; }
                                echo '<li>' . $name .'<span>type=page_template&name='. urlencode(  $name ) .'&slug='.$template.'&id=null&other=null</span></li>';
                            }; ?>               
                            </ul>
                        </li>
                        <?php
                        }   
                        $taxonomies  = get_taxonomies();
                        if(!empty($taxonomies)){
                            foreach($taxonomies as $taxonomy){ 
                                if($taxonomy == 'nav_menu' OR $taxonomy == 'link_category'){ continue; }
                        
                        $terms = get_terms($taxonomy);
                        if(!empty($terms)){ 
                        ?>
                        <li><a href="#"><?php echo ucwords(str_replace('_',' ',$taxonomy)); ?> <span>[+]</span></a>
                            <ul><?php
                            
                            foreach($terms as $term){                           
                                //if(array_key_exists ('prime_sbm_'.$taxonomy.'_'.$term->term_id,$prime_sbm_options['sidebars'])){ continue; }
                                echo '<li>' . $term->name . '<span>type='. $taxonomy .'&name='. urlencode( $term->name ) .'&slug='.$term->slug.'&id='.$term->term_id.'&other='.$taxonomy.'</span></li>';
                            }?>
                            </ul>
                        </li>
                            <?php
                            }
                        }
                        }
                        ?>
                    
                        <li><a href="#">Template Hierarchy <span>[+]</span></a>
                            <ul>
                                <?php
                                $heirarchy = array( 'Front Page' => 'front_page',
                                                    'Home' => 'home',
                                                    'Posts (single.php)' => 'single',
                                                    'Pages' => 'page',
                                                    'Singular (posts and pages)' => 'singular',
                                                    'All Archives' => 'archive',
                                                    'Category Archive' => 'category',
                                                    'Tag Archive' => 'tag',
                                                    'Taxonomy Archive' => 'tax',
                                                    'Author Archive' => 'author',
                                                    'Date Archive' => 'date',
                                                    'Search Results' => 'search',
                                                    'Paged' => 'paged',
                                                    'Attachment' => 'attach',
                                                    '404' => '404'
                                                    );
                                foreach($heirarchy as $name => $item){
                                //if(array_key_exists ('prime_sbm_hierarchy_' . $item,$prime_sbm_options['sidebars'])){ continue; }
                                    echo '<li>'.$name.'<span>type=hierarchy&name='.$name.'&slug='.$item.'&id=null&other=null&other=null</span></li>';
                                }
                                ?>
                            </ul>
                        </li>
                        <?php
                            /**
                             *  Support for custom post types, if using WordPress 3.0+.
                             */
                            
                            global $wp_version;
                            
                            if ( $wp_version >= '3.0' ) {
                            
                            $_args = array(
                                        'show_ui' => true, 
                                        'public' => true, 
                                        'publicly_queryable' => true, 
                                        '_builtin' => false
                                        );
                            
                            $_post_types = get_post_types( $_args, 'object' );
                            
                            // Set certain post types that aren't allowed to have custom sidebars.
                            
                            $_disallowed_types = array( 'slide' );
                            
                            // Make the array pluggable.
                            
                            $_disallowed_types = apply_filters( 'primeframework_sbm_disallowed_posttypes', $_disallowed_types );
                        
                            if ( count( $_post_types ) ) {
                            
                                foreach ( $_post_types as $k => $v ) {
                                
                                    if ( in_array( $k, $_disallowed_types ) ) {
                                    
                                        unset( $_post_types[$k] );
                                    
                                    } // End IF Statement
                                
                                } // End FOREACH Loop
                            
                            } // End IF Statement
                            
                            if ( count( $_post_types ) ) {
                        ?>
                            <li>
                                <a href="#">Custom Post Type<span>[+]</span></a>
                                <?php
                                    $_html = '';
                                    
                                        $_html .= '<ul>' . "\n";
                                            
                                            foreach ( $_post_types as $k => $v ) {
                                            
                                                $_html .= '<li>' . $v->labels->name . '<span>type=custom_post_type&name=' . urlencode( $v->labels->name ) . '&slug=' . urlencode( $k ) . '&id=' . urlencode( $k ) . '&other=' . urlencode( $k ) . '</span></li>' . "\n";
                                                
                                            } // End FOREACH Loop
                                        
                                        $_html .= '</ul>' . "\n";
                                        
                                        echo $_html;
                                    
                                ?>
                            </li>
                        <?php
                        
                                } // End IF Statement
                            
                            } // End IF Statement
                        ?>
                        </ul>
                    </div><!-- /#prime-sbm-menu -->
                    
                </div><!-- /#sbm-sidebar -->
                
                <div id="sbm-main">
                    
                    <div class="prime-sbm-builder">

                        <span class="prime-sbm-tip" id="prime-sbm-tip-1">Start by selecting a template from the menu on the left for your new sidebar. The new sidebar will be available on the <a href="<?php echo admin_url('widgets.php'); ?>">Widgets</a> page.<?php /*<br /><br /><small>Please note that, if custom sidebars are created for categories, the sidebar of the posts in that category will use the first custom sidebar created for categories assigned to that post (eg: if "Category 1" and "Category 2" are assigned to the post and the "Category 2" custom sidebar is created first, that sidebar will be displayed on the single post template).</small>*/ ?></span>
                        
                        <form action="" id="prime-sbm-get-links">
                            <?php
                                // Add nonce for added security.
                                if ( function_exists( 'wp_nonce_field' ) ) { wp_nonce_field( 'primeframework-sbm-options-update' ); } // End IF Statement
                            ?>
                            <div id="prime-sbm-get-links-inner">
                            <?php //Sidebar Options panel get created here... ?>
                            <div id="prime-sbm-response-builder">
                            <?php //Template Info ?>
                            
                            <div id="prime-sbm-builder-meta">
                                <div id="prime-sbm-builder-meta-top">Template Info</div>
                                <div id="prime-sbm-builder-meta-bottom">
                                    <label><span>Name:</span></label><input type="hidden" name="name" id="template-info-name" value="">
                                    <label><span>Type:</span></label><input type="hidden" name="type" id="template-info-type" value="">
                                    <label><span>Slug:</span></label><input type="hidden" name="name" id="template-info-slug" value="">
                                    <label><span>ID:</span></label><input type="hidden" name="id" id="template-info-id" value="">
                                    <label class="last"><span>URL:</span> <small><a href=""></a></small></label><input type="hidden" name="other" id="template-info-other" value="">
                                </div>
                            </div>
                            <div class="nav-tabs-nav">
                                <div class="nav-tabs-wrapper">
                                    <div class="nav-tabs">
                                        <a id="prime-sbm-tab-new" href="#" class="nav-tab nav-tab-active">Create a new Sidebar</a>
                                        <?php if(!empty($prime_sbm_options['sidebars'])) { ?> 
                                        <a id="prime-sbm-tab-existing" class="nav-tab" href="#">Use Existing Sidebar</a>
                                        <?php } ?>
                                        <a id="prime-sbm-toggle-info" class="fr" href="#">Template Info<img src="<?php bloginfo('template_url'); ?>/functions/images/ico-info.png" /></a>
                                    </div>
                                </div>
                            </div>
                            <div class="builder-header">
                                <label id="prime-sbm-label-sb-name"><span>Sidebar Name</span> <input value="" type="text" name="sidebar-title" id="sidebar-title"/></label>
                            </div>
                            
                            <div id="prime-sbm-builder-body">
                                <div id="prime-sbm-builder-part-assign" class="prime-sbm-builder-part-inner">
                                    <label><span>Sidebar to use</span>
                                    <select name="sidebar_to_sourceback" id="sidebar_to_sourceback">
                                    <?php echo $new_sidebars; ?>
                                    </select>
                                </div>
                                <div id="prime-sbm-builder-part-create" class="prime-sbm-builder-part-inner">
                                    <label><span>Sidebar to replace</span>
                                    <select name="sidebar_replace" id="sidebar_replace">
                                    <?php echo $init_sidebars; ?>
                                    </select></label>
                                </div>
                            
                                    <label id="prime-sbm-label-sb-desc"><span>Sidebar description</span> <textarea id="sidebar-description" name="sidebar-description" style="width:230px"></textarea></label>
                                    <input id="prime-sbm-builder-conditional" type="hidden" name="conditional" value="'" />
                                    <input id="prime-sbm-builder-stage" type="hidden" name="stage" value="2" />
                                    <input id="prime-sbm-builder-source" type="hidden" name="source" value="0" />
                                </div>
                                <div class="prime-sbm-controls">
                                    <input type="submit" value="Add Sidebar" class="button" />
                                </div>
                            </div>
                        </div>
                    </form>                     
                </div><!-- /.prime-sbm-builder -->
                    
                <div id="prime-sbm-sidebars" class="js">
                        
                        <h3>Custom Sidebars <span>Newly created sidebars</span></h3>
                        <?php       
                        //$prime_sbm_options = get_option('sbm_prime_sbm_options');
                        $top_array = array();
                        if(!empty($prime_sbm_options['sidebars'])){
                        ?>
                            <ul class="menu ui-sortable" id="menu-to-edit">
                            <?php
                                foreach($prime_sbm_options['sidebars'] as $sidebar){
                                    $sidebar_name = $sidebar['setup']['name'];
                                    $id = $sidebar['conditionals']['id'];
                                    $sidebar_id = $sidebar['conditionals']['sidebar_id'];
                                    $sidebar_replace = $sidebar['conditionals']['sidebar_replace'];
                                    $sidebar_source = $sidebar['conditionals']['source'];
                                    if(empty($sidebar_source)){
                                        $top_array[$sidebar_id] = array();
                                    } 
                                    if(!empty($sidebar_source)){
                                        $top_array[$sidebar_source][] = $sidebar_id;
                                    } 
                                }       
                                    
                                //print_r($top_array);
                                foreach($top_array as $top_id => $top_sidebar){
                                    
                                    $sidebar_id = $top_id;
                                    $sidebar_name = $prime_sbm_options['sidebars'][$sidebar_id]['setup']['name'];
                                    
                                    $sidebar_id = $prime_sbm_options['sidebars'][$sidebar_id]['conditionals']['sidebar_id'];
                                    $sidebar_desc = $prime_sbm_options['sidebars'][$sidebar_id]['setup']['description'];
                                    $sidebar_replace = $prime_sbm_options['sidebars'][$sidebar_id]['conditionals']['sidebar_replace'];
                                    $sidebar_replace_nice = $wp_registered_sidebars[$sidebar_replace]['name'];
                                    ?>
                                    <li class="menu-item menu-item-depth-0 menu-item-edit-inactive" id="<?php echo $sidebar_id ?>">
                                        <form>
                                        <dl class="menu-item-bar">
                                            <dt class="menu-item-handle">
                                                <span class="item-title"><?php echo $sidebar_name; ?></span>
                                                <span class="item-controls">
                                                    <span class="item-type"><?php echo $sidebar_replace_nice; ?></span>
                                                    <a class="item-edit" title="Edit" href="#">Edit</a>
                                                </span>
                                            </dt>
                                        </dl>
                                        <div class="menu-item-settings" style="display: none;">
                                    
                                        <p class="description description-thin">
                                            <label>Sidebar Name<br />
                                                <input type="text" class="widefat edit-menu-item-title" name="sidebar_name" value="<?php echo $sidebar_name; ?>">
                                            </label>
                                        </p>
                                    
                                        <p class="description description-thin">
                                            <label>Sidebar to replace<br />
                                                <select class="widefat sidebar-to-replace" name="sidebar_replace">
                                                    <?php echo $init_sidebars; ?>
                                                </select>
                                            </label>
                                        </p>
                                        
                                        <p class="field-description description description-wide">
                                            <label>Description<br />
                                                <textarea class="widefat" rows="3" cols="20" name="sidebar_description"><?php echo $sidebar_desc; ?></textarea>
                                            </label>
                                        </p>
                                        <input type="hidden" name="sidebar_id" value="<?php echo $sidebar_id ?>" />
                                        <div class="menu-item-actions description-wide submitbox">
                                            <a class="item-delete submitdelete deletion" onclick="return confirm('Are you sure you want to delete this sidebar?');" href="#">Remove This & All Dependents</a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" href="#">Cancel</a> <span class="meta-sep"> | </span> <a class="item-save submitsave" href="#">Save</a>
                                        </div>
                                    </div>
                                    <ul class="menu-item-transport"></ul>
                                    <script type="text/javascript">
                                        jQuery(document).ready(function(){
                                            jQuery('#<?php echo $sidebar_id ?>').find('.sidebar-to-replace option').each(function(){
                                                if(jQuery(this).val() == '<?php echo $sidebar_replace; ?>'){
                                                    jQuery(this).attr('selected','selected');
                                                }
                                            })
                                        })
                                    </script>
                                </form>
                            </li>
                                
                                <?php
                                if(!empty($top_sidebar)){
                                    foreach($top_sidebar as $piggies){
                                        $sidebar_id = $piggies;
                                        $sidebar_name = $prime_sbm_options['sidebars'][$sidebar_id]['setup']['name'];
                                        $sidebar_id = $prime_sbm_options['sidebars'][$sidebar_id]['conditionals']['sidebar_id'];
                                        //$sidebar_nice = $wp_registered_sidebars[$sidebar_id]['name'];

                                        ?>  
                                        <li class="menu-item menu-item-depth-1" id="<?php echo $sidebar_id ?>">
                                            <form>
                                                <dl class="menu-item-bar">
                                                    <dt class="menu-item-handle">
                                                        <span class="item-title"><?php echo $sidebar_name; ?></span>
                                                        <span class="item-controls">
                                                            <span class="item-type"></span>
                                                            <a class="item-edit" title="Edit" href="#">Edit</a>
                                                        </span>
                                                    </dt>
                                                </dl>
                                            
                                                <div class="menu-item-settings" style="display: none;">
                                                    
                                                    <p class="description description-thin">
                                                    <?php /*
                                                        <label>Sidebar to replace<br />
                                                            <select class="widefat" name="sidebar_replace">
                                                                <?php echo $init_sidebars; ?>
                                                            </select> 
                                                        </label>
                                                        */ ?>
                                                    </p>
                                                    
                                                
                                                    <input type="hidden" name="sidebar_id" value="<?php echo $sidebar_id ?>" />
                                                    <div class="menu-item-actions description-wide submitbox">
                                                        <a class="item-delete submitdelete deletion" onclick="return confirm('Are you sure you want to delete this sidebar?');" href="#">Delete</a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" href="#">Cancel</a> <span class="meta-sep">
                                                    </div>
                                                </div><!-- .menu-item-settings-->
                                                <ul class="menu-item-transport"></ul>
                                            </form>
                                        </li>
                                        <?php
                                    }
                                }   
                            }
                        ?>
                    </ul>
                    <?php
                    } else { ?>
                    <h5><em>No sidebars added yet.</em></h5>
                    <?php
                    }
                    ?>
                    </div><!-- /#prime-sbm-sidebars -->
                    
                </div><!-- /#sbm-main -->
            
         </div>
         <div class="clear"></div>
         </div>
         <div class="save_bar_top">
         <img style="display:none" src="<?php echo bloginfo('template_url'); ?>/functions/images/loading-bottom.gif" class="ajax-loading-img ajax-loading-img-bottom" alt="Working..." />
         <form action="<?php echo wp_specialchars( $_SERVER['REQUEST_URI'] ) ?>" method="post" style="display:inline" id="primeform-reset">
            <span class="submit-footer-reset">
            <input name="reset" type="submit" value="Reset Sidebar Manager" class="button submit-button reset-button" onclick="return confirm('Click OK to reset. Any Sidebar Manager settings will be lost!');" />
            <input type="hidden" name="prime_save" value="sbm_reset" /> 
            </span>
        </form>
    </div>    
    <div style="clear:both;"></div>    
    <pre style="display:none">
    <?php // print_r($prime_sbm_options); ?>
    </pre> 
    </div><!--wrap-->

<?php } 
/**
 * Ajax Save Action - prime_ajax_callback
 */

add_action('wp_ajax_prime_sbm_post_action', 'prime_sbm_callback');

function prime_sbm_callback() {
    global $wpdb, $wp_registered_sidebars; // this is how you get access to the database
        
    $save_type = $_POST['type'];
    
    // Sanitise posted value.
    $save_type = strtolower( trim( strip_tags( $save_type ) ) );
    
    $prime_sbm_options = get_option('sbm_prime_sbm_options');

    if($save_type == 'prime_sbm_get_links'){
    
        $data = $_POST['data'];
        
        parse_str($data,$data_array);
        
        $type = $data_array['type'];
        $slug = $data_array['slug'];
        $name = $data_array['name'];
        $id = $data_array['id'];
        $id = intval($id);
        $other = $data_array['other'];

        $output = '';
        
        if($type == 'page'){
            $url = get_page_link( $id );
            $conditional = 'page';
            $type = 'Page';
        }
        elseif($type == 'page_template'){
            $url = '';
            $name = $name;
            $id = $slug;
            $conditional = 'page_template';
            $type = 'Page Template';
        }
        elseif($type == 'category'){
            $url = get_term_link( $id, 'category');
            $name = $name;
            $conditional = $other;
            $type = 'Category';
        }
        elseif($type == 'post_tag'){
            // $url = get_term_link( $name, $other ); // Replaced by line below. - 2010-11-28.
            $url = get_term_link( $slug, $other ); // Use the slug to get the term link, not the name.
            $name = $name;
            $conditional = $other;
            $type = 'Tag';
        }
        elseif ( $type == 'hierarchy'){
            $url = '';
            $name = $name;
            $id = $slug;
            $conditional = 'hierarchy';
            $type = 'Template Hierarchy';
        }
        elseif ( $type == 'custom_post_type'){
            $url = '';
            $name = $name;
            $id = $slug;
            $conditional = 'custom_post_type';
            $type = 'Custom Post Type';
        }
        
        echo "$type|$name|$slug|$id|$url|$conditional";
    
    }
    
    if($save_type == 'prime_sbm_add_sidebar'){
        
        $data = $_POST['data'];
        
        parse_str($data,$data_array);
        
        $type = $data_array['type'];
        $slug = $data_array['slug'];
        $name = $data_array['name'];
        $id = $data_array['id'];
        $conditional = $data_array['conditional'];
        $other = $data_array['other'];
        $sidebar_replace = $data_array['sidebar_replace'];
        $sidebar_title = $data_array['sidebar-title'];
        $sidebar_description = $data_array['sidebar-description'];
        $sidebar_sourceback = $data_array['sidebar_to_sourceback'];
        $stage = $data_array['stage'];
        $source = $data_array['source'];
    
        if(empty($prime_sbm_options)){ $prime_sbm_options = array(); }
        
        $new_id = "prime_sbm_" . $conditional . "_" . str_replace('.','',$id) . "_" . $sidebar_replace;
        
        if($source == true){
        
            $sidebar_sourceback = $sidebar_sourceback;
            
        } else {
        
            $sidebar_sourceback = false;
        }
        
        // Get the data for the sidebar we're looking to replace.
        // This will be used in the before_title, after_title, etc.
        
        $index = $sidebar_replace;
        
        if ( is_int($index) ) {
            $index = "sidebar-$index";
        } else {
            $index = sanitize_title($index);
            foreach ( (array) $wp_registered_sidebars as $key => $value ) {
                if ( sanitize_title($value['name']) == $index ) {
                    $index = $key;
                    break;
                }
            }
        }
        
        $sidebar_data = $wp_registered_sidebars[$index];
        
        $prime_sbm_new_set = array( "setup"         => array(   'name' => $sidebar_title,
                                                            'id' => $new_id,
                                                            'description' => $sidebar_description, 
                                                            'before_widget' => $sidebar_data['before_widget'],
                                                            'after_widget' => $sidebar_data['after_widget'],
                                                            'before_title' => $sidebar_data['before_title'],
                                                            'after_title' => $sidebar_data['after_title']
                                                    ),
                                "conditionals"  => array(   'name' => $sidebar_title,
                                                            'type' => $type,
                                                            'id' => $id,
                                                            'conditional' => $conditional,
                                                            'sidebar_id' => $new_id,
                                                            'other' => $other,
                                                            'sidebar_replace' => $sidebar_replace,
                                                            'source' => $sidebar_sourceback
                                                    )
                                );
                                
        $prime_sbm_options['sidebars'][$new_id] = $prime_sbm_new_set;
        
        update_option('sbm_prime_sbm_options',$prime_sbm_options);
        
        if(!empty($sidebar_sourceback)){
            $source = '1';
        } else { $source = '0';}
        
        echo "$type|$name|$slug|$id|$other|$conditional|$stage|$sidebar_title|$new_id|$source";
    }
    
    if($save_type == 'prime_sbm_delete-sidebar'){
        $id = $_POST['data'];
        $ids = array();
        $prime_sbm_options_temp = $prime_sbm_options;
        if(!empty($prime_sbm_options['sidebars'])){
            $pos = '';
            foreach($prime_sbm_options['sidebars'] as $top_id => $sidebar){
                $sidebar_source = $sidebar['conditionals']['source'];

                if($id == $top_id OR $id == $sidebar_source){
                    unset($prime_sbm_options_temp['sidebars'][$top_id]);
                    $ids[] = $top_id;
                }

                if($id == $top_id){ $pos = $id; }
            }
        }
        update_option('sbm_prime_sbm_options',$prime_sbm_options_temp);
        if(is_array($ids)){
            $id = implode(',#',$ids);
        }
        echo "#$id|$pos";
    }
    
    if($save_type == 'prime_sbm_save-sidebar'){
    
        $data = $_POST['data'];
        
        parse_str($data,$data_array);
        
        $id = $data_array['sidebar_id'];
        $sidebar_replace = $data_array['sidebar_replace'];
        $name = $data_array['sidebar_name'];
        $desc = $data_array['sidebar_description'];
    
        
        $prime_sbm_options['sidebars'][$id]['conditionals']['sidebar_replace'] = $sidebar_replace;
        $prime_sbm_options['sidebars'][$id]['setup']['name'] = $name;
        $prime_sbm_options['sidebars'][$id]['conditionals']['name'] = $name;
        $prime_sbm_options['sidebars'][$id]['setup']['description'] = $desc;
        
        $sidebar_replace_nice = $wp_registered_sidebars[$sidebar_replace]['name'];
        echo "$name|$sidebar_replace_nice";

        update_option('sbm_prime_sbm_options',$prime_sbm_options);
                
    }
    
    if($save_type == 'prime_sbm_dismiss_intro'){
        
        //$data = $_POST['data'];
        $temp_options = get_option('sbm_prime_sbm_options');
        $temp_options['settings']['infobox'] = 'hide';
        
        update_option('sbm_prime_sbm_options',$temp_options);

        
    }
  die();

}



?>