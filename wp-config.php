<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('WP_CACHE', true);
define( 'WPCACHEHOME', '/var/www/html/wp-content/plugins/wp-super-cache/' );
define( 'DB_NAME', 'performtable' );

/** Database username */
define( 'DB_USER', 'performtable' );

/** Database password */
define( 'DB_PASSWORD', 'performhvm.2022' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */

define('AUTH_KEY',         'pvx|k9Z02.Gnz4453c+(Z2d?c9jMl-9RNLMOP%9.OIFD~R_a?{{>ke1k=|rw4V1+');
define('SECURE_AUTH_KEY',  '48.`g}82Qugk}gmtZ}MmD6=5Zx^UK0Ny+K ]chs*J%mQ~^/OYF3Cu;?qq|$xEmb;');
define('LOGGED_IN_KEY',    'l0i6^%O*^]%%Qra.S>tEhC;$X=M44}F<1QqqS)1+|LRrM;RypW6DfsRH[w_-opu!');
define('NONCE_KEY',        '_BY2luOe} $*7]JG%0+xP*w!eQ;+`i=N8fdngex`sl.wpJEzAa2*M8`12d%8{-;i');
define('AUTH_SALT',        'F0)gt3/|g9[cY7ophPsdp}T8p,7itY8i<2D7n-^|[jr9-+Q(AYBIVv0;Mj|{GoRT');
define('SECURE_AUTH_SALT', '2:G{4?QtjQQJFys+!~(B;pGTF=K]w-$4]n-udsgXVvB|e+%?.--a72EN4dCu_sX%');
define('LOGGED_IN_SALT',   'Z H5SecB+-g2HEeHC(G#_MsbG)m9@ibl,hKJ&^I>{Y==6--cVF&!oB<1c_+q ~IN');
define('NONCE_SALT',       'I)zD$yrNwI8Whsx?};jXWO+[;=KtRbgy@-f.j|JNS+S4tt-(;(VOaa&6G`#ZkV,O');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
