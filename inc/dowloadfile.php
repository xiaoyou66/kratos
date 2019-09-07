<?php
class Downloadfile
{
    public function get($url, $file)
    {
        return file_put_contents($file, file_get_contents($url));
    }



    public function openGet($url, $file)
    {
        $in = fopen($url, "rb");
        $out = fopen($file, "wb");
        while ($chunk = fread($in,8192))
        {
            fwrite($out, $chunk, 8192);
        }
        fclose($in);
        fclose($out);
    }

    /**
    *
    * 创建目录，支持递归创建目录
    * @param String $dirName 要创建的目录
    * @param int $mode 目录权限
    */
    public function smkdir($dirName , $mode = 0777) {

        $dirs = explode('/' , str_replace('\\' , '/' , $dirName));
        $dir = '';

        foreach ($dirs as $part) {
            $dir.=$part . '/';
            if ( ! is_dir($dir) && strlen($dir) > 0) {
                if ( ! mkdir($dir , $mode)) {
                    return false;
                }
                if ( ! chmod($dir , $mode)) {
                    return false;
                }
            }
        }
        return true;
    }
}