<?php
/**
    Enlighter Class
    Version: 2.0
    Author: Andi Dittrich
    Author URI: http://andidittrich.de
    Plugin URI: http://andidittrich.de/go/enlighterjs
    License: MIT X11-License
    
    Copyright (c) 2013-2015, Andi Dittrich

    Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
    
    The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
    
    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/
namespace Enlighter;

class ThemeGenerator{
    
    private $_settings;
    private $_cacheFilename = 'EnlighterJS.custom.css';
    private $_cacheManager = null;

    // list of all customizable styles
    private static $_customStyleKeys = array(
        'kw1', //'Keyword(Type1)Color', 'enlighter'),
        'kw2', //'Keyword(Type2)Color', 'enlighter'),
        'kw3', //'Keyword(Type3)Color', 'enlighter'),
        'kw4', //'Keyword(Type4)Color', 'enlighter'),
        'co1', //'Slash-StyleCommentsColor', 'enlighter'),
        'co2', //'Multiline-StyleCommentsColor', 'enlighter'),
        'st0', //'Strings(Type1)Color', 'enlighter'),
        'st1', //'Strings(Type2)Color', 'enlighter'),
        'st2', //'Strings(Type3)Color', 'enlighter'),
        'nu0', //'NumberColor', 'enlighter'),
        'me0', //'Method(Type1)Color', 'enlighter'),
        'me1', //'Method(Type2)Color', 'enlighter'),
        'br0', //'BracketColor', 'enlighter'),
        'sy0', //'SymbolColor', 'enlighter'),
        'es0', //'EscapeSymbolColor', 'enlighter'),
        're0', //'RegexColor', 'enlighter'),
        'de1', //'StartDelimiterColor', 'enlighter'),
        'de2'  //'StopDelimiterColor', 'enlighter')
    );

    public function __construct($settingsUtil, $cacheManager){
        $this->_settings = $settingsUtil;
        $this->_cacheManager = $cacheManager;

        // custom theme selected ?
        if ($this->_settings->getOption('defaultTheme') == 'wpcustom' && !$this->isCached()){
            // regenerate cache file
            $this->generateCSS();
        }
    }

    public function isCached(){
        return $this->_cacheManager->fileExists($this->_cacheFilename);
    }

    public static function getCustomStyleKeys(){
        return self::$_customStyleKeys;
    }

    // update cache/generate dynamic css
    public function generateCSS(){

        // load css template
        $cssTPL = new SimpleTemplate(ENLIGHTER_PLUGIN_PATH.'/views/WpCustomTheme.css');
        
        // generate token styles
        foreach (self::$_customStyleKeys as $key=>$tokenname){
            $styles = '';
            
            // text color overwrite available ?
            if (($o = $this->_settings->getOption('custom-color-'.$tokenname)) != false){
                $styles .= 'color: '.$o.';';
            }
            
            // bg color overwrite available ?
            if (($o = $this->_settings->getOption('custom-bgcolor-'.$tokenname)) != false){
                $styles .= 'background-color: '.$o.';';
            }
            
            // style overwrite available ?
            if (($o = $this->_settings->getOption('custom-fontstyle-'.$tokenname)) != false){
                switch ($o){
                    case 'bold':
                        $styles .= 'font-weight: bold;';
                        break;
                    case 'italic':
                        $styles .= 'font-style: italic;';
                        break;
                    case 'bolditalic':
                        $styles .= 'font-weight: bold;font-style: italic;';
                        break;
                }
            }
            
            // decoration overwrite available ?
            if (($o = $this->_settings->getOption('custom-decoration-'.$tokenname)) != false){
                switch ($o){
                    case 'overline':
                        $styles .= 'text-decoration: overline;';
                        break;
                    case 'underline':
                        $styles .= 'text-decoration: underline';
                        break;
                    case 'through':
                        $styles .= 'text-decoration: line-through;';
                        break;
                }
            }
                        
            // assign token style
            $cssTPL->assign(strtoupper($tokenname), $styles);
        }
        
        // ========= FONT STYLES ======================
        // generate font styles
        $fontstyles = '';
        if (($o = $this->_settings->getOption('customFontFamily')) != false){
            $fontstyles .= 'font-family: '.$o.';';
        }
        if (($o = $this->_settings->getOption('customFontSize')) != false){
            $fontstyles .= 'font-size: '.$o.';';
        }
        if (($o = $this->_settings->getOption('customLineHeight')) != false){
            $fontstyles .= 'line-height: '.$o.';';
        }
        if (($o = $this->_settings->getOption('customFontColor')) != false){
            $fontstyles .= 'color: '.$o.';';
        }
        
        // assign font styles
        $cssTPL->assign('FONTSTYLE', $fontstyles);
        
        // ========= LINE STYLES ======================
        // generate line styles
        $linestyles = '';
        if (($o = $this->_settings->getOption('customLinenumberFontFamily')) != false){
            $linestyles .= 'font-family: '.$o.';';
        }
        if (($o = $this->_settings->getOption('customLinenumberFontSize')) != false){
            $linestyles .= 'font-size: '.$o.';';
        }
        if (($o = $this->_settings->getOption('customLinenumberFontColor')) != false){
            $linestyles .= 'color: '.$o.';';
        }        
        
        $cssTPL->assign('LINESTYLE', $linestyles);
        
        // ========= SPECIAL STYLES ======================
        // special styles
        if (($o = $this->_settings->getOption('customLineHighlightColor')) != false){
            $cssTPL->assign('HIGHLIGHT_BG_COLOR', $o);
        }
        if (($o = $this->_settings->getOption('customLineHoverColor')) != false){
            $cssTPL->assign('HOVER_BG_COLOR', $o);
        }
        
        // ========= RAW STYLES ======================
        // generate raw styles
        $rawstyles = '';
        if (($o = $this->_settings->getOption('customRawFontFamily')) != false){
            $rawstyles .= 'font-family: '.$o.';';
        }
        if (($o = $this->_settings->getOption('customRawFontSize')) != false){
            $rawstyles .= 'font-size: '.$o.';';
        }
        if (($o = $this->_settings->getOption('customRawLineHeight')) != false){
            $rawstyles .= 'line-height: '.$o.';';
        }
        if (($o = $this->_settings->getOption('customRawFontColor')) != false){
            $rawstyles .= 'color: '.$o.';';
        }
        if (($o = $this->_settings->getOption('customRawBackgroundColor')) != false){
            $rawstyles .= 'background-color: '.$o.';';
        }
        
        // assign font styles
        $cssTPL->assign('RAWSTYLE', $rawstyles);
        
        // load EnlighterJS base
        $enlighterJSBaseCss = file_get_contents(ENLIGHTER_PLUGIN_PATH.'/resources/EnlighterJS.min.css');
        
        // load theme base
        $enlighterJSThemeCss = file_get_contents(ENLIGHTER_PLUGIN_PATH.'/views/themes/'.strtolower($this->_settings->getOption('customThemeBase')).'.css');
        
        // store file, prepend base styles
        $this->_cacheManager->writeFile($this->_cacheFilename, $enlighterJSBaseCss . $enlighterJSThemeCss . $cssTPL->render());
    }
    
}