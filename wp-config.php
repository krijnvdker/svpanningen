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
define( 'DB_NAME', 'wordpress_svpanningen' );

/** MySQL database username */
define( 'DB_USER', 'krijnlocal' );

/** MySQL database password */
define( 'DB_PASSWORD', 'krijn1234' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'D3/pZbC#(aSj/57f=9a}Ot#9I;E6f7l,#rB1j+ z G#<y:QWUy@%nl_kNEP=`>sn' );
define( 'SECURE_AUTH_KEY',  'az<^-[<W>RvI3p%M!4]=6>dp<X$TKNunx1nntQkv|1& KW0ceB&#wt(6NBR_C|Th' );
define( 'LOGGED_IN_KEY',    '^paEJ5QYf5 u#Tt/Xr_|;:w{SRf~|%GS_ F0_)#ZtzOtdwUE2z4{pHLzuL{jbKPD' );
define( 'NONCE_KEY',        'gt`W{kP`sn..zK[w#z;jO,Mf$h# N`D218X0gR+*V2=2aKFNv-2;`&9gC**BRH@s' );
define( 'AUTH_SALT',        'd8VTO/{Fqo/t5=Zs{/]0GHj~n~WXzdxi>cZ#SN~Ce +z$hL01/z:<0y@KaiK& !(' );
define( 'SECURE_AUTH_SALT', '=j5VU/2<BPM)f?-h!#Rbvne}/0B$1s-WcYsXrMr4^@gJ+:-2b6rZ!S-[Q=f~Eqw<' );
define( 'LOGGED_IN_SALT',   '?RxhO|)a%*~o;E_Ez1$bSv*!UnJz8UIF.#P!YV&nG[2sx+Rc:d9nI}-wm(L}u .D' );
define( 'NONCE_SALT',       '1x5.Lui3M&RGjmIRg~q&`TY|NI/O]Bk0782ZIy~,mMK%0?2i6rd>zs:%whS<QcZQ' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
