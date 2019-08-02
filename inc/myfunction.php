<?php
//把Qplayer集成到主题中
if(kratos_option('openmusicplug')) include ("QPlayer/QPlayer.php");
if(kratos_option('open_tinymce')) include ("tinymce-advanced/tinymce-advanced.php");


//字数统计
function count_words ($text) {
    global $post;
    if ( '' == $text ) {
        $text = $post->post_content;
        if (mb_strlen($output, 'UTF-8') < mb_strlen($text, 'UTF-8')) $output .= '共' . mb_strlen(preg_replace('/\s/','',html_entity_decode(strip_tags($post->post_content))),'UTF-8') . '个字&nbsp;&nbsp;';
        return $output;
    }
}
//首页过滤指定分类目录文章
function excludeCat($query) {
  if ( $query->is_home ) { //首页过滤指定分类，你可以指定其他页面
    $query->set('cat', kratos_option('filter')); //过滤分类ID为 3,5,23的分类文章
  }
  return $query;
}
add_filter('pre_get_posts', 'excludeCat');


function article_index($content) {
    $matches = array();
    $ul_li = '';
    $js='';//js脚本
    $r = '/<h([2-6]).*?\>(.*?)<\/h[2-6]>/is';
    $i=0;
    if(is_single() && preg_match_all($r, $content, $matches)) {
        foreach($matches[1] as $key => $value) {
            $title = trim(strip_tags($matches[2][$key]));
            $content = str_replace($matches[0][$key], '<h' . $value . ' id="title-' . $key . '">'.$title.'</h2>', $content);
            $ul_li .= '<li id="go-'.$key.'" title="'.$title.'">'.$title."</li>\n";
            $i++;
        }
        for($j=0;$j<$i;$j++)
        {
            $js.='document.querySelector("#go-'.$j.'").onclick = function(){
                    document.querySelector("#title-'.$j.'").scrollIntoView(true);
                };';
        }
        $content = "<div id=\"article-index\"><div id=\"article-index-move\">文章目录<a id=\"category-close\">[x]</a></div>
<ol id=\"index-ul\">" . $ul_li . "</ol>
</div>".'<script type="text/javascript">'.$js.'</script>'.$content;
    }
    return $content;
}
if(kratos_option('opencontent')) add_filter( 'the_content', 'article_index');

//随机显示头像
function local_random_avatar( $avatar, $id_or_email, $size, $default, $alt) {
    $imgs=getfilecouts(dirname(dirname(__FILE__)).'/static/images/avatar/*');
    if ( $id_or_email->user_id ==0) {
        $random = mt_rand(0,count($imgs)-1);
        $avatar = get_bloginfo('template_url')."/static/images/avatar/".substr($imgs[$random],strripos($imgs[$random],'/')+1);
        $avatar = "<img alt='{$alt}' src='{$avatar}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}'/>";
    }
    return $avatar;
}
add_filter( 'get_avatar' , 'local_random_avatar' , 1 , 5 );

//去除回车换行
function trimall($str){
    $qian=array(" ","　","\t","\n","\r");
    return str_replace($qian, '', $str);
}

//自定义显示摘要函数
function showSummary($content)
{
    //先清除html注释和回车换行
    $content=strip_tags($content);
    $content=trimall($content);
    //判断最前面的是不是信息框
   if($content[0]=='[')
   {
       /*如果是就返回信息框的内容*/
       $content=substr($content,strpos($content,']')+1);
       $content=substr($content,0,strpos($content,'['));
       return $content;
   }
   else //如果不是信息框那么就直接截取字符
   {
       return wp_trim_words($content,kratos_option('w_num'));
   }
}

