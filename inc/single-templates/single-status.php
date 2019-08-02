<?php if(kratos_option('side_bar')=='left_side'){ ?>
<aside id="kratos-widget-area" class="col-md-4 hidden-xs hidden-sm scrollspy">
    <div id="sidebar" class="affix-top">
        <?php dynamic_sidebar('sidebar_tool'); ?>
    </div>
</aside>
<?php } ?>
<section id="main" class='<?php echo (kratos_option('side_bar')=='center')?'col-md-12':'col-md-8'; ?>'>
    <?php if(have_posts()){the_post();update_post_caches($posts); ?>
    <article>
        <div class="time-machine m-l-lg panel b-a">
            <div class="panel-header pos-rlt b-b b-light">
                <span class="arrow left"></span>
                <a href="<?php bloginfo(‘url’); ?>" rel="external nofollow"><?php the_author(); ?></a><span class="text-muted m-l-sm pull-right" ><?php echo get_the_date();echo get_the_date(' H:i'); ?></span>
            </div>
            <div class="panel-body-statue">

                <p><?php the_content() ?></p>
            </div>
            <div class="panel-footer">
                <div class="say_footer">
                    </i>&nbsp;<span class="star_count"><i class="fa fa-commenting-o" aria-hidden="true"></i><a href="<?php the_permalink() ?>"><?php comments_number('0','1','%');_e('条评论','moedog'); ?>&nbsp;</a></span>
                    <i class="fa fa-eye" aria-hidden="true"></i><span class="text-muted"><?php echo kratos_get_post_views();_e('次阅读','moedog'); ?></span>
                </div>
            </div>
        </div>
        <nav class="navigation post-navigation clearfix" role="navigation">
            <?php
            $prev_post = get_previous_post();
            if(!empty($prev_post)){ ?>
            <div class="nav-previous clearfix">
                <a title="<?php echo $prev_post->post_title;?>" href="<?php echo get_permalink($prev_post->ID); ?>">&lt; <?php _e('上一篇','moedog'); ?></a>
            </div>
            <?php }
            $next_post = get_next_post();
            if(!empty($next_post)){ ?>
            <div class="nav-next">
                <a title="<?php echo $next_post->post_title; ?>" href="<?php echo get_permalink($next_post->ID); ?>"><?php _e('下一篇','moedog'); ?> &gt;</a>
            </div>
            <?php } ?>
        </nav>
        <?php comments_template(); ?>
    </article>
    <?php } ?>
</section>
<?php if(kratos_option('side_bar')=='right_side'){ ?>
    <aside id="kratos-widget-area" class="col-md-4 hidden-xs hidden-sm scrollspy">
        <div id="sidebar" class="affix-top">
            <?php dynamic_sidebar('sidebar_tool'); ?>
        </div>
    </aside>
<?php } ?>