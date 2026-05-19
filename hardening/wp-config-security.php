<?php
// ── WordPress Security Hardening Constants ─────────────────────────────

// Disable file editing from wp-admin
define('DISALLOW_FILE_EDIT', true);

// Disable plugin/theme installation from wp-admin
define('DISALLOW_FILE_MODS', true);

// Force HTTPS for admin pages
define('FORCE_SSL_ADMIN', true);

// Limit login attempts via cookie (not full rate-limiting but adds friction)
define('AUTH_COOKIE_EXPIRATION', 3600);

// Disable debug output in production
define('WP_DEBUG', false);
define('WP_DEBUG_LOG', false);
define('WP_DEBUG_DISPLAY', false);

// Block username enumeration via author archives
// (Add this to functions.php instead — shown below)

// Limit post revisions
define('WP_POST_REVISIONS', 3);

// Set unique authentication keys — ALWAYS regenerate these:
// https://api.wordpress.org/secret-key/1.1/salt/
define('AUTH_KEY',         'REPLACE_WITH_UNIQUE_VALUE');
define('SECURE_AUTH_KEY',  'REPLACE_WITH_UNIQUE_VALUE');
define('LOGGED_IN_KEY',    'REPLACE_WITH_UNIQUE_VALUE');
define('NONCE_KEY',        'REPLACE_WITH_UNIQUE_VALUE');
define('AUTH_SALT',        'REPLACE_WITH_UNIQUE_VALUE');
define('SECURE_AUTH_SALT', 'REPLACE_WITH_UNIQUE_VALUE');
define('LOGGED_IN_SALT',   'REPLACE_WITH_UNIQUE_VALUE');
define('NONCE_SALT',       'REPLACE_WITH_UNIQUE_VALUE');