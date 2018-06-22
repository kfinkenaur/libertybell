<?php
 /** 
 * Slider Custom Post Type
 *
 *
 * @file           slider_post_type.php
 * @package        DK Responsive
 * @author         Dipali Dhole
 * @copyright      2014 Zenant
 * @license        license.txt
 * @version        Release: 1.0
 */  
if ( ! defined( 'WPINC' ) ) {
    die;
}

// Meta Box for Slider Information

	$slidelink_2_metabox = array( 
		'id' => 'slidelink',
		'title' => 'Slide Information',
		'page' => array('post'),
		'context' => 'normal',
		'priority' => 'default',
		'fields' => array(
	
					array(
						'name' 			=> 'Display In Front Page Slider',
						'desc' 			=> 'If it is checked then this post will display in front page slider.(Featured Image, Slide Title, Slide Caption, Post URL as Slide URL.)',
						'id' 				=> 'dk_slieron',
						'class' 			=> 'dk_slieron',
						'type' 			=> 'checkbox',
						'rich_editor' 	=> 0,			
						'max' 			=> 0				
					),
					array(
						'name' 			=> 'Slide Title',
						'desc' 			=> '',
						'id' 				=> 'dk_slideTitle',
						'class' 			=> 'dk_slideTitle',
						'type' 			=> 'text',
						'rich_editor' 	=> 0,			
						'max' 			=> 0				
					),
					array(
						'name' 			=> 'Slide Caption',
						'desc' 			=> '',
						'id' 				=> 'dk_slidecaption',
						'class' 			=> 'dk_slidecaption',
						'type' 			=> 'textarea',
						'rich_editor' 	=> 0,			
						'max' 			=> 0				
					),
					)
	);			
				
	add_action('admin_menu', 'dk_add_slidelink_2_meta_box');
	function dk_add_slidelink_2_meta_box() {
	
		global $slidelink_2_metabox;		
	
		foreach($slidelink_2_metabox['page'] as $page) {
			add_meta_box($slidelink_2_metabox['id'], $slidelink_2_metabox['title'], 'dk_show_slidelink_2_box', $page, 'normal', 'default', $slidelink_2_metabox);
		}
	}
	
	// function to show meta boxes
	function dk_show_slidelink_2_box()	{
		global $post;
		global $slidelink_2_metabox;
		global $dk_prefix;
		global $wp_version;
		
		// Use nonce for verification
		echo '<input type="hidden" name="dk_slidelink_2_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
		
		echo '<table class="form-table">';
	
		foreach ($slidelink_2_metabox['fields'] as $field) {
			// get current post meta data
	
			$meta[$field['id']] = get_post_meta($post->ID, $field['id'], true);			
			
			echo '<tr>',
					'<th style="width:20%"><label for="', $field['id'], '">', stripslashes($field['name']), '</label></th>',
					'<td class="dk_field_type_' . str_replace(' ', '_', $field['type']) . '">';
					
			switch ($field['type']) {
			
			 
				case 'text':
				$std = (!empty($field['std'])) ? $field['std'] : '';
					echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta[$field['id']] ? $meta[$field['id']] : $std, '" size="30" style="width:97%" /><br/>', '', stripslashes($field['desc']);
					break;
				case 'checkbox':
				$std = (!empty($field['std'])) ? $field['std'] : 'Y';

				echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '" value="', $meta[$field['id']] ? $meta[$field['id']] : $std, '" '.( (isset ( $meta[$field['id']] )) ? checked( $meta[$field['id']], 'Y' ) :'').'  size="30"  /><br/>', '', stripslashes($field['desc']);
				break;
					case 'textarea':
				$std = (!empty($field['std'])) ? $field['std'] : '';
				echo '<textarea style="width:97%" name='.$field["id"].' id="', $field['id'], '" >'.($meta[$field['id']] ? $meta[$field['id']] : $std).'</textarea>';
				//	echo '<input type="textarea" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $std, '" rows=10 style="width:97%" /><br/>', '', stripslashes($field['desc']);
					break;
			}
			echo    '<td>',
				'</tr>';
		}
		
		echo '</table>';
	}	
	
	// Save data from meta box
	add_action('save_post', 'dk_slidelink_2_save');
	function dk_slidelink_2_save($post_id) {
		global $post;
		global $slidelink_2_metabox;
		
		// verify nonce
		if(isset($_POST['dk_slidelink_2_meta_box_nonce'])) {
		  if (!wp_verify_nonce($_POST['dk_slidelink_2_meta_box_nonce'], basename(__FILE__))) {
			 return $post_id;
		  }
		}
	
		// check autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post_id;
		}
	
		// check permissions
		if(isset($_POST['post_type'])) {
		if (('page' == $_POST['post_type'])) {
			if (!current_user_can('edit_page', $post_id)) {
				return $post_id;
			}
		} elseif (!current_user_can('edit_post', $post_id)) {
			return $post_id;
		    }
		}
		$old ='';
		$new= '';
		foreach ($slidelink_2_metabox['fields'] as $field) {
		    if(isset($_POST[$field['id']])) {
			$old = get_post_meta($post_id, $field['id'], true);
			$new = $_POST[$field['id']];
			}
			
			
			if ($new && $new != $old) {
				if($field['type'] == 'date') {
					$new = dk_format_date($new);
					update_post_meta($post_id, $field['id'], $new);
				} else {
					if(is_string($new)) {
						$new = $new;
					} 
					update_post_meta($post_id, $field['id'], $new);
					
					
				}
			} elseif ('' == $new && $old) {
				delete_post_meta($post_id, $field['id'], $old);
			}
			if( isset( $_POST[ 'dk_slieron' ] ) ) {
			update_post_meta( $post_id, 'dk_slieron', 'Y' );
			} else {
			update_post_meta( $post_id, 'dk_slieron', 'N' );
			}
		}
	}