<?php

/*

	Plugin Name: Text Obfuscator
	Plugin URI: http://www.flutt.co.uk/development/wordpress-plugins/text-obfuscator/
	Version: 1.4.1
	Description: Text Obfuscator is a simple plugin for replacing words and phrases in post or page content and comments with alternative words and phrases. Initially designed to remove names from personal blog posts, it can be used to correct common spelling errors or automatically expand abbreviations.
	Author: ConfuzzledDuck
	Author URI: http://www.flutt.co.uk/

*/

#
#  text-obfuscator.php
#
#  Created by Jonathon Wardman on 04-10-2008.
#  Copyright 2008 - 2015, Jonathon Wardman. All rights reserved.
#
#  This program is free software: you can redistribute it and/or modify
#  it under the terms of the GNU General Public License as published by
#  the Free Software Foundation, either version 3 of the License, or
#  (at your option) any later version.
#
#  You may obtain a copy of the License at:
#  http://www.gnu.org/licenses/gpl-3.0.txt
#
#  This program is distributed in the hope that it will be useful,
#  but WITHOUT ANY WARRANTY; without even the implied warranty of
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#  GNU General Public License for more details.

 /**
  * Main Text Obfuscator Plugin functionality.
  */
if ( is_admin() ) {

	 // Add actions for admin pages...
	add_action( 'admin_init', 'obfuscator_register_settings' );
	add_action( 'admin_menu', 'obfuscator_add_pages' );
	add_filter( 'plugin_action_links', 'obfuscator_settings_link', 10, 2 );

	 // Add actions for main post input parsing functionality...
	add_filter( 'content_save_pre', 'obfuscator_filter_input_content', 10 );
	add_filter( 'title_save_pre', 'obfuscator_filter_input_title', 10 );
	add_filter( 'excerpt_save_pre', 'obfuscator_filter_input_excerpt', 10 );

} else {

	 // Add actions for main post output parsing functionality...
	add_filter( 'the_content', 'obfuscator_filter', 10 );
	add_filter( 'the_title', 'obfuscator_filter_title', 10 );
	add_filter( 'single_post_title', 'obfuscator_filter_title', 10 );
	add_filter( 'the_excerpt', 'obfuscator_filter_excerpt', 10 );

	 // Add actions for comment parsing functionality...
	add_filter( 'comment_text', 'obfuscator_filter_comment', 10 );
	add_filter( 'pre_comment_content', 'obfuscator_filter_input_comment', 10 );
	add_filter( 'comment_excerpt', 'obfuscator_filter_comment', 10 );

}

 /**
  * Adds a settings link to the plugin page listing.
  *
  * @since 1.3
  */
function obfuscator_settings_link($links, $file) {

	if ( plugin_basename( __FILE__ ) == $file ) {
		array_push( $links, '<a href="tools.php?page=obfuscator">Settings</a>' );
	}
	return $links;

}

 /**
  * Adds the main admin management page.
  *
  * @since 0.2
  */
function obfuscator_add_pages() {

	$pageHook = add_management_page( 'Text Obfuscator admin', 'Text Obfuscator', 2, 'obfuscator', 'obfuscator_admin_page' );
	add_action( 'admin_print_scripts-'.$pageHook, 'obfuscator_admin_javascript' );

}

 /**
  * Registers the required settings array.
  *
  * @since 0.2
  */
function obfuscator_register_settings() {

	register_setting( 'text-obfuscator', 'obfuscator_replacements', 'obfuscator_sanitize_options' );

}

 /**
  * Sanitizes replacement pairs.
  *
  * @since 0.2
  */
