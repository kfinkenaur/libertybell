<?php

class FrmProEntriesHelper{

    // check if form should automatically be in edit mode (limited to one, has draft)
    public static function &allow_form_edit($action, $form) {
        if ( $action != 'new' ) {
            // make sure there is an entry id in the url if the action is being set in the url
			$entry_id = FrmAppHelper::simple_get( 'entry', 'sanitize_title', 0 );
            if ( empty($entry_id) && ( ! $_POST || ! isset($_POST['frm_action']) ) ) {
                $action = 'new';
            }
        }

        $user_ID = get_current_user_id();
        if ( ! $form || ! $user_ID ) {
            return $action;
        }

        if ( ! $form->editable ) {
            $action = 'new';
        }

        $is_draft = false;
        if($action == 'destroy')
            return $action;

        global $wpdb;
		if ( ( $form->editable && ( isset( $form->options['single_entry'] ) && $form->options['single_entry'] && $form->options['single_entry_type'] == 'user' ) || ( isset( $form->options['save_draft'] ) && $form->options['save_draft'] ) ) ) {
			if ( $action == 'update' && $form->id == FrmAppHelper::get_param( 'form_id', '', 'get', 'absint' ) ) {
                //don't change the action is this is the wrong form
            }else{
                $checking_drafts = isset($form->options['save_draft']) && $form->options['save_draft'] && ( ! $form->editable || ! isset($form->options['single_entry']) || ! $form->options['single_entry'] || $form->options['single_entry_type'] != 'user' );
                $meta = self::check_for_user_entry($user_ID, $form, $checking_drafts);

                if ( $meta ) {
                    if ( $checking_drafts ) {
                        $is_draft = 1;
                    }

                    $action = 'edit';
                }
            }
        }

        //do not allow editing if user does not have permission
        if ( $action != 'edit' || $is_draft ) {
            return $action;
        }

        $entry = FrmAppHelper::get_param('entry', 0);

        if ( ! self::user_can_edit($entry, $form) ) {
            $action = 'new';
        }

        return $action;
    }

    /**
     * Check if the current user already has an entry
     * @since 2.0
     */
    public static function check_for_user_entry( $user_ID, $form, $is_draft ) {
        $query = array( 'user_id' => $user_ID, 'form_id' => $form->id);
        if ( $is_draft ) {
            $query['is_draft'] = 1;
        }

		return FrmDb::get_col( 'frm_items', $query );
    }

    public static function user_can_edit( $entry, $form = false ) {
        if ( empty($form) ) {
			FrmEntry::maybe_get_entry( $entry );

            if ( is_object($entry) ) {
                $form = $entry->form_id;
            }
        }

		FrmForm::maybe_get_form( $form );

        $allowed = self::user_can_edit_check($entry, $form);
        return apply_filters('frm_user_can_edit', $allowed, compact('entry', 'form'));
    }

    public static function user_can_edit_check($entry, $form) {
        $user_ID = get_current_user_id();

        if ( ! $user_ID || empty($form) || ( is_object($entry) && $entry->form_id != $form->id ) ) {
            return false;
        }

        if ( is_object($entry) ) {
            if ( ( $entry->is_draft && $entry->user_id == $user_ID ) || self::user_can_edit_others( $form ) ) {
                //if editable and user can edit this entry
                return true;
            }
        }

		$where = array( 'fr.id' => $form->id );

        if ( self::user_can_only_edit_draft($form) ) {
            //only allow editing of drafts
			$where['user_id'] = $user_ID;
			$where['is_draft'] = 1;
        }

        if ( ! self::user_can_edit_others( $form ) ) {
			$where['user_id'] = $user_ID;

            if ( is_object($entry) && $entry->user_id != $user_ID ) {
                return false;
            }

			// Check if open_editable_role and editable_role is set for reverse compatibility
			if ( $form->editable && isset( $form->options['open_editable_role'] ) && ! FrmAppHelper::user_has_permission( $form->options['open_editable_role'] ) && isset( $form->options['editable_role'] ) && ! FrmAppHelper::user_has_permission( $form->options['editable_role'] ) ) {
                // make sure user cannot edit their own entry, even if a higher user role can unless it's a draft
                if ( is_object($entry) && ! $entry->is_draft ) {
                    return false;
                } else if ( ! is_object($entry) ) {
					$where['is_draft'] = 1;
                }
            }
        } else if ( $form->editable && $user_ID && empty($entry) ) {
            // make sure user is editing their own draft by default, even if they have permission to edit others' entries
		   $where['user_id'] = $user_ID;
        }

        if ( ! $form->editable ) {
			$where['is_draft'] = 1;

            if ( is_object($entry) && ! $entry->is_draft ) {
                return false;
            }
        }

        // If entry object, and we made it this far, then don't do another db call
        if ( is_object($entry) ) {
            return true;
        }

		if ( ! empty($entry) ) {
			$where_key = is_numeric($entry) ? 'it.id' : 'item_key';
			$where[ $where_key ] = $entry;
		}

        return FrmEntry::getAll( $where, ' ORDER BY created_at DESC', 1, true);
    }

