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
define( 'DB_USER', 'krijn' );

/** MySQL database password */
define( 'DB_PASSWORD', 'localhosttest' );

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
define( 'AUTH_KEY',         ';Uj!Un<5Ej*,ql4bagn&I!i <@`W>`Y4@0-D8[MZK VqFa[Ck !BK!?SE8-C+tLZ' );
define( 'SECURE_AUTH_KEY',  'Qd[vUoKc.&-OF!?(Ukn_4aurCOQh.50MjS!|Ctz6QX79F=+M7tMk&D5$PtkN`-;]' );
define( 'LOGGED_IN_KEY',    'qj? zf`E{a.amZfgM!(`8_])JD+#pu8jxr6?n&JUWwY%jO=:c$p[9lY[OW<+1 dx' );
define( 'NONCE_KEY',        'V~>Z<)>6mQzSnCy8o7H]7|r=R5s@96lKUU|/9$t(bu>1Q6n0yiR(/Zumm8Tp-3B9' );
define( 'AUTH_SALT',        'oS`RG;~7B8.Wc*1e3,(.o kg*F<qC1K4tl^%.yb )U2jx~0k-~z8.s+4D;XJog=&' );
define( 'SECURE_AUTH_SALT', '9fZ/thxbVD%|[J:[8{2Vixt,=D6)JH:&[Fynl9=a?.nXq.czQDU>r/<oL`+Zj,<o' );
define( 'LOGGED_IN_SALT',   '/K$1M3}q6CtC[aSpxIb]@>P!|N~^D!4|2,BaEg>>4SC!IfT16ZN@{K#;5^3$&Fcv' );
define( 'NONCE_SALT',       'NE>`0i;E~oYs-sZ6gA67j<t|#*!0*P=UrvnCp)YZ&?Q>Ful854WTrliY$M!G$.rk' );

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
