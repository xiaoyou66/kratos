<?php
/**
Resource Utility Loader Class
Version: 1.0
Author: Andi Dittrich
Author URI: http://andidittrich.de
Plugin URI: http://andidittrich.de/go/enlighterjs
License: MIT X11-License

Copyright (c) 2013-2016, Andi Dittrich

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
namespace Enlighter;

class ResourceManager{

    // generate the resource url for ALL enlighter related public files
    public static function getResourceUrl($filename, $version=null){
        // strip whitespaces
        $filename = trim($filename);

        // apply resource filter
        $url = apply_filters('enlighter_resource_url', $filename, ENLIGHTER_PLUGIN_URL, $version);

        // filename not changed and relative url ? prepend plugin url, keep absolute path
        if ($filename == $url && preg_match('#^(?:/|[a-z]+:/).*$#i', $filename) === 0){

            // append version ?
            if ($version){
                $filename .= '?' . $version;
            }

            // cache file ?
            if (preg_match('#^cache/(.*)$#', $filename, $matches) === 1){
                // retrieve cache file url (add blog id)
                $url = CacheManager::getFileUrl($matches[1]);

            // default: static resource file
            }else{
                $url = ENLIGHTER_PLUGIN_URL . 'resources/' . $filename;
            }
        }

        return $url;
    }

}