function obfuscator_sanitize_options( $data ) {

	if ( array_key_exists( 'form_action', $data ) ) {
		if ( array_key_exists( 'add', $data['form_action'] ) && isset( $data['form_action']['new_pairs'] ) ) {
			set_transient( 'obfuscator_new_pairs', $data['form_action']['new_pairs'], 10 );
		}
		unset( $data['form_action'] );
	}

	$arrayIndex = 0;
	$sanitizedData = $errorArray = array();
	foreach ( $data AS $replacementPair ) {
		if ( isset( $replacementPair['token'] ) && ! empty( $replacementPair['token'] ) ) {
			if ( ! isset( $replacementPair['blank'] ) && ( ! isset( $replacementPair['value'] ) || empty( $replacementPair['value'] ) ) ) {
				$replacementPair['blank'] = true;
			}
			if ( trim( $replacementPair['token'] ) != $replacementPair['token'] ) {
				$errorArray[$arrayIndex]['token_trim'] = true;
			}
			if ( ! isset( $replacementPair['blank'] ) && ( trim( $replacementPair['value'] ) != $replacementPair['value'] ) ) {
				$errorArray[$arrayIndex]['value_trim'] = true;
			}
			$sanitizedData[$arrayIndex] = array( 'token' => $replacementPair['token'],
			                                     'scope' => ( isset( $replacementPair['scope'] ) && ( 'part' == $replacementPair['scope'] ) ) ? 'part' : 'full',
			                                     'case' => ( isset( $replacementPair['case'] ) && ( 'insensitive' == $replacementPair['case'] ) ) ? 'insensitive' : 'sensitive',
			                                     'type' => ( isset( $replacementPair['type'] ) && ( 'post' == $replacementPair['type'] || 'page' == $replacementPair['type'] ) ) ? $replacementPair['type'] : 'all',
			                                     'value' => ( isset( $replacementPair['blank'] ) ) ? '' : $replacementPair['value'],
			                                     'blank' => ( isset( $replacementPair['blank'] ) ) ? true : false,
			                                     'location' => ( isset( $replacementPair['location'] ) && ( 'pre' == $replacementPair['location'] ) ) ? 'pre' : 'post',
			                                     'posts' => ( isset( $replacementPair['posts'] ) ) ? true : false,
			                                     'titles' => ( isset( $replacementPair['titles'] ) ) ? true : false,
			                                     'excerpts' => ( isset( $replacementPair['excerpts'] ) ) ? true : false,
			                                     'comments' => ( isset( $replacementPair['comments'] ) ) ? true : false );
			$arrayIndex++;
		}
	}

	if ( count( $errorArray ) > 0 ) {
		set_transient( 'obfuscator_input_error', $errorArray, 10 );
	}

	return $sanitizedData;

}

 /**
  * Adds the javascript include to the admin page.
  *
  * @since 1.3
  */
function obfuscator_admin_javascript() {

	wp_enqueue_script( 'obfuscator_admin_js', plugins_url( '/obfuscator.js', __FILE__ ) );

}

 /**
  * Outputs the admin page.
  *
  * @since 0.2
  */
