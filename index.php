<?php get_header(); ?>
<?php if($_COOKIE['goto_bibo']==1){
    include dirname(__FILE__)."/pages/bilibililive/BilibiliLive.php";
    $bilibilUid=kratos_option('bilibili_uid');
    $bilibililive=new BilibiliLive($bilibilUid);
?>
    <div id="wrapper"  class="theme" style="background:url(<?php echo kratos_option('bibo_background')?>) no-repeat top center; padding-top:50px;background-color: white;background-attachment:fixed;background-size:100%;">
        <header id="header" class="site-header">
            <!-- 导航结束 -->
            <section class="banner bg" style="background-image: url(<?php echo $bilibililive->spacepicture?>)">
                <div class="big-title">
                        <h1 class="big-title-h1" ><?php echo $bilibililive->usrname ?>
                            <span id="h-gender" class="icon gender male"></span>
                            <a href="//www.bilibili.com/html/help.html#k" target="_blank" lvl="<?php echo $bilibililive->level ?>" class="h-level m-level"></a>
                            <?php
                            if($bilibililive->isvip){
                                ?>
                                <a href="//account.bilibili.com/account/big" target="_blank" class="h-vipType">年度大会员</a>
                            <?php }?>
                        </h1>
                    <h3 class="big-title-h3 tips-top" aria-label="<?php echo $bilibililive->sign ?>" id="yiyan"><?php echo $bilibililive->sign ?>
                        <br></h3>
                </div>
                <div class="contactme">
                    <a  target="_blank" href="https://space.bilibili.com/<?php echo $bilibilUid?>"><div class="weixin">关注</div></a>
                    <a  target="_blank" class="qq" href="https://message.bilibili.com/#whisper/mid<?php echo $bilibilUid?>">发私信</a>
                </div>
            </section>
            <div class="touxiang">
                <a href="https://space.bilibili.com/<?php echo $bilibilUid?>" target="_top">
                    <img src="<?php echo $bilibililive->advanter ?>" alt="头像"></a>
                <span class="renzheng" style="background-image:url(<?php echo  bloginfo('template_url').'/pages/';?>bilibililive/images/icon2.png);"></span>
            </div>
            <div class="banner-item width">
                <a target="_blank" class="active" href="https://space.bilibili.com/<?php echo $bilibilUid?>">我的主页</a>
                <a target="_blank" href="https://space.bilibili.com/<?php echo $bilibilUid?>/album">我的相册</a></div>
        </header>
        <div id="kratos-blog-post">
        <div id="container" class="container">
        <section id="contents" class="width">
            <!-- 侧边栏 -->
            <aside id="aside" class="left">
                <div class="inner wow bounceInLeft">
                    <div class="sns web-info">
                        <li class="frinum">
                            <a href="https://space.bilibili.com/<?php echo $bilibilUid?>/fans/follow"><?php echo $bilibililive->attation?>
                                <span>关注数</span></a>
                        </li>
                        <li class="vitnum">
                            <a href="https://space.bilibili.com/<?php echo $bilibilUid?>/fans/fans"><?php echo $bilibililive->fans?>
                                <span>粉丝数</span></a>
                        </li>
                        <li class="ptnum">
                            <?php echo $bilibililive->play?>
                            <span>播放数</span>
                        </li>
                    </div>
                    <div class="sns master-info">
                        <div class="person-info">
                            <li class="item">
                                <div class="row user-auth"><span title="<?php echo kratos_option('bibo_auth');?>" class="auth-description"><a href="https://space.bilibili.com/<?php echo $bilibilUid?>" title="个人认证" target="_blank" class="auth-icon personal-auth"></a><!---->
                            bilibili个人认证<br><?php echo kratos_option('bibo_auth');?>
                          </span></div>
                            </li>
                        </div>
                        <ul class="m_info-items">
                            <?php if(kratos_option('bibo_palce')){?>
                                <li class="item">
                                    <i class="icon louie-location"></i>
                                    <span class="tips-right" aria-label="<?php echo kratos_option('bibo_palce');?>"><?php echo kratos_option('bibo_palce');?></span></li>
                            <?php }?>
                            <li class="item">
                                <i class="icon louie-time-o"></i>
                                <span class="tips-right" aria-label="我的生日：<?php echo $bilibililive->birthday ?>">生日：<?php echo $bilibililive->birthday ?></span></li>
                            <?php if(kratos_option('bibo_descript')){?>
                                <li class="item">
                                    <i class="icon louie-smiling"></i>
                                    <span class="tips-right" aria-label="<?php echo kratos_option('bibo_descript');?>">简介：<?php echo kratos_option('bibo_descript');?></span></li>
                            <?php }?>
                            <li class="item last">
                                <i class="icon louie-link-o"></i>
                                <a class="tips-right" aria-label="个性域名" href="<?php echo kratos_option('bibo_pushlink');?>" target="_blank"><?php echo kratos_option('bibo_push');?></a></li>
                        </ul>
                        <div class="sns readmore">
                            <a href="<?php echo kratos_option('bibo_more');?>">查看更多&nbsp;&gt;</a></div>
                    </div>
                    <?php if(kratos_option('bibo_post')){?>}
                    <div class="alteration">
                        <div class="widget">
                            <h3 class="widget-title">
                                <i class="icon louie-notice"></i>公告</h3>
                            <div class="textwidget">
                                <!-- 评论 -->
                                <div class="info">
                                    <?php echo kratos_option('bibo_post');?>
                                </div>
                                <!-- 评论结束 -->
                            </div>
                        </div>
                    </div>
                    <?php }?>
                    <?php if(kratos_option('bibo_post')){?>
                            <div class="widget">
                                <h3 class="widget-title">
                                    <i class="icon icon louie-smile"></i>友情链接(随机10个)</h3>
                                <ul class="items links-bar">
                                    <!-- 友链 -->
                                    <?php
                                    $bookmarks = get_bookmarks(array('orderby'=>'rand'));
                                    if(!empty($bookmarks)){
                                        $i=0;
                                        foreach($bookmarks as $bookmark){
                                            echo '<li class="item"><a href="'.$bookmark->link_url.'" target="_blank" title="'.$bookmark->link_description.'">'.$bookmark->link_name.'</a></li>';
                                            $i++;
                                            if($i==10) break;
                                        }
                                    } ?>
                                    <!-- 友链结束 -->
                                </ul>
                            </div>
                        <?php }?>
                        <?php if(kratos_option('bibo_hot')){?>
                            <div class="widget">
                                <h3 class="widget-title">
                                    <i class="icon louie-trend"></i>热门文章</h3>
                                <ul class="items hot-views">
                                    <li class="item">
                                        <!-- 文章排行榜 -->
                                        <?php most_hot_posts(180,10); ?>
                                        <!-- 结束 -->
                                    </li>
                                </ul>
                            </div>
                        <?php }?>
                    </div>
            </aside>
    <div id="loop" class="right">
            <!-- 实现看板娘的灵活切换-->
            <style><?php
                $style=kratos_option('wifuside');
                $position=substr($style,0,strripos($style,':'));
                $value=substr($style,strripos($style,':')+1);
                echo '.waifu {'.$position.':'.$value.'px;}';
                ?></style>
                <?php if(kratos_option('home_side_bar')=='left_side'){ ?>
                    <aside class="col-md-4 hidden-xs hidden-sm scrollspy">
                        <div id="sidebar" class="affix-top">
                            <?php dynamic_sidebar('sidebar_tool'); ?>
                        </div>
                    </aside>
                <?php } ?>
                    <?php
                    if(is_home()){kratos_banner();}
                    elseif(is_category()){
                        if(kratos_option('show_head_cat')){ ?>
                            <div class="kratos-hentry clearfix">
                                <h1 class="kratos-post-header-title">分类<?php echo single_cat_title('',false); ?></h1>
                                <h1 class="kratos-post-header-title"><?php echo category_description(); ?></h1>
                            </div>
                        <?php }
                    }elseif(is_tag()){
                        if(kratos_option('show_head_tag')){ ?>
                            <div class="kratos-hentry clearfix">
                                <h1 class="kratos-post-header-title">标签：<?php echo single_cat_title('',false); ?></h1>
                                <h1 class="kratos-post-header-title"><?php echo category_description(); ?></h1>
                            </div>
                        <?php }
                    }elseif(is_search()){ ?>
                        <div class="kratos-hentry clearfix">
                            <h1 class="kratos-post-header-title">搜索结果：<?php the_search_query(); ?></h1>
                        </div>
                    <?php }
                    if(have_posts()){
                        while(have_posts()){
                            the_post();
                            get_template_part('/inc/content-templates/content',get_post_format());
                        }
                    }else{ ?>
                        <div class="kratos-hentry clearfix">
                            <h1 class="kratos-post-header-title">很抱歉，没有找到任何内容。</h1>
                        </div>
                    <?php }
                    kratos_pages(3);wp_reset_query(); ?>
                </section>
            <script src="<?php echo bloginfo('template_url').'/static/js/weixinAudio.js';?>"></script>
            <?php if(kratos_option('animal_load')){?>
                <script src = "<?php echo  bloginfo('template_url').'/static/js/wow.min.js';?>" ></script >
            <?php }?>
            <script type="text/javascript">
                $('.weixinAudio').weixinAudio({
                });
                //    动画脚本
                new WOW().init();
            </script>
    </div>
     </section>
    </div>
    </div>
 <?php }else{ ?>
    <div id="container" class="container">
<!-- 实现看板娘的灵活切换-->
        <style><?php
            $style=kratos_option('wifuside');
            $position=substr($style,0,strripos($style,':'));
            $value=substr($style,strripos($style,':')+1);
            echo '.waifu {'.$position.':'.$value.'px;}';
        ?></style>
        <div class="row">
            <?php if(kratos_option('home_side_bar')=='left_side'){ ?>
                <aside class="col-md-4 hidden-xs hidden-sm scrollspy">
                    <div id="sidebar" class="affix-top">
                        <?php dynamic_sidebar('sidebar_tool'); ?>
                    </div>
                </aside>
            <?php } ?>
            <section id="main" class="<?php echo (kratos_option('home_side_bar')=='center')?'col-md-12':'col-md-8'; ?>">
            <?php
                if(is_home()){kratos_banner();}
                elseif(is_category()){
            if(kratos_option('show_head_cat')){ ?>
                <div class="kratos-hentry clearfix">
                    <h1 class="kratos-post-header-title">分类：<?php echo single_cat_title('',false); ?></h1>
                    <h1 class="kratos-post-header-title"><?php echo category_description(); ?></h1>
                </div>    
            <?php }
                }elseif(is_tag()){
            if(kratos_option('show_head_tag')){ ?>
                <div class="kratos-hentry clearfix">
                    <h1 class="kratos-post-header-title">标签： <?php echo single_cat_title('',false); ?></h1>
                    <h1 class="kratos-post-header-title"><?php echo category_description(); ?></h1>
                </div>
            <?php }
                }elseif(is_search()){ ?>
                <div class="kratos-hentry clearfix">
                    <h1 class="kratos-post-header-title">搜索结果：<?php the_search_query(); ?></h1>
                </div>                
            <?php }
                if(have_posts()){
                    while(have_posts()){
                        the_post();
                        get_template_part('/inc/content-templates/content',get_post_format());
                    }
                }else{ ?>
            <div class="kratos-hentry clearfix">
                    <h1 class="kratos-post-header-title">很抱歉，没有找到任何内容。</h1>
            </div>
            <?php }
                kratos_pages(3);wp_reset_query(); ?>
            </section>
        <?php if(kratos_option('home_side_bar')=='right_side'){ ?>
            <aside class="col-md-4 hidden-xs hidden-sm scrollspy">
<!--                id="kratos-widget-area"-->
                <div id="sidebar" class="affix-top wow bounceInRight">
                    <?php dynamic_sidebar('sidebar_tool'); ?>
                </div>
            </aside>
            <?php }?>
        </div>
        <script src="<?php echo  bloginfo('template_url').'/static/js/weixinAudio.js';?>"></script>
        <!--音乐播放器-->
        <?php if(kratos_option('animal_load')){?>
            <script src = "<?php echo  bloginfo('template_url').'/static/js/wow.min.js';?>" ></script >
        <?php }?>
        <script type="text/javascript">
            $('.weixinAudio').weixinAudio({
            });
        //    动画脚本
            new WOW().init();
        </script>
    </div>
</div>
<?php }?>
<?php get_footer(); ?>