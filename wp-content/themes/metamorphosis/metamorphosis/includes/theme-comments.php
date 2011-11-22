<?php
// Fist full of comments
function custom_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
                 
<?php // if (get_comment_type() == "comment"){ // If you wanted to separate comments from pingbacks ?>
<li class="comment wrap" id="comment-<?php comment_ID() ?>">

    <div class="comment wrap"  id="comment-<?php comment_ID() ?>">
        <div class="col-left">
            <?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
            <p><?php comment_author_link() ?><br /></p>
            <p><?php comment_date('M jS, Y'); ?><br /></p>
        </div>
        <div class="col-right">
            <?php comment_text() ?>
            <?php if ($comment->comment_approved == '0') : ?>
            <p><em><?php _e('Your comment is awaiting moderation.<',primethemes); ?>/em></p>
            <?php endif; ?>
            
        </div>
     	<?php echo comment_reply_link(array('before' => '<div class="reply">', 'after' => '</div>', 'reply_text' => 'Reply to this comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ));  ?>
        
    </div>

	<div class="fix"></div>
<?php  /*  The following are the pingback template. Will cause styling issues with odd and even styling due to threading.
        }  else {
               ?>
               <li <?php comment_class(); ?>>
                       
                    <div class="comment_head cl">
                        
                        <div class="user_meta" style="margin:0">
                            <p class="name"><strong><?php the_commenter_link() ?></strong></p>
                        </div>
                    </div>
                    <div class="comment_entry">
                        <?php comment_text() ?><?php edit_comment_link('Edit', ' <span class="edit-link">(', ')</span>');?>
                    </div>

                    <?php }*/ 
}

function the_commenter_link() {
    $commenter = get_comment_author_link();
    if ( ereg( ']* class=[^>]+>', $commenter ) ) {$commenter = ereg_replace( '(]* class=[\'"]?)', '\\1url ' , $commenter );
    } else { $commenter = ereg_replace( '(<a )/', '\\1class="url "' , $commenter );}
    echo $commenter ;
}

function the_commenter_avatar() {
    $email = get_comment_author_email();
    $avatar = str_replace( "class='avatar", "class='photo avatar", get_avatar( "$email", "32" ) );
    echo $avatar;
}

?>