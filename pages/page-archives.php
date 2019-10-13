<?php
/**
template name: 文章归档模板
*/
$arc_tags = wp_tag_cloud(array(
    'unit'=>'px',
    'smallest'=>14,
    'largest'=>14,
    'number'=>25,
    'format'=>'flat',
    'orderby'=>'cont',
    'order'=>'RAND',
    'echo'=>FALSE
));
$arr=["dark","success","warning","primary","danger","info"];
$the_query = new WP_Query('posts_per_page=-1&ignore_sticky_posts=1');
$year=0;
while($the_query->have_posts()):
    $the_query->the_post();
    $year_tmp = get_the_time('Y-m');
    if($year!=$year_tmp){
        $r=rand(0,5);
        $year = $year_tmp;
        $output.='<li class="tl-header"><h2 class="btn btn-sm btn-'.$arr[$r].' btn-rounded m-t-none" id="archive-year-'.$year.'">'.$year.'</h2></li>';
    }
    $output.='<div class="tl-body" ><li class="tl-item"><div class="tl-wrap b-'.$arr[$r].'"><span class="tl-date">'.get_the_time('d').'日'.'</span><h3 class="tl-content panel padder h5 l-h bg-'.$arr[$r].'"><span class="arrow arrow-'.$arr[$r].' left pull-up" aria-hidden="true"></span><a href="'.get_permalink().'" class="text-lt">'.get_the_title().'</a></h3></div></li></div>';
endwhile;
$output.='<li class="tl-header"><div class="btn btn-sm btn-default btn-rounded">开始</div></li>';
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
    <div id="kratos-blog-post">
    <div id="container" class="container">
        <div class="row">
            <?php if(kratos_option('page_side_bar')=='left_side' && $_COOKIE['goto_bibo']!=1){ ?>
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
                        <div class="kratos-post-content">
                            <div id="archives">
                                <h2 class="title-h2" style="text-align:center;font-size:18pt">文章归档</h2>
                                <p style="text-align:center"><span style="color:#999">当前共有<?php echo wp_count_posts()->publish;echo '篇公开日志';echo wp_count_posts('page')->publish;echo'个公开页面。 (゜-゜)つロ 干杯~'?></span></p>
                            <hr/>
                                <h4>Tags</h4>
                                <div class="arc-tag">
                                <?php echo $arc_tags; ?>
                                </div>
                            <hr/>
                                <h4>Archives</h4>
                                <?php echo $output; ?>
                            </div>
                            <hr/>
                        </div>
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
        </div>
    </div>
</div>

<?php get_footer(); ?>