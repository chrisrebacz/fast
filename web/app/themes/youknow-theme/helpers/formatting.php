<?php

//
add_filter('show_admin_bar', '__return_false');


function youknow_custom_excerpt_length ($length) {
    return 60;
}
add_filter('excerpt_length', 'youknow_custom_excerpt_length');

function deregisterAdminBarAssetsOnFrontend() {
    if (! is_admin()) {
        wp_deregister_script('thickbox');
        wp_deregister_script('jquery');
        wp_deregister_style('dashicons');
        wp_deregister_style('thickbox');

        wp_register_script('jquery', YK_THEME_ASSET_URL.'/js/jquery.js', false, '1.12.4');
        wp_enqueue_script('jquery');
    }
}
add_action('wp_enqueue_scripts', 'deregisterAdminBarAssetsOnFrontend');


function disable_emojis()
{
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
    add_filter('wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2);
}
add_action('init', 'disable_emojis');

function disable_emojis_tinymce($plugins)
{
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    } else {
        return array();
    }
}

function disable_emojis_remove_dns_prefetch($urls, $relation_type)
{
    if ('dns-prefetch' == $relation_type) {
        /** This filter is documented in wp-includes/formatting.php */
        $emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/');
        $urls = array_diff($urls, array($emoji_svg_url));
    }
    return $urls;
}

if (function_exists('add_theme_support')) {
    //opt in to some options that themes can support but that aren't
    //turned on by default like thumbnailed images or using post-foormats.
    add_theme_support('post-formats', array('link', 'quote', 'video', 'image', 'audio'));
    add_theme_support('post-thumbnails');
}

if (function_exists('add_image_size')) {
    //identify the image sizes that you would like for media uploads. WP will
    //generate a version for that particular size.
    add_image_size('gallery-thumbnail-small', 160, 160, true);
    add_image_size('gallery-thumbnail-medium', 240, 240, true);
    add_image_size('gallery-thumbnail-large', 320, 320, true);
    add_image_size('featured-image', 800, 9999, true);
}
