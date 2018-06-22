<?php
/*
 *      Envelope Add
 */

function ss_envelope_detail_cb() {
    global $wpdb;
    $tbl_envelope = $wpdb->prefix . 'ssign_envelope';
    $get_envelope = '';

    /** Add envelope * */
//    if (isset($_POST['save_ssign_add_envelope_add']) && wp_verify_nonce($_POST['save_ssign_add_envelope_add'], 'save_ssign_add_envelope_add')) {
//        $env_name = trim($_POST['env_name']);
//        $embedded = trim(sani $_POST['env_embedded']);
//    }

    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $get_envelope = $wpdb->get_row("SELECT * FROM `$tbl_envelope` WHERE `envelope_id`=" . $_GET['id']);
        if (empty($get_envelope)) {
            wp_redirect(home_url() . "/wp-admin/admin.php?page=ss_envelopes");
            die;
        }
    } else {
        wp_redirect(home_url() . "/wp-admin/admin.php?page=ss_envelopes");
        die;
    }
    ?>
    <div class="wrap">
        <h2>Envelopes</h2>
        <hr/>
        <div class="inner_content">
            <form name="FrmSsignEnvelopeAdd" id="FrmSsignEnvelopeAdd" method="post">
                <table class="form-table">
                    <tr>
                        <th><label>Name: </label></th>
                        <td>
                            <input type="text" id="env_name" class="regular-text" name="env_name" required="required" value="<?php echo $get_envelope->envelope_name; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th><label>Embedded: </label></th>
                        <td>
                            <textarea id="env_embedded" class="regular-text" name="env_embedded" required="required" rows="8" cols="36"><?php echo $get_envelope->envelope_data; ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-left: 0;">
                            <?php wp_nonce_field('save_ssign_add_envelope_add', 'save_ssign_add_envelope_add') ?>
                            <input type="hidden" id="env_id" name="env_id" value="<?php echo $get_envelope->envelope_id; ?>" />
                            <button type="submit" name="ssign_add_envelope_add" id="ssign_add_envelope_add" class="button button-primary" />Add Envelope</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <?php
}
?>