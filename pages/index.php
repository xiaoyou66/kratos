<!DOCTYPE HTML>
<html>
<head>
    <title>我的追番</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="bilibili/css/zzsc.css" rel="stylesheet" type="text/css" />
    <script src="bilibili/js/jquery.js?v=1.83.min" type="text/javascript"></script>
    <script src="bilibili/js/zzsc.js"></script>
    <style>
        .theme-dark .yue a:not([data-fancybox=gallery]):not(.post-like):not(.edit-button){border-color:#aaa}
        .yue a:not([data-fancybox=gallery]):not(.post-like):not(.edit-button){border-bottom:1px solid rgba(0,0,0,.2)}
        .yue a{word-wrap:break-word;word-break:break-all}
        .theme-dark a,.theme-dark a:hover{color:#b0b0b0}
        .bgm-item{background-color: rgba(253,253,253,0.30);border-radius:7px;height: 600px;float: left;display:block;margin:10px;width:300px;position:relative;box-shadow:0 0 6px rgba(0,0,0,.2);transition:.3s ease box-shadow;border:none!important;text-decoration:none!important;}
        .bgm-item-thumb{opacity: 0.7;border-top-left-radius: 7px;border-top-right-radius: 7px;transition: all 0.5s;width:100%;padding-top:120%;background-position:center;background-repeat:no-repeat;background-size:cover}
        .bgm-item-info{height: 28%;display:flex;flex-direction:column;align-items:center;padding:.5rem;overflow:hidden}
        .bgm-item-title{text-overflow:ellipsis;font-size:.86rem;color:#248ea9;font-weight:700;font-style:italic;}
        .bgm-item-info>*{display:block;margin:0 auto;max-width:100%}
        .bgm-item-statusBar-container{bottom:-22px;width: 97%;margin:.2rem auto;padding:.2em;background:rgba(0,0,0,.2);position:relative;z-index:0;color:#333;font-size:17px;font-weight: 700;font-style: italic;text-align: center;}
        .bgm-item-statusBar{position:absolute;height:100%;background:#ffb6c1;left:0;top:0;z-index:-1}
        .bgm-item:hover{background-color: rgba(253,253,253,0.90);box-shadow: 0 0 6px rgba(0,0,0,.8);}
        .bgm-item:hover .bgm-item-thumb{transform:scale(1.02);opacity: 1;}
        .bgm-item-titlemain {text-overflow: ellipsis;color: #f36886;font-weight: 400;font-size: 18px;text-shadow: 0 0 3px #fa8282;margin-bottom:8px;}
        .page-header{text-align: center;}
        .page-header{border-bottom: 1px solid #a773c3;}
        .page-header h1 small {font-size: 18px;color: #e42c64;}
        .page-header h1 {color: #63707e;font-weight: 800;}
        @media(max-width: 663px){.bgm-item-title{visibility: hidden;}.bgm-item{width:180px;height:320px;}.bgm-item-statusBar-container{bottom: 25px;font-size: 14px;}.bgm-item{background-color: rgba(253,253,253,0.80);}.bgm-item-thumb{opacity:1;}#rocket-to-top{visibility: hidden;}.bgm-item-titlemain{font-size: 16px}
        }
    </style>
</head>

<body style="background: url(bilibili/images/01.png);background-size: cover;background-attachment:fixed;background-position-x: center;">
<div style="display: none;" id="rocket-to-top">
    <div style="opacity:0;display: block;" class="level-2"></div>
    <div class="level-3"></div>
</div>
<div class="container">
    <div class="page-header">
        <h1>我的追番
         <?php
             require_once ("bilibili/bilibiliAnime.php");
             $bili=new bilibiliAnime();
            echo "<small>当前已追".$bili->sum."部，继续加油！</small></h1></div>";
            function precentage($str1,$str2)
            {
                if(is_numeric($str1) && is_numeric($str2)) return $str1/$str2*100;
                else if ($str1=="没有记录!") return 0;
                else return 100;
            }
            for($i=0;$i<$bili->sum;$i++)
            {
                echo "<a class=\"bgm-item\" href=\"https://www.bilibili.com/bangumi/play/ss".$bili->season_id[$i]."/ \" target=\"_blank\"><div class=\"bgm-item-thumb\" style=\"background-image:url(".$bili->image_url[$i].")\"></div><div class=\"bgm-item-info\"><span class=\"bgm-item-titlemain\">".$bili->title[$i]."</span><span class=\"bgm-item-title\">".$bili->evaluate[$i]."</span></div><div class=\"bgm-item-statusBar-container\"><div class=\"bgm-item-statusBar\" style=\"width:".precentage($bili->progress[$i],$bili->total[$i])."%\"></div>进度：".$bili->progress[$i]."/". $bili->total[$i]."</div></a>";
            }
        ?>
</div>

</body>
</html>