    /**
     * check if this user can edit entry from another user
     * @return boolean True if user can edit
     */
    public static function user_can_edit_others( $form ) {
        if ( ! $form->editable || ! isset($form->options['open_editable_role']) || ! FrmAppHelper::user_has_permission($form->options['open_editable_role']) ) {
            return false;
        }

        return ( ! isset($form->options['open_editable']) || $form->options['open_editable'] );
    }

    /**
     * only allow editing of drafts
     * @return boolean
     */
    public static function user_can_only_edit_draft($form) {
        if ( ! $form->editable || empty($form->options['editable_role']) || FrmAppHelper::user_has_permission($form->options['editable_role']) ) {
            return false;
        }

        if ( isset($form->options['open_editable_role']) && $form->options['open_editable_role'] != '-1' ) {
            return false;
        }

        return ! self::user_can_edit_others( $form );
    }

    public static function user_can_delete($entry) {
		FrmEntry::maybe_get_entry( $entry );
        if ( ! $entry ) {
            return false;
        }

        if ( current_user_can('frm_delete_entries') ) {
            $allowed = true;
        } else {
            $allowed = self::user_can_edit($entry);
            if ( !empty($allowed) ) {
                $allowed = true;
            }
        }

        return apply_filters('frm_allow_delete', $allowed, $entry);
    }

    public static function show_new_entry_button($form) {
        echo self::new_entry_button($form);
    }

    public static function new_entry_button($form) {
        if ( ! current_user_can('frm_create_entries') ) {
            return;
        }

        $link = '<a href="?page=formidable-entries&frm_action=new';
        if ( $form ) {
            $form_id = is_numeric($form) ? $form : $form->id;
            $link .= '&form='. $form_id;
        }
        $link .= '" class="add-new-h2">'. __( 'Add New', 'formidable' ) .'</a>';

        return $link;
    }

    public static function show_duplicate_link($entry) {
        echo self::duplicate_link($entry);
    }

    public static function duplicate_link($entry) {
        if ( current_user_can('frm_create_entries') ) {
            $link = '<a href="?page=formidable-entries&frm_action=duplicate&form='. $entry->form_id .'&id='. $entry->id .'" class="button-secondary alignright">'. __( 'Duplicate', 'formidable' ) .'</a>';
            return $link;
        }
    }

    public static function edit_button() {
        if ( ! current_user_can('frm_edit_entries') ) {
            return;
        }
?>
	    <div id="publishing-action">
			<a href="<?php echo esc_url( add_query_arg( 'frm_action', 'edit' ) ) ?>" class="button-primary"><?php _e( 'Edit', 'formidable' ) ?></a>
        </div>
<?php
    }

    public static function resend_email_links($entry_id, $form_id, $args = array()) {
        $defaults = array(
            'label' => __( 'Resend Email Notifications', 'formidable' ),
            'echo' => true,
        );

        $args = wp_parse_args($args, $defaults);

		$link = '<a href="#" data-eid="' . esc_attr( $entry_id ) . '" data-fid="' . esc_attr( $form_id ) . '" id="frm_resend_email" title="' . esc_attr( $args['label'] ) . '">' . $args['label'] . '</a>';
        if ( $args['echo'] ) {
            echo $link;
        }
        return $link;
    }

