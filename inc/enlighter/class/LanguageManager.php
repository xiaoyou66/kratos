<?php
/**
    Manages the Available Languages
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

class LanguageManager{

    // list of build-in languages
    // Format: Description => Name
    private static $_languages = array(
        'Generic Highlighting' => 'generic',
        'CSS (Cascading Style Sheets)' => 'css',
        'HTML (Hypertext Markup Language)' => 'html',
        'Java' => 'java',
        'Javascript' => 'js',
        'JSON' => 'json',
        'Markdown' => 'md',
        'PHP' => 'php',
        'Python' => 'python',
        'Ruby' => 'ruby',
        'Batch MS-DOS' => 'msdos',
        'Shell Script' => 'shell',
        'SQL' => 'sql',
        'XML' => 'xml',
        'C' => 'c',
        'C++' => 'cpp',
        'C#' => 'csharp',
        'RUST' => 'rust',
        'LUA' => 'lua',
        'Matlab' => 'matlab',
        'NSIS' => 'nsis',
        'Diff' => 'diff',
        'VHDL' => 'vhdl',
        'Avr Assembly' => 'avrasm',
        'Generic Assembly' => 'asm',
        'Kotlin' => 'kotlin',
        'Squirrel' => 'squirrel',
        'Ini/Conf Syntax' => 'ini',
        'RAW Code' => 'raw',
        'No Highlighting' => 'no-highlight'
    );

    // fetch the language list
    public static function getLanguages(){
        return apply_filters('enlighter_languages', self::$_languages);
    }
}