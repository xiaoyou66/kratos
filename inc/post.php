<?php
//The article reading quantity statistics
function kratos_set_post_views(){
    if(is_singular()){
      global $post;
      $post_ID = $post->ID;
      if($post_ID){
          $post_views = (int)get_post_meta($post_ID,'views',true);
          if(!update_post_meta($post_ID,'views',($post_views+1))) add_post_meta($post_ID,'views',1,true);
      }
    }
}
add_action('wp_head','kratos_set_post_views');
function num2tring($num){
    if($num>=1000) $num = round($num/1000*100)/100 .'k';
    return $num;
}
function kratos_get_post_views($before='',$after='',$echo=1){
  global $post;
  $post_ID = $post->ID;
  $views = (int)get_post_meta($post_ID,'views',true);
  return num2tring($views);
}
//Appreciate the article
function kratos_love(){
    global $wpdb,$post;
    $id = $_POST["um_id"];
    $action = $_POST["um_action"];
    if($action=='love'){
        $raters = get_post_meta($id,'love',true);
        $expire = time()+99999999;
        $domain = ($_SERVER['HTTP_HOST']!='localhost')?$_SERVER['HTTP_HOST']:false;
        setcookie('love_'.$id,$id,$expire,'/',$domain,false);
        if(!$raters||!is_numeric($raters)){
            update_post_meta($id,'love',1);
        }else{
            update_post_meta($id,'love',($raters+1));
        }
        echo get_post_meta($id,'love',true);
    }
    die;
}
add_action('wp_ajax_nopriv_love','kratos_love');
add_action('wp_ajax_love','kratos_love');
//Post title optimization
add_filter('private_title_format','kratos_private_title_format' );
add_filter('protected_title_format','kratos_private_title_format' );
function kratos_private_title_format($format){return '%s';}
//Password protection articles
add_filter('the_password_form','custom_password_form');
function custom_password_form(){
    $url = wp_login_url();
    global $post;$label='pwbox-'.(empty($post->ID)?rand():$post->ID);$o='
    <form class="protected-post-form" action="'.$url.'?action=postpass" method="post">
        <div class="panel panel-pwd">
            <div class="panel-body text-center">
                <img class="post-pwd" src="'.get_template_directory_uri().'/static/images/fingerprint.png"><br />
                <h4>这是一篇受保护的文章，请输入阅读密码！</h4>
                <div class="input-group" id="respond">
                    <div class="input-group-addon"><i class="fa fa-key"></i></div>
                    <p><input class="form-control" placeholder="输入阅读密码" name="post_password" id="'.$label.'" type="password" size="20"></p>
                </div>
                <div class="comment-form" style="margin-top:15px;"><button id="generate" class="btn btn-primary btn-pwd" name="Submit" type="submit">确认</button></div>
            </div>
        </div>
    </form>';
return $o;
}
//Comments face
add_filter('smilies_src','custom_smilies_src',1,10);
function custom_smilies_src($img_src,$img,$siteurl){
    $owodir = get_bloginfo('template_directory');
    return $owodir.'/static/images/smilies/'.$img;
}
function smilies_reset(){
    global $wpsmiliestrans,$wp_smiliessearch,$wp_version;
    if(!get_option('use_smilies')||$wp_version<4.2) return;
    $wpsmiliestrans = array(
     ':hehe:' => 'tieba/hehe.png',
     ':haha:' => 'tieba/haha.png',
    ':tushe:' => 'tieba/tushe.png',
        ':a:' => 'tieba/a.png',
       ':ku:' => 'tieba/ku.png',
       ':nu:' => 'tieba/nu.png',
   ':kaixin:' => 'tieba/kaixin.png',
      ':han:' => 'tieba/han.png',
      ':lei:' => 'tieba/lei.png',
  ':heixian:' => 'tieba/heixian.png',
    ':bishi:' => 'tieba/bishi.png',
':bugaoxing:' => 'tieba/bugaoxing.png',
 ':zhenbang:' => 'tieba/zhenbang.png',
     ':qian:' => 'tieba/qian.png',
    ':yiwen:' => 'tieba/yiwen.png',
  ':yinxian:' => 'tieba/yinxian.png',
       ':tu:' => 'tieba/tu.png',
       ':yi:' => 'tieba/yi.png',
    ':weiqv:' => 'tieba/weiqv.png',
   ':huaxin:' => 'tieba/huaxin.png',
       ':hu:' => 'tieba/hu.png',
  ':xiaoyan:' => 'tieba/xiaoyan.png',
     ':leng:' => 'tieba/leng.png',
':taikaixin:' => 'tieba/taikaixin.png',
     ':meng:' => 'tieba/meng.png',
':mianqiang:' => 'tieba/mianqiang.png',
 ':kuanghan:' => 'tieba/kuanghan.png',
     ':guai:' => 'tieba/guai.png',
 ':shuijiao:' => 'tieba/shuijiao.png',
   ':jingku:' => 'tieba/jingku.png',
  ':shengqi:' => 'tieba/shengqi.png',
   ':jingya:' => 'tieba/jingya.png',
      ':pen:' => 'tieba/pen.png',
    ':aixin:' => 'tieba/aixin.png',
   ':xinsui:' => 'tieba/xinsui.png',
   ':meigui:' => 'tieba/meigui.png',
     ':liwu:' => 'tieba/liwu.png',
  ':caihong:' => 'tieba/caihong.png',
     ':xxyl:' => 'tieba/xxyl.png',
      ':sun:' => 'tieba/sun.png',
    ':money:' => 'tieba/money.png',
     ':bulb:' => 'tieba/bulb.png',
      ':cup:' => 'tieba/cup.png',
     ':cake:' => 'tieba/cake.png',
    ':music:' => 'tieba/music.png',
    ':haha2:' => 'tieba/haha2.png',
      ':win:' => 'tieba/win.png',
     ':good:' => 'tieba/good.png',
      ':bad:' => 'tieba/bad.png',
       ':ok:' => 'tieba/ok.png',
     ':stop:' => 'tieba/stop.png',
        ':huaji:' => 'tieba/huaji.png',
        ':huaji2:' => 'tieba/huaji2.png',
   ':hahaha:' => 'tieba/hahaha.png',
    ':zhihu1:' => 'zhihu/1.gif',
    ':zhihu2:' => 'zhihu/2.gif',
    ':zhihu3:' => 'zhihu/3.gif',
    ':zhihu4:' => 'zhihu/4.gif',
    ':zhihu5:' => 'zhihu/5.gif',
    ':zhihu6:' => 'zhihu/6.gif',
    ':zhihu7:' => 'zhihu/7.gif',
    ':zhihu8:' => 'zhihu/8.gif',
    ':zhihu9:' => 'zhihu/9.gif',
    ':zhihu10:' => 'zhihu/10.gif',
    ':zhihu11:' => 'zhihu/11.gif',
    ':zhihu12:' => 'zhihu/12.gif',
    ':zhihu13:' => 'zhihu/13.gif',
    ':zhihu14:' => 'zhihu/14.gif',
    ':zhihu15:' => 'zhihu/15.gif',
    ':zhihu16:' => 'zhihu/16.gif',
    ':zhihu17:' => 'zhihu/17.gif',
    ':zhihu18:' => 'zhihu/18.gif',
    ':zhihu19:' => 'zhihu/19.gif',
    ':zhihu20:' => 'zhihu/20.gif',
    ':zhihu21:' => 'zhihu/21.gif',
    ':bilibili0:' => 'bilibili/0.png',
    ':bilibili1:' => 'bilibili/1.png',
    ':bilibili2:' => 'bilibili/2.png',
    ':bilibili3:' => 'bilibili/3.png',
    ':bilibili4:' => 'bilibili/4.png',
    ':bilibili5:' => 'bilibili/5.png',
    ':bilibili6:' => 'bilibili/6.png',
    ':bilibili7:' => 'bilibili/7.png',
    ':bilibili8:' => 'bilibili/8.png',
    ':bilibili9:' => 'bilibili/9.png',
    ':bilibili10:' => 'bilibili/10.png',
    ':bilibili11:' => 'bilibili/11.png',
    ':bilibili12:' => 'bilibili/12.png',
    ':bilibili13:' => 'bilibili/13.png',
    ':bilibili14:' => 'bilibili/14.png',
    ':bilibili15:' => 'bilibili/15.png',
    ':bilibili16:' => 'bilibili/16.png',
    ':bilibili17:' => 'bilibili/17.png',
    ':bilibili18:' => 'bilibili/18.png',
    ':bilibili19:' => 'bilibili/19.png',
    ':bilibili20:' => 'bilibili/20.png',
    ':bilibili21:' => 'bilibili/21.png',
    ':bilibili22:' => 'bilibili/22.png',
    ':bilibili23:' => 'bilibili/23.png',
    ':bilibili24:' => 'bilibili/24.png',
    ':bilibili25:' => 'bilibili/25.png',
    ':bilibili26:' => 'bilibili/26.png',
    ':bilibili27:' => 'bilibili/27.png',
    ':bilibili28:' => 'bilibili/28.png',
    ':bilibili29:' => 'bilibili/29.png',
    ':bilibili30:' => 'bilibili/30.png',
    ':bilibili31:' => 'bilibili/31.png',
    ':bilibili32:' => 'bilibili/32.png',
    ':bilibili33:' => 'bilibili/33.png',
    ':bilibili34:' => 'bilibili/34.png',
    ':bilibili35:' => 'bilibili/35.png',
    ':bilibili36:' => 'bilibili/36.png',
    ':bilibili37:' => 'bilibili/37.png',
    ':bilibili38:' => 'bilibili/38.png',
    ':bilibili39:' => 'bilibili/39.png',
    ':bilibili40:' => 'bilibili/40.png',
    ':bilibili41:' => 'bilibili/41.png',
    ':bilibili42:' => 'bilibili/42.png',
    ':bilibili43:' => 'bilibili/43.png',
    ':bilibili44:' => 'bilibili/44.png',
    ':bilibili45:' => 'bilibili/45.png',
    ':bilibili46:' => 'bilibili/46.png',
    ':bilibili47:' => 'bilibili/47.png',
    ':bilibili48:' => 'bilibili/48.png',
    ':bilibili49:' => 'bilibili/49.png',
    ':bilibili50:' => 'bilibili/50.png',
    ':bilibili51:' => 'bilibili/51.png',
    ':bilibili52:' => 'bilibili/52.png',
    ':bilibili53:' => 'bilibili/53.png',
    ':bilibili54:' => 'bilibili/54.png',
    ':bilibili55:' => 'bilibili/55.png',
    ':bilibili56:' => 'bilibili/56.png',
    ':bilibili57:' => 'bilibili/57.png',
    ':bilibili58:' => 'bilibili/58.png',
    ':bilibili59:' => 'bilibili/59.png',
    ':bilibili60:' => 'bilibili/60.png',
    ':bilibili61:' => 'bilibili/61.png',
    ':bilibili62:' => 'bilibili/62.png',
    ':bilibili63:' => 'bilibili/63.png',
    ':bilibili64:' => 'bilibili/64.png',
    ':bilibili65:' => 'bilibili/65.png',
    ':bilibili66:' => 'bilibili/66.png',
    ':bilibili67:' => 'bilibili/67.png',
    ':bilibili68:' => 'bilibili/68.png',
    ':bilibili69:' => 'bilibili/69.png',
    ':bilibili70:' => 'bilibili/70.png',
    ':bilibili71:' => 'bilibili/71.png',
    ':bilibili72:' => 'bilibili/72.png',
    ':bilibili73:' => 'bilibili/73.png',
    ':bilibili74:' => 'bilibili/74.png',
    ':bilibili75:' => 'bilibili/75.png',
    ':bilibili76:' => 'bilibili/76.png',
    ':bilibili77:' => 'bilibili/77.png',
    ':bilibili78:' => 'bilibili/78.png',
    ':bilibili79:' => 'bilibili/79.png',
    ':bilibili80:' => 'bilibili/80.png',
    ':bilibili81:' => 'bilibili/81.png',
    ':bilibili82:' => 'bilibili/82.png',
    ':bilibili83:' => 'bilibili/83.png',
    ':bilibili84:' => 'bilibili/84.png',
    ':bilibili85:' => 'bilibili/85.png',
    ':bilibili86:' => 'bilibili/86.png',
    ':bilibili87:' => 'bilibili/87.png',
    ':bilibili88:' => 'bilibili/88.png',
    ':bilibili89:' => 'bilibili/89.png',
    ':bilibili90:' => 'bilibili/90.png',
    ':bilibili91:' => 'bilibili/91.png',
    ':bilibili92:' => 'bilibili/92.png',
    ':bilibili93:' => 'bilibili/93.png',
    ':bilibili94:' => 'bilibili/94.png',
    ':bilibili95:' => 'bilibili/95.png',
    ':bilibili96:' => 'bilibili/96.png',
    ':bilibili97:' => 'bilibili/97.png',
    ':bilibili98:' => 'bilibili/98.png',
        ':tv1:' => 'bilibili_tv/tv_1.png',
        ':tv2:' => 'bilibili_tv/tv_2.png',
        ':tv3:' => 'bilibili_tv/tv_3.png',
        ':tv4:' => 'bilibili_tv/tv_4.png',
        ':tv5:' => 'bilibili_tv/tv_5.png',
        ':tv6:' => 'bilibili_tv/tv_6.png',
        ':tv7:' => 'bilibili_tv/tv_7.png',
        ':tv8:' => 'bilibili_tv/tv_8.png',
        ':tv9:' => 'bilibili_tv/tv_9.png',
        ':tv10:' => 'bilibili_tv/tv_10.png',
        ':tv11:' => 'bilibili_tv/tv_11.png',
        ':tv12:' => 'bilibili_tv/tv_12.png',
        ':tv13:' => 'bilibili_tv/tv_13.png',
        ':tv14:' => 'bilibili_tv/tv_14.png',
        ':tv15:' => 'bilibili_tv/tv_15.png',
        ':tv16:' => 'bilibili_tv/tv_16.png',
        ':tv17:' => 'bilibili_tv/tv_17.png',
        ':tv18:' => 'bilibili_tv/tv_18.png',
        ':tv19:' => 'bilibili_tv/tv_19.png',
        ':tv20:' => 'bilibili_tv/tv_20.png',
        ':tv21:' => 'bilibili_tv/tv_21.png',
        ':tv22:' => 'bilibili_tv/tv_22.png',
        ':tv23:' => 'bilibili_tv/tv_23.png',
        ':tv24:' => 'bilibili_tv/tv_24.png',
        ':tv25:' => 'bilibili_tv/tv_25.png',
        ':tv26:' => 'bilibili_tv/tv_26.png',
        ':tv27:' => 'bilibili_tv/tv_27.png',
        ':tv28:' => 'bilibili_tv/tv_28.png',
        ':tv29:' => 'bilibili_tv/tv_29.png',
        ':tv30:' => 'bilibili_tv/tv_30.png',
        ':tv31:' => 'bilibili_tv/tv_31.png',
        ':tv32:' => 'bilibili_tv/tv_32.png',
        ':tv33:' => 'bilibili_tv/tv_33.png',
        ':tv34:' => 'bilibili_tv/tv_34.png',
        ':tv35:' => 'bilibili_tv/tv_35.png',
        ':tv36:' => 'bilibili_tv/tv_36.png',
        ':tv37:' => 'bilibili_tv/tv_37.png',
        ':tv38:' => 'bilibili_tv/tv_38.png',
        ':tv39:' => 'bilibili_tv/tv_39.png',
        ':tv40:' => 'bilibili_tv/tv_40.png',
        ':tv41:' => 'bilibili_tv/tv_41.png',
        ':tv42:' => 'bilibili_tv/tv_42.png',
        ':tv43:' => 'bilibili_tv/tv_43.png',
        ':tv44:' => 'bilibili_tv/tv_44.png',
        ':tv45:' => 'bilibili_tv/tv_45.png',
        ':tv46:' => 'bilibili_tv/tv_46.png',
        ':tv47:' => 'bilibili_tv/tv_47.png',
        ':tv48:' => 'bilibili_tv/tv_48.png',
        ':tv49:' => 'bilibili_tv/tv_49.png',
    );
}
smilies_reset();
//Paging
function kratos_pages($range=5){
    global $paged,$wp_query,$max_page;
    if(!$max_page){$max_page=$wp_query->max_num_pages;}
    if($max_page>1){if(!$paged){$paged=1;}
    echo "<div class='text-center wow swing' id='page-footer'><ul class='pagination'>";
        if($paged != 1) echo '<li><a href="'.get_pagenum_link(1).'" class="extend" title="首页">&laquo;</a></li>';
        if($paged>1) echo '<li><a href="'.get_pagenum_link($paged-1).'" class="prev" title="上一页">&lt;</a></li>';
        if($max_page>$range){
            if($paged<$range){
                for($i=1;$i<=($range+1);$i++){
                    echo "<li";
                    if($i==$paged) echo " class='active'";
                    echo "><a href='".get_pagenum_link($i)."'>$i</a></li>";
                }
            }
            elseif($paged>=($max_page-ceil(($range/2)))){
                for($i=$max_page-$range;$i<=$max_page;$i++){
                    echo "<li";
                    if($i==$paged) echo " class='active'";echo "><a href='".get_pagenum_link($i)."'>$i</a></li>";
                }
            }
            elseif($paged>=$range&&$paged<($max_page-ceil(($range/2)))){
                for($i=($paged-ceil($range/2));$i<=($paged+ceil(($range/2)));$i++){
                    echo "<li";
                    if($i==$paged) echo " class='active'";
                    echo "><a href='".get_pagenum_link($i)."'>$i</a></li>";
                }
            }
        }else{
            for($i=1;$i<=$max_page;$i++){
                echo "<li";
                if($i==$paged) echo " class='active'";
                echo "><a href='".get_pagenum_link($i)."'>$i</a></li>";
            }
        }
        if($paged<$max_page) echo '<li><a href="'.get_pagenum_link($paged+1).'" class="next" title="下一页">&gt;</a></li>';
        if($paged!=$max_page) echo '<li><a href="'.get_pagenum_link($max_page).'" class="extend" title="尾页">&raquo;</a></li>';
        echo "</ul></div>";
    }
}