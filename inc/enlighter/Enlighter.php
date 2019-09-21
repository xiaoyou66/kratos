<?php
/**
    Plugin Name: Enlighter - Customizable Syntax Highlighter
    Plugin URI: https://enlighterjs.org
    Domain Path: /lang
    Text Domain: enlighter
    Description: All-in-one Syntax Highlighting solution. Full Gutenberg and Classic Editor integration. Graphical theme customizer. Based on EnlighterJS.
    Version: 3.10.0
    Author: Andi Dittrich
    Author URI: https://andidittrich.de
    License: MIT X11-License
    
    Copyright (c) 2013-2019, Andi Dittrich

    Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
    
    The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
    
    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

/*
*    BOOTSTRAP FILE
*/

define('ENLIGHTER_INIT', true);
define('ENLIGHTER_VERSION', '3.10.0');
define('ENLIGHTER_PLUGIN_PATH',  dirname(__FILE__));
define('ENLIGHTER_PLUGIN_URL',  get_bloginfo('template_directory')."/inc/enlighter/");

// PHP Version Error Notice
function Enlighter_PhpEnvironmentError(){
    // error message
    $message = '<strong>Enlighter Plugin Error:</strong> Your PHP Version <strong style="color: #cc0a00">('. phpversion() .')</strong> is outdated! <strong>PHP 5.3 or greater</strong> is required to run this plugin!';

    // styling
    echo '<div class="notice notice-error is-dismissible"><p>', $message, '</p></div>';
}

// check php version
if (version_compare(phpversion(), '5.3', '>=')){
    // load classes
    require_once(ENLIGHTER_PLUGIN_PATH.'/class/Enlighter.php');
    require_once(ENLIGHTER_PLUGIN_PATH.'/class/HtmlUtil.php');
    require_once(ENLIGHTER_PLUGIN_PATH.'/class/PluginConfig.php');
    require_once(ENLIGHTER_PLUGIN_PATH.'/class/SettingsUtil.php');
    require_once(ENLIGHTER_PLUGIN_PATH.'/class/InputFilter.php');
    require_once(ENLIGHTER_PLUGIN_PATH.'/class/LegacyShortcodeHandler.php');
    require_once(ENLIGHTER_PLUGIN_PATH.'/class/ContentProcessor.php');
    require_once(ENLIGHTER_PLUGIN_PATH.'/class/ShortcodeFilter.php');
    require_once(ENLIGHTER_PLUGIN_PATH.'/class/CompatibilityModeFilter.php');
    require_once(ENLIGHTER_PLUGIN_PATH.'/class/GfmFilter.php');
    require_once(ENLIGHTER_PLUGIN_PATH.'/class/ResourceLoader.php');
    require_once(ENLIGHTER_PLUGIN_PATH.'/class/ResourceManager.php');
    require_once(ENLIGHTER_PLUGIN_PATH.'/class/SimpleTemplate.php');
    require_once(ENLIGHTER_PLUGIN_PATH.'/class/CacheManager.php');
    require_once(ENLIGHTER_PLUGIN_PATH.'/class/LanguageManager.php');
    require_once(ENLIGHTER_PLUGIN_PATH.'/class/ThemeGenerator.php');
    require_once(ENLIGHTER_PLUGIN_PATH.'/class/ThemeManager.php');
    require_once(ENLIGHTER_PLUGIN_PATH.'/class/TinyMCE.php');
    require_once(ENLIGHTER_PLUGIN_PATH.'/class/ContextualHelp.php');
    require_once(ENLIGHTER_PLUGIN_PATH.'/class/ConfigGenerator.php');
    require_once(ENLIGHTER_PLUGIN_PATH.'/class/GoogleWebfontResources.php');
    require_once(ENLIGHTER_PLUGIN_PATH.'/class/BBPress.php');
    require_once(ENLIGHTER_PLUGIN_PATH.'/class/EnvironmentCheck.php');
    
    // enlighter startup - NEVER CALL IT OUTSIDE THIS FILE !!
    Enlighter::run(__FILE__);
}else{
    // add admin message handler
    add_action('admin_notices', 'Enlighter_PhpEnvironmentError');
    add_action('network_admin_notices', 'Enlighter_PhpEnvironmentError');
}