    public static function before_table( $footer, $form_id = false ) {
		if ( FrmAppHelper::simple_get( 'page', 'sanitize_title' ) != 'formidable-entries' ) {
            return;
        }

        if ( $footer ) {
            if ( apply_filters('frm_show_delete_all', current_user_can('frm_edit_entries'), $form_id) ) {
            ?><div class="frm_uninstall alignleft actions"><a href="?page=formidable-entries&amp;frm_action=destroy_all<?php echo $form_id ? '&amp;form='. (int) $form_id : '' ?>" class="button" onclick="return confirm('<?php esc_attr_e( 'Are you sure you want to permanently delete ALL the entries in this form?', 'formidable' ) ?>')"><?php _e( 'Delete ALL Entries', 'formidable' ) ?></a></div>
<?php
            }
            return;
        }

        $page_params = array( 'frm_action' => 0, 'action' => 'frm_entries_csv', 'form' => $form_id);

        if ( !empty( $_REQUEST['s'] ) )
            $page_params['s'] = sanitize_text_field( $_REQUEST['s'] );

        if ( !empty( $_REQUEST['search'] ) )
            $page_params['search'] = sanitize_text_field( $_REQUEST['search'] );

    	if ( !empty( $_REQUEST['fid'] ) )
    	    $page_params['fid'] = (int) $_REQUEST['fid'];

        ?>
        <div class="alignleft actions"><a href="<?php echo esc_url(add_query_arg($page_params, admin_url( 'admin-ajax.php' ))) ?>" class="button"><?php _e( 'Download CSV', 'formidable' ); ?></a></div>
        <?php
    }

    // check if entry being updated just switched draft status
    public static function is_new_entry($entry) {
		FrmEntry::maybe_get_entry( $entry );

        // this function will only be correct if the entry has already gone through FrmProEntriesController::check_draft_status
        return ( $entry->created_at == $entry->updated_at );
    }

    public static function get_field($field = 'is_draft', $id) {
        $entry = FrmAppHelper::check_cache( $id, 'frm_entry' );
        if ( $entry && isset($entry->$field) ) {
            return $entry->{$field};
        }

		$var = FrmDb::get_var( 'frm_items', array( 'id' => $id ), $field );

        return $var;
    }

	public static function get_dfe_values( $field, $entry, &$field_value ) {
		_deprecated_function( __FUNCTION__, '2.0.08', 'FrmProEntriesHelper::get_dynamic_list_values' );
		return FrmProEntriesHelper::get_dynamic_list_values( $field, $entry, $field_value );
	}

	/**
	* Get the values for Dynamic List fields based on the conditional logic settings
	*
	* @since 2.0.08
	* @param object $field
	* @param object $entry
	* @param string|array|int $field_value, pass by reference
	*/
	public static function get_dynamic_list_values( $field, $entry, &$field_value ) {
		// Exit now if a value is already set, field type is not Dynamic List, or conditional logic is not set
		if ( $field_value || $field->type != 'data' || ! FrmProField::is_list_field( $field ) || ! isset( $field->field_options['hide_field'] ) ) {
			return;
		}

		$field_value = array();
		foreach ( (array) $field->field_options['hide_field'] as $hfield ) {
			if ( isset( $entry->metas[ $hfield ] ) ) {
				// Check if field in conditional logic is a Dynamic field
				$cl_field_type = FrmField::get_type( $hfield );
				if ( $cl_field_type == 'data' ) {
					$cl_field_val = maybe_unserialize( $entry->metas[ $hfield ] );
					if ( is_array( $cl_field_val ) ) {
						$field_value += $cl_field_val;
					} else {
						$field_value[] = $cl_field_val;
					}
				}
			}
		}
	}

	public static function get_search_str( $where_clause = '', $search_str, $form_id = 0, $fid = 0 ) {
        if ( ! is_array($search_str) ) {
            $search_str = explode(' ', $search_str);
        }

        $add_where = array();

        foreach ( $search_str as $search_param ) {
            self::add_entry_meta_query( $fid, $form_id, $search_param, $add_where );
            self::add_entry_col_query( $fid, $search_param, $add_where );
        }

        if ( ! empty( $add_where ) ) {
			self::add_where_to_query( $add_where, $where_clause );
        }

        return $where_clause;
    }

