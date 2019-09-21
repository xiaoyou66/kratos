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

class ContentProcessor{
    
    // stores the plugin config
    private $_config;

    // GFM Filter instance
    private $_gfmFilter;

    // short code filter instance
    private $_shortcodeFilter;

    // compatibility mode filter
    private $_compatFilter;

    // flag to indicate if shortcodes have been applied
    public $_hasContent = false;

    public function __construct($settingsUtil, $languageShortcodes){
        // store local plugin config
        $this->_config = $settingsUtil->getOptions();

        // setup filters
        $this->_gfmFilter = new GfmFilter($settingsUtil);
        $this->_shortcodeFilter = new ShortcodeFilter($settingsUtil, $languageShortcodes);
        $this->_compatFilter = new CompatibilityModeFilter($settingsUtil);

        // array of sections which will be filtered
        $shortcodeSections = array();
        $gfmSections = array();
        $compatSections = array();

        // ------------------------------------
        // ---------- SHORTCODE ---------------

        // use modern shortcode handler ?
        if ($this->_config['shortcodeMode'] == 'modern'){
            // setup sections to filter based on plugin configuration
            if ($this->_config['shortcodeFilterContent']){
                $shortcodeSections[] = 'the_content';
            }
            if ($this->_config['shortcodeFilterExcerpt']){
                $shortcodeSections[] = 'get_the_excerpt';
            }
            if ($this->_config['shortcodeFilterComments']){
                $shortcodeSections[] = 'get_comment_text';
            }
            if ($this->_config['shortcodeFilterCommentsExcerpt']){
                $shortcodeSections[] = 'get_comment_excerpt';
            }
            if ($this->_config['shortcodeFilterWidgetText']){
                $shortcodeSections[] = 'widget_text';
            }
        }

        // apply filter hook to allow users to modify the list/add additional filters
        $shortcodeSections = array_unique(apply_filters('enlighter_shortcode_filters', $shortcodeSections));

        // register filter targets
        foreach ($shortcodeSections as $section){
            $this->registerShortcodeFilterTarget($section);
        }

        // ------------------------------------
        // ---------- GFM ---------------------

        // use gfm in the default sections ?
        if ($this->_config['gfmFilterContent']){
            $gfmSections[] = 'the_content';
        }
        if ($this->_config['gfmFilterExcerpt']){
            $gfmSections[] = 'get_the_excerpt';
        }
        if ($this->_config['gfmFilterComments']){
            $gfmSections[] = 'get_comment_text';
        }
        if ($this->_config['gfmFilterCommentsExcerpt']){
            $gfmSections[] = 'get_comment_excerpt';
        }
        if ($this->_config['gfmFilterWidgetText']){
            $gfmSections[] = 'widget_text';
        }

        // apply filter hook to allow users to modify the list/add additional filters
        $gfmSections = array_unique(apply_filters('enlighter_gfm_filters', $gfmSections));

        // register filter targets
        foreach ($gfmSections as $section){
            $this->registerGfmFilterTarget($section);
        }

        // ------------------------------------
        // ---------- COMPATIBILITY MODE  -----

        // use gfm in the default sections ?
        if ($this->_config['compatFilterContent']){
            $compatSections[] = 'the_content';
        }
        if ($this->_config['compatFilterExcerpt']){
            $compatSections[] = 'get_the_excerpt';
        }
        if ($this->_config['compatFilterComments']){
            $compatSections[] = 'get_comment_text';
        }
        if ($this->_config['compatFilterCommentsExcerpt']){
            $compatSections[] = 'get_comment_excerpt';
        }
        if ($this->_config['compatFilterWidgetText']){
            $compatSections[] = 'widget_text';
        }

        // apply filter hook to allow users to modify the list/add additional filters
        $compatSections = array_unique(apply_filters('enlighter_compat_filters', $compatSections));

        // register filter targets
        foreach ($compatSections as $section){
            $this->registerCompatibilityFilterTarget($section);
        }

        // ------------------------------------
        // ---------- DRI DETECTOR  -----------

        // dynamics resource incovation active ?
        if ($this->_config['dynamicResourceInvocation']){
            // PHP 5.3 compatibility
            $T = $this;

            // EnlighterJS Code detection
            add_filter('the_content', function($content) use ($T){
                // block overrides caused by multiple calls to the_content filter
                // is the filter called regular to display the content ? 
                if (!$T->_hasContent && in_the_loop() && is_main_query()){
                    // contains enlighterjs codeblocks ?                   
                    $T->_hasContent = (strpos($content, 'EnlighterJSRAW') !== false);
                }

                return $content;
            }, 9999, 1);
        }
    }

    // add content filter (strip + restore) to the given content section
    public function registerShortcodeFilterTarget($name){
        // add content filter to first position - replaces all enlighter shortcodes with placeholders
        add_filter($name, array($this->_shortcodeFilter, 'stripCodeFragments'), 0, 1);

        // add restore filter to the end of filter chain - placeholders are replaced with rendered html
        add_filter($name, array($this->_shortcodeFilter, 'renderFragments'), 9998, 1);
    }

    // add content filter (strip + restore) to the given content section
    public function registerGfmFilterTarget($name){
        // add content filter to first position - replaces all enlighter shortcodes with placeholders
        add_filter($name, array($this->_gfmFilter, 'stripCodeFragments'), 0, 1);

        // add restore filter to the end of filter chain - placeholders are replaced with rendered html
        add_filter($name, array($this->_gfmFilter, 'renderFragments'), 9998, 1);
    }

    // add content filter to the given content section
    public function registerCompatibilityFilterTarget($name){
        // add content filter to first position - replaces all enlighter shortcodes with placeholders
        add_filter($name, array($this->_compatFilter, 'stripCodeFragments'), 0, 1);

        // add restore filter to the end of filter chain - placeholders are replaced with rendered html
        add_filter($name, array($this->_compatFilter, 'renderFragments'), 9998, 1);
    }

    // check if shortcode have been applied
    public function hasContent(){
        return $this->_hasContent;
    }
}