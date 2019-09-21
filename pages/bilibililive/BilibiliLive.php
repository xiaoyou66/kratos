<?php
class BilibiliLive{
    public $uid;
    public $usrname;//用户名
    public $sign;//签名
    public $isvip;//是否为vip
    public $level;//等级
    public $sex;//性别
    public $advanter;//头像
    public $hangpicture;//个性挂件
    public $attation;//关注数
    public $fans;//粉丝数
    public $play;//播放数
    public $birthday;//生日的月
    public $spacepicture;
    public $archivecount;//动态数目
    public $next_url;//下一次的url


    public function __construct($uid)
    {
        $this->uid=$uid;
        $url="https://api.bilibili.com/x/space/acc/info?mid=$uid&jsonp=jsonp";
        //获取播放量
        $url2="https://api.bilibili.com/x/space/upstat?mid=$uid&jsonp=jsonp";
        //获取粉丝数
        $url3="https://api.bilibili.com/x/relation/stat?vmid=$uid&jsonp=jsonp";
        //获取空间背景
        $url4="https://api.bilibili.com/x/web-interface/card?mid=$uid&photo=true";


        $ch = curl_init(); //初始化curl模块
        curl_setopt($ch, CURLOPT_URL, $url); //登录提交的地址
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);//这个很关键就是把获取到的数据以文件流的方式返回，而不是直接输出
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            //发送请求头
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.90 Safari/537.36",
            "Referer: https://www.bilibili.com/",
        ));
        $info=json_decode(curl_exec($ch),true);


        curl_setopt($ch, CURLOPT_URL, $url2); //登录提交的地址
        $info2=json_decode(curl_exec($ch),true);

        curl_setopt($ch, CURLOPT_URL, $url3); //登录提交的地址
        $info3=json_decode(curl_exec($ch),true);

        curl_setopt($ch, CURLOPT_URL, $url4); //登录提交的地址
        $info4=json_decode(curl_exec($ch),true);

        curl_close($ch);//关闭连接

        $this->usrname=$info["data"]["name"];
        $this->sign=$info["data"]["sign"];
        $this->isvip=$info["data"]["vip"]["status"];
        $this->level=$info["data"]["level"];
        $this->sex=$info["data"]["sex"];
        $this->advanter=substr($info["data"]["face"],stripos($info["data"]["face"],":")+1);
        $this->birthday= $info["data"]["birthday"];
        /*还有获取其他的信息*/
        $this->play=$info2['data']['archive']['view'];
        $this->attation=$info3['data']['following'];
        $this->fans=$info3['data']['follower'];
        $this->spacepicture=substr($info4['data']['space']['l_img'],stripos( $info4['data']['space']['l_img'],":")+1);
        $this->archivecount=$info4['data']['archive_count'];

    }

    function getlive($id)
    {
        $url="https://api.vc.bilibili.com/dynamic_svr/v1/dynamic_svr/space_history?visitor_uid=$this->uid&host_uid=$this->uid&offset_dynamic_id=$id";
        $ch = curl_init(); //初始化curl模块
        curl_setopt($ch, CURLOPT_URL, $url); //登录提交的地址
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);//这个很关键就是把获取到的数据以文件流的方式返回，而不是直接输出
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            //发送请求头
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.90 Safari/537.36",
            "Referer: https://www.bilibili.com/",
        ));
        $info=json_decode(curl_exec($ch),true);
        curl_close($ch);//关闭连接
        $this->hangpicture=$info["data"]["cards"][0]['desc']['user_profile']['pendant']['image'];
        $this->hangpicture=substr($this->hangpicture,stripos($this->hangpicture,":")+1);
        $this->next_url=$info["data"]["cards"][9]['desc']['dynamic_id'];
        return $info["data"]["cards"];
    }






}