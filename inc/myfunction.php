<?php
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
    $query->set('cat', '-39'); //过滤分类ID为 3,5,23的分类文章
  }
  return $query;
}
add_filter('pre_get_posts', 'excludeCat');

?>
