<?php
/**
    LowlLevel Shortcode handler to avoid issues with uescaped html or wpautop
    Version: 1.0
    Author: Andi Dittrich
    Author URI: http://andidittrich.de
    Plugin URI: http://andidittrich.de/go/enlighterjs
    License: MIT X11-License
    
    Copyright (c) 2016, Andi Dittrich

    Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
    
    The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
    
    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/
namespace Enlighter;

class ShortcodeFilter{
    
    // stores the plugin config
    private $_config;
    
    // store registered shortcodes
    private $_languageTags;

    // cached code content
    // public visibility required for PHP5.3 compatibility (lambda functions)
    // @TODO set to private in next major release (requires PHP5.4)
    public $_codeFragments = array();

    public function __construct($settingsUtil, $languageShortcodes){
        // store local plugin config
        $this->_config = $settingsUtil->getOptions();

        // default shortcodes
        $this->_languageTags = 'enlighter';

        // enable language shortcodes ?
        if ($this->_config['languageShortcode']){
            $this->_languageTags .= '|' . implode('|', $languageShortcodes);
        }
    }

    private function getShortcodeRegex($shortcodes){
        // opening tag based on enabled shortcodes
        return '/\[(' . $shortcodes . ')\s*' .

        // shortcode attributes (optional)
        '(.*)?' .

        // close opening tag
        '\s*\]' .

        // arbitrary multi-line content
        '([\S\s]*)' .

        // closing tag using opening tag back reference
        '\[\/\1\]' .

        // ungreedy, case insensitive
        '/Ui';
    }

    // internal regex function to replace shortcodes with placeholders
    // scoped to use it standalone as well as within shortcodes as second stage
    public function findShortcodes($content, $group = null){
        // PHP 5.3 compatibility
        $T = $this;

        // process enlighter & language shortcodes
        return preg_replace_callback($this->getShortcodeRegex($this->_languageTags), function ($match) use ($T, $group){

            // wordpress internal shortcode attribute parsing
            $attb = shortcode_parse_atts($match[2]);

            // language identifier (tagname)
            $lang = $match[1];

            // generic shortcode ?
            if (strtolower($match[1]) == 'enlighter') {
                // set language
                if ($attb['lang']) {
                    $lang = $attb['lang'];
                }
            }

            // generate code fragment
            $T->_codeFragments[] = array(
                // the language identifier
                'lang' => $lang,

                // shortcode attributes
                'attb' => $attb,

                // code to highlight
                'code' => $match[3],

                // auto codegroup
                'group' => $group
            );

            // replace it with a placeholder
            return '{{EJS0-' . count($T->_codeFragments) . '}}';
        }, $content);
    }

    // strip the content
    // internal shortcode processor - replace enlighter shortcodes by placeholder
    public function stripCodeFragments($content){
        // PHP 5.3 compatibility
        $T = $this;

        // STAGE 1
        // process codegroup shortcodes
        $content = preg_replace_callback($this->getShortcodeRegex('codegroup'), function ($match) use ($T){

            // create unique group identifier
            $group = uniqid('ejsg');

            // replace it with inner content an parse the shortcodes
            return $T->findShortcodes($match[3], $group);
        }, $content);

        // STAGE 2
        // process non grouped shortcodes
        $content = $this->findShortcodes($content);

        return $content;
    }

    // internal handler to insert the content
    public function renderFragments($content){

        // replace placeholders by html
        foreach ($this->_codeFragments as $index => $fragment){
            $content = str_replace('{{EJS0-' . ($index + 1) . '}}', $this->renderFragment($fragment), $content);
        }

        return $content;
    }

    // restore the content
    // process shortcode attributes and generate html
    private function renderFragment($fragment){
        // default attribute settings
        $shortcodeAttributes = shortcode_atts(
                array(
                        'theme' => null,
                        'group' => false,
                        'tab' => null,
                        'highlight' => null,
                        'offset' => null,
                        'linenumbers' => null
                ), $fragment['attb']);

        // html tag standard attributes
        $htmlAttributes = array(
                'data-enlighter-language' => InputFilter::filterLanguage($fragment['lang']),
                'class' => 'EnlighterJSRAW'
        );
        
        // force theme ?
        if ($shortcodeAttributes['theme']){
            $htmlAttributes['data-enlighter-theme'] = InputFilter::filterTheme($shortcodeAttributes['theme']);
        }
                
        // handle as inline code ?
        if ($this->_config['enableInlineHighlighting'] && strpos($fragment['code'], "\n") === false){
            // generate html output
            return $this->generateCodeblock($htmlAttributes, $fragment['code'], 'code');
            
        // line-breaks found -> block code
        }else{
            // highlight specific lines of code ?
            if ($shortcodeAttributes['highlight']){
                $htmlAttributes['data-enlighter-highlight'] = trim($shortcodeAttributes['highlight']);
            }
            
            // line offset ?
            if ($shortcodeAttributes['offset']){
                $htmlAttributes['data-enlighter-lineoffset'] = InputFilter::filterInteger($shortcodeAttributes['offset']);
            }
            
            // force linenumber visibility ?
            if ($shortcodeAttributes['linenumbers']){
                $htmlAttributes['data-enlighter-linenumbers'] = (strtolower($shortcodeAttributes['linenumbers']) === 'true' ? 'true' : 'false');
            }
            
            // tab-name available ?
            if ($shortcodeAttributes['tab']){
                $htmlAttributes['data-enlighter-title'] = trim($shortcodeAttributes['tab']);
            }

            // auto grouping ?
            if ($fragment['group']){
                $htmlAttributes['data-enlighter-group'] = trim($fragment['group']);

            // manual grouping ?
            }else if ($shortcodeAttributes['group']){
                $htmlAttributes['data-enlighter-group'] = trim($shortcodeAttributes['group']);
            }
            
            // generate html output
            return $this->generateCodeblock($htmlAttributes, $fragment['code']);
        }
    }

    /**
     * Generate HTML output (code within "pre"/"code"-tag including options)
     */
    private function generateCodeblock($attributes, $content, $tagname = 'pre'){
        // generate "pre" wrapped html output
        $html = HtmlUtil::generateTag($tagname, $attributes, false);

        // strip specialchars
        $content = esc_html($content);

        // add closing tag
        return $html.$content.'</'.$tagname.'>';
    }

}