<?php



/*
|----------------------------------------------------------------
| Make sure YouKnow Foundation is available
|----------------------------------------------------------------
| The theme relies on the YouKnow foundation for a lot of the
| functionality it offers. As such, we need to be sure that we
| have it available for this theme to run properly.
*/
if (! class_exists('App\Framework\Container')) {
    if (is_admin()) {
        add_action('admin_notices', function () {
            echo "<div class='notice notice-error'><p>The You Know foundation plugin is not currently active. The theme will break without it.</p></div>";
        });
    }
    return;
}


/*
|----------------------------------------------------------------
| Include the autoloader
|----------------------------------------------------------------
| The theme also uses a Composer-based autoloader. While we don't
| require multiple packages, we want to be able to require any
| of our core theme files automatically.
*/
$composer = __DIR__.'/vendor/autoload.php';
if (! file_exists($composer)) {
    if (is_admin()) {
        add_action('admin_notices', function () {
            echo "<div class='notice notice-error'><h3>Autoloader not found.</h3><p>You must run <code>composer install</code> from the youknow-theme directory.</p></div>";
        });
    }
    return;
}
require_once $composer;


/*
|----------------------------------------------------------------
| Define Theme Constants
|----------------------------------------------------------------
| There are key paths/uris that we need to be aware of within the
| theme. As with the plugin, we define them using constants, so
| that we can access them throughout the application as needed.
*/
define('YK_THEME_PATH', rtrim(get_template_directory(), '/'));
define('YK_THEME_URL', rtrim(get_template_directory_uri(), '/'));

define('YK_THEME_ASSET_URL', YOUKNOW_FRONTEND_ASSETS_URL);
define('YK_THEME_VERSION', '3.1.0');
define('YK_BASE_URI', WP_HOME);

/*
|----------------------------------------------------------------
| Register Theme in the IOC container
|----------------------------------------------------------------
| The Container is a core component of YouKnow Foundation, and it
| includes a number of critical details, e.g., config settings.
| Here we also register the theme as a service provider so
| our plugins can utilize the theme more easily as well.
*/
$app = App\Framework\Container::getInstance();
$app->register(new YouKnow\ThemeServiceProvider($app));


/*
|----------------------------------------------------------------
| Upon Theme Activation
|----------------------------------------------------------------
| When the theme is activated we need to do a few things, e.g.,
| create home pages for each org within our system.
*/
add_action('after_switch_theme', function ($oldtheme_name, $oldtheme) {
    if (! class_exists('App\Framework\Container')) {
        switch_theme($oldtheme->stylesheet);
        return false;
    } else {
        $activation = new YouKnow\ThemeActivation();
        $activation->run();
    }
}, 10, 2);

function move_categories()
{
    
}

