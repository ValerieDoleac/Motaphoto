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
define( 'AUTH_KEY',         '`u$Dr271Dz>B&!0Gx+A-j(;fu(vZpAd&LjS ;Id{We@$S)L/yeTDPU}Tuo62Bj0]' );
define( 'SECURE_AUTH_KEY',  'y_A=Nv(f(XtVXj0qF?gQf+m 7s#O^{FWgtjtRsIZSZY$}9`A+IN0r$8iEflTgi^s' );
define( 'LOGGED_IN_KEY',    '/.+x%`:{UcGrkiJ9lTOZC:GoBM #!a}R.*ck/T4H%UC!) gIm,94iB{hI|kFNbD0' );
define( 'NONCE_KEY',        'm[gVmxyyreV&LYDp++%aJJL>p50G/gOY=C-X}ji-*A>Q,wvO9gar0hvTJDc?%B7i' );
define( 'AUTH_SALT',        'tz7%`ecO?$PV$(6mkZQR59r>`P Mdu[nDSbzJ#]%aboeY9RE:&`P+e_n8<EOe<vI' );
define( 'SECURE_AUTH_SALT', 'k8QBggnWhS*NtsX)*y4LmvRkmoeUX|csb`>$ hS`1$[(>Ekr2 C8Z)UKcSx@GLdL' );
define( 'LOGGED_IN_SALT',   '5y#{MCw?+8J+flqk2}Y%QCmP{AzA;N:k69AAe{2M.++Ij kE.~8qBixR=!!r6|mZ' );
define( 'NONCE_SALT',       ';;ID{i|;8<)VjsM)Aw*Z-89!~y0k(P>hYWLpUs9{P79QE2&(X<Ph&D~I-n~S,l^e' );

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
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
@ini_set('display_errors', 0);


/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
