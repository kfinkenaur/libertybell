<?php
if(!defined('ABSPATH') || !defined('WP_UNINSTALL_PLUGIN'))
    exit();
delete_option('cnhk_options');
$upl_dir = ABSPATH . 'wp-content' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'cnhk-slideshow';
if ($hd = opendir($upl_dir)) {
    $deleted = true;
    while (false !== ($entry = readdir($hd))) {
        if ('.' != $entry && '..' != $entry) {
            try {
                unlink($upl_dir . '/' . $entry);
            } catch (Exception $ex) {
                $deleted = false;
            }
        }
    }
    closedir($hd);
    if ($deleted) {
        @rmdir($upl_dir);
    }
}
