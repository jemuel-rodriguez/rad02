<?php get_header(); ?>
       
    <!-- Content Starts -->
    <div id="content" class="white">

        <div id="main-full">
        
        <?php if (have_posts()) : $count = 0; ?>
        <?php while (have_posts()) : the_post(); $count++; ?>
                                                                    
            <!-- Post Starts -->
            <div class="post wrap">

				<?php prime_get_image('image','150','100','thumbnail fr'); ?>
                <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                <p class="post-details"><?php _e('Posted by',primethemes); ?>  <?php the_author_posts_link(); ?> <?php _e('in',primethemes); ?> <?php the_category(', ') ?> <?php _e('on',primethemes); ?> <?php the_time('d. M, Y'); ?> | <?php comments_popup_link(__('0 Comments',primethemes), __('1 Comment',primethemes), __('% Comments',primethemes)); ?></p>
                
                <?php the_excerpt(); ?>

            </div>
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
            
        </div><!-- main-full ends -->

    </div><!-- Content Ends -->
    <div id="content-bot-white"></div>
		
<?php get_footer(); ?>