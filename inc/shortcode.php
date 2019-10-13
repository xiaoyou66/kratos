<?php
function success($atts,$content=null,$code=""){
    $return = '<div class="alert alert-success">';
    $return .= do_shortcode($content);
    $return .= '</div>';
    return $return;
}
add_shortcode('success','success');
function info($atts,$content=null,$code=""){
    $return = '<div class="alert alert-info">';
    $return .= do_shortcode($content);
    $return .= '</div>';
    return $return;
}
add_shortcode('info','info');

function danger($atts,$content=null,$code=""){
    $return = '<div class="alert alert-danger">';
    $return .= do_shortcode($content);
    $return .= '</div>';
    return $return;
}
add_shortcode('danger','danger');
function wymusic($atts,$content=null,$code=""){
    extract(shortcode_atts(array("autoplay"=>'0'),$atts));
    $return = '<iframe style="width:100%" frameborder="no" border="0" marginwidth="0" marginheight="0" height="86" src="https://music.163.com/outchain/player?type=2&id=';
    $return .= $content;
    $return .= '&auto='.$autoplay.'&height=66"></iframe>';
    return $return;
}
add_shortcode('music','wymusic');

function ypbtn($atts,$content=null,$code=""){
    $return = '<a class="downbtn downcloud" href="';
    $return .= $content;
    $return .= '" target="_blank"><i class="fa fa-cloud-download"></i>云盘下载</a>';
    return $return;
}
add_shortcode('ypbtn','ypbtn');
function nrtitle($atts,$content=null,$code=""){
    $return = '<h2 class="title-h2">';
    $return .= $content;
    $return .= '</h2>';
    return $return;
}
add_shortcode('title','nrtitle');


function striped($atts,$content=null,$code=""){
    $return = '<div class="progress progress-striped active"><div class="progress-bar" style="width: ';
    $return .= $content;
    $return .= '%;"></div></div>';
    return $return;
}
add_shortcode('striped','striped');
function xcollapse($atts,$content=null,$code=""){
    extract(shortcode_atts(array("title"=>'标题内容'),$atts));
    $return = '<div class="xControl"><div class="xHeading"><div class="xIcon"><i class="fa fa-plus"></i></div><h5>';
    $return .= $title;
    $return .= '</h5></div><div class="xContent"><div class="inner">';
    $return .= do_shortcode($content);
    $return .= '</div></div></div>';
    return $return;
}
add_shortcode('collapse','xcollapse');


function hide($atts,$content=null,$code=""){
    extract(shortcode_atts(array("reply_to_this"=>'true'),$atts));
    global $current_user;
    get_currentuserinfo();
    if($current_user->ID) $email = $current_user->user_email;
    if($reply_to_this=='true'){
        if($email){
            global $wpdb;
            global $id;
            $comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_author_email = '".$email."' and comment_post_id='".$id."'and comment_approved = '1'");
        }
        if(!$comments) $content = '<div class="hide_notice">'.sprintf('抱歉，只有<a href="%s" rel="nofollow">登录</a>并在本文发表评论才能阅读隐藏内容',wp_login_url(get_permalink())).'</div>';
    }else{
        if($email){
            global $wpdb;
            global $id;
            $comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_author_email = '".$email."' and comment_approved = '1'");
        }
        if(!$comments) $content = '<div class="hide_notice">'.sprintf('抱歉，只有<a href="%s" rel="nofollow">登录</a>并在本站任一文章发表评论才能阅读隐藏内容',wp_login_url(get_permalink())).'</div>';
    }
    if($comments) $content = '<div class="unhide"><div class="info">以下为隐藏内容：</div>'.$content.'</div>';
    return $content;
}
add_shortcode('hide','hide');
function successbox($atts,$content=null,$code=""){
    extract(shortcode_atts(array("title"=>'标题内容'),$atts));
    $return = '<div class="panel panel-success"><div class="panel-heading"><h3 class="panel-title">';
    $return .= $title;
    $return .= '</h3></div><div class="panel-body">';
    $return .= do_shortcode($content);
    $return .= '</div></div>';
    return $return;
}
add_shortcode('successbox','successbox');
function infobox($atts,$content=null,$code=""){
    extract(shortcode_atts(array("title"=>'标题内容'),$atts));
    $return = '<div class="panel panel-info"><div class="panel-heading"><h3 class="panel-title">';
    $return .= $title;
    $return .= '</h3></div><div class="panel-body">';
    $return .= do_shortcode($content);
    $return .= '</div></div>';
    return $return;
}
add_shortcode('infobox','infobox');

