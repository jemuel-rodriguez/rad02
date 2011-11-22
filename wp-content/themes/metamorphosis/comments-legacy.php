<?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if (!empty($post->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
			?>

			<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.',primethemes); ?></p>

			<?php
			return;
		}
	}

	/* This variable is for alternating comment background */
	$oddcomment = 'alt';
?>

<?php
	global $bm_comments;
	global $bm_trackbacks;
	
	split_comments( $comments );
?>

<!-- You can start editing here. -->

<?php if ($comments) : ?>

	
	<?php
		$trackbackcounter = count( $bm_trackbacks );
		$commentcounter = count( $bm_comments );
	?>

	<h2 class="commh2"><?php echo $commentcounter; ?> <?php _e('Comments For This Post',primethemes); ?></h2>

	<ol class="commentlist">

	<?php foreach ($bm_comments as $comment) : ?>
    
		<li class="comment" id="comment-<?php comment_ID() ?>">	

         <?php
         	// Determine which gravatar to use for the user
         	$email =  $comment->comment_author_email;
            $grav_url = "http://www.gravatar.com/avatar.php?gravatar_id=".md5($email). "&default=".urlencode($GLOBALS['defaultgravatar'])."&size=48";
            $usegravatar = get_option('prime_gravatar');
         ?>

			<span class="gravatar"><img src="<?php echo $grav_url; ?>" width="48" height="48" alt="" /></span>

            <div class="content">
                <cite><?php comment_author_link() ?></cite> <?php _e('Says:',primethemes); ?>
                <?php if ($comment->comment_approved == '0') : ?>
                <em><?php _e('Your comment is awaiting moderation.',primethemes); ?></em>
                <?php endif; ?>
                <br />
    
                <span class="commentmetadata"><a href="#comment-<?php comment_ID() ?>" title=""><?php comment_date('F jS, Y') ?> <?php _e('at',primethemes); ?> <?php comment_time() ?></a> <?php edit_comment_link('e','',''); ?></span>
    
                <?php comment_text() ?>
             </div>

		</li>

	<?php /* Changes every other comment to a different class */
		if ('alt' == $oddcomment) $oddcomment = '';
		else $oddcomment = 'alt';
	?>

	<?php endforeach; /* end for each comment */ ?>

	</ol>

	<?php if ( count( $bm_trackbacks ) > 0 ) { ?>

	<h2 class="commh2"><?php echo $trackbackcounter; ?> <?php _e('Trackbacks For This Post',primethemes); ?></h2>

	<ol class="commentlist">

	<?php foreach ($bm_trackbacks as $comment) : ?>

		<li class="<?php echo $oddcomment; ?> <?php if(function_exists("author_highlight")) author_highlight(); ?>" id="comment-<?php comment_ID() ?>">

			<cite><?php comment_author_link() ?></cite> Says:
			<?php if ($comment->comment_approved == '0') : ?>
			<em><?php _e('Your comment is awaiting moderation.',primethemes); ?></em>
			<?php endif; ?>
			<br />

			<small class="commentmetadata"><a href="#comment-<?php comment_ID() ?>" title=""><?php comment_date('F jS, Y') ?> at <?php comment_time() ?></a> <?php edit_comment_link('e','',''); ?></small>

			<?php comment_text() ?>

		</li>

	<?php /* Changes every other comment to a different class */
		if ('alt' == $oddcomment) $oddcomment = '';
		else $oddcomment = 'alt';
	?>

	<?php endforeach; /* end for each comment */ ?>

	</ol>

	<?php } ?>

 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ('open' == $post->comment_status) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments"><?php _e('Comments are closed.',primethemes); ?></p>

	<?php endif; ?>
<?php endif; ?>


<?php if ('open' == $post->comment_status) : ?>
<div id="respond">

<h2 class="commh2"><?php _e('Leave a Reply',primethemes); ?></h2>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p class="alert"><?php _e('You must be',primethemes); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>"><?php _e('logged in',primethemes); ?></a> <?php _e('to post a comment.',primethemes); ?></p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>

<p><?php _e('Logged in as',primethemes); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account"><?php _e('Logout &raquo;',primethemes); ?></a></p>

<?php else : ?>

<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
<label for="author"><small><?php _e('Name',primethemes); ?> <?php if ($req) echo  __('(required)',primethemes); ?></small></label></p>

<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
<label for="email"><small><?php _e('Mail (will not be published)',primethemes); ?> <?php if ($req) echo __('(required)',primethemes); ?></small></label></p>

<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
<label for="url"><small><?php _e('Website',primethemes); ?></small></label></p>

<?php endif; ?>

<!--<p><small><strong>XHTML:</strong> You can use these tags: <?php echo allowed_tags(); ?></small></p>-->

<p><textarea name="comment" id="comment" style="width:97%;" rows="10" tabindex="4"></textarea></p>

<p><input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Submit Comment',primethemes); ?>" />
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
</p>

</form>

<?php endif; // If registration required and not logged in ?>

</div>
<?php endif; // if you delete this the sky will fall on your head ?>
