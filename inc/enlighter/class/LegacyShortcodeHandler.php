<?php
/**
    Shortcode Handler Class
    Version: 1.0
    Author: Andi Dittrich
    Author URI: http://andidittrich.de
    Plugin URI: http://andidittrich.de/go/enlighterjs
    License: MIT X11-License
    
    Copyright (c) 2013, Andi Dittrich

    Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
    
    The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
    
    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/
namespace Enlighter;

class LegacyShortcodeHandler{
    
    // stores the plugin config
    private $_config;
    
    // store registered shortcodes
    private $_registeredShortcodes;
    
    // currently active codegroup
    private $_activeCodegroup;

    // flag to indicate if shortcodes have been applied
    public $_hasContent = false;
    
    public function __construct($settingsUtil, $languageShortcodes){
        // store local plugin config
        $this->_config = $settingsUtil->getOptions();
        
        // store registered shortcodes
        $this->_registeredShortcodes = array_merge($languageShortcodes, array('enlighter', 'codegroup'));
        
        // add texturize filter
        add_filter('no_texturize_shortcodes', array($this, 'texturizeHandler'));

        // add shotcode handlers
        add_shortcode('enlighter', array($this, 'genericShortcodeHandler'));
        add_shortcode('codegroup', array($this, 'codegroupShortcodeHandler'));

        // enable language shortcodes ?
        if ($this->_config['languageShortcode']){
            foreach ($languageShortcodes as $lang){
                add_shortcode($lang, array($this, 'microShortcodeHandler'));
            }
        }
    }
    
    // handle codegroups
    public function codegroupShortcodeHandler($shortcodeAttributes=NULL, $content='', $tagname=''){
        // default attribute settings
        $shortcodeAttributes = shortcode_atts(
                array(
                    'theme' => $this->_config['defaultTheme']
                ), $shortcodeAttributes);
    
        // html "pre"-tag attributes
        $htmlAttributes = array(
                'data-enlighter-theme' => $shortcodeAttributes['theme'],
                'class' => 'EnlighterJSRAW',
                'data-enlighter-group' => uniqid()
        );
    
        // assign html attrivutes
        $this->_activeCodegroup = $htmlAttributes;
    
        // call micro shortcode handlers
        $content = do_shortcode($content);
        
        // remove automatic generated html editor tags (from wpautop())
        $content = $this->removeWpAutoP($content);
        
        // disable group flag
        $this->_activeCodegroup = NULL;
        
        // return parsed content
        return $content;
    }
    
    // handle micro shortcode [php,js ..] ...
    public function microShortcodeHandler($shortcodeAttributes=NULL, $content='', $tagname=''){
        // default attribute settings
        $shortcodeAttributes = shortcode_atts(
                array(
                        'theme' => null,
                        'group' => false,
                        'tab' => null,
                        'highlight' => null,
                        'offset' => null,
                        'linenumbers' => null
                ), $shortcodeAttributes);

        // html tag standard attributes
        $htmlAttributes = array(
                'data-enlighter-language' => trim($tagname),
                'class' => 'EnlighterJSRAW'
        );
        
        // force theme ?
        if ($shortcodeAttributes['theme']){
            $htmlAttributes['data-enlighter-theme'] = trim($shortcodeAttributes['theme']);
        }
                
        // handle as inline code ?
        if ($this->_config['enableInlineHighlighting'] && strpos($content, "\n") === false){
            // generate html output
            return $this->generateCodeblock($htmlAttributes, $content, 'code');
            
        // linebreaks found -> block code    
        }else{
            // highlight specific lines of code ?
            if ($shortcodeAttributes['highlight']){
                $htmlAttributes['data-enlighter-highlight'] = trim($shortcodeAttributes['highlight']);
            }
            
            // line offset ?
            if ($shortcodeAttributes['offset']){
                $htmlAttributes['data-enlighter-lineoffset'] = intval($shortcodeAttributes['offset']);
            }
            
            // force linenumber visibility ?
            if ($shortcodeAttributes['linenumbers']){
                $htmlAttributes['data-enlighter-linenumbers'] = (strtolower($shortcodeAttributes['linenumbers']) === 'true' ? 'true' : 'false');
            }
            
            // tab-name available ?
            if ($shortcodeAttributes['tab']){
                $htmlAttributes['data-enlighter-title'] = trim($shortcodeAttributes['tab']);
            }
            
            // codegroup active ?
            if ($this->_activeCodegroup != NULL){
                // overwrite settings
                $htmlAttributes['data-enlighter-group'] = $this->_activeCodegroup['data-enlighter-group'];
            }else{
                // manual grouping ?
                if ($shortcodeAttributes['group']){
                    $htmlAttributes['data-enlighter-group'] = trim($shortcodeAttributes['group']);
                }
            }
            
            // generate html output
            return $this->generateCodeblock($htmlAttributes, $content);
        }
    }
    
    // handle wp shortcode [enlighter ..] ... [/enlighter] - generic handling
    public function genericShortcodeHandler($shortcodeAttributes=NULL, $content='', $tagname=''){
        // default language
        $language = (isset($shortcodeAttributes['lang']) ? $shortcodeAttributes['lang'] : $this->_config['defaultLanguage']);
    
        // run micro shortcode handler with given language key
        return $this->microShortcodeHandler($shortcodeAttributes, $content, $language);
    }
    
    /**
     * Generate HTML output (code within "pre"/"code"-tag including options)
     */
    private function generateCodeblock($attributes, $content, $tagname = 'pre'){
        // set flag
        $this->_hasContent = true;

        // generate "pre" wrapped html output
        $html = HtmlUtil::generateTag($tagname, $attributes, false);
        
        // remove automatic generated html editor tags (from wpautop())
        $content = $this->removeWpAutoP($content);
        
        // strip specialchars
        $content = esc_html($content);//htmlspecialchars($content, ENT_COMPAT | ENT_XHTML, 'UTF-8', false);
                
        // add closing tag
        return $html.$content.'</'.$tagname.'>';
    }

    /**
     * Removes wordpress auto-texturize handler from used shortcodes
     */
    public function texturizeHandler($shortcodes) {
        return array_merge($shortcodes, $this->_registeredShortcodes);
    }
    
    /**
     * Removes automatic generated html editor tags (from wpautop()) and restores linebreaks
     */
    private function removeWpAutoP($content){
        // wpautop priority changed ?
        if ($this->_config['wpAutoPFilterPriority']!='default'){
            // no modification needed
            return $content;
        }else{
            // fallback: remove added tags - will work on most cases
            return str_replace(array('<br />', '<p>', '</p>'), array('', '', "\n"), $content);
        }
    }

    // check if shortcode have been applied
    public function hasContent(){
        return $this->_hasContent;
    }
}