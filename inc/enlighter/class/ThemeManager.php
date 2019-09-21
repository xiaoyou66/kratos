<?php
/**
    Try to load User-Themes from the `enlighter` directory of current selected Theme
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

class ThemeManager{
    
    private $_cachedData = null;

    // list of supported themes
    // Enlighter Godzilla Beyond Classic MooTwo Eclipse Droide Git Mocha MooTools Panic Tutti Twilight
    private static $_supportedThemes = array(
        'Enlighter' => true,
        'Godzilla' => true,
        'Beyond' => true,
        'Classic' => true,
        'MooTwo' => true,
        'Eclipse' => true,
        'Droide' => true,
        'Minimal' => true,
        'Atomic' => true,
        'Rowhammer' => true,
        'Git' => true,
        'Mocha' => true,
        'MooTools' => true,
        'Panic' => true,
        'Tutti' => true,
        'Twilight' => true
    );

    public function __construct(){
        // try to load cached data
        $this->_cachedData = get_transient('enlighter_userthemes');
    }
    
    // drop cache content and remove cache file
    public function forceReload(){
        //$this->_cache->clear();
        delete_transient('enlighter_userthemes');
    }

    // get a list of all available themes
    public function getThemes(){
        return $this->getThemeList();
    }

    // fetch the build-in theme list (EnlighterJS)
    public function getBuildInThemes(){
        return self::$_supportedThemes;
    }

    // get a list of all available themes (build-in + user)
    public function getThemeList(){
        // generate the theme list
        $themes = array(
            'WPCustom' => 'wpcustom'
        );

        // add build-in themes
        foreach (self::$_supportedThemes as $t => $v){
            $themes[$t] = strtolower($t);
        }

        // add external user themes with prefix
        foreach ($this->getUserThemes() as $t => $source){
            $themes[$t.'/ext'] = strtolower($t);
        }

        // run filter to enable user specific themes
        return apply_filters('enlighter_themes', $themes);
    }

    // fetch user themes
    // Enlighter Themes which are stored a directory named `enlighter/` of the current active theme
    public function getUserThemes(){
        // cached data available ?
        if ($this->_cachedData === false){
            // get template directories
            $childDir = get_stylesheet_directory();
            $themeDir = get_template_directory();
            
            // load enlighter-themes from current theme
            $themeFiles = $this->getCssFilesFromDirectory($themeDir, get_template_directory_uri());
            
            // load enlighter-themes from current child-theme (if used)
            if ($childDir != $themeDir){
                $themeFiles = array_merge($themeFiles, $this->getCssFilesFromDirectory($childDir, get_stylesheet_directory_uri()));
            }
            
            // store data; 1day cache expire
            set_transient('enlighter_userthemes', $themeFiles, DAY_IN_SECONDS);
            $this->_cachedData = $themeFiles;
        }

        return $this->_cachedData;
    }
    
    private function getCssFilesFromDirectory($dir, $uri){
        // enlighter subdirectory
        $dir .= '/enlighter/';
        $uri .= '/enlighter/';
        
        // available ?
        if (!is_dir($dir)){
            return array();
        }
        
        // get all files of the selected directory
        $files = scandir($dir);
        
        // theme buffers
        $themes = array();
        
        // filter css files
        foreach($files as $file){
            if ($file != '.' && $file != '..'){
                if (substr($file, -3) == 'css'){
                    // absolute path + uri for external themes
                    $themes[basename($file, '.css')] = array(
                            $dir.$file,
                            $uri.$file
                    );
                }
            }
        }
        
        return $themes;
    }
    
}