    private static function add_entry_col_query( $fid, $search_param, &$add_where ) {
        if ( is_numeric( $fid ) ) {
            return;
        }

        $add_where['or'] = 1;

        if ( in_array( $fid, array( 'created_at', 'updated_at') ) ) {
            $add_where['it.'. $fid .' like'] = $search_param;
        } else if ( in_array( $fid, array( 'user_id', 'id') ) ) {
            if ( $fid == 'user_id' && ! is_numeric( $search_param ) ) {
                $search_param = FrmAppHelper::get_user_id_param( $search_param );
            }

            $add_where['it.' . $fid . ' like'] = $search_param;
        } else {
            $add_where['it.name like']      = $search_param;
            $add_where['it.item_key like']  = $search_param;
            $add_where['it.description like'] = $search_param;
            $add_where['it.created_at like'] = $search_param;
        }
    }

    /**
     * Check the entry meta for the search term
     *
     * @param int $fid The id of the field we are searching
     * @param int|false $form_id The id of the form we are searching or false
     * @param string $search_param One word of the search
     * @param array $add_where By reference. An array of queries for this search
     */
    private static function add_entry_meta_query( $fid, $form_id, $search_param, &$add_where ) {
		$get_entry_ids = array();

        if ( empty( $fid ) ) {
            $add_where['or'] = 1;
        } else if ( is_numeric( $fid ) ) {
            $get_entry_ids['field_id'] = $fid;
        } else {
            return;
        }

        $where_entries_array = array( 'or' => 1, 'meta_value like' => $search_param );

        if ( $form_id ) {
            $get_entry_ids['fi.form_id'] = $form_id;
            self::add_linked_field_query( $fid, $form_id, $search_param, $where_entries_array );
        }

        $get_entry_ids[] = $where_entries_array;

        unset( $where_entries_array );

        if ( FrmAppHelper::is_admin_page('formidable-entries') ) {
            // Search both drafts and non-drafts when on the back-end
            $include_drafts = 'both';
        } else {
            $include_drafts = false;
        }

        $meta_ids = FrmEntryMeta::getEntryIds( $get_entry_ids, '', '', true, array( 'is_draft' => $include_drafts));
        if ( empty( $meta_ids ) ) {
            $meta_ids = 0;
        }

        if ( isset($add_where['it.id']) ) {
            $add_where['it.id'] = array_merge( (array) $add_where['it.id'], (array) $meta_ids );
        } else {
            $add_where['it.id'] = $meta_ids;
        }
    }

	/**
	 * @since 2.0.8
	 */
	private static function add_where_to_query( $add_where, &$where_clause ) {
		if ( is_array( $where_clause ) ) {
			$where_clause[] = $add_where;
		} else {
			global $wpdb;
			$where = '';
			$values = array();
			FrmDb::parse_where_from_array( $add_where, '', $where, $values );
			FrmDb::get_where_clause_and_values( $add_where );
			$where_clause .= ' AND ('. $wpdb->prepare( $where, $values ) .')';
        }
	}

    /**
     * Check linked entries for the search query
     */
    private static function add_linked_field_query( $fid, $form_id, $search_param, &$where_entries_array ) {
        $data_fields = FrmProFormsHelper::has_field( 'data', $form_id, false );
        if ( empty ( $data_fields ) ) {
            // this form has no linked fields
            return;
        }

        $df_form_ids = array();

        //search the joined entry too
        foreach ( (array) $data_fields as $df ) {
            //don't check if a different field is selected
            if ( is_numeric( $fid ) && (int) $fid != $df->id ) {
                continue;
            }

            FrmProFieldsHelper::get_subform_ids( $df_form_ids, $df );

            unset( $df );
        }
        unset( $data_fields );

        if ( empty( $df_form_ids ) ) {
            return;
        }

        $data_form_ids = FrmDb::get_col( 'frm_fields', array( 'id' => $df_form_ids), 'form_id' );

        if ( $data_form_ids ) {
            $data_entry_ids = FrmEntryMeta::getEntryIds( array( 'fi.form_id' => $data_form_ids, 'meta_value LIKE' => $search_param ),  '', '', true, array( 'is_draft' => 'both' ) );
            if ( ! empty( $data_entry_ids ) ) {
                if ( count($data_entry_ids) == 1 ) {
                    $where_entries_array['meta_value like'] = reset( $data_entry_ids );
                } else {
                    $where_entries_array['meta_value'] = $data_entry_ids;
                }
            }
        }
    }

