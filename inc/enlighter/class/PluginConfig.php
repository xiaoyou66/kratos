<?php
/**
    Plugin Config Storage
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

class PluginConfig{
    
    // enlighter config keys with default values
    private static $_defaultConfig = array(
        'embedEnlighterCSS' => true,
        'embedEnlighterJS' => true,
        'embedExternalThemes' => true,

        'mootoolsSource' => 'local',
        'jsType' => 'inline',
        'jsPosition' => 'footer',
        'defaultTheme' => 'enlighter',
        'defaultLanguage' => 'generic',
        'indent' => 2,
        'linenumbers' => 'true',
        'hoverClass' => 'hoverEnabled',
        'selector' => 'pre.EnlighterJSRAW',
        'selectorInline' => 'code.EnlighterJSRAW',

        'languageShortcode' => true,
        'shortcodeMode' => 'modern',
        'shortcodeFilterContent' => true,
        'shortcodeFilterExcerpt' => false,
        'shortcodeFilterComments' => false,
        'shortcodeFilterCommentsExcerpt' => false,
        'shortcodeFilterWidgetText' => false,

        'gfmDefaultLanguage' => 'generic',
        'gfmFilterContent' => false,
        'gfmFilterExcerpt' => false,
        'gfmFilterComments' => false,
        'gfmFilterCommentsExcerpt' => false,
        'gfmFilterWidgetText' => false,

        'compatDefaultLanguage' => 'generic',
        'compatFilterContent' => false,
        'compatFilterExcerpt' => false,
        'compatFilterComments' => false,
        'compatFilterCommentsExcerpt' => false,
        'compatFilterWidgetText' => false,
        
        'editorFontFamily' => '"Source Code Pro", "Liberation Mono", "Courier New", Courier, monospace',
        'editorFontSize' => '0.7em',
        'editorLineHeight' => '0.9em',
        'editorFontColor' => '#000000',
        'editorBackgroundColor' => '#f9f9f9',
        'editorAutowidth' => false,
        'editorQuicktagMode' => 'html',
        'editorAddStyleFormats' => true,
        'editorTabIndentation' => false,
        'editorKeyboardShortcuts' => false,

        'customThemeBase' => 'standard',
        'customFontFamily' => 'Monaco, Courier, Monospace',
        'customFontSize' => '12px',
        'customLineHeight' => '16px',
        'customFontColor' => '#000000',

        'customLinenumberFontFamily' => 'Monaco, Courier, Monospace',
        'customLinenumberFontSize' => '10px',
        'customLinenumberFontColor' => '#000000',

        'customLineHighlightColor' => '#f0f0ff',
        'customLineHoverColor' => '#f0f0ff',

        'customRawFontFamily' => 'Monaco, Courier, Monospace',
        'customRawFontSize' => '12px',
        'customRawLineHeight' => '16px',
        'customRawFontColor' => '#000000',
        'customRawBackgroundColor' => '#000000',

        'wpAutoPFilterPriority' => 'default',
        'enableTranslation' => true,
        'enableTinyMceIntegration' => true,
        'enableFrontendTinyMceIntegration' => false,
        'enableQuicktagBackendIntegration' => false,
        'enableQuicktagFrontendIntegration' => false,
        
        'rawButton' => true,
        'windowButton' => true,
        'infoButton' => true,
        'rawcodeDoubleclick' => false,
        'enableInlineHighlighting' => true,

        'cryptexEnabled' => false,
        'cryptexFallbackEmail' => 'mail@example.tld',

        'extJetpackInfiniteScroll' => false,
        'extJQueryAjax' => false,

        'bbpressShortcode' => false,
        'bbpressMarkdown' => false,

        'dynamicResourceInvocation' => false,
        'gutenbergSupport' => true
    );
    
    public static function getDefaults(){
        $c = self::$_defaultConfig;

        // generate theme customizers config keys
        foreach (ThemeGenerator::getCustomStyleKeys() as $key){
            $c['custom-color-'.$key] = '';
            $c['custom-bgcolor-'.$key] = '';
            $c['custom-fontstyle-'.$key] = '';
            $c['custom-decoration-'.$key] = '';
        }

        // generate webfont config keys
        foreach (GoogleWebfontResources::getMonospaceFonts() as $name => $font){
            $fid = preg_replace('/[^A-Za-z0-9]/', '', $name);
            $c['webfonts'.$fid] = false;
        }

        return $c;
    }

}