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
define( 'DB_NAME', 'wordpress' );

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
define( 'AUTH_KEY',         'x]?+pbYeesO6dQxew~vKCD7.QEhT;?~o{:K_T0,C6)nwgI}z(/vq^5xc7I>>q?]j' );
define( 'SECURE_AUTH_KEY',  'v_0e)X%y_LeP[/Jq060s3q4&?>HZBgX/+*Dm/5(~]!prUS_G,`X?JV:SfS_06YDf' );
define( 'LOGGED_IN_KEY',    '4zu(r]>B$qkz4BgE7|)DYcuWy+P.E2Oc]89s1!P~eix`T,KgO%Iw9,}=p=/TJ&`X' );
define( 'NONCE_KEY',        '5PO7Wg?Q (S;upXmDOE>-1b[L;19-$Ozinq2O,pMB>Idp+!:> |rUX4CNTJC%$:f' );
define( 'AUTH_SALT',        '4;MF|j@-`_~;PNyCbd^(nC;nCS9V=K(*VI(Of]lNq!45voSc&PZ9wb|,u_,BBs.s' );
define( 'SECURE_AUTH_SALT', 'S]kDSl9^.DghrbL1bjzzq<c:A ZOugdxl=ciO WQ7g0qN=Y=@e4w%Ewl_ jy,t84' );
define( 'LOGGED_IN_SALT',   ':.6]3xv.F))*D(<axfXOwZgXb/xOC!gUD0,u;eIln#W_hTG]i<]A_bDj@8_QQf>%' );
define( 'NONCE_SALT',       'obPz|M_BS`4BQ+I_gom.im-[V=~@X9KY~Sgl-DucreAs?n=!^~4r$&}umzl7STyu' );

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