	public static function get_search_ids( $s, $form_id, $args = array() ) {
        global $wpdb;

		if ( empty( $s ) ) {
			return false;
		}

		preg_match_all('/".*?("|$)|((?<=[\\s",+])|^)[^\\s",+]+/', $s, $matches);
		$search_terms = array_map('trim', $matches[0]);

        $spaces = '';
        $e_ids = $p_search = array();
		$search = array( 'or' => 1 );

        $data_field = FrmProFormsHelper::has_field('data', $form_id, false);

		foreach ( (array) $search_terms as $term ) {
			$p_search[] = array(
				$spaces . $wpdb->posts . '.post_title like' => $term,
				$spaces . $wpdb->posts . '.post_content like' => $term,
				'or' => 1, // search with an OR
			);

			$search[ $spaces . 'meta_value like' ] = $term;
			$spaces .= ' '; // add a space to keep the array keys unique

			if ( is_numeric( $term ) ) {
                $e_ids[] = (int) $term;
			}

			if ( $data_field ) {
                $df_form_ids = array();

                //search the joined entry too
                foreach ( (array) $data_field as $df ) {
                    FrmProFieldsHelper::get_subform_ids($df_form_ids, $df);

                    unset($df);
                }

                $data_form_ids = FrmDb::get_col( $wpdb->prefix .'frm_fields', array( 'id' => $df_form_ids), 'form_id' );
                unset($df_form_ids);

				if ( $data_form_ids ) {
					$data_entry_ids = FrmEntryMeta::getEntryIds( array( 'fi.form_id' => $data_form_ids, 'meta_value like' => $term ) );
					if ( $data_entry_ids ) {
						if ( ! isset( $search['meta_value'] ) ) {
							$search['meta_value'] = array();
						}
						$search['meta_value'] = array_merge( $search['meta_value'], $data_entry_ids );
					}
                }

                unset($data_form_ids);
            }
		}

		$matching_posts = FrmDb::get_col( $wpdb->posts, $p_search, 'ID' );
		$p_ids = array( $search, 'or' => 1 );
		if ( $matching_posts ) {
			$post_ids = FrmDb::get_col( $wpdb->prefix .'frm_items', array( 'post_id' => $matching_posts, 'form_id' => (int) $form_id) );
			if ( $post_ids ) {
				$p_ids['item_id'] = $post_ids;
			}
		}

		if ( ! empty( $e_ids ) ) {
			$p_ids['item_id'] = $e_ids;
		}

		$query = array( 'fi.form_id' => $form_id );
		$query[] = $p_ids;

		return FrmEntryMeta::getEntryIds( $query, '', '', true, $args );
    }

	public static function generate_csv( $form, $entry_ids, $form_cols ) {
		_deprecated_function( __FUNCTION__, '2.0.8', 'FrmProCSVHelper::generate_csv');
		FrmProCSVHelper::generate_csv( compact( 'form', 'entry_ids', 'form_cols' ) );
	}

	public static function csv_headings() {
		_deprecated_function( __FUNCTION__, '2.0.8' );
	}

	public static function add_repeat_field_values_to_csv() {
		_deprecated_function( __FUNCTION__, '2.0.8' );
	}

	public static function add_field_values_to_csv() {
		_deprecated_function( __FUNCTION__, '2.0.8' );
	}

	public static function add_comments_to_csv() {
		_deprecated_function( __FUNCTION__, '2.0.8' );
	}

	public static function add_entry_data_to_csv() {
		_deprecated_function( __FUNCTION__, '2.0.8' );
	}

	public static function print_csv_row() {
		_deprecated_function( __FUNCTION__, '2.0.8' );
	}

	public static function encode_value( $line ) {
		_deprecated_function( __FUNCTION__, '2.0.8', 'FrmProCSVHelper::encode_value');
		return FrmProCSVHelper::encode_value( $line );
	}

	public static function escape_csv( $value ) {
		_deprecated_function( __FUNCTION__, '2.0.8', 'FrmProCSVHelper::escape_csv');
		return FrmProCSVHelper::escape_csv( $value );
	}
}
