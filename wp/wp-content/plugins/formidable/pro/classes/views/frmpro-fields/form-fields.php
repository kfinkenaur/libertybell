<?php
if ( 'date' == $field['type'] ) {
?>
<input type="text" id="<?php echo esc_attr( $html_id ) ?>" name="<?php echo esc_attr( $field_name ) ?>" value="<?php echo esc_attr( $field['value'] ) ?>" <?php do_action( 'frm_field_input_html', $field ) ?>/>
<?php

    if ( ! FrmField::is_read_only( $field ) ) {
        if ( ! isset($frm_vars['datepicker_loaded']) || ! is_array($frm_vars['datepicker_loaded']) ) {
            $frm_vars['datepicker_loaded'] = array();
        }

        if ( ! isset($frm_vars['datepicker_loaded'][ $html_id ]) ) {
            $static_html_id = FrmFieldsHelper::get_html_id($field);
            if ( $html_id != $static_html_id ) {
                // user wildcard for repeating fields
                $frm_vars['datepicker_loaded']['^'. $static_html_id] = true;
            } else {
                $frm_vars['datepicker_loaded'][$html_id] = true;
            }
        }

        FrmProFieldsHelper::set_field_js($field, (isset($entry_id) ? $entry_id : 0));
    }

} else if ( $field['type'] == 'time' ) {

    if ( $field['unique'] ) {
        if ( ! isset($frm_vars['timepicker_loaded']) || ! is_array($frm_vars['timepicker_loaded']) ) {
            $frm_vars['timepicker_loaded'] = array();
        }

        if ( ! isset($frm_vars['timepicker_loaded'][ $html_id ]) ) {
            $frm_vars['timepicker_loaded'][$html_id] = true;
        }
    }

    if ( isset($field['options']['H']) ) {
        if ( ! empty($field['value']) && ! is_array($field['value']) ) {
            $h = explode(':', $field['value']);
            $m = explode(' ', $h[1]);
            $h = reset($h);
            $a = isset($m[1]) ? $m[1] : '';
            $m = reset($m);
        } else if ( is_array($field['value']) ) {
            $h = isset($field['value']['H']) ? $field['value']['H'] : '';
            $m = isset($field['value']['m']) ? $field['value']['m'] : '';
            $a = isset($field['value']['A']) ? $field['value']['A'] : '';
        } else {
            $h = $m = $a = '';
        }
?>
<select name="<?php echo esc_attr( $field_name ) ?>[H]" id="<?php echo esc_attr( $html_id ) ?>_H" <?php do_action( 'frm_field_input_html', $field ) ?>>
    <?php foreach ( $field['options']['H'] as $hour ) { ?>
        <option value="<?php echo esc_attr( $hour ) ?>" <?php selected( $h, $hour ) ?>><?php echo $hour ?></option>
    <?php } ?>
</select> :
<select name="<?php echo esc_attr( $field_name ) ?>[m]" id="<?php echo esc_attr( $html_id ) ?>_m" <?php do_action( 'frm_field_input_html', $field ) ?>>
    <?php foreach ( $field['options']['m'] as $min ) { ?>
        <option value="<?php echo esc_attr( $min ) ?>" <?php selected( $m, $min ) ?>><?php echo $min ?></option>
    <?php } ?>
</select>
<?php   if ( isset($field['options']['A']) ) { ?>
<select name="<?php echo esc_attr( $field_name ) ?>[A]" id="<?php echo esc_attr( $html_id ) ?>_A" <?php do_action( 'frm_field_input_html', $field ) ?>>
    <?php foreach ( $field['options']['A'] as $am ) { ?>
        <option value="<?php echo esc_attr( $am ) ?>" <?php selected( $a, $am ) ?>><?php echo $am ?></option>
    <?php } ?>
</select>
<?php
        }
    } else {
?>
<select name="<?php echo esc_attr( $field_name ) ?>" id="<?php echo esc_attr( $html_id ) ?>" <?php do_action( 'frm_field_input_html', $field ) ?>>
    <?php foreach ( $field['options'] as $t ) { ?>
        <option value="<?php echo esc_attr( $t ) ?>" <?php selected( $field['value'], $t ) ?>><?php echo esc_html( $t ) ?></option>
    <?php } ?>
</select>
<?php
    }
} else if ( 'tag' == $field['type'] ) {
    if ( is_array($field['value']) ) {
        FrmProFieldsHelper::tags_to_list($field, $entry_id);
    }
?>
<input type="text" id="<?php echo esc_attr( $html_id ) ?>" name="<?php echo esc_attr( $field_name ) ?>" value="<?php echo esc_attr( $field['value'] ) ?>" <?php do_action( 'frm_field_input_html', $field ) ?>/>
<?php
} else if ( in_array($field['type'], array( 'number', 'password', 'range')) ) {
?>
<input type="<?php echo ( $frm_settings->use_html || $field['type'] == 'password' ) ? esc_attr( $field['type'] ) : 'text'; ?>" id="<?php echo esc_attr( $html_id ) ?>" name="<?php echo esc_attr( $field_name ) ?>" value="<?php echo esc_attr( $field['value'] ) ?>" <?php do_action( 'frm_field_input_html', $field ) ?>/>
<?php
} else if ( $field['type'] == 'phone' ) {
    $field['type'] = 'tel';
?>
<input type="<?php echo ( $frm_settings->use_html ) ? esc_attr( $field['type'] ) : 'text'; ?>" id="<?php echo esc_attr( $html_id ) ?>" name="<?php echo esc_attr( $field_name ) ?>" value="<?php echo esc_attr( $field['value'] ) ?>" <?php do_action( 'frm_field_input_html', $field ) ?>/>
<?php
    $field['type'] = 'phone';
} else if ($field['type'] == 'image' ) { ?>
<input type="<?php echo ($frm_settings->use_html) ? 'url' : 'text'; ?>" id="<?php echo esc_attr( $html_id ) ?>" name="<?php echo esc_attr( $field_name ) ?>" value="<?php echo esc_attr( $field['value'] ) ?>" <?php do_action( 'frm_field_input_html', $field ) ?>/>
<?php if ( $field['value'] ) {
        ?><img src="<?php echo esc_attr( $field['value'] ) ?>" height="50px" /><?php
    }

} else if ( $field['type'] == 'scale' ) {
    require(FrmAppHelper::plugin_path() .'/pro/classes/views/frmpro-fields/10radio.php');

	if ( FrmField::is_option_true( $field, 'star' ) ) {
        if ( ! isset($frm_vars['star_loaded']) || ! is_array($frm_vars['star_loaded']) ) {
            $frm_vars['star_loaded'] = array(true);
        }
    }

// Rich Text for back-end
} else if ( $field['type'] == 'rte' && FrmAppHelper::is_admin() ) { ?>
<div id="<?php echo user_can_richedit() ? 'postdivrich' : 'postdiv'; ?>" class="postarea frm_full_rte">
<?php
    wp_editor(str_replace('&quot;', '"', $field['value']), $html_id,
        array( 'dfw' => true, 'textarea_name' => $field_name)
    );
?>
</div>
<?php
// Rich text for front-end, including Preview page
} else if ($field['type'] == 'rte' ) {

    if ( ! isset($frm_vars['skip_rte']) || ! $frm_vars['skip_rte'] ) {
        $e_args = array( 'media_buttons' => false, 'textarea_name' => $field_name);
        if ( $field['max'] ) {
            $e_args['textarea_rows'] = $field['max'];
        }

        $e_args = apply_filters('frm_rte_options', $e_args, $field);

        if ( $field['size'] ) { ?>
<style type="text/css">#wp-field_<?php echo esc_attr( $field['field_key'] ) ?>-wrap{width:<?php echo $field['size'] . ( is_numeric($field['size']) ? 'px' : '' ); ?>;}</style><?php
        }

		wp_editor( str_replace( '&quot;', '"', $field['value'] ), $html_id, $e_args );

        // If submitting with Ajax or on preview page and tinymce is not loaded yet, load it now
        if ( ( FrmAppHelper::doing_ajax() || FrmAppHelper::is_preview_page() ) && ( ! isset($frm_vars['tinymce_loaded']) || ! $frm_vars['tinymce_loaded']) ) {
            add_action( 'wp_print_footer_scripts', '_WP_Editors::editor_js', 50 );
			add_action( 'wp_print_footer_scripts', '_WP_Editors::enqueue_scripts', 1 );
			$frm_vars['tinymce_loaded'] = true;
		}
        unset($e_args);
	} else {
?>
<textarea name="<?php echo esc_attr( $field_name ) ?>" id="<?php echo esc_attr( $html_id ) ?>" style="height:<?php echo ($field['max']) ? ( (int) $field['max'] * 17 ) : 125 ?>px;<?php
if ( ! $field['size'] ) {
    ?>width:<?php echo FrmStylesController::get_style_val('field_width');
} ?>" <?php do_action( 'frm_field_input_html', $field ) ?>><?php echo FrmAppHelper::esc_textarea($field['value']) ?></textarea>
<?php
    }
} else if ( $field['type'] == 'file' ) {

	if ( FrmField::is_read_only( $field ) ) {
        // Read only file upload field shows the entry without an upload button
        foreach ( (array) maybe_unserialize($field['value']) as $media_id ) {
            if ( ! is_numeric($media_id) ) {
                continue;
            }
?>
<input type="hidden" name="<?php
    echo esc_attr( $field_name );
	if ( FrmField::is_option_true( $field, 'multiple' ) ) {
        echo '[]';
    }
?>" value="<?php echo esc_attr($media_id) ?>" />
<div class="frm_file_icon"><?php echo FrmProFieldsHelper::get_file_icon($media_id); ?></div>
<?php
        }
	} else if ( FrmField::is_option_true( $field, 'multiple' ) ) {
		$media_ids = maybe_unserialize($field['value']);
		if ( ! is_array( $media_ids ) && strpos( $media_ids, ',' ) ) {
			$media_ids = explode(',', $media_ids);
		}

		foreach ( (array) $media_ids as $media_id ) {
			$media_id = trim($media_id);
            if ( ! is_numeric($media_id) ) {
                continue;
            }

            $media_id = (int) $media_id;
?>
<div id="frm_uploaded_<?php echo esc_attr( $media_id ) ?>" class="frm_uploaded_files">
<input type="hidden" name="<?php echo esc_attr( $field_name ) ?>[]" value="<?php echo esc_attr( $media_id ) ?>" />
<div class="frm_file_icon"><?php echo FrmProFieldsHelper::get_file_icon( $media_id ); ?></div>
<a href="javascript:void(0)" class="frm_remove_link"><?php _e( 'Remove', 'formidable' ) ?></a>
</div>
<?php
		    unset($media_id);
	    }
        unset($media_ids);

        if ( empty($field_value) ) { ?>
<input type="hidden" name="<?php echo esc_attr( $field_name ) ?>[]" value="" />
<?php   } ?>

<input type="file" data-fid="<?php echo esc_attr( $field['id'] ) ?>" multiple="multiple" name="<?php echo esc_attr( $file_name ); ?>[]" id="<?php echo esc_attr( $html_id ) ?>" <?php do_action( 'frm_field_input_html', $field ) ?> />
<?php
    } else {
        // single upload field
?>
<input type="file" name="<?php echo esc_attr( $file_name ) ?>" id="<?php echo esc_attr( $html_id ) ?>" <?php do_action( 'frm_field_input_html', $field ) ?> /><br/>
<input type="hidden" name="<?php echo esc_attr( $field_name ) ?>" value="<?php echo esc_attr( is_array($field['value']) ? reset( $field['value'] ) : $field['value'] ) ?>" />
<?php
        echo FrmProFieldsHelper::get_file_icon($field['value']);
    }

    include_once(FrmAppHelper::plugin_path() .'/pro/classes/views/frmpro-entries/loading.php');

} else if ( $field['type'] == 'data' ) { ?>
<div class="frm_data_field_container">
<?php require(FrmAppHelper::plugin_path() .'/pro/classes/views/frmpro-fields/data-options.php'); ?>
</div>
<?php

} else if ( $field['type'] == 'form' ) {
    if ( ! is_numeric($field['form_select']) ) {
        return;
    }

    if ( ! isset($errors) ) {
        $errors = array();
    }

    FrmProFormsHelper::get_sub_form($field_name, $field, array(
        'errors' => $errors, 'repeat' => 0,
    ));

} else if ( 'divider' == $field['type'] ) {
    FrmProFormsHelper::get_sub_form($field_name, $field, array(
        'errors' => $errors, 'repeat' => 5,
    ));
}
