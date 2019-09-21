<?php
/**
    Enlighter Javascript Config Generator
    Version: 1.2
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

class ConfigGenerator{
    
    private $_config;
    private $_cacheFilename = 'EnlighterJS.init.js';
    private $_cacheManager = null;
    
    public function __construct($settingsUtil, $cacheManager){
        $this->_config = $settingsUtil->getOptions();
        $this->_cacheManager = $cacheManager;
    }
    
    public function isCached(){
        return $this->_cacheManager->fileExists($this->_cacheFilename);
    }

    public function getEnlighterJSConfig(){
        $c = 'EnlighterJS_Config = ' . json_encode(array(
            'selector' =>  array(
                'block' => $this->_config['selector'],
                'inline' => $this->_config['selectorInline']
            ),
            'language' =>             $this->_config['defaultLanguage'],
            'theme' =>                $this->_config['defaultTheme'],
            'indent' =>               intval($this->_config['indent']),
            'hover' =>                ($this->_config['hoverClass'] ? 'hoverEnabled': 'NULL'),
            'showLinenumbers' =>      ($this->_config['linenumbers'] ? true : false),
            'rawButton' =>            ($this->_config['rawButton'] ? true : false),
            'infoButton' =>           ($this->_config['infoButton'] ? true : false),
            'windowButton' =>         ($this->_config['windowButton'] ? true : false),
            'rawcodeDoubleclick' =>   ($this->_config['rawcodeDoubleclick'] ? true : false),
            'grouping' => true,
            'cryptex' => array(
                'enabled' =>          ($this->_config['cryptexEnabled'] ? true : false),
                'email' =>            $this->_config['cryptexFallbackEmail']
            )
        ));
        return $c . ';';
    }
    
    // generate js based config
    public function getInitializationConfig(){
        // global config
        $c = $this->getEnlighterJSConfig();

        // initialization code
        $c .= file_get_contents(ENLIGHTER_PLUGIN_PATH . '/resources/EnlighterJS.Startup.min.js');

        return $c;
    }
    
    // store generated config into cachefile
    public function generate(){
        $this->_cacheManager->writeFile($this->_cacheFilename, $this->getInitializationConfig());
    }

    public function getEditorPluginConfig(){
        $c = 'EnlighterJS_EditorConfig = ';

        // create config object
        $c .= json_encode(array(
            'languages' => \Enlighter::getAvailableLanguages(),
            'themes' => \Enlighter::getAvailableThemes(),
            'config' => array(
                'theme' => $this->_config['defaultTheme'],
                'language' => $this->_config['defaultLanguage'],
                'linenumbers' => ($this->_config['linenumbers'] ? true : false),
                'indent' => intval($this->_config['indent']),
                'tabIndentation' => ($this->_config['editorTabIndentation'] ? true : false),
                'quicktagMode' => $this->_config['editorQuicktagMode'],
                'languageShortcode' => ($this->_config['languageShortcode'] ? true : false),
                'shortcuts' => ($this->_config['editorKeyboardShortcuts'] ? true : false)
            )
        ));

        return $c;
    }
}