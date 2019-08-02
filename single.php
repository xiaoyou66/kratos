<?php get_header(); ?>
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
        <script src="<?php echo  bloginfo('template_url').'/static/js/prism.js';?>"></script>
        <div class="row">
        <?php get_template_part('/inc/single-templates/single',get_post_format()); ?>
        </div><?php
        if(current_user_can('manage_options')&&is_single()||is_page()){ ?><div class="cd-tool text-center"><div class="<?php if(kratos_option('cd_weixin')) echo 'edit-box2 '; ?>edit-box"><?php echo edit_post_link('<span class="fa fa-pencil"></span>'); ?></div></div><?php } ?>
    <script src="<?php echo  bloginfo('template_url').'/static/js/weixinAudio.js';?>"></script>
    <!--音乐播放器-->
    <script type="text/javascript">
        $('.weixinAudio').weixinAudio({});
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
<?php get_footer(); ?>