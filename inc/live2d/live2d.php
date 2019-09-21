<?php
/*
Plugin Name: live2d看板娘设置
Description: 用于设置看板娘
*/

define('FILE_PATH', dirname(__FILE__));

//获取js文件内容
function getjs()
{
    try{
        //读取文件内容
        $js=fopen(FILE_PATH.'/waifu-tips.js','r') or die("无法打开文件");
        $content=fread($js,filesize(FILE_PATH.'/waifu-tips.js'));
        fclose($js);
        return $content;
    }catch (Exception $e)
    {
        return "好像出了一点问题，无法获取到js的内容，请检查PHP是否有对该文件的读写权限！";
    }

}

//保存js文件内容
function savejs($content)
{
    $content=stripslashes($content);//字符反转义
    try{
        //读取文件内容
        $js=fopen(FILE_PATH.'/waifu-tips.js','w') or die(0);
        fwrite($js,$content);
        fclose($js);
        return 1;
    }catch (Exception $e)
    {
        return 0;
    }

}

//下载图片
function downloadimg($url,$imgpath)
{
    curlGet($url, $imgpath.'1.zip');//下载
    unzip($imgpath.'1.zip',$imgpath);//解压
    unlink($imgpath.'1.zip');//删除
}



//看板娘的设置界面
function live2d_option_page() {
    //判断是否有数据提交
    if(!empty($_POST)) {
        //live2d的设置
        if(!empty($_POST['live2d-setting'])) {
            if (savejs($_POST['live2d-setting'])) {
                ?>
                <div id="message" class="updated">
                    <p><strong>数据已保存(清除缓存后设置才能生效)</strong></p>
                </div>
                <?php
            } else {
                ?>
                <div id="message" class="updated">
                    <p><strong>保存数据失败</strong></p>
                </div>
                <?php
            }
        }
        //邮件订阅设置
        if(!empty($_POST['email_list'])) {
            if(emaillist_add($_POST['email_list'])==1) {
                ?>
                <div id="message" class="updated">
                    <p><strong>添加记录成功</strong></p>
                </div>
                <?php
            }
            else
            {
                 ?>
                 <div id="message" class="updated">
                     <p><strong>该记录已存在</strong></p>
                 </div>
                 <?php
            }
        }
        //删除订阅用户
        if(!empty($_POST['delete']))
        {
            if(emaillist_remove($_POST['delete'])==0)
            {
                ?>
                <div id="message" class="updated">
                    <p><strong>没有找到该订阅者</strong></p>
                </div>
                <?php
            }
            else
            {
                ?>
                <div id="message" class="updated">
                    <p><strong>已从列表中移除该订阅者</strong></p>
                </div>
                <?php
            }
        }
        //下载图片资源
        if($_POST['download']) {
            $imgpath=dirname(dirname(dirname(__FILE__))).'/static/images/thumb/';
            $filelist=getfilecouts($imgpath.'*');
            if($_POST['donman'] || $_POST['bilibili'])
            {
                foreach ($filelist as $filename)
                {
                    unlink($filename);
                }
            }
            //删除目录下所有图片
            if($_POST['donman']) {
                //批量删除图片
                downloadimg('http://cdn.xiaoyou66.com/image/thumb.zip',$imgpath)
                ?>
                <div id="message" class="updated">
                    <p><strong>已下载动漫图片资源,不保证绝对下载成功，请自行到主页刷新来进行查看</strong></p>
                </div>
                <?php
            }
            if($_POST['bilibili']) {
                downloadimg('http://cdn.xiaoyou66.com/image/bilibili.zip',$imgpath);
                ?>
                <div id="message" class="updated">
                    <p><strong>已下载哔哩哔哩图片资源,不保证绝对下载成功，请自行到主页刷新来进行查看</strong></p>
                </div>
                <?php
            }
            //live2d的设置
            $blogpath=$_SERVER['DOCUMENT_ROOT'] ;



        }
        /*下载头像*/
        if($_POST['downloadavatar']) {
            $imgpath=dirname(dirname(dirname(__FILE__))).'/static/images/avatar/';
            $filelist=getfilecouts($imgpath.'*');
            if($_POST['man'] || $_POST['woman'])
            {
                foreach ($filelist as $filename)
                {
                    unlink($filename);
                }
            }
            //删除目录下所有图片
            if($_POST['man']) {
                //批量删除图片
                downloadimg('http://cdn.xiaoyou66.com/image/avatarman.zip',$imgpath)
                ?>
                <div id="message" class="updated">
                    <p><strong>已下载动漫男生头像,不保证绝对下载成功，请自行到主页刷新来进行查看</strong></p>
                </div>
                <?php
            }
            if($_POST['woman']) {
                downloadimg('http://cdn.xiaoyou66.com/image/avatarwoman.zip',$imgpath);
                ?>
                <div id="message" class="updated">
                    <p><strong>已下载动漫女生头像,不保证绝对下载成功，请自行到主页刷新来进行查看</strong></p>
                </div>
                <?php
            }
        }
        if($_POST['downlive2d']) {
            downloadimg('http://cdn.xiaoyou66.com/image/live2d.zip',$_SERVER['DOCUMENT_ROOT'].'/');
            ?>
            <div id="message" class="updated">
                <p><strong>已下载live2d资源，不保证绝对成功，请自行检查</strong></p>
            </div>
            <?php
        }
        /*表情包下载*/
        if($_POST['downloadsmilies'])
        {
            $smilepath=dirname(dirname(dirname(__FILE__))).'/static/images/smilies/';
            $owo=dirname(dirname(__FILE__))."/OwO.json";
            if(!file_exists($smilepath."tieba/")) downloadimg('http://cdn.xiaoyou66.com/image/smile.zip', $smilepath);
            $url="";
            if($_POST['tieba']) $url.="1";
            if($_POST['face'])  $url?$url.=",2":$url.="2";
            if($_POST['zhihu']) $url?$url.=",3":$url.="3";
            if($_POST['bilibili']) $url?$url.=",4":$url.="4";
            if($_POST['tv']) $url?$url.=",5":$url.="5";
            if(file_exists($owo)) unlink($owo);
            curlGet("http://api.xiaoyou66.com/theme/OwO/?id=".$url,$owo);
            ?>
            <div id="message" class="updated">
                <p><strong>已下载表情包，不保证绝对成功，请自行检查</strong></p>
            </div>
            <?php
        }

    }
    ?>
    <style>
        .title{margin-bottom: 5px}
        .savejs{margin: 0px;}
    </style>
<div style="overflow-y: scroll">
    <h1>主题其他设置</h1><br>
    <div>
        <form action="" method="post" id="live2d-options-form">
            <div><div class="title"><h4>看板娘设置</h4> 直接读取的js文件，同时也会保存为js文件，不要修改除设置以外的其他地方！</div>
                <textarea  rows="6" cols="150" name="live2d-setting"><?php echo getjs() ?></textarea>
            </div>
            <input class="savejs" type="submit" name="savejs" value="保存js文件" />
        </form>
    </div>
    <div>
        <form action="" method="post" id="email-options-form">
            <?php wp_nonce_field('kratos_admin_options-update'); ?>
            <div><div class="title"><h4>邮件订阅设置</h4></div>这里显示了所有订阅者名单,每行一个,添加时不会判断邮箱的正确性，请自行检查</div>
                <textarea  rows="6" cols="50" name="email_lists"><?php $arr=explode(",",esc_attr(get_option('email_list')));$i=1;foreach ($arr as $item ){if($item){echo $i.':'.$item."\n";}$i++;}?></textarea>
            <p>
            添加订阅用户:<input type="text" id="email_list" name="email_list"/>
            <input class="savejs" type="submit" name="submit1" value="添加到订阅列表" /><br>
            </p>
            <p>
            删除订阅用户:<input type="text" id="delete" name="delete"/>
            <input class="savejs" type="submit" name="submit2" value="从订阅列表中移除" />
            </p>
        </form>
    </div>
    <div>
        <form action="" method="post">
            <div class="title"><h4>背景图片资源包下载</h4>请自行选择你喜欢的类型(<span style="color:red;">注意：将会把之前的图片全部删除（包括自己上传的）,如果两个都选将全部下载</span>)</div>
            <p><div>默认动漫图:<input type="checkbox" name="donman"/> 哔哩哔哩:<input type="checkbox" name="bilibili" /></div></p>
            <p><input type="submit" name="download" value="开始下载"/></p>
        </form>
    </div>
    <div>
        <form action="" method="post">
            <div class="title"><h4>随机头像下载</h4>请自行选择你喜欢的类型(<span style="color:red;">注意：将会把之前的头像全部删除（包括自己上传的）,如果两个都选将全部下载</span>)</div>
            <p><div>动漫男生头像:<input type="checkbox" name="man"/> 动漫女生头像:<input type="checkbox" name="woman" /></div></p>
            <p><input type="submit" name="downloadavatar" value="开始下载"/></p>
         </form>
    </div>
    <?php
    if(!file_exists($_SERVER['DOCUMENT_ROOT'] .'/live2d-api/')) {
        ?>
        <div>
            <form action="" method="post">
                <div class="title"><h4>live2dapi下载</h4>此功能专为小白使用,因为原api太大，所以该api为精简版(想体验完整版的自行下载原版api)</div>
                <span style="color:red;">注意：下载完毕后该功能会自行消失，下载完后到主页刷新一般会出现人物，没有人物可以试着切换人物，如果出现人物说明说明下载成功，一般过一会会自动出现的，所以不要认为api有问题，如果真的没用，请自行到博客根目录删除live2d-api目录</span>
                <p><input type="submit" name="downlive2d" value="开始下载"/></p>
            </form>
        </div>
        </div>
        <?php
    }?>
    <div>
        <form action="" method="post">
            <div class="title"><h4>表情包下载</h4>请自行选择你喜欢的类型(<span style="color:red;">会把之前的表情包全部删除，请至少选择一个表情包</span>)</div>
            <p><div>
                贴吧泡泡:<input type="checkbox" name="tieba"/>
                颜文字:<input type="checkbox" name="face" />
                知乎表情包:<input type="checkbox" name="zhihu" />
                B站表情包:<input type="checkbox" name="bilibili" />
                B站小电视表情包:<input type="checkbox" name="tv" />
            </div></p>
            <p><input type="submit" name="downloadsmilies" value="开始下载"/></p>
        </form>
    </div>
<?php
}

//注册数据库
function email_init() {
    register_setting('kratos_options', 'email_list');
}

add_action('admin_init', 'email_init');


//把设置界面添加到wordpress的设置内
function live2d_plugin_menu() {
    add_options_page('主题设置', '主题', 'manage_options', 'live2d-plugin','live2d_option_page' );
}

//加到wordpress进程中
add_action( 'admin_menu', 'live2d_plugin_menu' );


