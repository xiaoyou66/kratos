<?php
/**
template name: bilibili追番模板
*/
get_header(); ?>

<div id="container" class="container" >
    <div class="page-header">
        <h1>我的追番
         <?php
             require_once ("bilibili/bilibiliAnime.php");
             $bili=new bilibiliAnime(kratos_option('bilibili_uid'),kratos_option('bilibili_cookie'));
            echo "<small>当前已追".$bili->sum."部，继续加油！</small></h1></div><div class=\"bilibili\">";
            function precentage($str1,$str2)
            {
                if(is_numeric($str1) && is_numeric($str2)) return $str1/$str2*100;
                else if ($str1=="没有记录!") return 0;
                else return 100;
            }
            for($i=0;$i<$bili->sum;$i++)
            {
                echo "<a class=\"bgm-item\" href=\"https://www.bilibili.com/bangumi/play/ss".$bili->season_id[$i]."/ \" target=\"_blank\"><div class=\"bgm-item-thumb\" style=\"background-image:url(".$bili->image_url[$i].")\"></div><div class=\"bgm-item-info\"><span class=\"bgm-item-titlemain\">".$bili->title[$i]."</span><span class=\"bgm-item-title\">".$bili->evaluate[$i]."</span></div><div class=\"bgm-item-statusBar-container\"><div class=\"bgm-item-statusBar\" style=\"width:".precentage($bili->progress[$i],$bili->total[$i])."%\"></div>进度".$bili->progress[$i]."/". $bili->total[$i]."</div></a>";
            }
        ?>
    </div>
  </div>

<?php get_footer(); ?>










