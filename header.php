<!DOCTYPE HTML>
<html <?php language_attributes(); ?>>
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
    <link rel="icon" type="image/x-icon" href="<?php echo kratos_option('site_ico'); ?>">
      <?php if(kratos_option('title_change')){?>
      <script>document.addEventListener('visibilitychange',function(){if(document.visibilityState=='hidden'){normal_title=document.title;document.title='<?php echo  kratos_option('title_change'); ?>';}else{document.title=normal_title;}});</script>
      <?php }?>
    <!-- 新 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" type="text/css" href="<?php echo  bloginfo('template_url').'/static/css/bootstrap.min.css';?>"/>
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
        if(kratos_option('background_mode')=='image') echo '@media(min-width:768px){.pagination>li>a{background-color:rgba(255,255,255,.9)}.kratos-hentry,.navigation div,.comments-area .comment-list li,#kratos-widget-area .widget,.comment-respond{background-color:rgba(255,255,255,.9)!important}.comment-list .children li{background-color:rgba(255,253,232,.7)!important}.theme-bg{background-image:url('.kratos_option('background_index_image').');background-size:cover;background-attachment:fixed}}';
        if(kratos_option('openphoneimg')) echo'@media(max-width:768px){.theme-bg{background-image:url('.kratos_option('phone_img').');background-position: center center;top:0;}}';
        if(kratos_option('add_css')) echo kratos_option('add_css');
        ?>
    </style>
      <link rel="stylesheet" type="text/css" href="<?php echo  bloginfo('template_url').'/static/css/prism.css';?>"/>
      <link rel="stylesheet" type="text/css" href="<?php echo  bloginfo('template_url').'/inc/live2d/waifu.css';?>"/>


  </head>
    <?php flush(); ?>
    <body>
    <div class="theme-bg" <?php if(kratos_option('background_mode')=='image') echo 'class="custom-background"'; ?>></div>
    <div id="kratos-wrapper">
            <div id="kratos-page">
                <div id="sider-bar">
                    <div class="clearfix hidden-xs text-center hide  show" id="aside-user">
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