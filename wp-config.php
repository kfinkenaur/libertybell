<?php
define('WP_CACHE', true); // Added by WP Rocket

/** Enable W3 Total Cache */

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'liberuy2_newwp');

/** MySQL database username */
define('DB_USER', 'liberuy2_newwp');

/** MySQL database password */
define('DB_PASSWORD', '6f=n4zL#cB,z');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         ':#%S0c<oTWjDl1j-voIR%UKWMQe5~|x#(o3+iW2p6DE<O>CU_x6@u..x|xgq.GXF');
define('SECURE_AUTH_KEY',  '2}q:C}8Rm%2lbS1nUanH5FCe7aVGq#yN{keo$8lhnW1Y_rVCH%SF43_dXDUm>4>%');
define('LOGGED_IN_KEY',    'v7nN6AF8B:NI,hf=DKf$!Gi!<o}-fE@_~LFq>_,q-3elx}YOO>_9c%gcL`[=6@S^');
define('NONCE_KEY',        'AaJlk7sB{f6Qg=e`~ecBPW>f7^S*QWU?[gM^>*J|lA3zefra<N&Wgu%>Wr,3vS0,');
define('AUTH_SALT',        'V3p/&`|nEzZi(/1O|`m^}|6/V(M-M<D>b0OW8~mrt.XSG~6bm:/xE]0gH!t/$GSO');
define('SECURE_AUTH_SALT', '=6O:-Hy#R2sm[_-]gDnaB3*aOEBCI[+_H&R@WcXYOSgX0FM(6Zn?$_Z1gV^z<G7;');
define('LOGGED_IN_SALT',   '6l;4L?#$JY.ZJ Y3iQkxD~%o=M9=Y?aA2$*:txd*%SL#KZ%AKRL6bV=[4%)h}k +');
define('NONCE_SALT',       'eUIB6bdzAO5se*z>(<@:[>C; YFC?+s%?C)FG7=iJ!CrC{j,<]3SZsx58ViZ6;aL');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);
define('DISABLE_WP_CRON', true);
define('WP_MEMORY_LIMIT', '256M');
define('ENABLE_CACHE', true);
define('DISALLOW_FILE_EDIT', false);
define('WP_POST_REVISIONS', false);
define('EMPTY_TRASH_DAYS', 1);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
