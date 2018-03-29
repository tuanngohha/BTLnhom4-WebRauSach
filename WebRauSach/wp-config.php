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
define('DB_NAME', 'webrausach');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         '/ T+Fr[ne]=81a$NWMXw{k~JrSlRTDD~AC1E1A8(A=n`s9#B&$PiPP&]qU$9[:ak');
define('SECURE_AUTH_KEY',  '1%FG-,2`JQWFl}ZH^ales7<mo/4N$K{SxN*CyU_Dz_^41.t-C]zKY%k(PnmrIT9*');
define('LOGGED_IN_KEY',    'Cyq@%XL[8w+{miVZ-{V=/GtOT(0M556R4]*bisVe8Z({!Q&nGRW$[sX@OvL}0B8x');
define('NONCE_KEY',        'LKP9eYO,q0v!|(mmyNv4oqUC0?}I%`4}PsrC_3PYw|a}gaC9]BGT7a-Dt_A<^=NE');
define('AUTH_SALT',        'u2z3gm/u.&vzYyp)k=(|B1a,UNjO5)Z|@v%3}u]g;~k(esXoei$>qYjC%~87%OQR');
define('SECURE_AUTH_SALT', '5nqLm8A?Mi_EYE+rI0`[_6h`h5&%b9]!{>Bmv![K<P ;EZ9HrI1^~]6ep9y8`[We');
define('LOGGED_IN_SALT',   'V(h;k:%/LG3,HHn[%GspNA@y@Y+{h%=jM6Tr7&Q#}>;)ma&9$$+y<uy{T1%_KN#S');
define('NONCE_SALT',       'oz0z6D4?eQe=<dlo^^Gj*Z51f>F&U-Q.]<)s-#]}!);+Rd~<6D)=9w5l,R$:qt.k');

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
