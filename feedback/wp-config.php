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
define('DB_NAME', 'organicr_feedback');

/** MySQL database username */
define('DB_USER', 'organicr_feedbac');

/** MySQL database password */
define('DB_PASSWORD', 'qW(uMz~nCT]O');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/* * #@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', '6 5x.L(~7l{lcZb<W 5#@1dI{E;2Z?L?5H)OvYV&JrGEB5_$^ !0nr$Q0 mvOfc0');
define('SECURE_AUTH_KEY', 'N8@SPnHim~K3$u;rb`8Eur:(i7vEDKMG-(HUg>T?=!~4v7,-&O~|7pqv/It@wQO.');
define('LOGGED_IN_KEY', 'o&Xn_.}wF)?zLKysbqX2N|(byE3=~d xkcsKjMxzCRZv~Iiu3`c4U|TjH7vXF@a^');
define('NONCE_KEY', 'pJ#U;lE!xgqL,St8p gkvS~9!]c(vKts>tQnJ{P#]J5,,af GXavkY|dV+oyE`=!');
define('AUTH_SALT', '_NTg7:m_|8e8[C_Rcl`EtJY-Q*YverrYfOp*sF)|LLR?+zX+T)Bm^p3;)yv*`f0e');
define('SECURE_AUTH_SALT', '6YT!@|fZhg_/{;s`WJj?K<L&}uIy)g=lV(/)7De6L<~8E,EMp}kXOD#ip(0Px.Vw');
define('LOGGED_IN_SALT', 'x9^C/XPK4ydMG`S]+2,01t3+,Mq)r(|BeI}t0;F&FgcZ`f<;t8{KYO(RzanHG]+<');
define('NONCE_SALT', 'chD45-dZK8K%,4!1IWxsI%SRKk6?XM`L4FT10|p5<M5A5vzc[+}H.2Gg&B_K2S9v');

/* * #@- */

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'as_';

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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/');
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
