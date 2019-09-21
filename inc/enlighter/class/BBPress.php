<?php
/**
	BBPress Shortcode/GFM Plugin
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

class BBPress{

    public static function enableShortcodeFilter(){
        // add filter to hook into the section post-processing
        // user defined filters will have prio 10 by default
        add_filter('enlighter_shortcode_filters', function($sections){
            // add BuddyPress Sections
            $sections[] = 'bbp_get_reply_content';
            $sections[] = 'bbp_get_topic_content';

            return $sections;
        }, 5);
    }

    public static function disableCodeFilter(){
        // disable bbp_trick filters to preserve backticks permanently (content within the database is changed!)
        /*
        remove_filter('bbp_new_reply_pre_content', 'bbp_code_trick', 20);
        remove_filter('bbp_new_topic_pre_content', 'bbp_code_trick', 20);
        remove_filter('bbp_edit_reply_pre_content', 'bbp_code_trick', 20);
        remove_filter('bbp_edit_topic_pre_content', 'bbp_code_trick', 20);
        remove_filter('bbp_get_form_reply_content', 'bbp_code_trick_reverse');
        remove_filter('bbp_get_form_reply_content', 'bbp_code_trick_reverse');
        */

        // revert the code filter changes temporary - allows the use of triple backticks
        add_filter('bbp_get_reply_content', 'bbp_code_trick_reverse', 0);
        add_filter('bbp_get_topic_content', 'bbp_code_trick_reverse', 0);
    }

    public static function enableMarkdownFilter(){
        // add filter to hook into the section post-processing
        // user defined filters will have prio 10 by default
        add_filter('enlighter_gfm_filters', function($sections){
            // add BuddyPress Sections
            $sections[] = 'bbp_get_reply_content';
            $sections[] = 'bbp_get_topic_content';

            return $sections;
        }, 5);
    }
}