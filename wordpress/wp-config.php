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
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'T1If|<|(+xEfDSQFvQaz|N0vrz -mQeeoDG_;Eh2u ?kM.QS5O1:.pCf{D2 g.i[');
define('SECURE_AUTH_KEY',  ']}6NRpt$G!hQM !BuTF{/!|r, Eq(}%q$L%Z>@y.X=<f~%p9KURdn@l#>ZU{n2XT');
define('LOGGED_IN_KEY',    '$l%ud#9/WLO{mTfp.$aZ^4olM[|K$C:TH809prD,9I(ToX$RD=oFT(qE}cO0NQP$');
define('NONCE_KEY',        'J7hfupkxKSI60iw!7xrBFF+}K>mC%wwE;#{bE)xxE;VHsb}{ SX@j6&T030jE3Cf');
define('AUTH_SALT',        '2j%*%Bm1m vx]qDyoZU/1SckdPm^Z)XMdtGvbo2p>:Qb=ifPSo*z1fbyI%@9EJq1');
define('SECURE_AUTH_SALT', '; -*274MjjWzC4;49`ZG}}DIaP;Y>^n2GiUH=uf]%D-Lsrt=Vwg{K6EM2IeqXcW?');
define('LOGGED_IN_SALT',   '6{V<[:p`=afK&+AG%+NEyU==}V/b|[E)G-3`f0P|9QK;9jLKs_Mr,tFGm@f)56@*');
define('NONCE_SALT',       'a.VZ^1D*9ZM75z8BpN,fUM 3hX.{Tc9t$.v{%^e$nZ@R]L97Dk*W%[= 8YOA!O9[');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
