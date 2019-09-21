<?php
/**
    LowlLevel GFM Filter
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

class GfmFilter{
    
    // default fallback language
    private $_defaultLanguage;

    // cached code content
    private $_codeFragments = array();

    public function __construct($settingsUtil){
        $this->_defaultLanguage = $settingsUtil->getOption('gfmDefaultLanguage');
    }

    private function getGfmRegex(){
        // opening tag
        return '/^```' .

        // language identifier (optional)
        '([a-z]+)?' .

        // EOL
        '\s*$' .

        // arbitrary multi-line content
        '([\S\s]*)' .

        // closing tag
        '^```\s*$' .

        // ungreedy, case insensitive, multiline
        '/Uim';
    }

    private function getInlineGfmRegex(){
        // opening tag
        return '/`' .

        // arbitrary single-line content
        '([^`]*)' .

        // closing tag
        '`'.
        
        // optional language identifier (non gfm standard)
        '(?:([a-z]+)\b)?' .

        // ungreedy, case insensitive
        '/i';
    }

    // strip the content
    // internal regex function to replace gfm code sections with placeholders
    public function stripCodeFragments($content){

        // PHP 5.3 compatibility
        $T = $this;

        // Block Code
        $content = preg_replace_callback($this->getGfmRegex(), function ($match) use ($T){

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
                'code' => $match[2],

                // no inline
                'inline' => false
            );

            // replace it with a placeholder
            return '{{EJS1-' . count($T->_codeFragments) . '}}';
        }, $content);

        // Inline Code
        return preg_replace_callback($this->getInlineGfmRegex(), function ($match) use ($T){

            // default language
            $lang = $T->_defaultLanguage;

            // language given ? otherwise use default highlighting method
            if (isset($match[2]) && strlen($match[2]) > 0){
                $lang = $match[2];
            }

            // generate code fragment
            $T->_codeFragments[] = array(
                // the language identifier
                'lang' => $lang,

                // code to highlight
                'code' => $match[1],

                // inline
                'inline' => true
            );

            // replace it with a placeholder
            return '{{EJS1-' . count($T->_codeFragments) . '}}';
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

            if ($fragment['inline']){
                // generate html output
                $html = $this->generateCodeblock($htmlAttributes, $fragment['code'], 'code');
            }else{
                // generate html output
                $html = $this->generateCodeblock($htmlAttributes, $fragment['code']);
            }


            // replace placeholder with rendered content
            $content = str_replace('{{EJS1-' . ($index + 1) . '}}', $html, $content);
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