function obfuscator_admin_page() {

	$replacementData = get_option( 'obfuscator_replacements' );
	$tokenCount = count( $replacementData );

	 // Get stored data about new rows...
	$pairModifier = ($tokenCount > 0) ? 0 : 1;
	$newPairs = get_transient( 'obfuscator_new_pairs' );
	if ( isset( $newPairs ) && is_numeric( $newPairs ) ) {
		delete_transient( 'obfuscator_new_pairs' );
		if ( $newPairs > $pairModifier ) {
			$pairModifier = $newPairs;
		}
	}

	 // Get stored data about input errors and notices...
	$inputErrors = get_transient( 'obfuscator_input_error' );
	if ( isset( $inputErrors ) && is_array( $inputErrors ) ) {
		delete_transient( 'obfuscator_input_error' );
	}

?>

<style>
	.obfuscator_hidden_message {
		position: absolute;
		width: 250px;
		background-color: #FFFFE0;
		border: 1px solid #E6DB55;
		border-radius: 3px;
		padding: 0 0.6em;
		display: none;
	}
</style>

<div class="wrap">
<form id="posts-filter" action="options.php" method="post">
	<?php settings_fields( 'text-obfuscator' ); ?>
	<h2>Text Obfuscator admin</h2>
	<?php if ( ( isset( $_GET['updated'] ) || isset( $_GET['settings-updated'] ) ) && ( $newPairs == false ) ) { echo '<div id="message" class="updated fade"><p><b>Your replacement rules have been updated.</b></p><p>Output rules will apply immediately, input rules will apply to any data saved from now on.</p></div>'; } ?>
	<p>Add the term you want replacing into 'Match' and the text you want that term changing to in the 'Replace' box. Select when you want the replacement to take place and check the boxes to select which bits of content you want the filter to apply	to. To remove a rule simply delete the match string for that	line; if it's a display filter the original text will appear, if it's a save filter the replaced text will remain.</p>
	<table class="widefat">
		<thead>
		<tr valign="top">
			<th scope="column">Match</th>
			<th scope="column">Replace</th>
			<th scope="column">Content</th>
			<th scope="column">Title</th>
			<th scope="column">Excerpt</th>
			<th scope="column">Comment</th>
		</tr>
		</thead>
<?php
	for ( $i = 0; $i < ( $tokenCount + $pairModifier ); $i++ ) {
		$class = ( ( $i % 2 ) == 1) ? '' : 'alternate';
?>
		<tr class="<?php echo $class; ?>">
			<td>
				<input type="text" name="obfuscator_replacements[<?php echo esc_attr( $i ); ?>][token]" value="<?php echo esc_attr( $replacementData[$i]['token'] ); ?>" style="width: 296px;" /><br />
<?php
		if ( isset( $inputErrors[$i]['token_trim'] ) && $inputErrors[$i]['token_trim'] === true ) {
			echo '<span class="form-invalid">Whitespace was detected but was <em>not</em> removed.';
			echo '<sup><a href="#" onmouseover="obfuscator_toggleHiddenMessage(\'obfuscator_whitespace_token_'.esc_attr( $i ).'\');" onmouseout="obfuscator_toggleHiddenMessage(\'obfuscator_whitespace_token_'.esc_attr( $i ).'\');">?</a></sup></span><br />';
			echo '<div id="obfuscator_whitespace_token_'.esc_attr( $i ).'" class="obfuscator_hidden_message" style="left: 400px;"><p>The exact pattern which will be matched is <b>"'.str_replace( ' ', '&nbsp;', esc_html( $replacementData[$i]['token'] ) ).'"</b> (without quotes) <em>including</em> all spaces at the beginning and end of the string.</p>';
			echo '<p>If this is <em>not</em> what you intended to match you must remove the surrounding whitespace save the rules again.</p></div>';
		}
?>
				<select name="obfuscator_replacements[<?php echo esc_attr( $i ); ?>][scope]">
					<option value="full" <?php echo ( isset( $replacementData[$i]['scope'] ) && 'full' == $replacementData[$i]['scope'] ) ? 'selected="selected"' : ''; ?>>Full word</option>
					<option value="part" <?php echo ( isset( $replacementData[$i]['scope'] ) && 'part' == $replacementData[$i]['scope'] ) ? 'selected="selected"' : ''; ?>>Part word</option>
				</select>
				<select name="obfuscator_replacements[<?php echo esc_attr( $i ); ?>][case]">
					<option value="insensitive" <?php echo ( isset( $replacementData[$i]['case'] ) && 'insensitive' == $replacementData[$i]['case'] ) ? 'selected="selected"' : ''; ?>>Ignore case</option>
					<option value="sensitive" <?php echo ( isset( $replacementData[$i]['case'] ) && 'sensitive' == $replacementData[$i]['case'] ) ? 'selected="selected"' : ''; ?>>Match case</option>
				</select>
				<select name="obfuscator_replacements[<?php echo esc_attr( $i ); ?>][type]">
					<option value="all" <?php echo ( isset( $replacementData[$i]['type'] ) && 'all' == $replacementData[$i]['type'] ) ? 'selected="selected"' : ''; ?>>All public content</option>
					<option value="post" <?php echo ( isset( $replacementData[$i]['type'] ) && 'post' == $replacementData[$i]['type'] ) ? 'selected="selected"' : ''; ?>>Posts only</option>
					<option value="page" <?php echo ( isset( $replacementData[$i]['type'] ) && 'page' == $replacementData[$i]['type'] ) ? 'selected="selected"' : ''; ?>>Pages only</option>
<?php
		$customPostTypes = get_post_types(array('_builtin' => false));
		if (count($customPostTypes) > 0) {
			foreach ($customPostTypes AS $customPostType) {
				echo '<option value="'.$customPostType.'" '.( ( isset( $replacementData[$i]['type'] ) && $customPostType == $replacementData[$i]['type'] ) ? 'selected="selected"' : '').'>'.ucfirst($customPostType).'</option>'.PHP_EOL;
			}
		}
?>
				</select>
			</td>
			<td>
				<input type="text" id="value-<?php echo esc_attr( $i ); ?>" name="obfuscator_replacements[<?php echo esc_attr( $i ); ?>][value]" <?php echo ( isset( $replacementData[$i]['blank'] ) && true == $replacementData[$i]['blank'] ) ? 'value="[Blank]" disabled="disabled"' : 'value="'.esc_attr( $replacementData[$i]['value'] ).'"'; ?> style="width: 220px;" /><br />
<?php
		if ( isset( $inputErrors[$i]['value_trim'] ) && $inputErrors[$i]['value_trim'] === true ) {
			echo '<span class="form-invalid">Whitespace was detected but was <em>not</em> removed.';
			echo '<sup><a href="#" onmouseover="obfuscator_toggleHiddenMessage(\'obfuscator_whitespace_value_'.esc_attr( $i ).'\');" onmouseout="obfuscator_toggleHiddenMessage(\'obfuscator_whitespace_value_'.esc_attr( $i ).'\');">?</a></sup></span><br />';
			echo '<div id="obfuscator_whitespace_value_'.esc_attr( $i ).'" class="obfuscator_hidden_message" style="left: 700px;"><p>The exact string which will be inserted is <b>"'.str_replace( ' ', '&nbsp;', esc_html( $replacementData[$i]['value'] ) ).'"</b> (without quotes) <em>including</em> all spaces at the beginning and end of the string.</p>';
			echo '<p>If this is <em>not</em> what you intended you must remove the surrounding whitespace save the rules again.</p></div>';
		}
?>
				<input type="checkbox" name="obfuscator_replacements[<?php echo esc_attr( $i ); ?>][blank]" value="true" <?php echo ( isset( $replacementData[$i]['blank'] ) && true == $replacementData[$i]['blank'] ) ? 'checked="checked"' : ''; ?> onclick="obfuscator_toggleBlankReplace( this, <?php echo esc_attr( $i ); ?> );" /> Remove matched
				<select name="obfuscator_replacements[<?php echo esc_attr( $i ); ?>][location]">
					<option value="post" <?php echo ( isset( $replacementData[$i]['location'] ) && 'post' == $replacementData[$i]['location'] ) ? 'selected="selected"' : ''; ?>>On output</option>
					<option value="pre" <?php echo ( isset( $replacementData[$i]['location'] ) && 'pre' == $replacementData[$i]['location'] ) ? 'selected="selected"' : ''; ?>>On input</option>
				</select>
			</td>
			<td><input type="checkbox" name="obfuscator_replacements[<?php echo esc_attr( $i ); ?>][posts]" value="true" <?php echo ( isset( $replacementData[$i]['posts'] ) && true == $replacementData[$i]['posts'] ) ? 'checked="checked"' : ''; ?> style="margin-top: 18px;" /></td>
			<td><input type="checkbox" name="obfuscator_replacements[<?php echo esc_attr( $i ); ?>][titles]" value="true" <?php echo ( isset( $replacementData[$i]['titles'] ) && true == $replacementData[$i]['titles'] ) ? 'checked="checked"' : ''; ?> style="margin-top: 18px;" /></td>
			<td><input type="checkbox" name="obfuscator_replacements[<?php echo esc_attr( $i ); ?>][excerpts]" value="true" <?php echo ( isset( $replacementData[$i]['excerpts'] ) && true == $replacementData[$i]['excerpts'] ) ? 'checked="checked"' : ''; ?> style="margin-top: 18px;" /></td>
			<td><input type="checkbox" name="obfuscator_replacements[<?php echo esc_attr( $i ); ?>][comments]" value="true" <?php echo ( isset( $replacementData[$i]['comments'] ) && true == $replacementData[$i]['comments'] ) ? 'checked="checked"' : ''; ?> style="margin-top: 18px;" /></td>
		</tr>
<?php
		if ( isset( $replacementData[$i] ) && ( true != $replacementData[$i]['posts'] ) && ( true != $replacementData[$i]['titles'] ) && ( true != $replacementData[$i]['excerpts'] ) && ( true != $replacementData[$i]['comments'] ) ) {
?>
		<tr class="error">
			<td colspan="6" style="border-top: none;">The above replacement rule has been saved, but will not be applied to any content because no replacement locations have been selected.</td>
		</tr>
<?php
		}
	}
?>
	</table>
	<p>
		Add <input type="text" size="3" value="1" name="obfuscator_replacements[form_action][new_pairs]" /> new pair(s) <input type="submit" name="obfuscator_replacements[form_action][add]" value="Go" class="button" />
		<input type="submit" name="obfuscator_replacements[form_action][save]" value="Save changes" class="button-primary" />
	</p>
</form>
</div>
<?php

}

 /**
  * Builds the regular expressions needed for replacement for the given token
  * value pair.
  *
  * @since 1.2
  */
