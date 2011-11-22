<?php 
// Get the path to the root.
$full_path = __FILE__;

$path_bits = explode( 'wp-content', $full_path );

$url = $path_bits[0];

// Require WordPress bootstrap.
require_once( $url . '/wp-load.php' );
                                   
$prime_framework_version = get_option('prime_framework_version');

$MIN_VERSION = '2.9';

$meetsMinVersion = version_compare($prime_framework_version, $MIN_VERSION) >= 0;

$prime_framework_path = dirname(__FILE__) .  '/../../';

$prime_framework_url = get_template_directory_uri() . '/functions/';

$prime_shortcode_css = $prime_framework_path . 'css/shortcodes.css';
                                  
$isprimeTheme = file_exists($prime_shortcode_css);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
</head>
<body>
<div id="prime-dialog">

<?php if ( $meetsMinVersion && $isprimeTheme ) { ?>

<div id="prime-options-buttons" class="clear">
	<div class="alignleft">
	
	    <input type="button" id="prime-btn-cancel" class="button" name="cancel" value="Cancel" accesskey="C" />
	    
	</div>
	<div class="alignright">
	
	    <input type="button" id="prime-btn-preview" class="button" name="preview" value="Preview" accesskey="P" />
	    <input type="button" id="prime-btn-insert" class="button-primary" name="insert" value="Insert" accesskey="I" />
	    
	</div>
	<div class="clear"></div><!--/.clear-->
</div><!--/#prime-options-buttons .clear-->

<div id="prime-options" class="alignleft">
    <h3><?php echo __( 'Customize the Shortcode', 'primethemes' ); ?></h3>
    
	<table id="prime-options-table">
	</table>

</div>

<div id="prime-preview" class="alignleft">

    <h3><?php echo __( 'Preview', 'primethemes' ); ?></h3>

    <iframe id="prime-preview-iframe" frameborder="0" style="width:100%;height:250px" scrolling="no"></iframe>   
    
</div>
<div class="clear"></div>


<script type="text/javascript" src="<?php echo $prime_framework_url; ?>js/shortcode-generator/js/column-control.js"></script>
<script type="text/javascript" src="<?php echo $prime_framework_url; ?>js/shortcode-generator/js/tab-control.js"></script>
<?php  }  else { ?>

<div id="prime-options-error">

    <h3><?php echo __( 'Ninja Trouble', 'primethemes' ); ?></h3>
    
    <?php if ( $isprimeTheme && ( ! $meetsMinVersion ) ) { ?>
    <p><?php echo sprinf ( __( 'Your version of the primeFramework (%s) does not yet support shortcodes. Shortcodes were introduced with version %s of the framework.', 'primethemes' ), $prime_framework_version, $MIN_VERSION ); ?></p>
    
    <h4><?php echo __( 'What to do now?', 'primethemes' ); ?></h4>
    
    <p><?php echo __( 'Upgrading your theme, or rather the primeFramework portion of it, will do the trick.', 'primethemes' ); ?></p>

	<p><?php echo sprintf( __( 'The framework is a collection of functionality that all primeThemes have in common. In most cases you can update the framework even if you have modified your theme, because the framework resides in a separate location (under %s).', 'primethemes' ), '<code>/functions/</code>' ); ?></p>
	
	<p><?php echo sprintf ( __( 'There\'s a tutorial on how to do this on primeThemes.com: %sHow to upgradeyour theme%s.', 'primethemes' ), '<a title="primeThemes Tutorial" target="_blank" href="http://www.primethemes.com/2009/08/how-to-upgrade-your-theme/">', '</a>' ); ?></p>
	
	<p><?php echo __( '<strong>Remember:</strong> Every Ninja has a backup plan. Safe or not, always backup your theme before you update it or make changes to it.', 'primethemes' ); ?></p>

<?php } else { ?>

    <p><?php echo __( 'Looks like your active theme is not from primeThemes. The shortcode generator only works with themes from primeThemes.', 'primethemes' ); ?></p>
    
    <h4><?php echo __( 'What to do now?', 'primethemes' ); ?></h4>

	<p><?php echo __( 'Pick a fight: (1) If you already have a theme from primeThemes, install and activate it or (2) if you don\'t yet have one of the awesome primeThemes head over to the <a href="http://www.primethemes.com/themes/" target="_blank" title="primeThemes Gallery">primeThemes Gallery</a> and get one.', 'primethemes' ); ?></p>

<?php } ?>

<div style="float: right"><input type="button" id="prime-btn-cancel"
	class="button" name="cancel" value="Cancel" accesskey="C" /></div>
</div>

<?php  } ?>

<script type="text/javascript" src="<?php echo $prime_framework_url; ?>js/shortcode-generator/js/dialog-js.php"></script>

</div>

</body>
</html>