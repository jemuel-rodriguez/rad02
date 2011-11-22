	<!-- start Widget slider -->
    <div id="loopedSlider">
        <div id="slider-top"></div>
        <div id="slider-block">
            <?php if (is_sidebar_active(4)) { ?>
            <ul class="nav-buttons">
                    <li id="p"><a href="#" class="previous"><img src="<?php bloginfo('template_directory'); ?>/images/btn-prev.png" alt="&lt;" /></a></li>
                    <li id="n"><a href="#" class="next"><img src="<?php bloginfo('template_directory'); ?>/images/btn-next.png" alt="&gt;" /></a></li>
            </ul>
            <?php } ?>
            <div class="container">

                    <?php if (is_sidebar_active(1) || is_sidebar_active(2) || is_sidebar_active(3)){ ?>
                    <div id="slide-1" class="slide">
                    	<ul class="widget"><li><?php prime_sidebar(1); ?></li></ul>
                    	<ul class="widget"><li><?php prime_sidebar(2); ?></li></ul>
                    	<ul class="widget last"><li><?php prime_sidebar(3); ?></li></ul>
                    </div>
                    <?php } else { ?>
                    <p><?php _e('This area is controlled in your WP admin under <strong>Apperance > Widgets</strong>. You need to',primethemes); ?> <a href="<?php bloginfo('template_directory'); ?>/images/help-widgets.png" ><?php _e('add your desired widgets',primethemes); ?></a> <?php _e('to one of the 9 widget areas (Footer1-9)',primethemes); ?>.
                    <?php } ?>
                    <?php if (is_sidebar_active(4) || is_sidebar_active(5) || is_sidebar_active(6)){ ?>
                    <div id="slide-2" class="slide">
                    	<ul class="widget"><li><?php prime_sidebar(4); ?></li></ul>
                    	<ul class="widget"><li><?php prime_sidebar(5); ?></li></ul>
                    	<ul class="widget last"><li><?php prime_sidebar(6); ?></li></ul>
                    </div>
                    <?php  } ?>
                    <?php  if (is_sidebar_active(7) || is_sidebar_active(8) || is_sidebar_active(9)){ ?>
                    <div id="slide-3" class="slide">
                    	<ul class="widget"><li><?php prime_sidebar(7); ?></li></ul>
                    	<ul class="widget"><li><?php prime_sidebar(8); ?></li></ul>
                    	<ul class="widget last"><li><?php prime_sidebar(9); ?></li></ul>
                    </div>
                    <?php  } ?>
                    
            </div>
        </div>
        <div id="slider-bot"></div>
    </div>    
    <!-- end Widget slider -->

	<!-- footer Starts -->
	<div id="footer" class="wrap">
		<div class="col-left">
			<p>&copy; <?php echo date('Y'); ?> <?php bloginfo(); ?>. <?php _e('All Rights Reserved',primethemes); ?>.</p>
		</div>
		<div class="col-right">
			<p><?php _e('Delicious font by',primethemes); ?> <a href="http://www.josbuivenga.demon.nl/delicious.html">exljbris</a>. <?php _e('Powered by',primethemes); ?> <a href="http://www.wordpress.org">WordPress</a>. <?php _e('Designed by',primethemes); ?> <a href="http://www.primethemes.com"><img src="<?php bloginfo('template_directory'); ?>/images/primethemes.png" width="88" height="25" alt="prime Themes" /></a></p>
		</div>
	</div>
	<!-- footer Ends -->
	
</div>
<?php wp_footer(); ?>
<script type="text/javascript"> Cufon.now(); </script>

</body>
</html>