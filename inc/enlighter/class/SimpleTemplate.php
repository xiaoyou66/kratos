<?php
/**
    Dynamic CSS Generator
    Version: 1.2
    Author: Andi Dittrich
    Author URI: http://andidittrich.de
    Plugin URI: http://andidittrich.de/go/enlighterjs
    License: MIT X11-License
    
    Copyright (c) 2010-2014, Andi Dittrich

    Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
    
    The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
    
    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/
namespace Enlighter;

class SimpleTemplate{
    // list of assigned vars
    private $_cssVars;

    // raw css template
    private $_template;
    
    public function __construct($filename){
        // initialize var list
        $this->_cssVars = array();    
        
        // read template
        $this->_template = file_get_contents($filename);
    }
    
    // assign key/value pair
    public function assign($key, $value){
        $this->_cssVars['$('.$key.')'] = $value;
    }

    // return tpl
    public function render(){
        // replace key/value pairs
        $tplData = str_replace(array_keys($this->_cssVars), array_values($this->_cssVars), $this->_template);
        
        // filter non assigned template vars
        $tplData = preg_replace('/\$\([A-z_-]\)/i', '', $tplData);
        
        return $tplData;
    }
}