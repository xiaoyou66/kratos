<?php
/**
    Admin Settings Page Utility Class
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

class SettingsUtil{
    
    // local config storage
    private $_config = array();
    
    // stores options prefix
    private $_optionsPrefix;
    
    // initialize global plugin config
    public function __construct($prefix, $defaultConfig=array()){
        // store settings prefix
        $this->_optionsPrefix = $prefix;
    
        // load plugin config
        foreach ($defaultConfig as $key=>$value){
            // get option by key
            $this->_config[$key] = get_option($this->_optionsPrefix.$key, $value);
        }
    }
    
    // register settings
    public function registerSettings(){
        // register settings
        foreach ($this->_config as $key=>$value){
            register_setting($this->_optionsPrefix.'settings-group', $this->_optionsPrefix.$key);
        }
    }
    
    // update option
    public function setOption($key, $value){
        update_option($this->_optionsPrefix.$key, $value);
        $this->_config[$key] = $value;
    }

    // update options
    public function setOptions($values){
        foreach ($values as $key => $value){
            update_option($this->_optionsPrefix.$key, $value);
        }
    }
    
    // fetch option by key
    public function getOption($key){
        return $this->_config[$key];
    }
    
    // fetch all plugin options as array
    public function getOptions(){
        return $this->_config;
    }
    
    /**
     * Generates a checkbox based on the settings-name
     * @param unknown_type $title
     * @param unknown_type $optionName
     */
    public function displayCheckbox($title, $optionName, $description=''){
        ?>
    <!-- SETTING [<?php echo $optionName ?>] -->
    <div class="EnlighterSetting">    
        <div class="EnlighterSettingTitle"><?php echo esc_html($title); ?></div>
        <div class="EnlighterSettingItem">
            <?php
        $checked = '';    
        if ($this->_config[$optionName]){ 
            $checked = ' checked="checked" '; 
        }
        echo '<input '.$checked.' name="'.$this->_optionsPrefix.$optionName.'" type="checkbox" value="1" title="', esc_attr($description),'" />';
    ?>
        </div>
        <div class="EnlighterSettingClear"></div>
    </div>
            <?php 
        }
        
        /**
         * Generates a selectform  based on settings-name
         * @param String $title
         * @param String $optionName
         * @param Array $values
         */
        public function displaySelect($title, $optionName, $values){
            ?>
    <!-- SETTING [<?php echo $optionName ?>] -->            
    <div class="EnlighterSetting">    
        <div class="EnlighterSettingTitle"><?php echo esc_html($title); ?></div>
        <div class="EnlighterSettingItem">
            <select name="<?php echo $this->_optionsPrefix.$optionName ?>" id="<?php echo $this->_optionsPrefix.$optionName ?>">
            <?php
            
            foreach ($values as $key=>$value){
                $selected = ($this->_config[$optionName] == $value) ? 'selected="selected"' : '';
                echo '<option value="'.$value.'" '.$selected.'>'. esc_html($key).'</option>';
            }
            ?> 
            </select>       
        </div>
        <div class="EnlighterSettingClear"></div>
    </div>
            <?php
        }
        
        /**
         * Generates a input-form
         * @param String $title
         * @param String $optionName
         * @param String $label
         */
        public function displayInput($title, $optionName, $label, $cssClass=''){
        ?>    
    <div class="EnlighterSetting">
        <div class="EnlighterSettingTitle"><?php echo esc_html($title); ?></div>
        <div class="EnlighterSettingItem">
            <input id="<?php echo $this->_optionsPrefix.$optionName; ?>" name="<?php echo $this->_optionsPrefix.$optionName;?>" type="text" value="<?php echo esc_attr($this->_config[$optionName]); ?>" class="text <?php echo $cssClass; ?>" />
            <label for="<?php echo $this->_optionsPrefix.$optionName; ?>"><?php echo esc_html($label); ?></label>
           </div>
           <div class="EnlighterSettingClear"></div>
    </div>
          <?php
        }
}
