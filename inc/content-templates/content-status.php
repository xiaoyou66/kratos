<div class="time-machine m-l-lg panel b-a">
    <div class="panel-heading pos-rlt b-b b-light">
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