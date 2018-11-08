<?php

if(class_exists('wlJSODecoyer')) {
    return;
}

/**
 * WiseLoop JavaScript Obfuscator Decoyer class definition<br/>
 *
 * @author WiseLoop
 */
class wlJSODecoyer
{
    /**
     * Generates bogus-decoy JavaScript source code.<br/>
     * This is used when protecting the resulted obfuscated JavaScript code files against direct scrapping.<br/>
     * If direct access attempts to the obfuscated JavaScript code are detected, this bogus-decoy source code will be served so that the possible thief will work in vain if he will try to deobfuscate the final result.
     * @param string $js the real original JavaScript source code
     * @return string the decoy JavaScript source code
     */
    public static function decoy($js) {
        $decoy = 'var trap = "Protected";' . "\r\n";
        $decoy .= 'var trap = "by";' . "\r\n";
        $decoy .= 'var trap = "WiseLoop";' . "\r\n";
        $decoy .= 'var trap = "PHP";' . "\r\n";
        $decoy .= 'var trap = "JavaScript";' . "\r\n";
        $decoy .= 'var trap = "Obfuscator";' . "\r\n";
        $decoy .= 'var trap = "http://www.wiseloop.com";' . "\r\n";
        $decoy = str_repeat($decoy, ceil(strlen($js) / strlen($decoy)));
        return $decoy;
    }


    /**
     * Detects HTTP direct scrapping request on the given JavaScript file.<br/>
     * @return bool if HTTP request is valid (not direct scrap request)
     * @see decoy()
     */
    public static function httpCheck() {
        return isset($_SERVER['HTTP_REFERER']);
    }
}