function obfuscator_build_replacement_elements( $replacementItem ) {

	if ( isset( $replacementItem['token'] ) && isset( $replacementItem['value'] ) ) {
		$caseModifier = '';
		if ( 'insensitive' == $replacementItem['case'] ) {
			$caseModifier = 'i';
		}
		if ( 'part' == $replacementItem['scope'] ) {
			return array( 'token' => '/'.preg_quote( $replacementItem['token'], '/' ).'/'.$caseModifier,
			              'value' => $replacementItem['value'] );
		} else {
			return array( 'token' => '/([\W\s]?)'.preg_quote( $replacementItem['token'], '/' ).'($|[\W\s]+)/'.$caseModifier,
			              'value' => '\\1'.$replacementItem['value'].'\\2' );
		}
	} else {
		return false;
	}

}

 /**
  * Carries out the string replacement on post output.
  *
  * @since 0.2
  */
function obfuscator_filter( $content, $content_type = 'posts' ) {

	$replacementData = get_option( 'obfuscator_replacements' );
	$replacementTokens = $replacementValues = array();
	if ( isset( $replacementData ) && is_array( $replacementData ) ) {
		foreach ( $replacementData AS $replacementItem ) {
			if ( ! isset( $replacementItem['location'] ) || ( 'post' == $replacementItem['location'] ) ) {
				if ( ! isset( $replacementItem[$content_type] ) || ( true == $replacementItem[$content_type] ) ) {
					if ( ( 'all' == $replacementItem['type'] ) || ( get_post_type() == $replacementItem['type'] ) ) {
						if ( $replacementElements = obfuscator_build_replacement_elements( $replacementItem ) ) {
							$replacementTokens[] = $replacementElements['token'];
							$replacementValues[] = $replacementElements['value'];
						}
					}
				}
			}
		}
	}
	return preg_replace( $replacementTokens, $replacementValues, $content );

}

	 // Brief output function aliases...
