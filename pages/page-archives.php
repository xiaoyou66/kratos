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
//        $output .= '<div class="collection-title"><h2 class="archive-year" id="archive-year-'.$year.'">'.$year.'</h2></div>';
        $output.='<li class="tl-header"><h2 class="btn btn-sm btn-'.$arr[$r].' btn-rounded m-t-none" id="archive-year-'.$year.'">'.$year.'</h2></li>';
    }
//    $output .= '<article class="post post-type-normal" itemtype="http://schema.org/Article"><header class="post-header"><h2 class="post-title"><a class="post-title-link" href="'.get_permalink().'" itemprop="url"><span itemprop="name">'.get_the_title().'</span></a></h2><div class="post-meta"><time class="post-time" itemprop="dateCreated">'.get_the_time('m-d').'</time></div></header></article>';
    $output.='<div class="tl-body" ><li class="tl-item"><div class="tl-wrap b-'.$arr[$r].'"><span class="tl-date">'.get_the_time('d').'日'.'</span><h3 class="tl-content panel padder h5 l-h bg-'.$arr[$r].'"><span class="arrow arrow-'.$arr[$r].' left pull-up" aria-hidden="true"></span><a href="'.get_permalink().'" class="text-lt">'.get_the_title().'</a></h3></div></li></div>';
endwhile;
$output.='<li class="tl-header"><div class="btn btn-sm btn-default btn-rounded">开始</div></li>';
get_header(); ?>
    <div id="container" class="container">
        <div class="row">
            <?php if(kratos_option('page_side_bar')=='left_side'){ ?>
                <aside id="kratos-widget-area" class="col-md-4 hidden-xs hidden-sm scrollspy">
                    <div id="sidebar" class="affix-top">
                        <?php dynamic_sidebar('sidebar_tool'); ?>
                    </div>
                </aside>
            <?php } ?>
            <section id="main" class='<?php echo (kratos_option('page_side_bar')=='center')?'col-md-12':'col-md-8'; ?>'>
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