function highlight($atts,$content=null,$code=""){
    extract(shortcode_atts(array("lanaguage"=>'语言'),$atts));
    $return = '<pre class="line-numbers"><code class="language-';
    $return .= $lanaguage;
    $return .= '">';
    //处理预格式化的内容
    $replace=array('<pre>','</pre>','<code>','</code>');
    $content=str_replace($replace,'',$content);
    //处理<和>无法显示的问题
    $content=str_replace('<','&lt;',$content);
    $content=str_replace('>','&gt;',$content);
    $return .=trim($content);
    $return .= '</code></pre>';
    return $return;
}
add_shortcode('highlight','highlight');


function block($atts,$content=null,$code=""){
    $return = '<pre class="hl"><code class="">';
    //处理预格式化的内容
    $replace=array('<pre>','</pre>','<code>','</code>');
    $content=str_replace($replace,'',$content);
    //处理<和>无法显示的问题
    $content=str_replace('<','&lt;',$content);
    $content=str_replace('>','&gt;',$content);
    $return .=trim($content);
    $return .= '</code></pre>';
    return $return;
}
add_shortcode('block','block');



function dangerbox($atts,$content=null,$code=""){
    extract(shortcode_atts(array("title"=>'标题内容'),$atts));
    $return = '<div class="panel panel-danger"><div class="panel-heading"><h3 class="panel-title">';
    $return .= $title;
    $return .= '</h3></div><div class="panel-body">';
    $return .= do_shortcode($content);
    $return .= '</div></div>';
    return $return;
}
add_shortcode('dangerbox','dangerbox');

function wxmusic($atts,$content=null,$code=""){
    extract(shortcode_atts(array("url"=>'地址'),$atts));
    extract(shortcode_atts(array("author"=>'作者'),$atts));
    extract(shortcode_atts(array("title"=>'标题'),$atts));
    $return = '<p class="weixinAudio"><audio src="';
    $return .=$url;
    $return .='" id="media" width="1" height="1" preload=""></audio><span id="audio_area" class="db audio_area"><span class="audio_wrp db"><span class="audio_play_area"><i class="icon_audio_default"></i><i class="icon_audio_playing"></i></span><span id="audio_length" class="audio_length tips_global">3:07</span><span class="db audio_info_area"><strong class="db audio_title">';
    $return .=$title;
    $return .='</strong><span class="audio_source tips_global">';
    $return .=$author;
    $return .='</span></span><span id="audio_progress" class="progress_bar" style="width: 0%;"></span></span></span></p>';
    return $return;
}
add_shortcode('wxmusic','wxmusic');



function bilibili($atts,$content=null,$code=""){
    extract(shortcode_atts(array("cid"=>'0'),$atts));
    extract(shortcode_atts(array("page"=>'1'),$atts));
    $return = '<div class="video-container"><iframe src="//player.bilibili.com/player.html?aid=';
    $return .= $content;
    $return .= '&cid=';
    $return .= $cid;
    $return .= '&page=';
    $return .= $page;
    $return .= '" allowtransparency="true" width="100%" height="498" scrolling="no" frameborder="0" ></iframe></div>';
    return $return;
}
add_shortcode('bilibili','bilibili');

