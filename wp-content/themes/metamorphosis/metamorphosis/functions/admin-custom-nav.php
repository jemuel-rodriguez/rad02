<?php 

/**
 * TABLE OF CONTENTS
 *
 * Custom fields for WP write panel - primethemes_metabox_create
 * primethemes_uploader_custom_fields
 * primethemes_metabox_handle
 * primethemes_metabox_add
 * primethemes_metabox_header
 */

 
/* Custom fields for WP write panel */

function primethemes_metabox_create($post,$callback) {
    global $post;
    
    $template_to_show = $callback['args'];
    
    $prime_metaboxes = get_option('prime_custom_template');
    
    $seo_metaboxes = get_option('prime_custom_seo_template');  
    
    if(empty($seo_metaboxes) AND $template_to_show == 'seo'){
    	return;
    } 
    if(get_option('seo_prime_hide_fields') != 'true' AND $template_to_show == 'seo'){
    	$prime_metaboxes = $seo_metaboxes;
    }

    $output = '';
    $output .= '<table class="prime_metaboxes_table">'."\n";
    foreach ($prime_metaboxes as $prime_metabox) {
    	$prime_id = "primethemes_" . $prime_metabox["name"];
    	$prime_name = $prime_metabox["name"];
    	
    	if ($template_to_show == 'seo') {
    		$metabox_post_type_restriction = 'undefined';
    	} elseif (function_exists('primethemes_content_builder_menu')) {
    		$metabox_post_type_restriction = $prime_metabox['cpt'][$post->post_type];
    	} else {
    		$metabox_post_type_restriction = 'undefined';
    	}
    	
    	if ( ($metabox_post_type_restriction != '') && ($metabox_post_type_restriction == 'true') ) {
    		$type_selector = true;
    	} elseif ($metabox_post_type_restriction == 'undefined') {
    		$type_selector = true;
    	} else {
    		$type_selector = false;
    	}
    	
   		$prime_metaboxvalue = '';
    	
    	if ($type_selector) {
    
    		if(        
        	        $prime_metabox['type'] == 'text' 
			OR      $prime_metabox['type'] == 'select'
			OR      $prime_metabox['type'] == 'select2'
			OR      $prime_metabox['type'] == 'checkbox' 
			OR      $prime_metabox['type'] == 'textarea'
			OR      $prime_metabox['type'] == 'calendar'
			OR      $prime_metabox['type'] == 'time'
			OR      $prime_metabox['type'] == 'radio'
			OR      $prime_metabox['type'] == 'images') {
			
        	    	$prime_metaboxvalue = get_post_meta($post->ID,$prime_name,true);
				
				}
        	    
        	    if ( $prime_metaboxvalue == '' && isset( $prime_metabox['std'] ) ) {
        	    
        	        $prime_metaboxvalue = $prime_metabox['std'];
        	    }
				if($prime_metabox['type'] == 'info'){
        	    
        	        $output .= "\t".'<tr style="background:#f8f8f8; font-size:11px; line-height:1.5em;">';
        	        $output .= "\t\t".'<th class="prime_metabox_names"><label for="'.$prime_id.'">'.$prime_metabox['label'].'</label></th>'."\n";
        	        $output .= "\t\t".'<td style="font-size:11px;">'.$prime_metabox['desc'].'</td>'."\n";
        	        $output .= "\t".'</tr>'."\n";  
        	                      
        	    }
        	    elseif($prime_metabox['type'] == 'text'){
        	    
        	    	$add_class = ''; $add_counter = '';
        	    	if($template_to_show == 'seo'){$add_class = 'word-count'; $add_counter = '<span class="counter">0 characters, 0 words</span>';}
        	        $output .= "\t".'<tr>';
        	        $output .= "\t\t".'<th class="prime_metabox_names"><label for="'.$prime_id.'">'.$prime_metabox['label'].'</label></th>'."\n";
        	        $output .= "\t\t".'<td><input class="prime_input_text '.$add_class.'" type="'.$prime_metabox['type'].'" value="'.$prime_metaboxvalue.'" name="'.$prime_name.'" id="'.$prime_id.'"/>';
        	        $output .= '<span class="prime_metabox_desc">'.$prime_metabox['desc'] .' '. $add_counter .'</span></td>'."\n";
        	        $output .= "\t".'</tr>'."\n";  
        	                      
        	    }
        	    
        	    elseif ($prime_metabox['type'] == 'textarea'){
        	    
        	   		$add_class = ''; $add_counter = '';
        	    	if($template_to_show == 'seo'){$add_class = 'word-count'; $add_counter = '<span class="counter">0 characters, 0 words</span>';}
        	        $output .= "\t".'<tr>';
        	        $output .= "\t\t".'<th class="prime_metabox_names"><label for="'.$prime_metabox.'">'.$prime_metabox['label'].'</label></th>'."\n";
        	        $output .= "\t\t".'<td><textarea class="prime_input_textarea '.$add_class.'" name="'.$prime_name.'" id="'.$prime_id.'">' . stripslashes($prime_metaboxvalue) . '</textarea>';
        	        $output .= '<span class="prime_metabox_desc">'.$prime_metabox['desc'] .' '. $add_counter.'</span></td>'."\n";
        	        $output .= "\t".'</tr>'."\n";  
        	                      
        	    }
        	    
        	    elseif ($prime_metabox['type'] == 'calendar'){
        	    	
        	        $output .= "\t".'<tr>';
        	        $output .= "\t\t".'<th class="prime_metabox_names"><label for="'.$prime_metabox.'">'.$prime_metabox['label'].'</label></th>'."\n";
        	        $output .= "\t\t".'<td><input class="prime_input_calendar" type="text" name="'.$prime_name.'" id="'.$prime_id.'" value="'.$prime_metaboxvalue.'">';
        	        $output .= '<span class="prime_metabox_desc">'.$prime_metabox['desc'].'</span></td>'."\n";
        	        $output .= "\t".'</tr>'."\n";  
        	                      
        	    }
        	    
        	    elseif ($prime_metabox['type'] == 'time'){
        	    	
        	        $output .= "\t".'<tr>';
        	        $output .= "\t\t".'<th class="prime_metabox_names"><label for="'.$prime_id.'">'.$prime_metabox['label'].'</label></th>'."\n";
        	        $output .= "\t\t".'<td><input class="prime_input_time" type="'.$prime_metabox['type'].'" value="'.$prime_metaboxvalue.'" name="'.$prime_name.'" id="'.$prime_id.'"/>';
        	        $output .= '<span class="prime_metabox_desc">'.$prime_metabox['desc'].'</span></td>'."\n";
        	        $output .= "\t".'</tr>'."\n"; 
        	                      
        	    }
			
        	    elseif ($prime_metabox['type'] == 'select'){
        	               
        	        $output .= "\t".'<tr>';
        	        $output .= "\t\t".'<th class="prime_metabox_names"><label for="'.$prime_id.'">'.$prime_metabox['label'].'</label></th>'."\n";
        	        $output .= "\t\t".'<td><select class="prime_input_select" id="'.$prime_id.'" name="'. $prime_name .'">';
        	        $output .= '<option value="">Select to return to default</option>';
        	        
        	        $array = $prime_metabox['options'];
        	        
        	        if($array){
        	        
        	            foreach ( $array as $id => $option ) {
        	                $selected = '';
        	               
        	                if(isset($prime_metabox['default']))  {                            
								if($prime_metabox['default'] == $option && empty($prime_metaboxvalue)){$selected = 'selected="selected"';} 
								else  {$selected = '';}
							}
        	                
        	                if($prime_metaboxvalue == $option){$selected = 'selected="selected"';}
        	                else  {$selected = '';}  
        	                
        	                $output .= '<option value="'. $option .'" '. $selected .'>' . $option .'</option>';
        	            }
        	        }
        	        
        	        $output .= '</select><span class="prime_metabox_desc">'.$prime_metabox['desc'].'</span></td>'."\n";
        	        $output .= "\t".'</tr>'."\n";
        	    }
        	    elseif ($prime_metabox['type'] == 'select2'){
        	               
        	        $output .= "\t".'<tr>';
        	        $output .= "\t\t".'<th class="prime_metabox_names"><label for="'.$prime_id.'">'.$prime_metabox['label'].'</label></th>'."\n";
        	        $output .= "\t\t".'<td><select class="prime_input_select" id="'.$prime_id.'" name="'. $prime_name .'">';
        	        $output .= '<option value="">Select to return to default</option>';
        	        
        	        $array = $prime_metabox['options'];
        	        
        	        if($array){
        	        
        	            foreach ( $array as $id => $option ) {
        	                $selected = '';
        	               
        	                if(isset($prime_metabox['default']))  {                            
								if($prime_metabox['default'] == $id && empty($prime_metaboxvalue)){$selected = 'selected="selected"';} 
								else  {$selected = '';}
							}
        	                
        	                if($prime_metaboxvalue == $id){$selected = 'selected="selected"';}
        	                else  {$selected = '';}  
        	                
        	                $output .= '<option value="'. $id .'" '. $selected .'>' . $option .'</option>';
        	            }
        	        }
        	        
        	        $output .= '</select><span class="prime_metabox_desc">'.$prime_metabox['desc'].'</span></td>'."\n";
        	        $output .= "\t".'</tr>'."\n";
        	    }
        	    
        	    elseif ($prime_metabox['type'] == 'checkbox'){
        	    
        	        if($prime_metaboxvalue == 'true') { $checked = ' checked="checked"';} else {$checked='';}
			
        	        $output .= "\t".'<tr>';
        	        $output .= "\t\t".'<th class="prime_metabox_names"><label for="'.$prime_id.'">'.$prime_metabox['label'].'</label></th>'."\n";
        	        $output .= "\t\t".'<td><input type="checkbox" '.$checked.' class="prime_input_checkbox" value="true"  id="'.$prime_id.'" name="'. $prime_name .'" />';
        	        $output .= '<span class="prime_metabox_desc" style="display:inline">'.$prime_metabox['desc'].'</span></td>'."\n";
        	        $output .= "\t".'</tr>'."\n";
        	    }
        	    
        	    elseif ($prime_metabox['type'] == 'radio'){
        	    
        	    $array = $prime_metabox['options'];
        	    
        	    if($array){
        	    
        	    $output .= "\t".'<tr>';
        	    $output .= "\t\t".'<th class="prime_metabox_names"><label for="'.$prime_id.'">'.$prime_metabox['label'].'</label></th>'."\n";
        	    $output .= "\t\t".'<td>';
        	    
        	        foreach ( $array as $id => $option ) {
			
        	            if($prime_metaboxvalue == $id) { $checked = ' checked';} else {$checked='';}
			
        	                $output .= '<input type="radio" '.$checked.' value="' . $id . '" class="prime_input_radio"  name="'. $prime_name .'" />';
        	                $output .= '<span class="prime_input_radio_desc" style="display:inline">'. $option .'</span><div class="prime_spacer"></div>';
        	            }
        	            $output .= "\t".'</tr>'."\n";    
        	         }
        	    }
				elseif ($prime_metabox['type'] == 'images')
				{
				
				$i = 0;
				$select_value = '';
				$layout = '';
			
				foreach ($prime_metabox['options'] as $key => $option) 
					 { 
					 $i++;
					 
					 $checked = '';
					 $selected = '';
					 if($prime_metaboxvalue != '') {
					 	if ($prime_metaboxvalue == $key) { $checked = ' checked'; $selected = 'prime-meta-radio-img-selected'; }
					 } 
					 else {
					 	if ($option['std'] == $key) { $checked = ' checked'; } 
						elseif ($i == 1) { $checked = ' checked'; $selected = 'prime-meta-radio-img-selected'; }
						else { $checked=''; }
						
					 }
						
						$layout .= '<div class="prime-meta-radio-img-label">';			
						$layout .= '<input type="radio" id="prime-meta-radio-img-' . $prime_name . $i . '" class="checkbox prime-meta-radio-img-radio" value="'.$key.'" name="'. $prime_name.'" '.$checked.' />';
						$layout .= '&nbsp;' . $key .'<div class="prime_spacer"></div></div>';
						$layout .= '<img src="'.$option.'" alt="" class="prime-meta-radio-img-img '. $selected .'" onClick="document.getElementById(\'prime-meta-radio-img-'. $prime_metabox["name"] . $i.'\').checked = true;" />';
					}
				
				$output .= "\t".'<tr>';
				$output .= "\t\t".'<th class="prime_metabox_names"><label for="'.$prime_id.'">'.$prime_metabox['label'].'</label></th>'."\n";
				$output .= "\t\t".'<td class="prime_metabox_fields">';
				$output .= $layout;
				$output .= '<span class="prime_metabox_desc">'.$prime_metabox['desc'].'</span></td>'."\n";
        	    $output .= "\t".'</tr>'."\n"; 
							
				}
        	    
        	    elseif($prime_metabox['type'] == 'upload')
        	    {
					if(isset($prime_metabox["default"])) $default = $prime_metabox["default"];
					else $default = '';
        	    	
        	    	// Add support for the primeThemes Media Library-driven Uploader Module // 2010-11-09.
        	    	if ( function_exists( 'primethemes_medialibrary_uploader' ) ) {
        	    	
        	    		$_value = $default;
        	    		
        	    		$_value = get_post_meta( $post->ID, $prime_metabox["name"], true );
        	    	
        	    		$output .= "\t".'<tr>';
	    	            $output .= "\t\t".'<th class="prime_metabox_names"><label for="'.$prime_metabox["name"].'">'.$prime_metabox['label'].'</label></th>'."\n";
	    	            $output .= "\t\t".'<td class="prime_metabox_fields">'. primethemes_medialibrary_uploader( $prime_metabox["name"], $_value, 'postmeta', $prime_metabox["desc"], $post->ID );
	    	            $output .= '</td>'."\n";
	    	            $output .= "\t".'</tr>'."\n";
        	    	
        	    	} else {
        	    	
	    	            $output .= "\t".'<tr>';
	    	            $output .= "\t\t".'<th class="prime_metabox_names"><label for="'.$prime_id.'">'.$prime_metabox['label'].'</label></th>'."\n";
	    	            $output .= "\t\t".'<td class="prime_metabox_fields">'. primethemes_uploader_custom_fields($post->ID,$prime_name,$default,$prime_metabox["desc"]);
	    	            $output .= '</td>'."\n";
	    	            $output .= "\t".'</tr>'."\n";
        	        
        	        } // End IF Statement
        	        
        	    }
        }	// End IF Statement
    }
    
    $output .= '</table>'."\n\n";
    echo $output;
}


