<!DOCTYPE html>
<!--[if IE 8 ]>    <html lang="en" class="no-js ie9 ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="en-US" class="no-js">
<!--<![endif]-->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width" />
    <title><?php function_exists('get_youknow_formatted_title') ? get_youknow_formatted_title(): 'YouKnow'; ?></title>
    <link rel="shortcut icon" href="<?php echo YK_THEME_ASSET_URL.'/favicon.png?>';?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <div id="container">
        <?php get_template_part('layout/sidemenu', 'sidemenu'); ?>
        <?php get_template_part('layout/sidebar-right', 'sidebar-right'); ?>
        <div id="content-container">
            <?php get_template_part('layout/topnav', 'topnav'); ?>
            <div id="content">



