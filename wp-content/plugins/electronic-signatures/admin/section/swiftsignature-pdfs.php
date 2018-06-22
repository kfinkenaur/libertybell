<?php
/*
 *      Swiftsignature Envelopes
 */

function ssign_pdfs_cb() {
    global $wpdb;
    $tbl_pdf = $wpdb->prefix . 'ssign_pdfs';

    if (isset($_POST['btn_pdf']) && !empty($_POST['btn_pdf']) && $_POST['btn_pdf'] == 'Add') {
        $pdf_name = $_POST['pdf_name'];
        $pdf_insert = $ufiles = "";

        if ($_FILES['pdf_file']['size'] > 0) {
            if (!function_exists('wp_handle_upload')) {
                require_once( ABSPATH . 'wp-admin/includes/file.php');
            }
            $upload_overrides = array('test_form' => false);
            $img_ext = array('application/pdf');
            $pdf_file = $_FILES['pdf_file'];

            if (in_array($pdf_file['type'], $img_ext)) {
                if ($pdf_file['name']) {
                    $random = mt_rand(100000, 999999);
                    $uploadedfile = array(
                        'name' => $random . "_" . $pdf_file['name'],
                        'type' => $pdf_file['type'],
                        'tmp_name' => $pdf_file['tmp_name'],
                        'error' => $pdf_file['error'],
                        'size' => $pdf_file['size']
                    );
                    $movefile = wp_handle_upload($uploadedfile, $upload_overrides);
                    if ($movefile && !isset($movefile['error'])) {
                        if (empty($ufiles))
                            $ufiles = array();

                        $ufiles = $movefile;
                    }
                }
                $pdf_insert = $wpdb->insert($tbl_pdf, array('pdf_name' => $pdf_name, 'pdf_url' => $ufiles['url'], 'pdf_path' => $ufiles['file'], 'date_time' => date("Y-m-d H:i:s")), array('%s', '%s', '%s','%s'));
                if ($pdf_insert) {
                    $last_insert_id = $wpdb->insert_id;
                    $pdf_shortcode = '[swiftsign pdf="' . $last_insert_id . '"]';
                    $update = $wpdb->update($tbl_pdf, array('pdf_shortcode' => $pdf_shortcode), array('pdf_id' => $last_insert_id), array('%s'), array('%d'));
                }
                if ($update) {
                    wp_redirect(home_url() . "/wp-admin/admin.php?page=ss_pdfs&update=1");
                    die;
                }
            } else {
                wp_redirect(home_url() . "/wp-admin/admin.php?page=ss_pdfs&error=1");
                die;
            }
        } else {
            wp_redirect(home_url() . "/wp-admin/admin.php?page=ss_pdfs&error=2");
            die;
        }
    }

    /*
     *      Update
     */
    if (isset($_POST['btn_pdf']) && !empty($_POST['btn_pdf']) && $_POST['btn_pdf'] == 'Update') {
        $pdf_name = $_POST['pdf_name'];

        $pdf_id = $_POST['pdf_id'];
        $pdf_insert = $ufiles = "";
        $pdf_url = $_POST['pdf_url'];
        $pdf_path = $_POST['pdf_path'];

        if ($_FILES['pdf_file']['size'] > 0) {
            if (!function_exists('wp_handle_upload')) {
                require_once( ABSPATH . 'wp-admin/includes/file.php');
            }
            $upload_overrides = array('test_form' => false);
            $img_ext = array('application/pdf');
            $pdf_file = $_FILES['pdf_file'];

            if (in_array($pdf_file['type'], $img_ext)) {
                unlink($pdf_path);
                if ($pdf_file['name']) {
                    $random = mt_rand(100000, 999999);
                    $uploadedfile = array(
                        'name' => $random . "_" . $pdf_file['name'],
                        'type' => $pdf_file['type'],
                        'tmp_name' => $pdf_file['tmp_name'],
                        'error' => $pdf_file['error'],
                        'size' => $pdf_file['size']
                    );
                    $movefile = wp_handle_upload($uploadedfile, $upload_overrides);
                    if ($movefile && !isset($movefile['error'])) {
                        if (empty($ufiles))
                            $ufiles = array();

                        $ufiles = $movefile;
                        $pdf_url = $ufiles['url'];
                        $pdf_path = $ufiles['file'];
                    }
                }
                $pdf_update = $wpdb->update($tbl_pdf, array('pdf_name' => $pdf_name, 'pdf_url' => $pdf_url, 'pdf_path' => $pdf_path,), array('pdf_id' => $pdf_id), array('%s', '%s'), array('%d'));
                if ($pdf_update) {
                    wp_redirect(home_url() . "/wp-admin/admin.php?page=ss_pdfs&update=2");
                    die;
                }
            } else {
                wp_redirect(home_url() . "/wp-admin/admin.php?page=ss_pdfs&error=1");
                die;
            }
        } else {
            wp_redirect(home_url() . "/wp-admin/admin.php?page=ss_pdfs&error=2");
            die;
        }
    }

    /*
     *      Delete pdf
     */
    if (isset($_POST['ssign_delete_pdf']) && wp_verify_nonce($_POST['ssign_delete_pdf'], 'ssign_delete_pdf')) {
        if (!empty($_POST['pdf_id'])) {
            $pdf_id = $_POST['pdf_id'];
            $get_pdf_results = $wpdb->get_row("SELECT * FROM `$tbl_pdf` WHERE `pdf_id`=$pdf_id", ARRAY_A);
            unlink($get_pdf_results['pdf_path']);
            $del_pdf = $wpdb->delete($tbl_pdf, array('pdf_id' => $_POST['pdf_id']), array('%d'));
        }
        if ($del_pdf) {
            wp_redirect(home_url() . "/wp-admin/admin.php?page=ss_pdfs&update=3");
            die;
        }
    }

    $get_pdf_results = $wpdb->get_results("SELECT * FROM `$tbl_pdf`");
    ?>
    <div class="wrap">
        <h2>PDFs</h2><hr/>
        <?php if (isset($_GET['error']) && !empty($_GET['error'])) { ?>
            <div id="message" class="notice notice-error below-h2">
                <?php
                if ($_GET['error'] == 1) {
                    echo "<p>Invalid PDF formate.</p>";
                } else if ($_GET['error'] == 2) {
                    echo "<p>No PDF selected.</p>";
                }
                ?>
            </div>
        <?php } ?>
        <?php if (isset($_GET['update']) && !empty($_GET['update'])) { ?>
            <div id="message" class="notice notice-success below-h2">
                <?php
                if ($_GET['update'] == 1) {
                    echo "<p>PDF inserted successfully.</p>";
                } else if ($_GET['update'] == 2) {
                    echo "<p>PDF updated successfully.</p>";
                } else if ($_GET['update'] == 3) {
                    echo "<p>PDF deleted successfully.</p>";
                }
                ?>

            </div>
        <?php } ?>
        <div class="inner_content">
            <div class="ssign-add-new-wrap">
                <button class="button button-orange ssign-btn-add-new" data-btn="add" data-modal="#ssign_files_modal"><span class="dashicons dashicons-plus"></span> Add New</button>
            </div>
            <form method="post" id="frm_table_pdf">
                <?php wp_nonce_field('ssign_delete_pdf', 'ssign_delete_pdf') ?>
                <table class="wp-list-table widefat fixed striped ssign-files">
                    <thead>
                        <tr>
                            <th>File Name</th>
                            <th>Pages</th>
                            <th>Shortcodes</th>
                            <th width="80px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($get_pdf_results)) {
                            foreach ($get_pdf_results as $pdf_data) {
                                ?>
                                <tr>
                                    <td><?php echo (!empty($pdf_data->pdf_name) ? $pdf_data->pdf_name : '-'); ?></td>
                                    <td><?php echo '-'; ?></td>
                                    <td><input type="text" readonly="readonly" onclick="this.select();" value='[swiftsign_pdf doc="<?php echo $pdf_data->pdf_id; ?>"]' /></td>
                                    <td>
                                        <input type="hidden" name="pdf_id" class="pdf_id" value="<?php echo $pdf_data->pdf_id; ?>" />
                                        <a class="ssign-round-bg ssign-edit" href="#" data-pdf-id="<?php echo $pdf_data->pdf_id; ?>" data-btn="edit" data-modal="#ssign_files_modal"><span class="dashicons dashicons-edit"></span></a>
                                        <a class="ssign-round-bg ssign-delete" href="#" data-pdf-id="<?php echo $pdf_data->pdf_id; ?>"><span class="dashicons dashicons-no-alt"></span></a>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="4" style='text-align: center;'><h3>No PDFs found!</h3></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>

    <div class="ssign_modal ssign_modal_files" id="ssign_files_modal">
        <div class="ssign_modal_container">
            <form method="post" id="frm_ssign_pdfs" name="frm_ssign_pdfs" enctype="multipart/form-data">
                <div class="ssign_modal_header">
                    <h2 class="ssign_modal_title">Add File</h2>
                    <span class="dashicons dashicons-no ssign_modal_close"></span>
                </div>
                <div class="ssign_modal_content">
                    <div class="ssign-form-control">
                        <label for="pdf_name">Name / Label <span class="dashicons dashicons-editor-help ttip" title="Just for you for reference - will not display online"></span></label>
                        <input type="text" class="regular-text" name="pdf_name" id="pdf_name" />
                    </div>
                    <div class="ssign-form-control">
                        <label for="pdf_file">Upload PDF</label>
                        <input type="file" name="pdf_file" id="pdf_file" />
                    </div>
                </div>
                <div class="ssign_modal_footer textright">
                    <button type="submit" name="btn_pdf" id="btn_pdf" class="ssign-modal-btn button button-primary"/>Add PDF</button>
                </div>
            </form>
        </div>
    </div>
    <?php
}

/*
 *      Edit pdf
 */
add_action('wp_ajax_swift_sign_edit_pdf', 'swift_sign_edit_pdf_callback');
add_action('wp_ajax_nopriv_swift_sign_edit_pdf', 'swift_sign_edit_pdf_callback');

function swift_sign_edit_pdf_callback() {
    if (isset($_POST['action']) && !empty($_POST['action']) && $_POST['action'] == 'swift_sign_edit_pdf') {
        global $wpdb;
        $tbl_pdf = $wpdb->prefix . 'ssign_pdfs';

        $pdf_id = $_POST['data'];

        if (!empty($pdf_id)) {
            $get_pdf_results = $wpdb->get_row("SELECT * FROM `$tbl_pdf` WHERE `pdf_id`=$pdf_id", ARRAY_A);
            print_r(json_encode($get_pdf_results));
        }
    }
    wp_die();
}
?>