/* primethemes_uploader_custom_fields */

function primethemes_uploader_custom_fields($pID,$id,$std,$desc){

    // Start Uploader
    $upload = get_post_meta( $pID, $id, true);
	$href = cleanSource($upload);
	$uploader = '';
    $uploader .= '<input class="prime_input_text" name="'.$id.'" type="text" value="'.$upload.'" />';
    $uploader .= '<div class="clear"></div>'."\n";
    $uploader .= '<input type="file" name="attachement_'.$id.'" />';
    $uploader .= '<input type="submit" class="button button-highlighted" value="Save" name="save"/>';
    if ( $href ) 
		$uploader .= '<span class="prime_metabox_desc">'.$desc.'</span></td>'."\n".'<td class="prime_metabox_image"><a href="'. $upload .'"><img src="'.get_bloginfo('template_url').'/thumb.php?src='.$href.'&w=150&h=80&zc=1" alt="" /></a>';

return $uploader;
}


/* primethemes_metabox_handle */

function primethemes_metabox_handle(){
    
    $pID = '';
    global $globals, $post;
    
    $prime_metaboxes = get_option('prime_custom_template');  
    
    $seo_metaboxes = get_option('prime_custom_seo_template');  
    
    if(!empty($seo_metaboxes) AND get_option('seo_prime_hide_fields') != 'true'){
    	$prime_metaboxes = array_merge($prime_metaboxes,$seo_metaboxes);
    }
       
    // Sanitize post ID.
    
    if( isset( $_POST['post_ID'] ) ) {
    
		$pID = intval( $_POST['post_ID'] );
		
    } // End IF Statement
    
    // Don't continue if we don't have a valid post ID.
    
    if ( $pID == 0 ) {
    
    	return;
    
    } // End IF Statement
    
    $upload_tracking = array();
    
    if ( isset( $_POST['action'] ) && $_POST['action'] == 'editpost' ) {                                   
     
        foreach ($prime_metaboxes as $prime_metabox) { // On Save.. this gets looped in the header response and saves the values submitted
            if($prime_metabox['type'] == 'text' 
			OR $prime_metabox['type'] == 'calendar' 
			OR $prime_metabox['type'] == 'time'
			OR $prime_metabox['type'] == 'select' 
			OR $prime_metabox['type'] == 'select2' 
			OR $prime_metabox['type'] == 'radio'
			OR $prime_metabox['type'] == 'checkbox' 
			OR $prime_metabox['type'] == 'textarea' 
			OR $prime_metabox['type'] == 'images' ) // Normal Type Things...
            {
            
				$var = $prime_metabox["name"];
				
				if ( isset( $_POST[$var] ) ) {
				
					// Sanitize the input.
					$posted_value = '';
					$posted_value = $_POST[$var];
				    
				    // Get the current value for checking in the script.
				    $current_value = '';
				    $current_value = get_post_meta( $pID, $var, true );
					
					 // If it doesn't exist, add the post meta.
					if(get_post_meta( $pID, $var ) == "") { 
					
						add_post_meta( $pID, $var, $posted_value, true ); 
					
					}
					// Otherwise, if it's different, update the post meta.
					elseif( $posted_value != get_post_meta( $pID, $var, true ) ) { 
					
						update_post_meta( $pID, $var, $posted_value );
					
					}
					// Otherwise, if no value is set, delete the post meta.
					elseif($posted_value == "") { 
					
						delete_post_meta( $pID, $var, get_post_meta( $pID, $var, true ) );
					
					} // End IF Statement

					/**
				     * If it doesn't exist, add the post meta.    
							if ( $current_value == "" && $posted_value != '' ) {
					
							update_post_meta( $pID, $var, $posted_value );
					 *
					 * Otherwise, if it's different, update the post meta.
							} elseif ( ( $posted_value != '' ) && ( $posted_value != $current_value ) ) {
					 *	
							update_post_meta( $pID, $var, $posted_value );
					 *
					 * Otherwise, if no value is set, delete the post meta.
							} elseif ( $posted_value == "" && $current_value != '' ) {
					 *
							delete_post_meta($pID, $var, $current_value );
					 *
							} // End IF Statement
					 */
					
				} elseif ( ! isset( $_POST[$var] ) && $prime_metabox['type'] == 'checkbox' ) {
				 
					update_post_meta( $pID, $var, 'false' );
					
				} else {
				
					delete_post_meta( $pID, $var, $current_value ); // Deletes check boxes OR no $_POST
					
				} // End IF Statement 
            
            } elseif( $prime_metabox['type'] == 'upload' ) { // So, the upload inputs will do this rather
			
				$id = $prime_metabox['name'];
				$override['action'] = 'editpost';
			
			    if(!empty($_FILES['attachement_'.$id]['name'])){ //New upload
			    $_FILES['attachement_'.$id]['name'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', $_FILES['attachement_'.$id]['name']); 
			           $uploaded_file = wp_handle_upload($_FILES['attachement_' . $id ],$override); 
			           $uploaded_file['option_name']  = $prime_metabox['label'];
			           $upload_tracking[] = $uploaded_file;
			           update_post_meta( $pID, $id, $uploaded_file['url'] );
			          
			    } elseif ( empty( $_FILES['attachement_'.$id]['name'] ) && isset( $_POST[ $id ] ) ) {
			       
			       	// Sanitize the input.
					$posted_value = '';
					$posted_value = $_POST[$id];
			       
			        update_post_meta($pID, $id, $posted_value); 
			    	
			    } elseif ( $_POST[ $id ] == '' )  {
			    
			    	delete_post_meta( $pID, $id, get_post_meta( $pID, $id, true ) );
			    
			    } // End IF Statement
			
			} // End IF Statement
                
               // Error Tracking - File upload was not an Image
               update_option( 'prime_custom_upload_tracking', $upload_tracking );
            
            } // End FOREACH Loop
            
        } // End IF Statement

} // End primethemes_metabox_handle()


/* primethemes_metabox_add */

function primethemes_metabox_add() {
	$seo_metaboxes = get_option('prime_custom_seo_template');
	$seo_post_types = array('post','page');
	if(defined('SEOPOSTTYPES')){
		$seo_post_types_update = unserialize( constant('SEOPOSTTYPES') );
	}
				
	if(!empty($seo_post_types_update)){
		$seo_post_types = $seo_post_types_update;
	} 
			
	$prime_metaboxes = get_option('prime_custom_template');
		
    if ( function_exists('add_meta_box') ) {
    
    	if ( function_exists('get_post_types') ) {
    		$custom_post_list = get_post_types();
			foreach ($custom_post_list as $type){
			
				//if(!empty($prime_metaboxes)) Temporarily Removed
					add_meta_box('primethemes-settings', get_option('prime_themename').' Custom Settings','primethemes_metabox_create',$type,'normal');
				
				if(array_search($type, $seo_post_types) !== false){	
					if(get_option('seo_prime_hide_fields') != 'true'){
						add_meta_box('primethemes-seo',get_option('prime_themename').' SEO Settings','primethemes_metabox_create',$type,'normal','high','seo');
					}
				}
			}
    	} else {
    		add_meta_box('primethemes-settings',get_option('prime_themename').' Custom Settings','primethemes_metabox_create','post','normal');
        	add_meta_box('primethemes-settings',get_option('prime_themename').' Custom Settings','primethemes_metabox_create','page','normal');
        	if(get_option('seo_prime_hide_fields') != 'true'){
        		add_meta_box('primethemes-seo',get_option('prime_themename').' SEO Settings','primethemes_metabox_create','post','normal','high','seo');
        		add_meta_box('primethemes-seo',get_option('prime_themename').' SEO Settings','primethemes_metabox_create','page','normal','high','seo');
    		}
    	}
		
    }
}


/* primethemes_metabox_header */

function primethemes_metabox_header(){
?>
<script type="text/javascript">

    jQuery(document).ready(function(){
		
        jQuery('form#post').attr('enctype','multipart/form-data');
        jQuery('form#post').attr('encoding','multipart/form-data');
        
         //JQUERY DATEPICKER
		jQuery('.prime_input_calendar').each(function (){
			jQuery('#' + jQuery(this).attr('id')).datepicker({showOn: 'button', buttonImage: '<?php echo get_bloginfo('template_directory');?>/functions/images/calendar.gif', buttonImageOnly: true});
		});
		
		//JQUERY TIME INPUT MASK
		jQuery('.prime_input_time').each(function (){
			jQuery('#' + jQuery(this).attr('id')).mask("99:99");
		});
		
		//JQUERY CHARACTER COUNTER
		jQuery('.word-count').each(function(){ 
				var s = ''; var s2 = ''; 
			    var length = jQuery(this).val().length; 
			    var w_length = jQuery(this).val().split(/\b[\s,\.-:;]*/).length; 
			    
			    if(length != 1) { s = 's';}
			    if(w_length != 1){ s2 = 's';} 
			    if(jQuery(this).val() == ''){ s2 = 's'; w_length = '0';}
			    
			    jQuery(this).parent().find('.counter').html( length + ' character'+ s + ', ' + w_length + ' word' + s2);  

			    jQuery(this).keyup(function(){  
			    var s = ''; var s2 = '';
			        var new_length = jQuery(this).val().length; 
			        var word_length = jQuery(this).val().split(/\b[\s,\.-:;]*/).length;
			        
			        if(new_length != 1) { s = 's';} 
			        if(word_length != 1){ s2 = 's'}  
			        if(jQuery(this).val() == ''){ s2 == 's'; word_length = '0';}
			        
			        jQuery(this).parent().find('.counter').html( new_length + ' character' + s + ', ' + word_length + ' word' + s2);  
			    });  
			});  
		
        jQuery('.prime_metaboxes_table th:last, .prime_metaboxes_table td:last').css('border','0');
        var val = jQuery('input#title').attr('value');
        if(val == ''){ 
        jQuery('.prime_metabox_fields .button-highlighted').after("<em class='prime_red_note'>Please add a Title before uploading a file</em>");
        };
		jQuery('.prime-meta-radio-img-img').click(function(){
				jQuery(this).parent().find('.prime-meta-radio-img-img').removeClass('prime-meta-radio-img-selected');
				jQuery(this).addClass('prime-meta-radio-img-selected');
				
			});
			jQuery('.prime-meta-radio-img-label').hide();
			jQuery('.prime-meta-radio-img-img').show();
			jQuery('.prime-meta-radio-img-radio').hide();
        <?php //Errors
        $error_occurred = false;
        $upload_tracking = get_option('prime_custom_upload_tracking');
        if(!empty($upload_tracking)){
        $output = '<div style="clear:both;height:20px;"></div><div class="errors"><ul>' . "\n";
            $error_shown == false;
            foreach($upload_tracking as $array )
            {
                 if(array_key_exists('error', $array)){
                        $error_occurred = true;
                        ?>
                        jQuery('form#post').before('<div class="updated fade"><p>primeThemes Upload Error: <strong><?php echo $array['option_name'] ?></strong> - <?php echo $array['error'] ?></p></div>');
                        <?php
                }
            }
        }
		
        delete_option('prime_upload_custom_errors');
        ?>
    });

</script>
<style type="text/css">
.prime_input_text { margin:0 0 10px 0; background:#f4f4f4; color:#444; width:80%; font-size:11px; padding: 5px;}
.prime_input_select { margin:0 0 10px 0; background:#f4f4f4; color:#444; width:60%; font-size:11px; padding: 5px;}
.prime_input_checkbox { margin:0 10px 0 0; }
.prime_input_radio { margin:0 10px 0 0; }
.prime_input_radio_desc { font-size: 12px; color: #666 ; }
.prime_input_calendar { margin:0 0 10px 0; }
.prime_spacer { display: block; height:5px}
.prime_metabox_desc { font-size:10px; color:#aaa; display:block}
.prime_metaboxes_table{ border-collapse:collapse; width:100%}
.prime_metaboxes_table th,
.prime_metaboxes_table td{ border-bottom:1px solid #ddd; padding:10px 10px;text-align: left; vertical-align:top}
.prime_metabox_names { width:20%}
.prime_metabox_fields { width:70%}
.prime_metabox_image { text-align: right;}
.prime_red_note { margin-left: 5px; color: #c77; font-size: 10px;}
.prime_input_textarea { width:80%; height:120px;margin:0 0 10px 0; background:#f0f0f0; color:#444;font-size:11px;padding: 5px;}
.prime-meta-radio-img-img { border:3px solid #dedede; margin:0 5px 10px 0; display:none; cursor:pointer; border-radius: 3px; -moz-border-radius: 3px; -webkit-border-radius: 3px;}
.prime-meta-radio-img-img:hover, .prime-meta-radio-img-selected { border:3px solid #aaa; border-radius: 3px; -moz-border-radius: 3px; -webkit-border-radius: 3px; }
.prime-meta-radio-img-label { font-size:12px}
.prime_metabox_desc span.counter { color:green!important }
.prime_metabox_fields .controls input.upload { width:280px; padding-bottom:6px; }
.prime_metabox_fields .controls input.upload_button{ float:right; width:auto; border-color:#BBBBBB; cursor:pointer; height:16px; }
.prime_metabox_fields .controls input.upload_button:hover { width:auto; border-color:#666666; color:#000; }
.prime_metabox_fields .screenshot{margin:10px 0;float:left;margin-left:1px;position:relative;width:344px;}
.prime_metabox_fields .screenshot img{-moz-border-radius:4px;-webkit-border-radius:4px;-border-radius:4px;background:#FAFAFA;float:left;max-width:334px;border-color:#CCC #EEE #EEE #CCC;border-style:solid;border-width:1px;padding:4px;}
.prime_metabox_fields .screenshot .mlu_remove{background:url("<?php bloginfo('template_directory'); ?>/functions/images/ico-delete.png") no-repeat scroll 0 0 transparent;border:medium none;bottom:-4px;display:block;float:left;height:16px;position:absolute;left:-4px;text-indent:-9999px;width:16px;padding:0;}
.prime_metabox_fields .upload {background:none repeat scroll 0 0 #F4F4F4;color:#444444;font-size:11px;margin:0 0 10px;padding:5px;width:70%;}
.prime_metabox_fields .upload_button {-moz-border-radius:4px; -webkit-border-radius:4px;-border-radius:4px;}
.prime_metabox_fields .screenshot .no_image .file_link {margin-left: 20px;}
.prime_metabox_fields .screenshot .no_image .mlu_remove {bottom: 0px;}
</style>
<?php
 echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('template_directory') . '/functions/css/jquery-ui-datepicker.css" />';
}


function prime_custom_enqueue($hook) {
  	if ($hook == 'post.php' OR $hook == 'post-new.php' OR $hook == 'page-new.php' OR $hook == 'page.php') {
		add_action('admin_head', 'primethemes_metabox_header');
		wp_enqueue_script('jquery-ui-core');
		wp_register_script('jquery-ui-datepicker', get_bloginfo('template_directory').'/functions/js/ui.datepicker.js', array( 'jquery-ui-core' ));
		wp_enqueue_script('jquery-ui-datepicker');
		wp_register_script('jquery-input-mask', get_bloginfo('template_directory').'/functions/js/jquery.maskedinput-1.2.2.js', array( 'jquery' ));
		wp_enqueue_script('jquery-input-mask');
  	}
}

add_action('admin_enqueue_scripts','prime_custom_enqueue',10,1);
add_action('edit_post', 'primethemes_metabox_handle');
add_action('admin_menu', 'primethemes_metabox_add'); // Triggers primethemes_metabox_create

?>