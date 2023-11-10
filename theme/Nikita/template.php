<?php if(!defined('IN_GS')){ die('you cannot load this page directly.'); } ?>
<!DOCTYPE html>
<html lang ="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php get_page_clean_title(); ?></title>
        <?php get_header(); ?>
        <link href="<?php get_theme_url(); ?>/reset.css" rel="stylesheet">
        <link href="<?php get_theme_url(); ?>/default.css" rel="stylesheet">
        <link href="<?php get_theme_url(); ?>/style.css" rel="stylesheet">
    </head>
    <body>
        <nav><?php get_component('navbar'); ?></nav>
        <h1><?php get_page_title(); ?></h1>
        <?php get_page_content(); ?>
        <?php get_component('copyright'); ?>
    </body>
</html>
