<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('WP_CACHE', true);
define( 'WPCACHEHOME', 'C:\wamp64\www\Motaphoto\wp-content\plugins\wp-super-cache/' );
define( 'DB_NAME', 'Motaphoto' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'Bt%O/{@:cUs7VKSrN.X620E7DB2L6bx=bZyeGNGavZ7l}{~ej3$_I>V(Min_;.Sm' );
define( 'SECURE_AUTH_KEY',  'shpPDdzwO#{nmP8D1H3Oyx<):4D58O|i_vA&2n%mb5w-8wa~+Q+y:Y)3=v& %Z9}' );
define( 'LOGGED_IN_KEY',    'Zhaqncf#3+.P@eOoZa(EYfu&ZPRL61gL6kkd+w`/>Qk qpIt3q(g LcV>}8h5}tx' );
define( 'NONCE_KEY',        'hBRJ p 57^J$akrG&]{%?Z8?KzA1?Uw+&KqPP)[+G:NzB=YPwwi7Qf={7E5kx{fJ' );
define( 'AUTH_SALT',        'aC2IMrGCf}1sD:oUJx,C[,~9qyq#A$;};+Ic9<llP;yC?`xy>@p,B|pQ_7`[sA:j' );
define( 'SECURE_AUTH_SALT', '8B&rWf++&znf[BCb]p&mO[C8>.ww3i~7XRKV@l:VgQzq=N]{cn)hk4hH5O45Br9G' );
define( 'LOGGED_IN_SALT',   'lUEq/W@BRt^edGNQ?{n~~J$O<cD-@#E`4(<<WrJ3dS5;791=.#jIv4_<r=+Z3TSw' );
define( 'NONCE_SALT',       'JH#dL7,1exOsIKj-, -1V.qlvG[Fs){TJ|Qr,46rkp!0V^v(p=%-yx~$QG5RmyrR' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
// Activer le mode debug
define( 'WP_DEBUG', true );

// Activer l'enregistrement des erreurs dans un fichier
define( 'WP_DEBUG_LOG', true );

// Désactiver l'affichage des erreurs à l'écran (optionnel, mais conseillé en production)
define( 'WP_DEBUG_DISPLAY', false );

// S'assurer que les erreurs ne sont pas affichées directement
@ini_set( 'display_errors', 0 );



/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
