<!DOCTYPE HTML>
<html <?php language_attributes(); ?>>
<?php
/*B博处理函数*/
/*先判断是否需要跳转B博*/
//if($_REQUEST["style"]=='krato'){if(isset($_COOKIE['goto_bibo'])){setcookie('goto_bibo',0);}}
if(kratos_option('bibo_pagelink')) {
    if ($_REQUEST["style"] == 'krato') {
        setcookie('goto_bibo', 0);
        header("location:" . site_url());
        exit();
    }
    /*重定向*/
    if (is_home() || is_front_page()) {
        if (kratos_option('bibo_gotobibo') && kratos_option('bibo_pagelink')) {
            header("location:" . kratos_option('bibo_pagelink'));
            exit;
        }
        /*如果cookie记录了那么也直接跳转*/
        if ($_COOKIE['goto_bibo'] == 1) {
            header("location:" . kratos_option('bibo_pagelink'));
            exit;
        }
    }
    /*这里传入get请求，用于切换博客风格*/
    //if($_REQUEST["style"]=='bibo'){header("location:".kratos_option('bibo_pagelink'));if(isset($_COOKIE['goto_bibo'])){unset($_COOKIE['goto_bibo']);setcookie('goto_bibo',1);}else{setcookie('goto_bibo',1);}exit;}
    if ($_REQUEST["style"] == 'bibo') {
        header("location:" . kratos_option('bibo_pagelink'));
        setcookie('goto_bibo', 1);
        exit;
    }
}
else
{
    setcookie('goto_bibo', 0);
}
if($_COOKIE['goto_bibo']==1){
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="Cache-Control" content="no-transform">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <meta name="format-detection" content="telphone=no,email=no">
    <meta name="keywords" content="<?php kratos_keywords(); ?>">
    <meta name="description" itemprop="description" content="<?php kratos_description(); ?>">
    <meta property="og:title" content="<?php wp_title('-',true,'right'); ?>">
    <meta property="og:site_name" content="<?php wp_title('-',true,'right'); ?>">
    <meta property="og:type" content="website">
    <meta property="og:description" content="<?php kratos_description(); ?>">
    <meta property="og:url" content="<?php if(!is_home()) echo get_permalink(); else echo get_bloginfo('home'); ?>">
    <meta name="twitter:title" content="<?php wp_title('-',true,'right'); ?>">
    <meta name="twitter:description" content="<?php kratos_description(); ?>">
    <meta name="twitter:card" content="summary">
    <!-- 允许访问站外资源 -->
    <!--仅同源网站发送请求-->
    <meta name="referrer" content="same-origin">
    <link rel="icon" type="image/x-icon" href="<?php echo kratos_option('site_ico'); ?>">
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.10/highlight.min.js"></script>
    <title><?php wp_title('-',true,'right'); ?></title>
    <?php wp_head();wp_print_scripts('theme-jq'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo  bloginfo('template_url').'/inc/live2d/waifu.css';?>"/>
    <link rel="stylesheet" href="<?php echo  bloginfo('template_url').'/pages/';?>bilibililive/style/style.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="<?php echo  bloginfo('template_url').'/pages/';?>bilibililive/style/main.css">
    <style>
        #offcanvas-menu{background:#3a3f51;top:190px;width:198px;}
    </style>
</head>
<?php flush(); ?>
<body class="home blog" style="background-image: url(<?php echo  bloginfo('template_url').'/pages/';?>bilibililive/images/body_repeat.png); background-color: #d4d5e0; background-repeat: repeat-x; background-position: center 0;">
<div id="kratos-wrapper">
    <div id="kratos-page">
        <div id="sider-bar">
            <div class="clearfix  text-center hide  show" id="aside-user">
                <div class="dropdown wrapper">
                    <div ui-nav="">
                        <a href="<?php echo kratos_option('person_link'); ?>">
                            <span class="thumb-lg w-auto-folded avatar m-t-sm">
                                <img src="<?php echo kratos_option('phone_sideer_image'); ?>" class="img-full">
                            </span>
                        </a>
                    </div>
                    <span class="clear">
                              <span class="block m-t-sm">
                                <strong class="font-bold text-lt" style="color: #848484"><?php echo kratos_option('person_nickname'); ?></strong>
                              </span><br>
                              <span class="text-muted text-xs block" style="color: #848484"><?php echo kratos_option('person_sign'); ?></span>
                            </span>
                </div>
                <div class="line dk hidden-folded"></div>
            </div>
        </div>
        <div id="kratos-header">
            <?php if(has_nav_menu('header_menu')&&(kratos_option('head_mode')!='pic'||kratos_option('mobi_mode')=='side')): ?>
                <div class="nav-toggle"><a class="kratos-nav-toggle js-kratos-nav-toggle"><i></i></a></div>
            <?php endif; ?>
            <header id="kratos-header-section"<?php if(kratos_option('head_mode')!='pic') echo ' class="color-banner" style="background:rgba('.kratos_option('banner_color').')"'; ?>>
                <div class="container">
                    <div class="nav-header">
                        <?php if(kratos_option('head_mode')!='pic'): ?>
                            <div class="color-logo"><a href="<?php echo get_option('home'); ?>"><?php if(!kratos_option('banner_logo')) echo bloginfo('name'); else echo '<img src="'.kratos_option('banner_logo').'">'; ?></a></div>
                        <?php endif; ?>
                        <?php $defaults = array('theme_location'=>'header_menu','container'=>'nav','container_id'=>'kratos-menu-wrap','menu_class'=>'sf-menu','menu_id'=>'kratos-primary-menu',);
                        wp_nav_menu($defaults); ?>
                    </div>
                </div>
                <link rel="stylesheet" type="text/css" href="<?php echo  bloginfo('template_url').'/static/css/prism.css';?>"/>
                <link rel="stylesheet" type="text/css" href="<?php echo  bloginfo('template_url').'/inc/live2d/waifu.css';?>"/>
                <?php if(kratos_option('animal_load')){?>
                    <link rel="stylesheet" type="text/css" href="<?php echo  bloginfo('template_url').'/static/css/animate.min.css';?>"/>
                <?php }?>
            </header>
        </div>

<?php }else{ ?>
  <head>
    <meta charset="<?php bloginfo('charset'); ?>">
<!--      pjax强制重载-->
    <meta http-equiv="Cache-Control" content="no-transform">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <meta name="format-detection" content="telphone=no,email=no">
    <meta name="keywords" content="<?php kratos_keywords(); ?>">
    <meta name="description" itemprop="description" content="<?php kratos_description(); ?>">
    <meta property="og:title" content="<?php wp_title('-',true,'right'); ?>">
    <meta property="og:site_name" content="<?php wp_title('-',true,'right'); ?>">
    <meta property="og:type" content="website">
    <meta property="og:description" content="<?php kratos_description(); ?>">
    <meta property="og:url" content="<?php if(!is_home()) echo get_permalink(); else echo get_bloginfo('home'); ?>">
    <meta name="twitter:title" content="<?php wp_title('-',true,'right'); ?>">
    <meta name="twitter:description" content="<?php kratos_description(); ?>">
    <meta name="twitter:card" content="summary">
    <!-- 允许访问站外资源 -->
    <meta name="referrer" content="same-origin">
    <link rel="icon" type="image/x-icon" href="<?php echo kratos_option('site_ico'); ?>">
    <!-- 新 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" type="text/css" href="<?php echo  bloginfo('template_url').'/static/css/bootstrap.min.css';?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo  bloginfo('template_url').'/pages/';?>bilibililive/style/style.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.10/highlight.min.js"></script>
    <title><?php wp_title('-',true,'right'); ?></title>
    <?php wp_head();wp_print_scripts('theme-jq'); ?>
    <style><?php
        echo '#offcanvas-menu{background:#3a3f51}';
        if(kratos_option('head_mode')=='pic'){
            echo '.affix{top:61px}.kratos-cover.kratos-cover_2{background-image:url('.kratos_option('background_image').')}';
            if(kratos_option('background_image_mobi')) echo '@media(max-width:768px){.kratos-cover.kratos-cover_2{background-image:url('.kratos_option('background_image_mobi').')}}';
            if(kratos_option('mobi_mode')=='side') echo '@media(max-width:768px){#kratos-header-section{display:none}nav#offcanvas-menu{top:0;padding-top:190px;}.kratos-cover .desc.desc2{margin-top:-55px}}';
        }
//        背景图片
        if(kratos_option('background_mode')=='image') echo '@media(min-width:768px){.pagination>li>a{background-color:rgba(255,255,255,.9)}.comment-list .children li{background-color:rgba(255,253,232,.7)!important}.theme-bg{background-image:url('.kratos_option('background_index_image').');background-size:cover;background-attachment:fixed}}';
        if(kratos_option('openphoneimg')) echo'@media(max-width:768px){.theme-bg{background-image:url('.kratos_option('phone_img').');background-position: center center;top:0;}}';
        if(kratos_option('add_css')) echo kratos_option('add_css');
        ?>
    </style>
      <link rel="stylesheet" type="text/css" href="<?php echo  bloginfo('template_url').'/static/css/prism.css';?>"/>
      <link rel="stylesheet" type="text/css" href="<?php echo  bloginfo('template_url').'/inc/live2d/waifu.css';?>"/>
      <?php if(kratos_option('animal_load')){?>
          <link rel="stylesheet" type="text/css" href="<?php echo  bloginfo('template_url').'/static/css/animate.min.css';?>"/>
      <?php }?>
  </head>
    <?php flush(); ?>
    <body>
    <div class="theme-bg" <?php if(kratos_option('background_mode')=='image') echo 'class="custom-background"'; ?>></div>
    <div id="kratos-wrapper">
            <div id="kratos-page">
                <div id="sider-bar">
                    <div class="clearfix  text-center hide  show" id="aside-user">
                        <div class="dropdown wrapper">
                            <div ui-nav="">
                                <a href="<?php echo kratos_option('person_link'); ?>">
                                    <span class="thumb-lg w-auto-folded avatar m-t-sm">
                                        <img src="<?php echo kratos_option('phone_sideer_image'); ?>" class="img-full">
                                    </span>
                                </a>
                            </div>
                            <span class="clear">
                              <span class="block m-t-sm">
                                <strong class="font-bold text-lt"><?php echo kratos_option('person_nickname'); ?></strong>
                              </span><br>
                              <span class="text-muted text-xs block"><?php echo kratos_option('person_sign'); ?></span>
                            </span>
                        </div>
                        <div class="line dk hidden-folded"></div>
                    </div>
                </div>
                <div id="kratos-header">
                    <?php if(has_nav_menu('header_menu')&&(kratos_option('head_mode')!='pic'||kratos_option('mobi_mode')=='side')): ?>
                    <div class="nav-toggle"><a class="kratos-nav-toggle js-kratos-nav-toggle"><i></i></a></div>
                    <?php endif; ?>
                    <header id="kratos-header-section"<?php if(kratos_option('head_mode')!='pic') echo ' class="color-banner" style="background:rgba('.kratos_option('banner_color').')"'; ?>>
                        <div class="container">
                            <div class="nav-header">
                                <?php if(kratos_option('head_mode')!='pic'): ?>
                                <div class="color-logo"><a href="<?php echo get_option('home'); ?>"><?php if(!kratos_option('banner_logo')) echo bloginfo('name'); else echo '<img src="'.kratos_option('banner_logo').'">'; ?></a></div>
                                <?php endif; ?>
                                <?php $defaults = array('theme_location'=>'header_menu','container'=>'nav','container_id'=>'kratos-menu-wrap','menu_class'=>'sf-menu','menu_id'=>'kratos-primary-menu',);
                                wp_nav_menu($defaults); ?>
                            </div>
                        </div>
                    </header>
                </div>
                <?php if(kratos_option('head_mode')=='pic'){ ?>
                <div class="kratos-start kratos-hero-2">
                    <div class="kratos-overlay"></div>
                    <div class="kratos-cover kratos-cover_2 text-center">
                        <div class="desc desc2 animate-box">
                            <a href="<?php echo get_bloginfo('url'); ?>"><h2><?php echo kratos_option('background_image_text1'); ?></h2><br><span><?php echo  kratos_option('background_image_text2'); ?></span></a>
                        </div>
                    </div>
                </div>
                <?php }else{ ?>
                <div class="kratos-start kratos-hero"></div>
                <?php } ?>
                <div id="kratos-blog-post" <?php if(kratos_option('background_mode')=='color') echo 'style="background:'.kratos_option('background_index_color').'"'; ?>>

<?php }?>