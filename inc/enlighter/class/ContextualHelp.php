<?php
/**
     Contextual Help Screen
     Version: 1.0
     Author: Andi Dittrich
     Author URI: http://andidittrich.de
     Plugin URI: http://andidittrich.de/go/cryptex
     License: MIT X11-License
    
     Copyright (c) 2014, Andi Dittrich
    
     Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
    
     The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
    
     THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/
namespace Enlighter;

class ContextualHelp{
    
    public function __construct($settingsUtil){
    }

    /**
     * Setup Help Screen
     */
    public function contextualHelp(){
        // load screen
        $screen = get_current_screen();

        $screen->add_help_tab(array(
            'id' => 'enlighter_ch_tutorials',
            'title'    => __('Tutorials'),
            'callback' => array($this, 'tutorials')
        ));

        $screen->add_help_tab(array(
            'id' => 'enlighter_ch_usage',
            'title'    => __('General Usage'),
            'callback' => array($this, 'generalUsage')
        ));
        $screen->add_help_tab(array(
            'id' => 'enlighter_ch_markdown',
            'title'    => __('Markdown'),
            'callback' => array($this, 'markdown')
        ));
    
        // shortcode help
        $screen->add_help_tab(array(
                'id' => 'enlighter_ch_shortcode',
                'title'    => __('Shortcodes'),
                'callback' => array($this, 'shortcode')
        ));
        $screen->add_help_tab(array(
                'id' => 'enlighter_ch_shortcodeoptions',
                'title'    => __('Shortcode-Options'),
                'callback' => array($this, 'shortcodeoptions')
        ));
        $screen->add_help_tab(array(
                'id' => 'enlighter_ch_shortcodegeneric',
                'title'    => __('Generic-Shortcode'),
                'callback' => array($this, 'shortcodegeneric')
        ));
        $screen->add_help_tab(array(
                'id' => 'enlighter_ch_codegroups',
                'title'    => __('Codegroups'),
                'callback' => array($this, 'codegroups')
        ));
        $screen->add_help_tab(array(
                'id' => 'enlighter_ch_externalthemes',
                'title'    => __('External Themes'),
                'callback' => array($this, 'externalthemes')
        ));
        
        
        // sidebar
        $screen->set_help_sidebar(file_get_contents(ENLIGHTER_PLUGIN_PATH.'/views/help/'.'sidebar.en_EN.html'));
    }
    
    public function shortcode(){
        include(ENLIGHTER_PLUGIN_PATH.'/views/help/'.'shortcodes.en_EN.phtml');
    }
    
    public function shortcodeoptions(){
        include(ENLIGHTER_PLUGIN_PATH.'/views/help/'.'shortcode-options.en_EN.phtml');
    }
    
    public function codegroups(){
        include(ENLIGHTER_PLUGIN_PATH.'/views/help/'.'codegroups.en_EN.phtml');
    }
    
    public function shortcodegeneric(){
        include(ENLIGHTER_PLUGIN_PATH.'/views/help/'.'shortcode-generic.en_EN.phtml');
    }
    
    public function externalthemes(){
        include(ENLIGHTER_PLUGIN_PATH.'/views/help/'.'externalthemes.en_EN.phtml');
    }

    public function generalUsage(){
        include(ENLIGHTER_PLUGIN_PATH.'/views/help/'.'usage.en_EN.phtml');
    }

    public function markdown(){
        include(ENLIGHTER_PLUGIN_PATH.'/views/help/'.'markdown.en_EN.phtml');
    }
    public function tutorials(){
        include(ENLIGHTER_PLUGIN_PATH.'/views/help/'.'tutorials.en_EN.phtml');
    }
}