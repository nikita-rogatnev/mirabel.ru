<?php
define('WP_AUTO_UPDATE_CORE', 'minor');// Эта настройка требуется для того, чтобы убедиться, что обновлениями WordPress можно корректно управлять в WordPress Toolkit. Удалите эту строку, если этот экземпляр WordPress больше не управляется WordPress Toolkit.
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

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u0524927_wp_vr1b6' );

/** MySQL database username */
define( 'DB_USER', 'u0524_wp_krx40' );

/** MySQL database password */
define( 'DB_PASSWORD', '0#9qJ4SbdV' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost:3306' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'nbhoO9~E6~O;~pjuSd3Mbaqo:zb%+:%xj1tWv5xfW#yi6@_3uE1I&3bCH8M826@k');
define('SECURE_AUTH_KEY', '@3#jXUy9vuHAC#6Fd[h%t|q(37pis*@l/g%K41(:V)14R/~SV(q]e%v5i__8JE%q');
define('LOGGED_IN_KEY', 'VmMTk4q3~1:8&:[f49b|-+0Je0#mQbV#T5oV*a&0:1H!o/yCr9!A@1!3(4f9l9:;');
define('NONCE_KEY', 'KAZ|3G+@9745Vpx(K&B)58-1J3F%1x@2;6:Ai2xi4Sos10jh7TAI1R4y2:h2Oda3');
define('AUTH_SALT', '9b-3]WNk;3@Fgtik3CMn28zwa1~y&N793E18!GVoS!*P@26kwOL7eY1!y0dn0eZ8');
define('SECURE_AUTH_SALT', ';K2)KJBEPYn3_g5t9g76_+Qb9Z*ofWOAKP%RA9S-AQF;taN6PB0-ZNyme;R]lv_7');
define('LOGGED_IN_SALT', '2x0#ao@wH4Oo;s*~7ha%!QH]vUI7)tb:p]3NG1JoIA|I60]#~0DW@v68y&QTJ6!s');
define('NONCE_SALT', 'Q*(WD~g8Hftq*BS1o8#mJ-KXm%B1PrLV9044@[2|8qs[~p641XIa2gW5qRkhCi%8');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'MRtIpt6zT_';


define('WP_ALLOW_MULTISITE', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
