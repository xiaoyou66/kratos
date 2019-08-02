<?php


define('KRATOS_VERSION','1.0');
require(get_template_directory().'/theme-updates/theme-update-checker.php'); //支持主题更新
$example_update_checker=new ThemeUpdateChecker(
    'kratos',
    'http://xiaoyou66.com/theme.json'
);

require_once(get_template_directory().'/inc/core.php');
require_once(get_template_directory().'/inc/shortcode.php');
require_once(get_template_directory().'/inc/imgcfg.php');
require_once(get_template_directory().'/inc/post.php');
require_once(get_template_directory().'/inc/ua.php');
require_once(get_template_directory().'/inc/widgets.php');
require_once(get_template_directory().'/inc/smtp.php');
require_once(get_template_directory().'/inc/logincfg.php');
require_once(get_template_directory().'/inc/avatars.php');
require_once(get_template_directory().'/inc/myfunction.php');
require_once(get_template_directory().'/inc/live2d/live2d.php');//引入live2d界面



