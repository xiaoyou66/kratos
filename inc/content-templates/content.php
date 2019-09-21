<?php if($_COOKIE['goto_bibo']==1){?>
    <div id="primary" class="list wow bounceInUp">
        <article class="post">
            <div class="entry-header pull-left">
                <?php echo get_avatar( get_the_author_meta( 'ID' ) ); ?>
            </div>
            <div class="entry-content">
                <div class="meta">
                    <div class="author" itemprop="author">
                        <span class="author-name"><?php the_author(); ?></span>
                        <span class="is-author icon" aria-label="This is master"></span></div>
                    <time class="author-time" itemprop="datePublished" datetime="">
                        <?php echo get_the_date(); ?></time>

                </div>
                <h2 class="title-index" id="directory-0">
                    <?php the_title(); ?>
                </h2>
                <a href="<?php the_permalink() ?>">
                    <div class="summary" itemprop="description">
                        <?php if(has_excerpt()) echo the_excerpt();
                        else echo showSummary(get_the_content()) ?>
                    </div>
                </a>
            </div>
            <!--底部信息-->
            <div class="status-webo">
                <ul class="state">
                    <li  class="item fa fa-calendar">
                        <?php echo get_the_date(); ?>
                    </li>
                    <li class="item fa fa-eye">
                        <?php echo kratos_get_post_views().'次阅读'; ?>
                    </li>
                    <li class="item  fa fa-commenting-o">
                        <?php comments_number('0','1','%');echo '条评论' ?>
                    </li>
                    <li class="item  fa fa-thumbs-o-up" style="border-right:0">
                        <?php if(get_post_meta($post->ID,'love',true)){echo get_post_meta($post->ID,'love',true);}else{echo '0'; } echo '人点赞'; ?>
                    </li>
                </ul>
            </div>
        </article>
    </div>
<?php }else{?>
<article class="kratos-hentry clearfix wow bounceInUp">
<?php if(kratos_option('list_layout')=='old_layout'){ ?>
<div class="kratos-entry-thumb">
    <?php kratos_blog_thumbnail() ?>
</div>    
<div class="kratos-post-inner">
    <header class="kratos-entry-header clearfix">
        <h2 class="kratos-entry-title"><a href="<?php the_permalink() ?>"><?php if(is_sticky()) echo '<span style="font-size:25px;color:#f00">[TOP] </span>';the_title() ?></a></h2>
        <div class="kratos-post-meta">
            <span class="pull-left">
            <a><i class="fa fa-calendar"></i> <?php echo get_the_date(); ?></a>
            </span>
            <span class="visible-lg visible-md visible-sm pull-left">
            <?php $category=get_the_category();if($category) echo '<a href="'.get_category_link($category[0]->term_id).'"><i class="fa fa-folder-open-o"></i> '.$category[0]->cat_name.'</a>'; ?>
            <a href="<?php the_permalink() ?>#comments"><i class="fa fa-commenting-o"></i> <?php comments_number('0','1','%');echo '条评论' ?></a>
            </span>
            <span class="pull-left">
            <a href="<?php the_permalink() ?>"><i class="fa fa-eye"></i> <?php echo kratos_get_post_views().'次阅读' ?></a>
            <a href="javascript:;" data-action="love" data-id="<?php the_ID(); ?>" class="Love<?php if(isset($_COOKIE['love_'.$post->ID])) echo ' done';?>"><i class="fa fa-thumbs-o-up"></i> <?php if(get_post_meta($post->ID,'love',true)) echo get_post_meta($post->ID,'love',true); else echo '0';echo '人点赞'; ?></a>
            <a href="<?php site_url() ?>/?author=<?php the_author_ID() ?>"><i class="fa fa-user"></i> <?php the_author(); ?></a>
            </span>
        </div>
    </header>
    <div class="kratos-entry-content clearfix">
    <p><?php if(has_excerpt()) echo the_excerpt();
                else echo showSummary(get_the_content()) ?> </p>
    </div>
</div>
<?php }else{ ?>
<!-- 下面这一段都是图片代码-->
<div class="kratos-entry-border-new clearfix">
<!--    这个是置顶文章-->
    <?php if(is_sticky()) echo '<img class="stickyimg" src="'.get_bloginfo('template_directory').'/static/images/sticky.png"/>'; ?>
    <?php
    echo '<div class="kratos-post-inner-new" style="background-image:url(\''.kratos_blog_thumbnail_new().'\');">';
    ?>
        <div class="kratos-entry-content-new ">
            <header class="kratos-entry-header-new">
                <?php $category=get_the_category();if($category) echo '<a class="label" href="'.get_category_link($category[0]->term_id).'">'.$category[0]->cat_name.'</a>'; ?>
                <h2 class="kratos-entry-title-new"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
            </header>
            <p><?php if(has_excerpt()) echo the_excerpt();
                else echo showSummary(get_the_content()) ?></p>
        </div>
    </div>
    <div class="kratos-post-meta-new">
        <span class="pull-left">
            <a><i class="fa fa-calendar"></i> <?php echo get_the_date(); ?></a>
            <a href="<?php the_permalink() ?>#comments"><i class="fa fa-commenting-o"></i> <?php comments_number('0','1','%');echo '条评论'; ?></a>
        </span>
        <span class="visible-lg visible-md visible-sm pull-left">
            <a href="<?php the_permalink() ?>"><i class="fa fa-eye"></i> <?php echo kratos_get_post_views().'次阅读'; ?></a>
            <a href="javascript:;" data-action="love" data-id="<?php the_ID(); ?>" class="Love<?php if(isset($_COOKIE['love_'.$post->ID])) echo ' done';?>"><i class="fa fa-thumbs-o-up"></i> <?php if(get_post_meta($post->ID,'love',true)) echo get_post_meta($post->ID,'love',true); else echo '0';echo '人点赞' ?></a>
            <a href="<?php site_url() ?>/?author=<?php the_author_ID() ?>"><i class="fa fa-user"></i> <?php the_author(); ?></a>
        </span>
        <span class="pull-right">
            <a class="read-more" href="<?php the_permalink() ?>" title="<?php echo '阅读全文' ?>"><?php echo '阅读全文' ?> <i class="fa fa-chevron-circle-right"></i></a>
        </span>
    </div>
</div>
<?php } ?>
</article>
<?php }?>