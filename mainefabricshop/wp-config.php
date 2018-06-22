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
define('DB_NAME', 'liberuy2_wor5580');

/** MySQL database username */
define('DB_USER', 'liberuy2_wor5580');

/** MySQL database password */
define('DB_PASSWORD', 'AEKnxNa3yHR0');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY', '%Mtc-_YQ>LvUG*C<=m$])uPEkp(Mo-AbXGIYaJ&t=$TYzJQ^<qdcw?U(%q}i@(gXezFsu<fKRBkKkVq>eV}w]QCAddnOewp(Vp=MU[p+od@F}ZbKB@+VI{YPTI{DjaUj');
define('SECURE_AUTH_KEY', 'X>T/%vP$=bX+tx&=J)AEX+!c(tgIvO$A*p|[-hWSifXskAf$czvk-ce]-S;c?zch^nmkj;NuaMOiV|A;DCJYP}HhZera-cNCpgT}*)U/XtSppAO<bMuTGSTfA]u@Y@&v');
define('LOGGED_IN_KEY', 'Qx[vv)D%qQ]WuRs+P|W[<QOga};[R=;&aY}GJSAG}Ylx(zT)y}b!hpGFVm_u>uHIIy-W(cRWDbNyh[w}NOxy!MSp<Uuy_CF<wQs_(;;MeC_P$fJAOg[PE?B**L=B/mVL');
define('NONCE_KEY', 'aLQGSMFV&uLZmORi*}MmdcIqesrEb[>B=}Mk>RPs%or>thTBxKh>AUyANU|;i(Q;q*@ajEfV+*gv_GUATYBiPxJWV@;T/Fd(}BD=N+xsZom)ZHnlT*Ewbneo>wpdF^_^');
define('AUTH_SALT', 's%?KnKVMVHcpzrQUtW^)iGzbmqvJ($Kh;PD-!UBN[X+rcV?XLlFiwU%lI^FmyA!So_%yhlRWkas|O_-$SEHYBEqlps&xwRIuxYPox_!N}->fT[ksH!vk%_c-Ezr;G}GR');
define('SECURE_AUTH_SALT', '{f;bJ(Wx|Zrqbh+t]]Hpi}$ljUdIObXkMDq?g%T|%UTbA?bQOU>g$VWVlA(mJuS*iQ|-[DCZNI*)*ip;bFh/%p^g>lyU?I]$^n;dG+fLpHniYIO@^Kpy](]D!IKrgsKF');
define('LOGGED_IN_SALT', 'bAzsz+_pXH_=u)O]yyRc&j;mEUzI||LOE-e$PuIWm&Yuec^W_pt(dxj[}M_$DRqFgDsDa?OVVr*Yq<BKP{IC[GheMj;yegEf}W/TOcEs|]@-H/I>X<pImC_o-oTd/-$V');
define('NONCE_SALT', 'kwHz=<OForztQxu+?pcYZ=WpGw+VWXo[lbn=_)kJkjE-x(E&Gt-/<XKO[KWcW{C&yXxb|{b*}KTo<+>>%rVk&rqpVVi<&|--EZ=LL<(tiq^v>Tk$EU@qIzWIbU{ftwmt');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_pzhh_';

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

/**
 * Include tweaks requested by hosting providers.  You can safely
 * remove either the file or comment out the lines below to get
 * to a vanilla state.
 */
if (file_exists(ABSPATH . 'hosting_provider_filters.php')) {
	include('hosting_provider_filters.php');
}
