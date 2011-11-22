<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">

    <title><?php prime_title(); ?></title>
	<?php prime_meta(); ?>
    
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="screen" />
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php if ( get_option('prime_feedburner_url') <> "" ) { echo get_option('prime_feedburner_url'); } else { echo get_bloginfo_rss('rss2_url'); } ?>" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<!-- IE7 emulation on IE8 for footer widgets to work properly -->
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
       
    <!--[if IE 6]>
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/includes/js/pngfix.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/includes/js/menu.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/ie6.css" media="screen" />
    <![endif]-->

    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/includes/js/cufon-yui.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/includes/js/Delicious.font.js"></script>
	<script type="text/javascript">
    	Cufon.replace('h2');
    	Cufon.replace('h3');
    </script>
    
    
       
    <?php if ( is_single() ) wp_enqueue_script( 'comment-reply' ); ?>
    <?php wp_head(); ?>
</head>

<body <?php body_class('custom'); ?>>

<div id="wrap">
    <div id="top">
		<?php
		if ( function_exists('has_nav_menu') && has_nav_menu('primary-menu') ) {
			wp_nav_menu( array( 'depth' => 1, 'sort_column' => 'menu_order', 'container' => 'ul', 'link_before' => '<span class="left"></span>', 'link_after' => '<span class="right"></span>', 'menu_id' => 'pagenav', 'theme_location' => 'primary-menu' ) );
		} else { 
		?>
        <!-- PAGE NAVIGATION -->
        <ul id="pagenav">
        	<?php
			if ( get_option('prime_custom_nav_menu') == 'true' ) {
        		if ( function_exists('prime_custom_navigation_output') )
					prime_custom_navigation_output('name=prime Menu 1&depth=1');

			} else { ?>
            <li class="<?php if ( is_home() ) { echo 'current_page_item'; } ?>"><a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"><span class="left"></span><?php _e('Home',primethemes); ?><span class="right"></span></a></li>            
            <?php wp_list_pages('sort_column=menu_order&depth=1&title_li=&link_before=<span class="left"></span>&link_after=<span class="right"></span>&exclude=' . get_option('prime_exclude_pages') ); ?>        
       		<?php } ?>
        </ul>
        <!-- Page Nav Ends -->
        <?php } ?>
        <!-- HEADER -->
        <div id="header">
            <a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('description'); ?>"><img class="title" src="<?php if ( get_option('prime_logo') <> "" ) { echo get_option('prime_logo'); } else { bloginfo('template_directory'); ?>/images/logo.png<?php } ?>" alt="<?php bloginfo('name'); ?>" /></a>
            <h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>

        </div>
        <!-- end #header -->        

        <!-- MAIN MENU -->
		<div id="menu">
        	<?php
			if ( function_exists('has_nav_menu') && has_nav_menu('secondary-menu') ) {
				wp_nav_menu( array( 'depth' => 5, 'sort_column' => 'menu_order', 'container' => 'ul', 'menu_id' => 'catnav', 'theme_location' => 'secondary-menu' ) );
			} else {
			?>
			<ul id="catnav">
        	<?php
			if ( get_option('prime_custom_nav_menu') == 'true' ) {
        		if ( function_exists('prime_custom_navigation_output') )
					prime_custom_navigation_output('name=prime Menu 2&depth=3');

			} else { ?>
				<?php wp_list_categories('sort_column=menu_order&depth=3&title_li=&exclude=' . get_option('prime_exclude_cats') ); ?>
            <?php } ?>
            </ul>
            <?php } ?>
             <!-- SEARCH -->  
             <form method="get" id="searchform" action="<?php bloginfo('home'); ?>/">                
                <div id="search">
                    <input type="text" value="search" onfocus="if (this.value == '<?php _e('search',primethemes); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('search',primethemes); ?>';}" name="s" id="s" />
                    <input name="" type="hidden" value="<?php _e('Go',primethemes); ?>" class="btn"  />
                </div>                                                
            </form>
            <!-- end search -->  

        </div>
        <!-- end #menu -->        
                
    </div>
    <!-- end #top -->
