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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', getenv('WORDPRESS_DB_NAME') ?: 'wordpress' );

/** Database username */
define( 'DB_USER', getenv('WORDPRESS_DB_USER') ?: 'wpuser' );

/** Database password */
define( 'DB_PASSWORD', getenv('WORDPRESS_DB_PASSWORD') ?: 'wppassword' );

/** Database hostname */
define( 'DB_HOST', getenv('WORDPRESS_DB_HOST') ?: 'db' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );


// ** Set site URL dynamically based on environment ** //
define( 'WP_HOME', getenv('WP_HOME') ?: 'http://localhost:8080' );
define( 'WP_SITEURL', getenv('WP_SITEURL') ?: 'http://localhost:8080' );

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
define( 'AUTH_KEY',          'o0j_Nidj>!VpD_@wC;{/kWsK~8Bnz{;-pfxN0 xEj%GyeWD5q~45Ke}juT]Mj4D!' );
define( 'SECURE_AUTH_KEY',   'dHhw&@XQ<F!_rlrr>5<8gr+c)noq9CHxRG;MFo$kgb(L/CI`/ZzQPu?e3<R{|Z0J' );
define( 'LOGGED_IN_KEY',     'bTT}nrN?#Gg@_n]eT=c4e@smP+6AY@Rrg04WMn30L(I{]b1U9Z0aPVz@0oD3JV.w' );
define( 'NONCE_KEY',         'V0?V`Zv?t4*{hn;O5Bxq{Zy,!j+c.U/.LGYjJn&F9I&0U<+k1m@980{MadeY<8-V' );
define( 'AUTH_SALT',         '89/NlD1g/9RSsTdg-39L[m<orr:4V(>&_(:eF.i/zc|gKRz1^ .H`)7/JIdwH5gb' );
define( 'SECURE_AUTH_SALT',  'n|U;*Zclr=e(@oQ]l_QiX)Vb!mLxSu?v,9%,NBLAY0+0-{Q,$bzq>4MV?oQ%O-ON' );
define( 'LOGGED_IN_SALT',    'BR/qm.W72C(TlM6-jXxkd2R^x}*yD]?AC,OJ~#?7}5gy hD/}X2ugGMK%5G%.4z5' );
define( 'NONCE_SALT',        'X0}D#9<ceO2/GZ ;|JZ`lTVf&^7<R|PxF=^n4pB-3:P<qCy~`#iYLV%oQ%BT~[;j' );
define( 'WP_CACHE_KEY_SALT', 'D7`M#k4Vh_[T//R Y-%_8ZFR4ibAJ?%8!AyF)]E8zUarefk4OI7+r7u`Aq?S%>)e' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/* Add any custom values between this line and the "stop editing" line. */

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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', getenv('WP_ENVIRONMENT_TYPE') ?: 'local' );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
