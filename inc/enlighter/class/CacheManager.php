<?php 
/**
    Cache Path/Url Management
    Version: 1.0
    Author: Andi Dittrich
    Author URI: http://andidittrich.de
    Plugin URI: http://andidittrich.de/go/enlighterjs
    License: MIT X11-License
    
    Copyright (c) 2014-2016, Andi Dittrich
    
    Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
    
    The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
    
    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/
namespace Enlighter;

class CacheManager{
    
    // local cache path
    private $_cachePath;
    
    // cache url (public accessible)
    private $_cacheUrl;

    // update hash
    private $_uhash;

    // file prefix
    private $_prefix;

    // static url (provides simple access to getUrl())
    private static $_url;
    
    public function __construct($settingsUtil){

        // mu site ? generate prefix based on blog ID
        $this->_prefix = (is_multisite() ? 'X' . get_current_blog_id() . '_' : '');

        // default cache
        $this->_cachePath = ENLIGHTER_PLUGIN_PATH.'/cache/';
        $this->_cacheUrl = plugins_url('/enlighter/cache/');

        // generate static url
        self::$_url = $this->_cacheUrl . $this->_prefix;

        // get last update hash
        $this->_uhash = get_option('enlighter-settingsupdate-hash', '0A0B0C');
    }

    // file_put_contents wrapper
    public function writeFile($filename, $content){
        // ensure that the cache is accessible
        if (!$this->isCacheAccessible()){
            return false;
        }

        // write file - prepend absolute cache path
        file_put_contents($this->_cachePath . $this->_prefix . $filename, $content);
    }

    // caches file available ?
    public function fileExists($filename){
        return file_exists($this->_cachePath . $filename);
    }

    // drop cache items
    public function clearCache($clearAll = false){
        // cache dir
        $this->rmdir($this->_cachePath, $clearAll);

        // store last settings update time (unique hash to avoid caching)
        $hash = substr(sha1(microtime(true) . uniqid()), 0, 10);
        update_option('enlighter-settingsupdate-hash', $hash, true);
    }
    
    public function autosetPermissions(){
        // change permissions
        // owner +rwx
        // group +rwx
        // world +r
        chmod($this->_cachePath, 0774);
    }

    public function isCacheAccessible(){
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            return is_writeable($this->_cachePath);
        }else{
            return is_writeable($this->_cachePath) && is_executable($this->_cachePath);
        }
    }
    
    public function getCachePath(){
        return $this->_cachePath;
    }
    
    public function getCacheUrl(){
        return $this->_cacheUrl;
    }

    // instance-less access to pre-generated url
    public static function getFileUrl($filename){
        return self::$_url . $filename;
    }

    // Remove all files within the given directory (non recursive)
    private function rmdir($dir, $clearAll){
        // remove cached files
        if (is_dir($dir)){
            // get file list
            $files = scandir($dir);

            // process files
            foreach ($files as $file){

                // regular file ?
                if ($file!='.' && $file!='..' && is_file($dir.$file)){
                    // MU prefix set ?
                    if ($clearAll === false && strlen($this->_prefix) > 0){
                        // file starts with prefix ?
                        if (substr($file, 0, strlen($this->_prefix)) == $this->_prefix){
                            unlink($dir.$file);
                        }
                    // drop all cache files
                    }else{
                        unlink($dir.$file);
                    }

                }
            }
        }
    }
}