//发布文章时发送电子邮件
function send_email($new,$old,$post)
{

    if($new=="publish" && ($old=="auto-draft" || $old=="draft") && $post->post_title!="")
    {
        $to=explode(",",esc_attr(get_option('email_list')));
        $subject = '你关注的博主有新文章发布啦！φ(>ω<*) ';
        $permalink = get_permalink($post->ID);
        $message='
                    <style>.qmbox img.wp-smiley{width:auto!important;height:auto!important;max-height:8em!important;margin-top:-4px;display:inline}
</style>
            <div style="background:#ececec;width:100%;padding:50px 0;text-align:center">
                <div style="background:#fff;width:750px;text-align:left;position:relative;margin:0 auto;font-size:14px;line-height:1.5">
                    <div style="zoom:1;padding:25px 40px;background:#518bcb; border-bottom:1px solid #467ec3;">
                        <h1 style="color:#fff;font-size:25px;line-height:30px;margin:0"><a href="'.home_url().'" style="text-decoration:none;color:#FFF">'.get_bloginfo('name').'</a></h1>
                        <img style="position: relative;left: 423px;top:25px;" src="https://img.xiaoyou66.com/images/2019/05/17/lvDc.png">
                        <h3 style="position: relative;color:#FFF;left: 263px;bottom: -25px;">(〃\'▽\'〃)你关注的博主有文章更新啦( • ̀ω•́ )✧</h3>
                    </div>
                    <div style="padding:35px 40px 30px">
                        <h2 style="font-size:18px;margin:5px 0">文章标题:'.$post->post_title.'</h2>
                        <hr>
						<h3 style="font-size:18px;margin:5px 0">摘要：</h3>
                        <p style="color:#313131;line-height:20px;font-size:15px;margin:20px 0">'.showSummary($post->post_content).'</p>
						<h4><a href="'.$permalink.'">点击查看原文</a></h4>
                        <br  />
                        <div style="font-size:13px;color:#a0a0a0;padding-top:10px">该邮件由系统自动发出，如果不是您本人操作，请忽略此邮件。</div>
                        <div class="qmSysSign" style="padding-top:20px;font-size:12px;color:#a0a0a0">
                            <p style="color:#a0a0a0;line-height:18px;font-size:12px;margin:5px 0">'.get_bloginfo('name').'</p>
                            <p style="color:#a0a0a0;line-height:18px;font-size:12px;margin:5px 0"><span style="border-bottom:1px dashed #ccc" t="5" times="">'.date("Y-m-d",time()).'</span></p>
                        </div>
                    </div>
                </div>
            </div>
        ';
        $headers = 'Content-type: text/html';
        wp_mail($to,$subject,$message,$headers);
    }
}
//给注册用户开放邮件订阅服务
function open_email($user) {
    $content=esc_attr(get_option('email_list'));
    //判断用户是否已经订阅
    if(strpos($content,$user->user_email)===false)
    {
        ?>
        <h3>开启邮件订阅</h3>
        <input type="checkbox" name="openemail[]" />开启后当站长发布新文章后会通知你哦！
        <?php
    }
    else
    {
        ?>
        <h3>开启邮件订阅</h3>
        <input type="checkbox" name="openemail[]" checked="checked" />开启后当站长发布新文章后会通知你哦！
        <?php
    }
}

//给自己的列表添加用户
function emaillist_add($email)
{
    $content=esc_attr(get_option('email_list'));
    if(strpos($content,$email)===false)
    {
        if(!$content)
            $content=$email;
        else
            $content=$content.','.$email;
        update_option('email_list',$content);
        return 1;
    }
    else
    {
        return 0;
    }
}
//给自己的列表删除用户
function emaillist_remove($email)
{
    $content=esc_attr(get_option('email_list'));
    if(strpos($content,$email)===false)
    {
        return 0;
    }
    else
    {
        $pos = strpos($content, $email);
        if ($content[$pos - 1] == ',') {
            $content = str_replace(',' . $email, '', $content);
        } else {
            if ($content[$pos + strlen($email)] == ',')
                $content = str_replace($email . ',', '', $content);
            else
                $content = str_replace($email, '', $content);
        }
        update_option('email_list', $content);
        return 1;
    }
}

//更新后进行的操作
function update_email_setting($id)
{
    //判断是否有数据提交
    if(!empty($_POST)) {
        //获取用户邮箱
        $user=get_userdata($id);
        if($_POST['openemail'])
           emaillist_add($user->user_email);
        else
            emaillist_remove($user->user_email);
    }
}
if(kratos_option('openpassage'))
{
    add_action('show_user_profile', 'open_email');
    add_action('personal_options_update', 'update_email_setting');
    add_action('transition_post_status','send_email',1,3);
}


//获取文件夹下文件并返回为文件名数组
function getfilecouts($url)
{
    $sl=array();//造一个变量，让他默认值为0;
    $arr = glob($url);//把该路径下所有的文件存到一个数组里面;
    foreach ($arr as $v)//循环遍历一下，把数组$arr赋给$v;
    {
       if(is_file($v))//先用个if判断一下这个文件夹下的文件是不是文件，有可能是文件夹;
        {
            array_push($sl,$v);

       }
    }
    return $sl;//当这个方法走完后，返回一个值$sl,这个值就是该路径下所有的文件数量;
}


//下载文件
function curlGet($url, $file)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 0);
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $file_content = curl_exec($ch);
    curl_close($ch);
    $downloaded_file = fopen($file, 'w');
    fwrite($downloaded_file, $file_content);
    fclose($downloaded_file);
}

//解压文件
function unzip($fromName, $toName)
{
    if(!file_exists($fromName)){
        return FALSE;
    }
    $zipArc = new ZipArchive();
    if(!$zipArc->open($fromName)){
        return FALSE;
    }
    if(!$zipArc->extractTo($toName)){
        $zipArc->close();
        return FALSE;
    }
    return $zipArc->close();
}

?>
