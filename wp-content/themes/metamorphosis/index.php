<?php get_header(); ?>
      
    <!-- Content Starts -->
    <div id="content" class="wrap">

		<div class="col-left">
			<div id="featured">
			<?php $saved = $wp_query; query_posts('tag=featured&showposts='.get_option('prime_featured_posts')); ?>
            <?php if (have_posts()) : $count = 0; ?>
            <?php while (have_posts()) : the_post(); $count++; ?>
                                                                        
				<?php if ($count > 1) : $count2++; ?>
				            
                <?php if ($count == 2) echo '<h3 class="info">'.__('More Featured Stories',primethemes).'</h3>'; ?>

                <!-- 2-col post Starts -->
                <div class="post block <?php if ($count2 == 2) { echo 'last'; $count2=0; } ?>">
                    <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                    
                    <?php prime_get_image('image','200','90','thumbnail'); ?>
                    <?php the_excerpt(); ?>

                </div>
                
                <?php if ($count2 == 0) echo '<div class="fix"></div>'; ?>

                <?php else : ?>

                <!-- Top featured post Starts -->
                <div class="post">

                    <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                    <p class="post-details"><?php _e('Posted by',primethemes); ?>  <?php the_author_posts_link(); ?> <?php _e('in',primethemes); ?> <?php the_category(', ') ?> <?php _e('on',primethemes); ?> <?php the_time('d. M, Y'); ?> | <?php comments_popup_link(__('0 Comments',primethemes), __('1 Comment',primethemes), __('% Comments',primethemes)); ?></p>
                    
                    <?php prime_get_image('image','430','190','thumbnail'); ?>
                    <?php the_excerpt(); ?>

                </div>
                <!-- Post Ends -->
                
                <?php endif; ?>
                                                    
			<?php endwhile; else: ?>
                <p><?php _e('This is the <strong>featured posts area</strong> where you can add posts by',primethemes); ?> <a href="<?php bloginfo('template_directory'); ?>/images/help-tag.png" ><?php _e('adding a tag named "featured"',primethemes); ?></a>.</p>
            <?php endif; $wp_query = $saved; ?>  
        
            </div><!-- featured ends -->
        </div><!-- .col-left ends -->
        
		<div class="col-right">
			<div id="main">
            
			<h3 class="info"><?php _e('Recently Added',primethemes); ?></h3>                                                                        
			<?php
            global $wpdb; 
            $tag = $wpdb->get_var("SELECT term_ID FROM $wpdb->terms WHERE name='featured'");			
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $args=array(
               'tag__not_in' => array($tag,),
               'paged'=>$paged,
               );
            query_posts($args);
            ?>
            
            <?php if (have_posts()) : $count = 0; ?>
            <?php while (have_posts()) : the_post(); $count++; ?>

                <!-- Post Starts -->
                <div class="post wrap">

                    <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                    <p class="post-details"><?php _e('Posted by',primethemes); ?>  <?php the_author_posts_link(); ?> <?php _e('in',primethemes); ?> <?php the_category(', ') ?> <?php _e('on',primethemes); ?> <?php the_time('d. M, Y'); ?> | <?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></p>
                    
                    <?php prime_get_image('image','110','110','thumbnail-left'); ?>
                    <?php the_excerpt(); ?>

                </div>
                <div class="fix"></div>
                <!-- Post Ends -->
                                                    
			<?php endwhile; else: ?>
                <p><?php _e('Sorry, no posts matched your criteria.',primethemes); ?></p>
            <?php endif; ?>  
        
                <div class="more_entries wrap">
                    <?php if (function_exists('wp_pagenavi')) wp_pagenavi(); else { ?>
                    <div class="fl"><?php previous_posts_link(__('&laquo; Newer Entries ',primethemes)); ?></div>
                    <div class="fr"><?php next_posts_link(__(' Older Entries &raquo;',primethemes)); ?></div>
                    <br class="fix" />
                    <?php } ?>
                </div>
                
            </div><!-- main ends -->
        </div><!-- .col-right ends -->        

    </div><!-- Content Ends -->
    <div id="content-bot"></div>
		
<?php get_footer(); ?>