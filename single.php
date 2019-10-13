<?php get_header(); ?>
<?php if($_COOKIE['goto_bibo']==1){
    include dirname(__FILE__)."/pages/bilibililive/BilibiliLive.php";
    $bilibilUid=kratos_option('bilibili_uid');
    $bilibililive=new BilibiliLive($bilibilUid);
?><div id="wrapper"  class="theme" style="background:url(<?php echo kratos_option('bibo_background')?>) no-repeat top center; padding-top:50px;background-color: white;background-attachment:fixed;background-size:100%;">
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
    <div id="kratos-blog-post">
    <div id="container" class="container">
<section id="contents" class="width">
<div id="loop" class="right" style="width: 100%;">
    <main id="main" class="width-half index" role="main" itemprop="mainContentOfPage" style="min-height: 514px;">
    <style><?php
        $style=kratos_option('wifuside');
        $position=substr($style,0,strripos($style,':'));
        $value=substr($style,strripos($style,':')+1);
        if(kratos_option('wifuchange'))
        {if($position='left') $position='right'; else $position='left';}
        echo '.waifu {' . $position . ':' . $value . 'px;}';
    ?></style>
        <script src="<?php echo  bloginfo('template_url').'/static/js/prism.js';?>"></script>
<!--        <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.10/highlight.min.js"></script>-->
        <div id="primary" class="list">
        <?php get_template_part('/inc/single-templates/single',get_post_format()); ?>
    </div>
        <?php if(current_user_can('manage_options')&&is_single()||is_page()){ ?><div class="cd-tool text-center"><div class="<?php if(kratos_option('cd_weixin')) echo 'edit-box2 '; ?>edit-box"><?php echo edit_post_link('<span class="fa fa-pencil"></span>'); ?></div></div><?php } ?>
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
            hljs.initHighlightingOnLoad();
        </script>
        <!-- 文章目录移动-->
        <script>
            //点击关闭后目录消失
            $('#category-close').click(function () {
                $('#article-index').remove();
            });
            var dragJob=false;
            $(document).on("mousedown", '#article-index-move', function (e) {
                dragJob = true;
            });
            document.onmousemove = function (e) {
                if (dragJob) {
                    var e = e || window.event;
                    var height = $(window).height();
                    var width = $(window).width();
                    var widthJob = $("#article-index").width();
                    var heightJob = $("#article-index").height();
                    var left = e.clientX- widthJob / 2;;
                    var top = e.clientY;
                    if (top >= 0 && top < height - heightJob) {
                        $("#article-index").css("top", top);
                    }
                    if (left >= 0 && left < width - widthJob) {
                        $("#article-index").css("left", left);
                    }
                    return false;
                }
            };
            $(document).mouseup(function (e) {
                dragJob = false;
            });
        </script>
    </main>
    </div>
</section>
</div>
</div>
</div>
<?php }else{?>
    <div id="container" class="container">
        <style><?php
            $style=kratos_option('wifuside');
            $position=substr($style,0,strripos($style,':'));
            $value=substr($style,strripos($style,':')+1);
            if(kratos_option('wifuchange'))
            {
                if($position='left') $position='right';
                else $position='left';
            }
            echo '.waifu {' . $position . ':' . $value . 'px;}';
        ?></style>
        <!-- 引入js文件-->
        <script src="<?php echo  bloginfo('template_url').'/static/js/prism.js';?>"></script>
        <div class="row">
        <?php get_template_part('/inc/single-templates/single',get_post_format()); ?>
        </div><?php
        if(current_user_can('manage_options')&&is_single()||is_page()){ ?><div class="cd-tool text-center"><div class="<?php if(kratos_option('cd_weixin')) echo 'edit-box2 '; ?>edit-box"><?php echo edit_post_link('<span class="fa fa-pencil"></span>'); ?></div></div><?php } ?>
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
            hljs.initHighlightingOnLoad();
        </script>
<!-- 文章目录移动-->
    <script>
        //点击关闭后目录消失
        $('#category-close').click(function () {
            $('#article-index').remove();
        });
        var dragJob=false;
        $(document).on("mousedown", '#article-index-move', function (e) {
            dragJob = true;
        });
        document.onmousemove = function (e) {
            if (dragJob) {
                var e = e || window.event;
                var height = $(window).height();
                var width = $(window).width();
                var widthJob = $("#article-index").width();
                var heightJob = $("#article-index").height();
                var left = e.clientX- widthJob / 2;;
                var top = e.clientY;
                if (top >= 0 && top < height - heightJob) {
                    $("#article-index").css("top", top);
                }
                if (left >= 0 && left < width - widthJob) {
                    $("#article-index").css("left", left);
                }
                return false;
            }
        };
        $(document).mouseup(function (e) {
            dragJob = false;
        });
    </script>
</div>
<?php }?>
<?php get_footer(); ?>