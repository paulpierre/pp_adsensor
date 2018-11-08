<?php
require_once 'lib/jtokenizer.php';

if(class_exists('wlJSOLex')) {
    return;
}

/**
 * WiseLoop JavaScript Obfuscator JavaScript Lex class definition<br/>
 *
 * @author WiseLoop
 */
class wlJSOLex extends JLex {

    /**
     * @var array - ECMA and other reserved keywords that should not be scrambled or altered in any way.
     */
    public static $RESERVED = array(
        'abstract', 'alert', 'all', 'anchor', 'anchors', 'arguments', 'area', 'array', 'assign', 'await',
        'boolean', 'blur', 'break', 'button', 'byte',
        'case', 'checkbox', 'class', 'clearinterval', 'cleartimeout', 'clientinformation', 'close', 'closed', 'confirm', 'catch', 'char', 'class', 'const', 'constructor', 'continue', 'console', 'crypto',
        'date', 'debugger', 'decodeuri', 'decodeuricomponent', 'default', 'defaultstatus', 'delete', 'do', 'document', 'double',
        'else', 'element', 'elements', 'embed', 'embeds', 'encodeuri', 'encodeuricomponent', 'enum', 'error', 'eval', 'evalerror', 'escape', 'event', 'export', 'extends',
        'false', 'final', 'finally', 'fileupload', 'float', 'focus', 'for', 'form', 'forms', 'function', 'frame', 'frames', 'framerate',
        'goto',
        'hasownproperty', 'hidden', 'history',
        'if', 'iframe', 'image', 'images', 'infinity', 'innerheight', 'innerwidth', 'implements', 'import', 'in', 'instanceof', 'int', 'interface', 'isfinite', 'isnan', 'isprototypeof',
        'layer', 'layers', 'link', 'let', 'length', 'location', 'long',
        'math', 'mimetypes', 'module',
        'nan', 'name', 'navigate', 'navigator', 'native', 'new', 'null', 'number',
        'onblur', 'onclick', 'onerror', 'onfocus', 'onkeydown', 'onkeypress', 'onkeyup', 'onmouseover', 'onload', 'onmouseup', 'onmousedown', 'onsubmit',
        'object', 'offscreenbuffering', 'open', 'opener', 'option', 'outerheight', 'outerwidth',
        'package', 'packages', 'pagexoffset', 'pageyoffset', 'parent', 'parsefloat', 'parseint', 'password', 'pkcs11', 'plugin', 'private', 'prompt', 'propertyisenum', 'protected', 'prototype', 'public',
        'radio', 'reset', 'regexp', 'rangeerror', 'referenceerror', 'return',
        'screen', 'screenx', 'screeny', 'scroll', 'secure', 'select', 'self', 'setinterval', 'settimeout', 'short', 'static', 'status', 'string', 'submit', 'super', 'switch', 'synchronized', 'syntaxerror',
        'taint', 'text', 'textarea', 'this', 'throw', 'throws', 'top', 'tostring', 'transient', 'true', 'try', 'typeof', 'typeerror',
        'undefined', 'unescape', 'untaint', 'urierror',
        'valueof', 'var', 'void', 'volatile',
        'window', 'while', 'with',
        'yield',
        'jquery', 'angular',
        '_'
    );


    /**
     * Returns JavaScript literals such as punctuation marks and operators
     * @return array
     */
    public function getLiterals() {
        return $this->literals;
    }
}