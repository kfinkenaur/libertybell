<?php
/*
 *      Swiftsignature envelopes
 */

function ssign_envelopes_cb() {
    global $wpdb;
    $tbl_envelope = $wpdb->prefix . 'ssign_envelope';
    if (isset($_POST['save_ssign_add_envelope']) && wp_verify_nonce($_POST['save_ssign_add_envelope'], 'save_ssign_add_envelope')) {
        $env_name = trim($_POST['env_name']);
        $env_insert = $wpdb->insert($tbl_envelope, array('envelope_name' => $env_name, 'date_time' => date("Y-m-d H:i:s")), array('%s', '%s'));
        if ($env_insert) {
            $last_insert_id = $wpdb->insert_id;
            wp_redirect(home_url() . "/wp-admin/admin.php?page=ss_envelope_detail&id=" . $last_insert_id);
            die;
        }
    }
    $envelope_listing = $wpdb->get_results("SELECT * FROM `$tbl_envelope`");
    ?>
    <div class="wrap">
        <h2 style="display: inline-block;">Envelopes</h2>
        <h1 style="text-align: center;display: inline-block;width: 80%;">Coming Soon</h1>
        <div class="clear"></div>
        <hr/>
        <?php if (isset($_GET['update']) && !empty($_GET['update'])) { ?>
            <div id="message" class="notice notice-success below-h2">
                <?php
                if ($_GET['update'] == 1) {
                    echo "<p>Envelope inserted successfully.</p>";
                } else if ($_GET['update'] == 2) {
                    echo "<p>Envelope updated successfully.</p>";
                } else if ($_GET['update'] == 3) {
                    echo "<p>Envelope deleted successfully.</p>";
                }
                ?>

            </div>
        <?php } ?>
        <div class="inner_content">
            <p>envelopes are multiple docs that must be signed together.</p>
            <div class="ssign-add-new-wrap">
                <button class="button button-orange ssign-btn-add-new-envelope" data-btn="add" data-modal="#ssign_envelopes_modal"><span class="dashicons dashicons-plus"></span> Add New</button>
            </div>
            <table class="wp-list-table widefat fixed striped ssign-envelopes">
                <thead>
                    <tr>
                        <th>Envelope Name</th>
                        <th>Docs</th>
                        <th>Shortcodes</th>
                        <th width="80px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($envelope_listing)) {
                        foreach ($envelope_listing as $env_data) {
                            ?>
                            <tr>
                                <td><a href="<?php echo home_url() . "/wp-admin/admin.php?page=ss_envelope_detail&id=" . $env_data->envelope_id; ?>"><?php echo $env_data->envelope_name; ?></a></td>
                                <td>--</td>
                                <td><input type="text" readonly="readonly" onclick="this.select();" value='[swiftsign_envelope id="<?php echo $env_data->envelope_id; ?>"]'/></td>
                                <td>
                                    <a class="ssign-round-bg ssign-envelope-edit" href="<?php echo home_url() . "/wp-admin/admin.php?page=ss_envelope_detail&id=" . $env_data->envelope_id; ?>" data-env-id="<?php echo $env_data->envelope_id; ?>" data-btn="edit" data-modal="#ssign_envelopes_modal"><span class="dashicons dashicons-edit"></span></a>
                                    <a class="ssign-round-bg ssign-envelope-delete" href="#" data-env-id="<?php echo $env_data->envelope_id; ?>"><span class="dashicons dashicons-no-alt"></span></a>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="4"><h3>No envelope found!</h3></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="ssign_modal ssign_modal_envelope" id="ssign_envelopes_modal">
        <div class="ssign_modal_container">
            <form method="post" id="frm_ssign_envelope" name="frm_ssign_comparison_grid">
                <div class="ssign_modal_header">
                    <h2 class="ssign_modal_title">Add Comparison envelope</h2>
                    <span class="dashicons dashicons-no ssign_modal_close"></span>
                </div>
                <div class="ssign_modal_content">
                    <div class="ssign-form-control">
                        <label for="env_name">Name</label>
                        <input type="text" id="env_name" class="regular-text" name="env_name" required="required" />
                    </div>
                </div>
                <div class="ssign_modal_footer textright">
                    <?php wp_nonce_field('save_ssign_add_envelope', 'save_ssign_add_envelope') ?>
                    <button type="submit" name="ssign_add_envelope" id="ssign_add_envelope" class="ssign-modal-btn button button-primary" />Add</button>
                </div>
            </form>
        </div>
    </div>
    <?php
}
?>