add_action('init','more_button_a');
function more_button_a(){
    if(!current_user_can('edit_posts')&&!current_user_can('edit_pages')) return;
    if(get_user_option('rich_editing')=='true'){
        add_filter('mce_external_plugins','add_plugin');
        add_filter('mce_buttons','register_button');
    }
}
add_action('init','more_button_b');
function more_button_b(){
    if(!current_user_can('edit_posts')&&!current_user_can('edit_pages')) return;
    if(get_user_option('rich_editing')=='true'){
        add_filter('mce_external_plugins','add_plugin_b');
        add_filter('mce_buttons_3','register_button_b');
    }
}
function register_button($buttons){
    array_push($buttons," ","title");
    array_push($buttons," ","highlight");
    array_push($buttons," ","block");
    array_push($buttons," ","accordion");
    array_push($buttons," ","hide");
    array_push($buttons," ","striped");
    array_push($buttons," ","ypbtn");
    array_push($buttons," ","music");
    array_push($buttons," ","bilibili");
    array_push($buttons," ","wxmusic");
    return $buttons;
}
function register_button_b($buttons){
    array_push($buttons," ","success");
    array_push($buttons," ","info");
    array_push($buttons," ","danger");
    array_push($buttons," ","successbox");
    array_push($buttons," ","infoboxs");
    array_push($buttons," ","dangerbox");
    return $buttons;
}
function add_plugin($plugin_array){
    $plugin_array['title'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    $plugin_array['highlight'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    $plugin_array['block'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    $plugin_array['accordion'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    $plugin_array['hide'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    $plugin_array['striped'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    $plugin_array['ypbtn'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    $plugin_array['music'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    $plugin_array['bilibili'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    $plugin_array['wxmusic'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    return $plugin_array;
}
function add_plugin_b($plugin_array){
    $plugin_array['success'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    $plugin_array['info'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    $plugin_array['danger'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    $plugin_array['successbox'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    $plugin_array['infoboxs'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    $plugin_array['dangerbox'] = get_bloginfo('template_url').'/inc/buttons/more.js';
    return $plugin_array;
}
function add_more_buttons($buttons){
    $buttons[] = 'hr';
    $buttons[] = 'fontselect';
    $buttons[] = 'fontsizeselect';
    $buttons[] = 'styleselect';
    return $buttons;
}
add_filter("mce_buttons_2","add_more_buttons");

//显示表情
function fa_get_wpsmiliestrans(){
    global $wpsmiliestrans;
    $wpsmilies = array_unique($wpsmiliestrans);
    if(kratos_option('owo_out')) $owodir = bloginfo('template_url'); else $owodir = get_bloginfo('template_directory');
    foreach($wpsmilies as $alt => $src_path){
        $src_path=$owodir.'/static/images/smilies/'.$src_path;
        $output .= '<a class="add-smily" data-smilies="<img src=\''. $src_path.'\'>"><img src="'.$src_path.'"></a>';
    }
    return $output;
}
//添加表情
add_action('media_buttons_context','fa_smilies_custom_button');
function fa_smilies_custom_button($context){
    $context .= '<style>.smilies-wrap{background:#fff;border: 1px solid #ccc;box-shadow: 2px 2px 3px rgba(0, 0, 0, 0.24);padding: 10px;position: absolute;top: 60px;width: 380px;display:none}.smilies-wrap img{height:24px;width:24px;cursor:pointer;margin-bottom:5px} .is-active.smilies-wrap{display:block}</style><a id="REPLACE-media-button" style="position:relative" class="button REPLACE-smilies add_smilies" title="添加表情" data-editor="content" href="javascript:;">添加表情</a><div class="smilies-wrap">'. fa_get_wpsmiliestrans() .'</div><script>jQuery(document).ready(function(){jQuery(document).on("click", ".REPLACE-smilies",function() { if(jQuery(".smilies-wrap").hasClass("is-active")){jQuery(".smilies-wrap").removeClass("is-active");}else{jQuery(".smilies-wrap").addClass("is-active");}});jQuery(document).on("click", ".add-smily",function() { send_to_editor(" " + jQuery(this).data("smilies") + " ");jQuery(".smilies-wrap").removeClass("is-active");return false;});});</script>';
    return $context;
}
function appthemes_add_quicktags(){ ?>
    <script type="text/javascript">
        try{
            QTags.addButton( 'pre', 'pre', '<pre>\n', '\n</pre>' );
            QTags.addButton( 'hr', 'hr', '\n\n<hr />\n\n', '' );
            QTags.addButton( '代码高亮 ', '代码高亮 ', '[highlight lanaguage="语言"]', '[/highlight]' );
            QTags.addButton( '内容标题 ', '内容标题 ', '[title]', '[/title]' );
            QTags.addButton( '蓝色字体 ', '蓝色字体 ', '<span style="color: #0000ff;">', '</span>' );
            QTags.addButton( ' 红色字体 ', '红色字体 ', '<span style="color: #ff0000;">', '</span>' );
            QTags.addButton( '展开/收缩 ', '展开/收缩 ', '[collapse title="标题内容 "]', '[/collapse]' );
            QTags.addButton( '回复可见 ', '回复可见 ', '[hide reply_to_this="true"]', '[/hide]' );
            QTags.addButton( '云盘下载 ', '云盘下载 ', '[ypbtn]', '[/ypbtn]' );
            QTags.addButton( '网易云音乐 ', '网易云音乐 ', '[music autoplay="0"]', '[/music]' );
            QTags.addButton( '绿色背景栏 ', '绿色背景栏 ', '[success]', '[/success]' );
            QTags.addButton( '蓝色背景栏 ', '蓝色背景栏 ', '[info]', '[/info]' );
            QTags.addButton( '红色背景栏 ', '红色背景栏 ', '[danger]', '[/danger]' );
            QTags.addButton( '绿色面板 ', '绿色面板 ', '[successbox title="标题内容 "]', '[/successbox]' );
            QTags.addButton( '蓝色面板 ', '蓝色面板 ', '[infobox title="标题内容 "]', '[/infobox]' );
            QTags.addButton( '红色面板 ', '红色面板 ', '[dangerbox title="标题内容 "]', '[/dangerbox]' );
        }catch(err){}
    </script>
    <?php
}
add_action('admin_print_footer_scripts', 'appthemes_add_quicktags');