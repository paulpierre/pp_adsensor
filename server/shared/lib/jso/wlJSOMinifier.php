<?php
require_once 'wlJSOJsParser.php';

if(class_exists('wlJSOMinifier')) {
    return;
}

/**
 * WiseLoop JavaScript Obfuscator Minifier class definition<br/>
 *
 * @author WiseLoop
 */
class wlJSOMinifier
{
    /**
     * Performs minimization and compressing against a parsed JavaScript source code.<br/>
     * It removes the comments and trims each line of code of whitespaces, tabs, line feeds and carriage returns.
     * @param wlJSOJsParser $wlJsParser a prebuilt JavaScript parser containing the tokenized source code
     * @return string the minimized JavaScript code
     */
    public static function minify($wlJsParser) {
        $wlJsParser->minify();
        return $wlJsParser->render();
    }

    /**
     * Performs minimization and compressing against the given JavaScript source code.<br/>
     * It removes the comments and trims each line of code of whitespaces, tabs, line feeds and carriage returns.
     * @param string $js JavaScript  source code
     * @return string the minimized JavaScript code
     */
    public static function minifyJsCode($js) {
        $wlJsParser = new wlJSOJsParser($js);
        return self::minify($wlJsParser);
    }
}
