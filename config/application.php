<?php

$root_dir = dirname(__DIR__);
$webroot_dir = $root_dir.'/web';

define('WP_ENV', 'development');

//UPDATE FILE PATHS & URIs
define('WP_HOME', 'http://fast.dev');
define('WP_SITEURL', 'http://fast.dev/wp');
define('CONTENT_DIR', '/app');
define('WP_CONTENT_DIR', $webroot_dir.CONTENT_DIR);
define('WP_CONTENT_URL', WP_HOME.CONTENT_DIR);

//SET ENVIRONMENT SPECIFIC VARIABLES
$additional_config = __DIR__.'/environments/'.WP_ENV.'.php';
if (file_exists($additional_config)) {
    require_once $additional_config;
}

//DATABASE VARIABLES
define('DB_NAME', 'fast');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

//GET RID OF THE DEFAULT 'wp_' TABLE PREFIX.
// $table_prefix = 'v8qbm6_';
$table_prefix = YOUKNOW_TABLE_PREFIX;

//SALTS
define('AUTH_KEY', ':d{Va||u}h*n%4ZO`~_3RV!g>+=MfC#2e3(ltpz?ZKOlh.#T1)p|Rg3aY32x8Z{l');
define('SECURE_AUTH_KEY', 'EPbtQ^7{48, *?:sj{7RN??r*bC@:t;>GJQGQ$Z M_ /wqlzEY:syh=@MM2`IYM!');
define('LOGGED_IN_KEY', 'u6R&Ji/^g!GwF)ynDrDg{DU@9<+7xpRvl8@g&Q-+A/r#I[7E{Hi=kHB[ntt{b@#3');
define('NONCE_KEY', 'oxCJtu:<U!G;Pab2*e)B<SU}NMc3-J2Hq/aJI*ANiC]sPB)4oQX;[*!~Fx]BnP4b');
define('AUTH_SALT', ';YId_|NBUPp#[iNotOu|jRgJi.L:M9>eOr}U>!Gstr-&W#23UEssq7cL!-:5N{B=');
define('SECURE_AUTH_SALT', 'V^k:K3IFM^g+.iFo%0u3nA!VU2nF/M1|[).:Lstz&jqSWCwOb=O>UI&+7V[_^4iv');
define('LOGGED_IN_SALT', 'dc#y:{rx^LP/uilATlk$+akTU-S|HaZi!T@nD{(3L=k0O/h?DeuvM;7Eq[X}+D(`');
define('NONCE_SALT', '#spw%;RPK#-KN0O>{h{e5SS%W~_ %02TWn1b-~|X(}_*Xa%>fsIO|#=UAx$:s]%e');

//CUSTOM
define('AUTOMATIC_UPDATER_DISABLED', true);
// define('DISABLE_WP_CRON', true);
define('DISALLOW_FILE_EDIT', true);


//CONNECT TO WP
if (! defined('ABSPATH')) {
    define('ABSPATH', $webroot_dir.'/wp/');
}
