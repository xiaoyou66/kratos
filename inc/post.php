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
                <h4>'.__('这是一篇受保护的文章，请输入阅读密码！','moedog').'</h4>
                <div class="input-group" id="respond">
                    <div class="input-group-addon"><i class="fa fa-key"></i></div>
                    <p><input class="form-control" placeholder="'.__('输入阅读密码','moedog').'" name="post_password" id="'.$label.'" type="password" size="20"></p>
                </div>
                <div class="comment-form" style="margin-top:15px;"><button id="generate" class="btn btn-primary btn-pwd" name="Submit" type="submit">'.__('确认','moedog').'</button></div>
            </div>
        </div>
    </form>';
return $o;
}
//Comments face
add_filter('smilies_src','custom_smilies_src',1,10);
function custom_smilies_src($img_src,$img,$siteurl){
    if(kratos_option('owo_out')) $owodir = 'https://cdn.jsdelivr.net/gh/xb2016/kratos-pjax@'.KRATOS_VERSION; else $owodir = get_bloginfo('template_directory');
    return $owodir.'/static/images/smilies/'.$img;
}
function smilies_reset(){
    global $wpsmiliestrans,$wp_smiliessearch,$wp_version;
    if(!get_option('use_smilies')||$wp_version<4.2) return;
    $wpsmiliestrans = array(
     ':hehe:' => 'hehe.png',
     ':haha:' => 'haha.png',
    ':tushe:' => 'tushe.png',
        ':a:' => 'a.png',
       ':ku:' => 'ku.png',
       ':nu:' => 'nu.png',
   ':kaixin:' => 'kaixin.png',
      ':han:' => 'han.png',
      ':lei:' => 'lei.png',
  ':heixian:' => 'heixian.png',
    ':bishi:' => 'bishi.png',
':bugaoxing:' => 'bugaoxing.png',
 ':zhenbang:' => 'zhenbang.png',
     ':qian:' => 'qian.png',
    ':yiwen:' => 'yiwen.png',
  ':yinxian:' => 'yinxian.png',
       ':tu:' => 'tu.png',
       ':yi:' => 'yi.png',
    ':weiqv:' => 'weiqv.png',
   ':huaxin:' => 'huaxin.png',
       ':hu:' => 'hu.png',
  ':xiaoyan:' => 'xiaoyan.png',
     ':leng:' => 'leng.png',
':taikaixin:' => 'taikaixin.png',
     ':meng:' => 'meng.png',
    ':huaji:' => 'huaji.png',
   ':huaji2:' => 'huaji2.png',
   ':huaji3:' => 'huaji3.gif',
   ':huaji4:' => 'huaji4.png',
   ':huaji5:' => 'huaji5.gif',
   ':huaji6:' => 'huaji6.png',
   ':huaji7:' => 'huaji7.png',
   ':huaji8:' => 'huaji8.png',
   ':huaji9:' => 'huaji9.png',
  ':huaji10:' => 'huaji10.png',
  ':huaji11:' => 'huaji11.png',
  ':huaji12:' => 'huaji12.png',
  ':huaji13:' => 'huaji13.png',
  ':huaji14:' => 'huaji14.png',
  ':huaji15:' => 'huaji15.png',
  ':huaji16:' => 'huaji16.gif',
  ':huaji17:' => 'huaji17.png',
  ':huaji18:' => 'huaji18.png',
  ':huaji19:' => 'huaji19.png',
  ':huaji20:' => 'huaji20.gif',
  ':huaji21:' => 'huaji21.gif',
  ':huaji22:' => 'huaji22.png',
  ':huaji23:' => 'huaji23.png',
':mianqiang:' => 'mianqiang.png',
 ':kuanghan:' => 'kuanghan.png',
     ':guai:' => 'guai.png',
 ':shuijiao:' => 'shuijiao.png',
   ':jingku:' => 'jingku.png',
  ':shengqi:' => 'shengqi.png',
   ':jingya:' => 'jingya.png',
      ':pen:' => 'pen.png',
    ':aixin:' => 'aixin.png',
   ':xinsui:' => 'xinsui.png',
   ':meigui:' => 'meigui.png',
     ':liwu:' => 'liwu.png',
  ':caihong:' => 'caihong.png',
     ':xxyl:' => 'xxyl.png',
      ':sun:' => 'sun.png',
    ':money:' => 'money.png',
     ':bulb:' => 'bulb.png',
      ':cup:' => 'cup.png',
     ':cake:' => 'cake.png',
    ':music:' => 'music.png',
    ':haha2:' => 'haha2.png',
      ':win:' => 'win.png',
     ':good:' => 'good.png',
      ':bad:' => 'bad.png',
       ':ok:' => 'ok.png',
     ':stop:' => 'stop.png',
   ':hahaha:' => 'hahaha.png',
        ':1 (1):' => 'QQ/1 (1).gif',
        ':1 (2):' => 'QQ/1 (2).gif',
        ':1 (3):' => 'QQ/1 (3).gif',
        ':1 (4):' => 'QQ/1 (4).gif',
        ':1 (5):' => 'QQ/1 (5).gif',
        ':1 (6):' => 'QQ/1 (6).gif',
        ':1 (7):' => 'QQ/1 (7).gif',
        ':1 (8):' => 'QQ/1 (8).gif',
        ':1 (9):' => 'QQ/1 (9).gif',
        ':1 (10):' => 'QQ/1 (10).gif',
        ':1 (11):' => 'QQ/1 (11).gif',
        ':1 (12):' => 'QQ/1 (12).gif',
        ':1 (13):' => 'QQ/1 (13).gif',
        ':1 (14):' => 'QQ/1 (14).gif',
        ':1 (15):' => 'QQ/1 (15).gif',
        ':1 (16):' => 'QQ/1 (16).gif',
        ':1 (17):' => 'QQ/1 (17).gif',
        ':1 (18):' => 'QQ/1 (18).gif',
        ':1 (19):' => 'QQ/1 (19).gif',
        ':1 (20):' => 'QQ/1 (20).gif',
        ':1 (21):' => 'QQ/1 (21).gif',
        ':1 (22):' => 'QQ/1 (22).gif',
        ':1 (23):' => 'QQ/1 (23).gif',
        ':1 (24):' => 'QQ/1 (24).gif',
        ':1 (25):' => 'QQ/1 (25).gif',
        ':1 (26):' => 'QQ/1 (26).gif',
        ':1 (27):' => 'QQ/1 (27).gif',
        ':1 (28):' => 'QQ/1 (28).gif',
        ':1 (29):' => 'QQ/1 (29).gif',
        ':1 (30):' => 'QQ/1 (30).gif',
        ':1 (31):' => 'QQ/1 (31).gif',
        ':1 (32):' => 'QQ/1 (32).gif',
        ':1 (33):' => 'QQ/1 (33).gif',
        ':1 (34):' => 'QQ/1 (34).gif',
        ':1 (35):' => 'QQ/1 (35).gif',
        ':1 (36):' => 'QQ/1 (36).gif',
        ':1 (37):' => 'QQ/1 (37).gif',
        ':1 (38):' => 'QQ/1 (38).gif',
        ':1 (39):' => 'QQ/1 (39).gif',
        ':1 (40):' => 'QQ/1 (40).gif',
        ':1 (41):' => 'QQ/1 (41).gif',
        ':1 (42):' => 'QQ/1 (42).gif',
        ':1 (43):' => 'QQ/1 (43).gif',
        ':1 (44):' => 'QQ/1 (44).gif',
        ':1 (45):' => 'QQ/1 (45).gif',
        ':1 (46):' => 'QQ/1 (46).gif',
        ':1 (47):' => 'QQ/1 (47).gif',
        ':1 (48):' => 'QQ/1 (48).gif',
        ':1 (49):' => 'QQ/1 (49).gif',
        ':1 (50):' => 'QQ/1 (50).gif',
        ':1 (51):' => 'QQ/1 (51).gif',
        ':1 (52):' => 'QQ/1 (52).gif',
        ':1 (53):' => 'QQ/1 (53).gif',
        ':1 (54):' => 'QQ/1 (54).gif',
        ':1 (55):' => 'QQ/1 (55).gif',
        ':1 (56):' => 'QQ/1 (56).gif',
        ':1 (57):' => 'QQ/1 (57).gif',
        ':1 (58):' => 'QQ/1 (58).gif',
        ':1 (59):' => 'QQ/1 (59).gif',
        ':1 (60):' => 'QQ/1 (60).gif',
        ':1 (61):' => 'QQ/1 (61).gif',
        ':1 (62):' => 'QQ/1 (62).gif',
        ':1 (63):' => 'QQ/1 (63).gif',
        ':1 (64):' => 'QQ/1 (64).gif',
        ':1 (65):' => 'QQ/1 (65).gif',
        ':1 (66):' => 'QQ/1 (66).gif',
        ':1 (67):' => 'QQ/1 (67).gif',
        ':1 (68):' => 'QQ/1 (68).gif',
        ':1 (69):' => 'QQ/1 (69).gif',
        ':1 (70):' => 'QQ/1 (70).gif',
        ':1 (71):' => 'QQ/1 (71).gif',
        ':1 (72):' => 'QQ/1 (72).gif',
        ':1 (73):' => 'QQ/1 (73).gif',
        ':1 (74):' => 'QQ/1 (74).gif',
        ':1 (75):' => 'QQ/1 (75).gif',
        ':1 (76):' => 'QQ/1 (76).gif',
        ':1 (77):' => 'QQ/1 (77).gif',
        ':1 (78):' => 'QQ/1 (78).gif',
        ':1 (79):' => 'QQ/1 (79).gif',
        ':1 (80):' => 'QQ/1 (80).gif',
        ':1 (81):' => 'QQ/1 (81).gif',
        ':1 (82):' => 'QQ/1 (82).gif',
        ':1 (83):' => 'QQ/1 (83).gif',
        ':1 (84):' => 'QQ/1 (84).gif',
        ':1 (85):' => 'QQ/1 (85).gif',
        ':1 (86):' => 'QQ/1 (86).gif',
        ':1 (87):' => 'QQ/1 (87).gif',
        ':1 (88):' => 'QQ/1 (88).gif',
        ':1 (89):' => 'QQ/1 (89).gif',
        ':1 (90):' => 'QQ/1 (90).gif',
        ':1 (91):' => 'QQ/1 (91).gif',
        ':1 (92):' => 'QQ/1 (92).gif',
        ':1 (93):' => 'QQ/1 (93).gif',
        ':1 (94):' => 'QQ/1 (94).gif',
        ':1 (95):' => 'QQ/1 (95).gif',
        ':1 (96):' => 'QQ/1 (96).gif',
        ':1 (97):' => 'QQ/1 (97).gif',
        ':1 (98):' => 'QQ/1 (98).gif',
        ':1 (99):' => 'QQ/1 (99).gif',
        ':1 (100):' => 'QQ/1 (100).gif',
        ':1 (101):' => 'QQ/1 (101).gif',
        ':1 (102):' => 'QQ/1 (102).gif',
        ':1 (103):' => 'QQ/1 (103).gif',
        ':1 (104):' => 'QQ/1 (104).gif',
        ':1 (105):' => 'QQ/1 (105).gif',
        ':1 (106):' => 'QQ/1 (106).gif',
        ':1 (107):' => 'QQ/1 (107).gif',
        ':1 (108):' => 'QQ/1 (108).gif',
        ':1 (109):' => 'QQ/1 (109).gif',
        ':1 (110):' => 'QQ/1 (110).gif',
        ':1 (111):' => 'QQ/1 (111).gif',
        ':1 (112):' => 'QQ/1 (112).gif',
        ':1 (113):' => 'QQ/1 (113).gif',
        ':1 (114):' => 'QQ/1 (114).gif',
        ':1 (115):' => 'QQ/1 (115).gif',
        ':1 (116):' => 'QQ/1 (116).gif',
        ':1 (117):' => 'QQ/1 (117).gif',
        ':1 (118):' => 'QQ/1 (118).gif',
        ':1 (119):' => 'QQ/1 (119).gif',
        ':1 (120):' => 'QQ/1 (120).gif',
        ':1 (121):' => 'QQ/1 (121).gif',
        ':1 (122):' => 'QQ/1 (122).gif',
        ':1 (123):' => 'QQ/1 (123).gif',
        ':1 (124):' => 'QQ/1 (124).gif',
        ':1 (125):' => 'QQ/1 (125).gif',
        ':1 (126):' => 'QQ/1 (126).gif',
        ':1 (127):' => 'QQ/1 (127).gif',
        ':1 (128):' => 'QQ/1 (128).gif',
        ':1 (129):' => 'QQ/1 (129).gif',
        ':1 (130):' => 'QQ/1 (130).gif',
        ':1 (131):' => 'QQ/1 (131).gif',
        ':1 (132):' => 'QQ/1 (132).gif',
        ':1 (133):' => 'QQ/1 (133).gif',
        ':1 (134):' => 'QQ/1 (134).gif',
        ':1 (135):' => 'QQ/1 (135).gif',
        ':1 (136):' => 'QQ/1 (136).gif',
        ':1 (137):' => 'QQ/1 (137).gif',
        ':1 (138):' => 'QQ/1 (138).gif',
        ':1 (139):' => 'QQ/1 (139).gif',
        ':1 (140):' => 'QQ/1 (140).gif',
    );
}
smilies_reset();
//Paging
function kratos_pages($range=5){
    global $paged,$wp_query,$max_page;
    if(!$max_page){$max_page=$wp_query->max_num_pages;}
    if($max_page>1){if(!$paged){$paged=1;}
    echo "<div class='text-center' id='page-footer'><ul class='pagination'>";
        if($paged != 1) echo '<li><a href="'.get_pagenum_link(1).'" class="extend" title="'.__('首页','moedog').'">&laquo;</a></li>';
        if($paged>1) echo '<li><a href="'.get_pagenum_link($paged-1).'" class="prev" title="'.__('上一页','moedog').'">&lt;</a></li>';
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
        if($paged<$max_page) echo '<li><a href="'.get_pagenum_link($paged+1).'" class="next" title="'.__('下一页','moedog').'">&gt;</a></li>';
        if($paged!=$max_page) echo '<li><a href="'.get_pagenum_link($max_page).'" class="extend" title="'.__('尾页','moedog').'">&raquo;</a></li>';
        echo "</ul></div>";
    }
}