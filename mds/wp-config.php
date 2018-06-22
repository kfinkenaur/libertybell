<?php
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
define('DB_NAME', 'liberuy2_MDS');

/** MySQL database username */
define('DB_USER', 'liberuy2_Drell');

/** MySQL database password */
define('DB_PASSWORD', 'Dmaster16@');

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
define('AUTH_KEY',         'voDiMSl?:*40uCH|e*HHpc$Visve~!0_W2|kUU!&E3Mk%^8Y;t!vsJRJA`i[cM0:');
define('SECURE_AUTH_KEY',  'ycL$EH!}$H5:=Kc[5|$4A,%->^a%Fs4fN.D:9X%k8[01V=mN?O*:VEvB,0K_0#*[');
define('LOGGED_IN_KEY',    'a4DI*M z~EHViK-vk/QA<RUep=kDF=xm=114v4P*yEa;eplE|zN=$ME+Pg4|;z@Y');
define('NONCE_KEY',        'F#`b^QI.7.@$DEubM!g{KFEBCT+^dc)3)`f;?[D`LZcB.I*b!d=Sb~f[j5Zq5,}F');
define('AUTH_SALT',        '<v0?I+UsXz>lp$TIEMktbrk(b2MrMhA5_@gZ{k5TE|e,ER%(,+*tr}^%*t>+3fzq');
define('SECURE_AUTH_SALT', 'O1+h]P[~+xh7RrI%?;7<||-;{:Fjr[j-;/4xzT{( !A[[4nx]+AqUlB6N/QMQ+{1');
define('LOGGED_IN_SALT',   '$= %.L_8H.5-[(bE.|zuD)*O|I;..yI4-kr+)C_?yaw[nac-`Gr4~2Tn>|lsar[&');
define('NONCE_SALT',       'Lmtgxf23$1K(s)olUv#JKDx-BE=#k>3(->5-{uU-|C%HD+xv-.n(VvYO5J8tNn}_');

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

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
