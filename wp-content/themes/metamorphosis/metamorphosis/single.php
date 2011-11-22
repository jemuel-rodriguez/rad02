<?php get_header(); ?>
       
    <!-- Content Starts -->
    <div id="content" class="wrap">

		<?php if (have_posts()) : $count = 0; ?>
        <?php while (have_posts()) : the_post(); $count++; ?>

		<div class="col-left">            
			<div id="featured">
                <!-- Post Starts -->
                <div class="post wrap">

                    <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                    <p class="post-details"><?php _e('Posted on',primethemes); ?> <?php the_time('d. M, Y'); ?> <?php _e('by',primethemes); ?> <?php the_author_posts_link(); ?> <?php _e('in',primethemes); ?> <?php the_category(', ') ?></p>
                    
                    <?php the_content(); ?>
					<?php the_tags('<p class="tags">Tags: ', ', ', '</p>'); ?>

                </div>
                <!-- Post Ends -->
            </div><!-- featured ends -->
        </div><!-- .col-left ends -->
        
		<div class="col-right">
			<div id="main">
            
                <div id="comments">
                    <?php comments_template(); ?>
                </div>
               
            </div><!-- main ends -->
        </div><!-- .col-right ends -->  
        
		<?php endwhile; else: ?>
            <p><?php _e('Sorry, no posts matched your criteria.',primethemes); ?></p>
        <?php endif; ?>  
              

    </div><!-- Content Ends -->
    <div id="content-bot"></div>
		
<?php get_footer(); ?>