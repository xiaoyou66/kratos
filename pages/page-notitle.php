<?php
/**
Template Name: 无标题页面模版
*/
get_header(); ?>
<?php if($_COOKIE['goto_bibo']==1){
    include dirname(__FILE__)."/bilibililive/BilibiliLive.php";
    $bilibilUid=kratos_option('bilibili_uid');
    $bilibililive=new BilibiliLive($bilibilUid);?>
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
                <a target="_blank" href="https://space.bilibili.com/<?php echo $bilibilUid?>"><div class="weixin">关注</div></a>
                <a target="_blank" class="qq" href="https://message.bilibili.com/#whisper/mid<?php echo $bilibilUid?>">发私信</a>
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
<?php }?>
    <div id="container" class="container">
        <div class="row">
            <?php if(kratos_option('page_side_bar')=='left_side'){ ?>
                <aside id="kratos-widget-area" class="col-md-4 hidden-xs hidden-sm scrollspy">
                    <div id="sidebar" class="affix-top">
                        <?php dynamic_sidebar('sidebar_tool'); ?>
                    </div>
                </aside>
            <?php } ?>
            <?php if($_COOKIE['goto_bibo']!=1){?>
            <section id="main" class='<?php echo (kratos_option('page_side_bar')=='center')?'col-md-12':'col-md-8'; ?>'>
                <?php }else{?>
                <section  class='width'>
            <?php }?>
            <?php if(have_posts()){the_post(); ?>
                <article>
                    <div class="kratos-hentry kratos-post-inner clearfix">
                        <div class="kratos-post-content"><?php the_content(); ?></div>
                        <?php if(kratos_option('page_cc')){ ?>
                        <div class="kratos-copyright text-center clearfix">
                            <h5>本作品采用<a rel="license nofollow" target="_blank" href="http://creativecommons.org/licenses/by-sa/4.0/">知识共享署名-相同方式共享 4.0 国际许可协议</a> 进行许可</h5>
                        </div>
                        <?php } ?>
                        <?php if(kratos_option('page_like_donate')||kratos_option('page_share')){ ?>
                        <footer class="kratos-entry-footer clearfix">
                            <div class="post-like-donate text-center clearfix" id="post-like-donate"><?php
                                if(kratos_option('page_like_donate')) echo '<a href="javascript:;" class="Donate"><i class="fa fa-bitcoin"></i> 打赏</a>';
                                if(kratos_option('page_share')){
                                    echo '<a href="javascript:;" class="Share"><i class="fa fa-share-alt"></i>分享</a>';
                                    require_once(get_template_directory().'/inc/share.php');
                                } ?>
                            </div>
                        </footer>
                        <?php } ?>
                    </div>
                    <?php comments_template(); ?>
                </article>
            <?php } ?>
            </section>
        <?php if($_COOKIE['goto_bibo']!=1){?>
                <?php if(kratos_option('page_side_bar')=='right_side'){ ?>
                <aside id="kratos-widget-area" class="col-md-4 hidden-xs hidden-sm scrollspy">
                    <div id="sidebar" class="affix-top">
                        <?php dynamic_sidebar('sidebar_tool'); ?>
                    </div>
                </aside>
                <?php } ?>
        <?php }?>
        </div><?php
        if(current_user_can('manage_options')&&is_single()||is_page()){ ?><div class="cd-tool text-center"><div class="<?php if(kratos_option('cd_weixin')) echo 'edit-box2 '; ?>edit-box"><?php echo edit_post_link('<span class="fa fa-pencil"></span>'); ?></div></div><?php } ?>
    </div>
</div>
<?php get_footer(); ?>