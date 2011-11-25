<?php

/*

TABLE OF CONTENTS

- primethemes_more_themes_page

*/

function primethemes_more_themes_page(){
        ?>
        <div class="wrap themes-page">
        <h2>More primeThemes</h2>
        
		<?php // Get RSS Feed(s)
        include_once(ABSPATH . WPINC . '/feed.php');
        $rss = fetch_feed('http://www.primethemes.com/?feed=more_themes');			
        // Of the RSS is failed somehow.
        if ( is_wp_error($rss) ) {
                        
            $error = $rss->get_error_code();
                            
            if($error == 'simplepie-error') {
            
                //Simplepie Error
                echo "<div class='updated fade'><p>An error has occured with the RSS feed. (<code>". $error ."</code>)</p></div>";
                
            }
            
            return;
        
         } 
        ?>
        <div class="info">
        <a href="http://www.primethemes.com/pricing/">Join the primeThemes Club</a>
        <a href="http://www.primethemes.com/themes">Online Themes Gallery</a>
        <a href="http://showcase.primethemes.com/">Theme Showcase</a>
        </div>
        
        <?php
        
        $maxitems = $rss->get_item_quantity(30); 
        $items = $rss->get_items(0, 30);
        
        ?>
        <ul class="themes">
        <?php if (empty($items)) echo '<li>No items</li>';
        else
        foreach ( $items as $item ) : ?>
            <li class="theme">
                <?php echo $item->get_description();?>
            </li>
        <?php 
        endforeach; ?>
        </ul>
        
        </div>
        
        <?php
        
        };
?>