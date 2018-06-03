<?php
define('SAVEQUERIES', true);
define('WP_DEBUG', true);
define('SCRIPT_DEBUG', true);
define('YOUKNOW_ERROR_HANDLING', true);

define('WP_HOME', 'http://fast.dev');
define('WP_SITEURL', 'http://fast.dev/wp');
define('DB_HOST', 'localhost');
define('YOUKNOW_TABLE_PREFIX', 'wp_');

define('YOUKNOW_PLUGIN_ROOT_PATH', WP_CONTENT_DIR.'/plugins/youknow-foundation');
define('YOUKNOW_THEME_ROOT_PATH', WP_CONTENT_DIR.'/themes/att-lh-theme');
define('YOUKNOW_PLUGIN_ROOT_URL', WP_CONTENT_URL.'/plugins/youknow-foundation');
define('YOUKNOW_THEME_ROOT_URL', WP_CONTENT_URL.'/themes/att-lh-theme');

//Proxy Server
define('YOUKNOW_PROXY_USERNAME', 'proxyserver');
define('YOUKNOW_PROXY_PASSWORD', 'password');
