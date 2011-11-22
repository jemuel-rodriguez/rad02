<?php get_header(); ?>
       
    <!-- Content Starts -->
    <div id="content" class="white">

        <div id="main-full">
        
        <?php if (have_posts()) : $count = 0; ?>
        <?php while (have_posts()) : the_post(); $count++; ?>
                                                                    
            <!-- Post Starts -->
            <div class="post wrap">

                <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                
                <?php the_content(); ?>

            </div>
            <!-- Post Ends -->
                                                
        <?php endwhile; else: ?>
            <p><?php _e('Sorry, no posts matched your criteria.',primethemes); ?></p>
        <?php endif; ?>  
    
            <div class="more_entries wrap">
                <?php if (function_exists('wp_pagenavi')) { ?><?php wp_pagenavi(); ?><?php } ?>
            </div>
            
        </div><!-- main-full ends -->

    </div><!-- Content Ends -->
    <div id="content-bot-white"></div>
		
<?php get_footer(); ?>