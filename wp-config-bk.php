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
define( 'DB_NAME', 'keihb_kowa_kokusai' );

/** Database username */
define( 'DB_USER', 'keihb_kowa_kokusai' );

/** Database password */
define( 'DB_PASSWORD', 'kowa-kokusai2024' );

/** Database hostname */
define( 'DB_HOST', 'mysql5.onamae.ne.jp' );

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
define( 'AUTH_KEY',          'psBIaYaXT:WL-|*T7us^A0)Sk&CfJA{YPj#>VLJC?-?X&dcSwZ<h.YYiQ.2p)t|D' );
define( 'SECURE_AUTH_KEY',   'E&m1C9`)UUvAwD%= f9.><?rx}TkA?g-Z+uoSi`JSuqun5YBvR&Ga}P:Gt6t$QFi' );
define( 'LOGGED_IN_KEY',     'Whb%-BMWQZ^+h_iMcWSgHFx_{Nocw|[bM2(Uy,qraGfNUS6E*F0H{+n8p@.7z:4h' );
define( 'NONCE_KEY',         'Cf/?PtO9pM9*OsbYcqniL0sDXM InjjIEI8ZCxY}lF4&VL2/{KFIWx:zhqF*g,5N' );
define( 'AUTH_SALT',         ',udQK^1`3=#w0#Wo.h?;zrwW e2+?#(S/9P?O8J<(BfdUtn{1Z<~D*xe`&8kxG{.' );
define( 'SECURE_AUTH_SALT',  'jmN/f1G$^)euAg-5>]a)<pZJi~A$HveCx)Hb~KqQ]l=?aPCKT:>d$|xAZWDaQKR5' );
define( 'LOGGED_IN_SALT',    'L;7v7[(YWn| 2]-9?]GAYfo@|}J3^[%-{z}Nf7S_]%AvlgwLxaj$>Z9ts%`NDW06' );
define( 'NONCE_SALT',        '>.nOlEQn|<tRK>[JEjgu]J@*+=CDV-6vSn^UHLw%sMY:.tOTWFFnK&VS{ QtS)i>' );
define( 'WP_CACHE_KEY_SALT', 'gu[o$B0GFm3BF9qa!SHZoD/<)& yEQI(6P.ik~DOnW ].4tVP{Tqq;Bp+jI^-^$6' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === "https") {
    $_SERVER['HTTPS'] = 'on';
    define('FORCE_SSL_LOGIN', true);
    define('FORCE_SSL_ADMIN', true);
}


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

define( 'RS_DASHBOARD_PLUGIN_SID', 'df6Tj6J8fDMgnSVXt3rIPkEt_YnZ_KovYrIq0ZGUMcwsrO2XLaFpFkt8IkDgCZbF4yIsE05wfUQ3NLEjAyNvsWmnwXAfx7s0cVKOwJlzvDA.' );
define( 'RS_DASHBOARD_PLUGIN_DID', 'QXOFiLOTf70WzwcyfvJMBgF55-4HHmF_PZgIJimlYV4VLrII9aYetzIcA1PTIv1Rq214GXE2qkfdFYHuXVkme0DVncwhelpk7IvENojDL1c.' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
