<?php
/**
template name: 友情链接模板
*/

get_header(); ?>
<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<?php
//这边接收post数据然后判断
if(!empty($_REQUEST)) {
    $webname=array_key_exists("webname",$_REQUEST)?$_REQUEST['webname']:"";
    $web=array_key_exists("web",$_REQUEST)?$_REQUEST['web']:"";
    $introduce=array_key_exists("introduce",$_REQUEST)?$_REQUEST['introduce']:"无";
    $avater=array_key_exists("avater",$_REQUEST)?$_REQUEST['avater']:"无";
    $mail=array_key_exists("mail",$_REQUEST)?$_REQUEST['mail']:"";
    if(!$webname) echo "<script type='text/javascript'>alert('名字不能为空！')</script>";
    else if(!$web) echo "<script type='text/javascript'>alert('网址不能为空！')</script>";
    else if(!$mail) echo "<script type='text/javascript'>alert('邮件地址不能为空！')</script>";
    else{
//        获取到了需要的数据
        //获取所有的申请
        $application=esc_attr(get_option('application_list'));
        //欲添加的数据
        $add=$webname."!!]".$web."!!]".$introduce."!!]".$avater."!!]".$mail;
        update_option('application_list',$application.$add."]!!");
        echo "<script type='text/javascript'>alert('提交申请成功，请等待站长审核!审核通过后会发送邮件通知你!');window.history.back(-1); </script>";
        //发送邮件
        $to=get_bloginfo('admin_email');
        $subject = '有新的友链申请!';
        $message='名字:'.$webname.'<br/>网站地址:'.$web.'<br/>介绍:'.$introduce.'<br/>头像链接:'.$avater.'<br/>邮箱:'.$mail;
        $headers = 'Content-type: text/html';
        wp_mail($to,$subject,$message,$headers);
    }
}

if($_COOKIE['goto_bibo']==1){
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
            <?php }?> <?php if(have_posts()){the_post(); ?>
                <article>
                    <div class="kratos-hentry kratos-post-inner clearfix">
                        <div class="kratos-post-content-l">
                            <h2 class="title-h2" style="text-align:center;font-size:18pt">dalao们</h2>
                            <p style="text-align:center"><span style="color:#999999">dalao们的链接，每次刷新随机排序~</span></p>
                            <div class="linkpage">
                                <hr/>
                                <ul><?php
                                $bookmarks = get_bookmarks(array('orderby'=>'rand'));
                                if(!empty($bookmarks)){
                                    foreach($bookmarks as $bookmark){
                                        $friendimg = $bookmark->link_image;
                                        if(empty($friendimg)) $friendimg = get_stylesheet_directory_uri().'/static/images/avatar.png';
                                        echo '<li><a href="'.$bookmark->link_url.'" target="_blank"><img src="'.$friendimg.'"><h4>'.$bookmark->link_name.'</h4><p>'.$bookmark->link_description.'</p></a></li>';
                                    }
                                } ?>
                                </ul>
                                <hr/>
                                <!-- 按钮触发模态框 -->
                                <button class="btn btn-success" data-toggle="modal" data-target="#myModal" style="border-radius: 4px;margin-bottom: 15px">点击申请</button>
                                <!-- 模态框（Modal） -->
                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="margin-top: 30%;margin-right: 45%;">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4>友链申请</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form action=" " method="post" class="bs-example bs-example-form" role="form" style="text-align: center;">
                                                    <div class="input-group" >
                                                        <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                                                        <input type="text" name="webname" class="form-control" placeholder="名字">
                                                    </div>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-link" aria-hidden="true"></i></span>
                                                        <input type="text" name="web" class="form-control" placeholder="网站地址">
                                                    </div>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-id-card-o" aria-hidden="true"></i></span>
                                                        <input type="text" name="introduce" class="form-control" placeholder="个人介绍">
                                                    </div>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-file-image-o" aria-hidden="true"></i></span>
                                                        <input type="text" name="avater" class="form-control" placeholder="头像链接"></div>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i> </span>
                                                        <input type="text" name="mail" class="form-control" placeholder="你的邮箱(添加后会通过邮箱通知你)">
                                                    </div>
                                                    <button type="submit" name="friend"  class="btn btn-info" style="border-radius: 10px;margin-top: 10px;">提交申请</button>
                                                </form>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal -->
                                </div>
                            </div>
                            <?php the_content(); ?>
                        </div>
                    </div>
                    <?php if ( comments_open() ) comments_template(); ?>
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
        </div><?php
        if(current_user_can('manage_options')&&is_single()||is_page()){ ?><div class="cd-tool text-center"><div class="<?php if(kratos_option('cd_weixin')) echo 'edit-box2 '; ?>edit-box"><?php echo edit_post_link('<span class="fa fa-pencil"></span>'); ?></div></div><?php } ?>
    </div>
</div>
<?php get_footer(); ?>