<?php

/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */
 
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'liberuy2_wrdp1');

/** MySQL database username */
define('DB_USER', 'liberuy2_jleone');

/** MySQL database password */
define('DB_PASSWORD', 'Whatthef420');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/**Ask for more memory. */
define('WP_MEMORY_LIMIT', '96M');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'gRW(H~V+uCMm>}rI5C+rOuM`jRn;xx5qHp4AMpwK)cy8=U>@V_iI|Ki-~[y!rAjL');
define('SECURE_AUTH_KEY',  '>q(-Huy,NbDmiAd:@)3ZJomr ?:xO^yt+S? G!;@9>3Qf3sV],%:q@[:kL_2N`VF');
define('LOGGED_IN_KEY',    'A$NR:c{-t[fMB71^/+mgrH><KyL1;-=KzkSt9TB4H@[JB$CJFM+q+yaarfW,e<7F');
define('NONCE_KEY',        '4vcSPuXF2/-C5}_)}6cG+LyrL1fe-EBsU1NGnhhl>Luada9D=j/$x>Ms_yNaJyd,');
define('AUTH_SALT',        '0sX<_Zf+i:A+>q|kj+G1+q|U|mGTl[ZjurKIan|^y?t=^B5d-Ky|&k+9VOzWB),0');
define('SECURE_AUTH_SALT', 'Z*T6T*+QArg6/aCX@_C{$#L/)-n^=Sb2o52CdH8)K)^i%}}8q|ap(VA.F8W,tqX#');
define('LOGGED_IN_SALT',   'v>5RY!5R1s%3;PzCSJvQlmpmxLcs.YRdKE#e|+-?%#XORq$OaqWPrS+!&|+hE49G');
define('NONCE_SALT',       'h -Kq`00#?s#=jQe-k>V2J<BZ@,kcuIx$i*gZSIJN+h$8J|yN<6/|(zdp}9;m-%}');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
?>