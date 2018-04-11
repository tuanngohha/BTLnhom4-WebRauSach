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
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'wordpress');

/** MySQL database password */
define('DB_PASSWORD', 'tuanngo123');

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
define('AUTH_KEY',         'Zrrh.}#eFt*$L8q7D|x=N/M sHa>a2MJuiyCviUFfiGO%%S.{FIvdqHakMgHSH]{');
define('SECURE_AUTH_KEY',  'H/|d1Ng_K5Ke3M*lN@q><-PQ2g%=mIn,XaFj.R D>;dm~&BjxB>HiX@T}0R*q[VT');
define('LOGGED_IN_KEY',    'AIQ^6VDL~$f)yatAnR@_3!]2X8/9K!D*;mf|ujaTJxG ]I=?VH*s_S5NH(nvVICc');
define('NONCE_KEY',        '+seBU#N@Hv.VD=a[.EmRjVV@ta1P}475B8qjG2:S@}`IYDAGIo9OQ[ M]wA<Sav#');
define('AUTH_SALT',        'c, X:snoa9;A#1h.LLzi&{T_YH&3A@^voaRIANx{0D<sXOd6av+{~B=*ASuW(?m]');
define('SECURE_AUTH_SALT', '*a~?Y+<1_8yZ++B(wKj7P>].V~~fxw&oW&5[rBZ21=OA7t=t,7ssMwCK:|2FrI>H');
define('LOGGED_IN_SALT',   '%T%EgYr4y*b{jO|0al3i0it+4m.U .aZ&K5^)goCwm6^;j.Gf8babvjbOUipLKtC');
define('NONCE_SALT',       'hA,1iD.t)Y~D.bhLh2*Y0^w!,jP%08}f0N,{%TgLQ>**]#zDb5?%T}Z(gfIt^#sU');

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
