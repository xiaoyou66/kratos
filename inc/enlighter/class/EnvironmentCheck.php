<?php
/**
    Environment Check to ensure plugin compatibility with current WordPress setup
    Version: 1.0
    Author: Andi Dittrich
    Author URI: http://andidittrich.de
    Plugin URI: http://andidittrich.de/go/enlighterjs
    License: MIT X11-License

    Copyright (c) 2013-2016, Andi Dittrich

    Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

    The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/
namespace Enlighter;

class EnvironmentCheck{

    private $_cacheManager;

    public function __construct($cacheManager){
        $this->_cacheManager = $cacheManager;
    }

    // external triggered as admin_notices
    public function throwNotifications(){
        // trigger check
        $results = self::check();

        // show errors
        foreach ($results['errors'] as $err){
            // styling
            echo '<div class="notice notice-error enlighter-notice"><p><strong>Enlighter Plugin Error: </strong>', $err;
            echo ' - <a href="https://github.com/EnlighterJS/Plugin.WordPress/tree/master/docs/PluginNotifications.md" target="_new">', __('view help', 'enlighter'), '</a></p></div>';
        }

        // show warnings
        foreach ($results['warnings'] as $err){
            // styling
            echo '<div class="notice notice-warning enlighter-notice"><p><strong>Enlighter Plugin Warning: </strong>', $err;
            echo ' - <a href="https://github.com/EnlighterJS/Plugin.WordPress/tree/master/docs/PluginNotifications.md" target="_new">', __('view help', 'enlighter'), '</a></p></div>';
        }
    }

    // check for common environment errors
    public function check(){

        // list of errors
        $errors = array();
        $warnings = array();

        // bad xhtml fixing has been removed from WordPress v2, but sometime it is still enabled, only the setting is removed from the settings page !
        // see https://core.trac.wordpress.org/changeset/3223
        if (get_option('use_balanceTags') != 0){
            $warnings[] = __('Option <code>use_balanceTags</code> is enabled - this option is <strong>DEPRECATED</strong>. Might cause a weired behaviour by inserting random closing html tags into your code.', 'enlighter');
        }

        // Smilies shouldn't render within sourcecode
        if (get_option('use_smilies') != 0){
            $warnings[] = __('Option <code>use_smilies</code> is enabled. Legacy smiley sequences like :) are replaced by images which also affects posted sourcecode.', 'enlighter');
        }

        // Crayon Syntax highlighter may take over the Enlighter <pre> elements
        if (is_plugin_active('crayon-syntax-highlighter/crayon_wp.class.php')){
            $errors[] = __('Plugin "Crayon Syntax Highlighter" is enabled - it may take over the Enlighter pre elements - highlighting will not work!', 'enlighter');
        }

        // cache accessible ?
        if (!$this->_cacheManager->isCacheAccessible()){
            $errors[] = __('The cache-directory <code>'. $this->_cacheManager->getCachePath(). '</code> is not writable! Please change the directory permission (chmod <code>0774</code> or <code>0777</code>) to use the ThemeCustomizer (the generated stylesheets are stored there). - <a href="'.admin_url('admin.php?page=Enlighter').'&cache-permission-fix=true">Autoset Permissions</a>');

            // fix successful ?
            if (isset($_GET['cache-permission-fix'])){
                $errors[] = __('Autoset Permissions failed - Please change the directory permission (chmod <code>0644</code> or <code>0777</code>) manually!');
            }
        }

        // plugin path wp-content/plugins/enlighter ?
        if (strpos(__DIR__, 'enlighter'.DIRECTORY_SEPARATOR.'class') === false){
            $errors[] = __('The plugin is located within an invalid path - the <code>enlighter/</code> directory name is <strong>mandatory</strong>', 'enlighter');
        }

        return array(
            'errors' => $errors,
            'warnings' => $warnings
        );
    }
}