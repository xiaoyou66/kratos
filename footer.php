</section>
                <footer>
                    <div id="footer"<?php echo ' style="background:rgba('.kratos_option('footer_color').')"'; ?>>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3 footer-list text-center">
                                    <p class="kratos-social-icons"><?php
                                        echo (!kratos_option('social_weibo'))?'':'<a target="_blank" rel="nofollow" href="'.kratos_option('social_weibo').'"><i class="fa fa-weibo"></i></a>';
                                        echo (!kratos_option('social_tweibo'))?'':'<a target="_blank" rel="nofollow" href="'.kratos_option('social_tweibo').'"><i class="fa fa-tencent-weibo"></i></a>';
                                        echo (!kratos_option('social_mail'))?'':'<a target="_blank" rel="nofollow" href="'.kratos_option('social_mail').'"><i class="fa fa-envelope"></i></a>';
                                        echo (!kratos_option('social_twitter'))?'':'<a target="_blank" rel="nofollow" href="'.kratos_option('social_twitter').'"><i class="fa fa-twitter"></i></a>';
                                        echo (!kratos_option('social_facebook'))?'':'<a target="_blank" rel="nofollow" href="'.kratos_option('social_facebook').'"><i class="fa fa-facebook-official"></i></a>';
                                        echo (!kratos_option('social_linkedin'))?'':'<a target="_blank" rel="nofollow" href="'.kratos_option('social_linkedin').'"><i class="fa fa-linkedin-square"></i></a>';
                                        echo (!kratos_option('social_github'))?'':'<a target="_blank" rel="nofollow" href="'.kratos_option('social_github').'"><i class="fa fa-github"></i></a>'; ?>
                                    </p>
                                    <p> © <?php echo date('Y'); ?> <a href="<?php echo get_option('home'); ?>"><?php bloginfo('name'); ?></a>. All Rights Reserved.<br><?php _e('本站已萌萌哒(✪ω✪)运行','moedog'); ?> <span id="span_dt_dt">Loading...</span><br>Theme <a href="https://www.fczbl.vip/787.html" target="_blank" rel="nofollow">Kratos</a> Made by <a href="https://www.fczbl.vip" target="_blank" rel="nofollow">Moedog</a> Modified by <a href="https://xiaoyou66.com" target="_blank" rel="nofollow">XiaoYou</a><?php if(kratos_option('sitemap')) echo ' <br><a href="'.get_option('home').'/sitemap.html" target="_blank">Sitemap</a>'; ?>
                                    <?php if(kratos_option('icp_num')) echo '<br><a href="http://www.miitbeian.gov.cn/" rel="external nofollow" target="_blank">'.kratos_option('icp_num').'</a>';
                                          if(kratos_option('gov_num')) echo '<br><a href="'.kratos_option('gov_link').'" rel="external nofollow" target="_blank"><i class="govimg"></i>'.kratos_option('gov_num').'</a>'; ?>
                                    <br><!--  站长统计-->
                                        <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? "https://" : "http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1276887212'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s96.cnzz.com/z_stat.php%3Fid%3D1276887212%26show%3Dpic1' type='text/javascript'%3E%3C/script%3E"));</script>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="cd-tool text-center">
                            <div class="<?php if(kratos_option('cd_weixin')) echo 'gotop-box2 '; ?>gotop-box"><div class="gotop-btn"><span class="fa fa-chevron-up"></span></div></div>
                            <?php if(kratos_option('cd_weixin')) echo '<div id="wechat-img" class="wechat-img"><span class="fa fa-weixin"></span><div id="wechat-pic"><img src="'.kratos_option('weixin_image').'"></div></div>'; ?>
                            <div class="search-box">
                                <span class="fa fa-search"></span>
                                <form class="search-form" role="search" method="get" id="searchform" action="<?php echo home_url('/'); ?>">
                                    <input type="text" name="s" id="search" placeholder="Search..." style="display:none"/>
                                </form>
                            </div>
                        </div>
                        <?php if(kratos_option('ap_footer')){ ?>
                        <div class="aplayer-footer">
                            <div id="ap-footer" data-json="<?php echo kratos_option('ap_json'); ?>" data-autoplay="<?php echo kratos_option('ap_autoplay'); ?>" data-loop="<?php echo kratos_option('ap_loop'); ?>" data-order="<?php echo kratos_option('ap_order'); ?>"></div>
                        </div>
                        <?php }if(kratos_option('site_snow')&&(!wp_is_mobile()||wp_is_mobile()&&kratos_option('snow_xb2016_mobile'))){ ?>
                        <div class="xb-snow">
                            <canvas id="Snow" data-count="<?php echo kratos_option('snow_xb2016_flakecount'); ?>" data-dist="<?php echo kratos_option('snow_xb2016_mindist'); ?>" data-color="<?php echo kratos_option('snow_xb2016_snowcolor'); ?>" data-size="<?php echo kratos_option('snow_xb2016_size'); ?>" data-speed="<?php echo kratos_option('snow_xb2016_speed'); ?>" data-opacity="<?php echo kratos_option('snow_xb2016_opacity'); ?>" data-step="<?php echo kratos_option('snow_xb2016_stepsize'); ?>"></canvas>
                        </div>
                        <?php } ?>
                    </div>
                </footer>
            </div>
        </div>
        <?php
        if (! wp_is_mobile() ) {
           echo '<script src="https://xiaoyou66.com/wp-content/themes/kratos-pjax-master/inc/live2d/autoload.js" type="text/javascript"></script>';
        } ?>
<script src="<?php echo  bloginfo('template_url').'/static/js/weixinAudio.js';?>"></script>
<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

<?php wp_footer();if(kratos_option('script_tongji')||kratos_option('add_script')){ ?>
<script type="text/javascript">
    <?php echo kratos_option('script_tongji');echo kratos_option('add_script'); ?>
</script>
<?php } ?>
<!--音乐播放器-->
<script type="text/javascript">
    $('.weixinAudio').weixinAudio({
    });
</script>

<!--       鼠标特效 -->
        <script type="text/javascript">
            var a_idx = 0;
            jQuery(document).ready(function($) {
                $("body").click(function(e) {
                    var a = new Array("技术宅", "二次元", "小白", "富有想象", "*:ஐ٩(๑´ᵕ`)۶ஐ:* 学习使我进步", "(๑*◡*๑)", "✧*｡٩(ˊᗜˋ*)و✧*｡" ,"（づ￣3￣）づ╭❤～", "╰( ´・ω・)つ──☆✿✿✿", "充满激情", "(((┏(;￣▽￣)┛装完逼就跑", "熬夜成瘾(,,•﹏•,,)");
                    var $i = $("<span />").text(a[a_idx]);
                    a_idx = (a_idx + 1) % a.length;
                    var x = e.pageX,
                        y = e.pageY;
                    $i.css({
                        "z-index": 99999999999999999999999999999999999999999999999999999999999999999999999999 ,
                        "top": y - 20,
                        "left": x,
                        "position": "absolute",
                        "font-weight": "bold",
                        "color": "#ff7bb0"
                    });
                    $("body").append($i);
                    $i.animate({
                            "top": y - 180,
                            "opacity": 0
                        },
                        1500,
                        function() {
                            $i.remove();
                        });
                });
            });
        </script>
    </body>
</html>