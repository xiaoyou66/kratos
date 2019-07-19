<?php
//把Qplayer集成到主题中
if(kratos_option('openmusicplug')) include ("QPlayer/QPlayer.php");
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

    $r = '/<h([2-6]).*?\>(.*?)<\/h[2-6]>/is';

    if(is_single() && preg_match_all($r, $content, $matches)) {
        foreach($matches[1] as $key => $value) {
            $title = trim(strip_tags($matches[2][$key]));
            $content = str_replace($matches[0][$key], '<h' . $value . ' id="title-' . $key . '">'.$title.'</h2>', $content);
            $ul_li .= '<li><a href="#title-'.$key.'" title="'.$title.'">'.$title."</a></li>\n";
        }

        $content = "\n<div id=\"article-index\">
<strong id=\"article-index-move\">文章目录</strong>
<ol id=\"index-ul\">\n" . $ul_li . "</ol>
</div>\n" . $content;
    }

    return $content;
}
add_filter( 'the_content', 'article_index' );


//随机显示头像
add_filter( 'get_avatar' , 'local_random_avatar' , 1 , 5 );
function local_random_avatar( $avatar, $id_or_email, $size, $default, $alt) {
    if ( ! empty( $id_or_email->user_id ) ) {
        $avatar = ''.get_template_directory_uri().'/static/images/avatar/admin.jpg';
    }else{
        $random = mt_rand(1, 67);
        $avatar = ''.get_template_directory_uri().'/static/images/avatar/'. $random .'.jpeg';
    }
    $avatar = "<img alt='{$alt}' src='{$avatar}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}'/>";
    return $avatar;
}



?>
