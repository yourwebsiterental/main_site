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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

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
define('AUTH_KEY',         'HwkHOvh7DDHTu+aHXbspOwj2WfiFiTsnR1zzYHYuW7hNYr7Rwahl2e+NFgvrbxe9eJ1FccukBL94ZWPKQf4WBA==');
define('SECURE_AUTH_KEY',  'SHt317I09ftulHXyQG+rPkhgbn6ldkjNQVXqEAt2aK4KErehjvR5Rvnz44PPhLRjMV0DfhlXA8g9L5Tnq1NAnA==');
define('LOGGED_IN_KEY',    '9dAqr8FK6YA7hRbFd8Oa9t5hH/kercDbeDhfb6vek2bryGt+xA8DP0kMcwA7FpBvxjarOrmGY9ze0XyR5uvBjg==');
define('NONCE_KEY',        'et7ypeUIoAw3yxgJ6mOxF6biSdFtw0K20p68wjyGMow7MMiUzL7kTqUUAR+nqJ9q5T1kxR/SZxFhR5ANg95pug==');
define('AUTH_SALT',        '7Il+kzGa7Hwmvk8tnknVSgnwTsrCvNhuXGxDTRheb/qO0SbCdTia3uzKe8nuhyHd1CNwVPmLI5dbJh1goxPX1w==');
define('SECURE_AUTH_SALT', 'ikPV1uRvAIg1PB1dB6AplaC2xWkthAu4918cvsNYaHhit04o2d+Cz7u68cpCnWBZ/HSDQxcfnxe+59hrN5uGrg==');
define('LOGGED_IN_SALT',   'G2fZL/bSva9KqtjgVZyYid2vkob2rmKRq0Vx25mAwFI3i+BNb4PnB2elkAliJUxW81s7fgFNL98XJ9SAdbyEog==');
define('NONCE_SALT',       '6mPdCitl1VpCVuPwMu/LSdxxOSkKhdsM4NyiiTd/fvPWAajBmxOp5lUDptCk/auOfdtKeLddu5LB+iRAnlo2ig==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
