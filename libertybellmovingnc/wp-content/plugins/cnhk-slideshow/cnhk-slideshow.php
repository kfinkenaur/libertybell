<?php
/*
    Plugin Name: Cnhk Slideshow
    Description: Fast setup and easy to use, full width slideshow plugin for WordPress with a drag and drop system for editing slides order.
    Version: 2.1.1
    Author: Rija Rajaonah
    License: GLPv3

    This program is a free software. you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses/>.

*/

/**
* Avoid direct call of the file
*/
if (!function_exists('add_action')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

if ( '' == session_id() ) {
	session_start();
}

define('CNHK_TEXTDOMAIN', 'cnhk_slideshow');
define('CNHK_DS', DIRECTORY_SEPARATOR);
define('CNHK_BASE_DIR', basename(dirname(__FILE__)));
define('CNHK_DIR_PATH', plugin_dir_path(__FILE__));
define('CNHK_CLASS_DIR', CNHK_DIR_PATH . 'classes' . CNHK_DS);
define('CNHK_INCL_DIR', CNHK_DIR_PATH . 'incl' . CNHK_DS);
define('CNHK_SCRIPT_URL', plugins_url('scripts/', __FILE__));
define('CNHK_UPLOADIFY_URL', plugins_url('uploadify/', __FILE__));
define('CNHK_UPLOADIFY_DIR', CNHK_DIR_PATH . 'uploadify' . CNHK_DS);
define('CNHK_IMG_URL', plugins_url('img/', __FILE__));
define('CNHK_UPLOAD_DIR', WP_CONTENT_DIR . CNHK_DS . 'uploads' . CNHK_DS . 'cnhk-slideshow' . CNHK_DS);
define('CNHK_UPLOAD_URL', WP_CONTENT_URL . '/uploads/cnhk-slideshow/');
define('CNHK_VERSION', '2.1.1');
define('CNHK_SLIDES_URL', admin_url( 'admin.php?page=cnhk-slides'));
define('CNHK_SLIDESHOW_URL', admin_url( 'admin.php?page=cnhk-slideshow'));

require_once(CNHK_CLASS_DIR . 'cnhkss_data.class.php');
require_once(CNHK_CLASS_DIR . 'cnhkss_widget.class.php');
require_once(CNHK_CLASS_DIR . 'cnhkss.class.php');
require_once(CNHK_CLASS_DIR . 'cnhkss_ajax.class.php');

load_plugin_textdomain(CNHK_TEXTDOMAIN, false, dirname(plugin_basename(__FILE__)) . '/lang/');

global $cnhk_ss;
$cnhk_ss = new CNHKSS();

/**
* Template tag
*/
function cnhk_slideshow($name) {
    global $cnhk_ss;
    $cnhk_ss->show($name);
}
