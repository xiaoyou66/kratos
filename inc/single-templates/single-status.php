<?php if(kratos_option('side_bar')=='left_side'){ ?>
<aside id="kratos-widget-area" class="col-md-4 hidden-xs hidden-sm scrollspy">
    <div id="sidebar" class="affix-top">
        <?php dynamic_sidebar('sidebar_tool'); ?>
    </div>
</aside>
<?php } ?>
<section id="main" class='<?php echo (kratos_option('side_bar')=='center')?'col-md-12':'col-md-8'; ?>'>
    <?php if(have_posts()){the_post();update_post_caches($posts); ?>
        <div id="primary-new" class="list">
            <article class="post" style=" border-radius: 15px;">
                <div class="entry-header pull-left">
                    <!-- 头像 -->
                    <?php echo get_avatar( get_the_author_meta( 'ID' ) ); ?>
                </div>
                <div class="entry-content">
                    <div class="meta">
                        <div class="author" itemprop="author">
                            <span class="author-name"><?php the_author(); ?></span>
                            <span class="is-author icon" aria-label="This is master"></span></div>
                        <time class="author-time" itemprop="datePublished" datetime="">
                            <?php echo get_the_date();echo get_the_date(' H:i'); ?>
                        </time>

                    </div>
                    <a href='<?php the_permalink() ?>'>
                        <div class="summary" itemprop="description">
                            <?php the_content() ?>
                        </div>
                    </a>
                </div>
                <!--底部信息-->
                <div class="status-webo">
                    <ul class="items state">
                        <li class="item-diary fa fa-comment-o" style="border-bottom-left-radius:15px;<?php if($_COOKIE['goto_bibo']==1)echo'width:49.9%'?>">
                            <?php comments_number('0','1','%');echo '条评论'; ?>
                        </li>
                        <li class="item-diary fa fa-eye" style="border-right:0;border-bottom-right-radius:15px;<?php if($_COOKIE['goto_bibo']==1)echo'width:49.9%'?>">
                            <?php echo kratos_get_post_views();echo '次阅读'; ?>
                        </li>
                    </ul>
                </div>
            </article>
        </div>
        <nav class="navigation post-navigation clearfix" role="navigation">
            <?php
            $prev_post = get_previous_post();
            if(!empty($prev_post)){ ?>
            <div class="nav-previous clearfix">
                <a title="<?php echo $prev_post->post_title;?>" href="<?php echo get_permalink($prev_post->ID); ?>">&lt; <?php echo '上一篇'; ?></a>
            </div>
            <?php }
            $next_post = get_next_post();
            if(!empty($next_post)){ ?>
            <div class="nav-next">
                <a title="<?php echo $next_post->post_title; ?>" href="<?php echo get_permalink($next_post->ID); ?>"><?php echo '下一篇'; ?> &gt;</a>
            </div>
            <?php } ?>
        </nav>
        <?php comments_template(); ?>
    <?php } ?>
</section>
<?php if(kratos_option('side_bar')=='right_side'){ ?>
    <aside id="kratos-widget-area" class="col-md-4 hidden-xs hidden-sm scrollspy">
        <div id="sidebar" class="affix-top">
            <?php dynamic_sidebar('sidebar_tool'); ?>
        </div>
    </aside>
<?php } ?>