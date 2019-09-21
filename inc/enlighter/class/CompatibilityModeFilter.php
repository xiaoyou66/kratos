<?php
/**
    Legacy Mode/3rd Party Compatibility
    Version: 1.0
    Author: Andi Dittrich
    Author URI: http://andidittrich.de
    Plugin URI: http://andidittrich.de/go/enlighterjs
    License: MIT X11-License
    
    Copyright (c) 2018-2019, Andi Dittrich

    Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
    
    The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
    
    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/
namespace Enlighter;

class CompatibilityModeFilter{
    
    // default fallback language
    private $_defaultLanguage;

    // cached code content
    private $_codeFragments = array();

    public function __construct($settingsUtil){
        $this->_defaultLanguage = $settingsUtil->getOption('compatDefaultLanguage');
    }
    
    // used by e.g. JetPack markdown
    private function getCompatRegexType1(){
        // opening tag, language identifier (optional)
        return '/<pre><code(?:\s+class="([a-z]+)")?>' .

        // arbitrary multi-line content
        '([\S\s]*)' .

        // closing tags
        '\s*<\/code>\s*<\/pre>\s*' .

        // ungreedy, case insensitive, multiline
        '/Uim';
    }

    // used by e.g. Gutenberg Codeblock
    private function getCompatRegexType2(){
        // opening tag - no language identifier
        return '/<pre(?:[^>]+?)?><code>' .

        // arbitrary multi-line content
        '([\S\s]*)' .

        // closing tags
        '\s*<\/code>\s*<\/pre>\s*' .

        // ungreedy, case insensitive, multiline
        '/Uim';
    }

    // used by e.g. Crayon
    private function getCompatRegexType3(){
        // opening tag, language identifier (optional)
        return '/<pre\s+class="lang:([a-z]+?)([^"]*)"\s*>' .

        // case insensitive, multiline
        '/im';
    }


    // strip the content
    // internal regex function to replace gfm code sections with placeholders
    public function stripCodeFragments($content){

        // PHP 5.3 compatibility
        $T = $this;

        // Block Code
        return preg_replace_callback($this->getCompatRegexType1(), function ($match) use ($T){

            // language identifier (tagname)
            $lang = $match[1];

            // language given ? otherwise use default highlighting method
            if (strlen($lang) == 0){
                $lang = $T->_defaultLanguage;
            }

            // generate code fragment
            $T->_codeFragments[] = array(
                // the language identifier
                'lang' => $lang,

                // code to highlight
                'code' => $match[2]
            );

            // replace it with a placeholder
            return '{{EJS2-' . count($T->_codeFragments) . '}}';
        }, $content);
    }


    // internal handler to insert the content
    public function renderFragments($content){

        // replace placeholders by html
        foreach ($this->_codeFragments as $index => $fragment){
            // html tag standard attributes
            $htmlAttributes = array(
                'data-enlighter-language' => InputFilter::filterLanguage($fragment['lang']),
                'class' => 'EnlighterJSRAW'
            );

            // generate html output
            $html = $this->generateCodeblock($htmlAttributes, $fragment['code']);

            // replace placeholder with rendered content
            $content = str_replace('{{EJS2-' . ($index + 1) . '}}', $html, $content);
        }

        return $content;
    }


    // Generate HTML output (code within "pre"/"code"-tag including options)
    private function generateCodeblock($attributes, $content, $tagname = 'pre'){
        // generate "pre" wrapped html output
        $html = HtmlUtil::generateTag($tagname, $attributes, false);

        // strip special-chars
        $content = esc_html($content);

        // add closing tag
        return $html.$content.'</'.$tagname.'>';
    }

}