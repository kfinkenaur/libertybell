<?php

/**
 *      Ajax callback
 */
add_action('wp_ajax_set_typing_text_cookie', 'ssing_set_typing_text_cookie_callback');
add_action('wp_ajax_nopriv_set_typing_text_cookie', 'ssing_set_typing_text_cookie_callback');

function ssing_set_typing_text_cookie_callback() {
    if (isset($_POST['action']) && !empty($_POST['action']) && $_POST['action'] == 'set_typing_text_cookie') {
        if ($_POST['type'] == "initials") {
            setcookie('ssing_initial_username', $_POST['textboxVal'], time() + (10 * 365 * 24 * 60 * 60), "/", '');
        } else {
            setcookie('ssing_username', $_POST['textboxVal'], time() + (10 * 365 * 24 * 60 * 60), "/", '');
        }
    }
    wp_die();
}

/**
 *      Ajax callback
 */
add_action('wp_ajax_ssFileUpload', 'ssing_ssFileUpload_callback');
add_action('wp_ajax_nopriv_ssFileUpload', 'ssing_ssFileUpload_callback');

function ssing_ssFileUpload_callback() {
    if (isset($_FILES) && !empty($_FILES)) {
        $DestPath = SWIFTSIGN_PLUGIN_DIR . 'uploads/';
        $uploadedFileArr = array();

        foreach ($_FILES as $Files) {
            $Lastpos = strrpos($Files['name'], '.');
            $FileExtension = strtolower(substr($Files['name'], $Lastpos, strlen($Files['name'])));
            $ValidExtensionArr = array(".jpg", ".jpeg", ".png", ".gif", ".pdf", ".odt", ".doc", "docx", ".txt", ".xlr", ".xls", ".xlsx", ".csv", ".ppt", ".pptx", ".mp3", ".mp4", ".mpa", ".wav", ".wma", ".wmv", ".3gp", ".avi", ".flv", ".mov", ".mpg");

            if (in_array(strtolower($FileExtension), $ValidExtensionArr)) {
                $FileName = md5($Files['name'] . time()) . $FileExtension;
                if (move_uploaded_file($Files['tmp_name'], $DestPath . $FileName)) {
                    $uploadedFileArr[] = SWIFTSIGN_PLUGIN_URL . 'uploads/' . $FileName;
                }
            }
        }

        if (!empty($uploadedFileArr)) {
            $response = array(
                'result' => 'success',
                'msg' => @implode(",", $uploadedFileArr)
            );
        } else {
            $response = array(
                'result' => 'error',
                'msg' => 'Error on uploading your file. Please try again later.'
            );
        }
    } else {
        $response = array(
            'result' => 'error',
            'msg' => 'Please select file to upload.'
        );
    }
    echo json_encode($response);
    wp_die();
}

?>