function obfuscator_filter_content( $content ) { return obfuscator_filter( $content, 'posts' ); }
function obfuscator_filter_title( $content ) { return obfuscator_filter( $content, 'titles' ); }
function obfuscator_filter_excerpt( $content ) { return obfuscator_filter( $content, 'excerpts' ); }
function obfuscator_filter_comment( $content ) { return obfuscator_filter( $content, 'comments' ); }

 /**
  * Carries out the string replacement on post input.
  *
  * @since 1.1
  */
function obfuscator_filter_input( $content, $content_type = 'posts' ) {

	$replacementData = get_option( 'obfuscator_replacements' );
	$replacementTokens = $replacementValues = array();
	if ( isset( $replacementData ) && is_array( $replacementData ) ) {
	foreach ( $replacementData AS $replacementItem ) {
		if ( isset( $replacementItem['location'] ) && ( 'pre' == $replacementItem['location'] ) ) {
			if ( ! isset( $replacementItem[$content_type] ) || ( true == $replacementItem[$content_type] ) ) {
				if ( $replacementElements = obfuscator_build_replacement_elements( $replacementItem ) ) {
					$replacementTokens[] = $replacementElements['token'];
					$replacementValues[] = $replacementElements['value'];
					}
				}
			}
		}
	}
	return preg_replace( $replacementTokens, $replacementValues, $content );

}

	 // Brief input function aliases...
function obfuscator_filter_input_content( $content ) { return obfuscator_filter_input( $content, 'posts' ); }
function obfuscator_filter_input_title( $content ) { return obfuscator_filter_input( $content, 'titles' ); }
function obfuscator_filter_input_excerpt( $content ) { return obfuscator_filter_input( $content, 'excerpts' ); }
function obfuscator_filter_input_comment( $content ) { return obfuscator_filter_input( $content, 'comments' ); }