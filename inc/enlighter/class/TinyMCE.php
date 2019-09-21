<?php
/**
    TinyMCE Editor Addons
    Version: 1.2
    Author: Andi Dittrich
    Author URI: http://andidittrich.de
    Plugin URI: http://andidittrich.de/go/enlighterjs
    License: MIT X11-License
    
    Copyright (c) 2014, Andi Dittrich

    Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
    
    The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
    
    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/
namespace Enlighter;

class TinyMCE{
    
    // stores the plugin config
    private $_config;
    
    // plugin supported languages
    private $_supportedLanguageKeys;

    // cache manager
    private $_cacheFilename = 'TinyMCE.css';
    private $_cacheManager;
    
    public function __construct($settingsUtil, $cacheManager, $languageKeys){
        // store local plugin config
        $this->_config = $settingsUtil->getOptions();
        
        // store languages
        $this->_supportedLanguageKeys = $languageKeys;

        // store cache manager
        $this->_cacheManager = $cacheManager;

        // css cached ? otherwise regenerate it
        if (!$this->_cacheManager->fileExists('TinyMCE.css')){
            $this->generateCSS();
        }
    }

    // run integration
    public function integrate(){
        // TinyMCE 4 required !
        if (!version_compare(get_bloginfo('version'), '3.9', '>=')) {
            return;
        }
        // primary buttons (edit, insert) of the Visual Editor integration
        add_filter('mce_buttons', array($this, 'addButtons1'), 101);

        // load tinyMCE styles
        add_filter('mce_css', array($this, 'loadEditorCSS'));

        // load tinyMCE enlighter plugin
        add_filter('mce_external_plugins', array($this, 'loadPlugin'));

        // add pre-formatted styles ?
        if ($this->_config['editorAddStyleFormats']){
            // add filter to enable the custom style menu - low priority to avoid conflicts with other plugins which try to overwrite the settings
            add_filter('mce_buttons_2', array($this, 'addButtons2'), 101);

            // add filter to add custom formats (TinyMCE 4; requires WordPress 3.9) - low priority to avoid conflicts with other plugins which try to overwrite the settings
            add_filter('tiny_mce_before_init', array($this, 'insertFormats4'), 101);
        }
    }
    
    // insert "code insert dialog button"
    public function addButtons1($buttons){
        // Enlighter insert already available ?
        if (!in_array('EnlighterInsert', $buttons)){
            $buttons[] = 'EnlighterInsert';
            $buttons[] = 'EnlighterEdit';
        }
        return $buttons;
    }
    
    // insert styleselect menu into the $buttons array
    public function addButtons2($buttons){
        // style-select menu already enabled ?
        if (!in_array('styleselect', $buttons)){
            array_unshift($buttons, 'styleselect');
        }
        return $buttons;
    }
    
    // callback function to filter the MCE settings
    public function insertFormats4($tinyMceConfigData){
        // new style formats
        $styles = array();
        
        // style formats already defined ?
        if (isset($tinyMceConfigData['style_formats'])){
            $styles = json_decode($tinyMceConfigData['style_formats'], true);
        }

        // do not allow additional formatting within pre/code tags!
        $validChildTags = '-code[strong|em|del|a|table|sub|sup],-pre[strong|em|del|a|table|sub|sup]';

        // valid html tags
        if (isset($tinyMceConfigData['valid_children'])){
            $tinyMceConfigData['valid_children'] .= ',' . $validChildTags;
        }else{
            $tinyMceConfigData['valid_children'] = $validChildTags;
        }
        
        // create new "Enlighter Codeblocks" item
        $blockstyles = array();
        
        // add all supported languages as Enlighter Style
        foreach ($this->_supportedLanguageKeys as $name => $lang){
            // define new enlighter style formats
            $blockstyles[] = array(
                    'title' => ''.$name,
                    'block' => 'pre',
                    'classes' => 'EnlighterJSRAW',
                    'wrapper' => false,
                    'attributes' => array(
                        'data-enlighter-language' => $lang
                    )
            );
        }
        
        // add block styles
        $styles[] = array(
            'title' => __('Enlighter Codeblocks', 'enlighter'),
            'items' => $blockstyles
        );
        
        // inline highlighting enabled ?
        if ($this->_config['enableInlineHighlighting']){
            $inlinestyles = array();
            
            foreach ($this->_supportedLanguageKeys as $name => $lang){
                // define new enlighter inline style formats
                $inlinestyles[] =    array(
                        'title' => ''.$name,
                        'inline' => 'code',
                        'classes' => 'EnlighterJSRAW',
                        'wrapper' => false,
                        'selector' => '',
                        'attributes' => array(
                                'data-enlighter-language' => $lang
                        )
                );
            }
            
            // add inline styles
            $styles[] = array(
                    'title' => __('Enlighter Inline', 'enlighter'),
                    'items' => $inlinestyles
            );
        }
        
        // dont overwrite all settings
        $tinyMceConfigData['style_formats_merge'] = true;
        
        // apply modified style data
        $tinyMceConfigData['style_formats'] = json_encode($styles);
        
        // tab indentation mode enabled ?
        if ($this->_config['editorTabIndentation']){
            // remove tabfocus plugin
            $tinyMceConfigData['plugins'] = str_replace('tabfocus,', '', $tinyMceConfigData['plugins']);
        }

        return $tinyMceConfigData;
    }

    // generate the editor css
    public function generateCSS(){
        // load base styles
        $styles = file_get_contents(ENLIGHTER_PLUGIN_PATH.'/resources/tinymce/EnlighterJS.TinyMCE.min.css');

        // inline editor styles
        $customizer = array(
            'font-family:' . $this->_config['editorFontFamily'] . ' !important',
            'font-size:' . $this->_config['editorFontSize'] . ' !important',
            'line-height:' . $this->_config['editorLineHeight'] . ' !important',
            'color:' . $this->_config['editorFontColor'] . ' !important',
            'background-color:' . $this->_config['editorBackgroundColor'] . ' !important',
        );

        // Custom TinyMCE Styling
        $styles .= 'code.EnlighterJSRAW, pre.EnlighterJSRAW{' . implode(';', $customizer) . '}';

        // generate language titles
        foreach ($this->_supportedLanguageKeys as $name => $lang){

            // default title
            $defaultTitle = 'Enlighter: ' . $name;

            // generate codeblock title name
            $title = apply_filters('enlighter_codeblock_title', $defaultTitle, $lang, $name);
            
            // generate css rule
            $styles .= 'pre.EnlighterJSRAW[data-enlighter-language="' . $lang . '"]:before{content: "'. addslashes($title) .'"}';
        }

        // Automatic Editor width
        if ($this->_config['editorAutowidth']){
            $styles .= '.mceContentBody { max-width: none !important;}';
        }

        // store generated styles
        $this->_cacheManager->writeFile($this->_cacheFilename, $styles);
    }

    public function loadEditorCSS($mce_css){
        // add hash from last settings update to force a cache update
        $url = ResourceManager::getResourceUrl('cache/TinyMCE.css', ENLIGHTER_VERSION);

        // other styles loaded ?
        if (empty($mce_css)){
            return $url;

            // append custom TinyMCE styles to editor stylelist
        }else{
            return $mce_css . ','.$url;
        }
    }

    public function loadPlugin($mce_plugins){
        // TinyMCE plugin js
        $mce_plugins['enlighterjs'] = ResourceManager::getResourceUrl('tinymce/EnlighterJS.TinyMCE.min.js', ENLIGHTER_VERSION);
        return $mce_plugins;
    }
}