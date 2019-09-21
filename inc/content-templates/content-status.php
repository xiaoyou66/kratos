<div id="primary-new" class="list wow bounceInLeft">
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
                <?php echo comments_number('0','1','%').'条评论'; ?>
            </li>
            <li class="item-diary fa fa-eye" style="border-right:0;border-bottom-right-radius:15px;<?php if($_COOKIE['goto_bibo']==1)echo'width:49.9%'?>">
                <?php echo kratos_get_post_views().'次阅读'; ?>
            </li>
        </ul>
    </div>
</article>
</div>
