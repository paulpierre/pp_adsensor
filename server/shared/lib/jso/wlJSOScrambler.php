<?php
require_once 'wlJSOJsParser.php';

if(class_exists('wlJSOScrambler')) {
    return;
}

/**
 * WiseLoop JavaScript Obfuscator Scrambler class definition<br/>
 *
 * @author WiseLoop
 */
class wlJSOScrambler
{
    /**
     * Performs names obfuscation against the given JavaScript source code.<br/>
     * It will replace every declared variables names with self generated ones consisting only of this chars: 'I', 'l', '1'.<br/>
     * In this way even if the code gets deobfuscated, it will be very hard to understand, follow or modify.
     * @param wlJSOJsParser $wlJsParser a prebuilt JavaScript parser containing the tokenized source code
     * @return string the JavaScript code with var names obfuscated
     */
    public static function scramble($wlJsParser) {
        $vars = $wlJsParser->getVars();

        $varNewNames = array();
        $k = 0;
        foreach($vars as $var) {
            $varNewNames[$var] = self::generateName($k++);
        }
        $wlJsParser->renameIdentifiers($varNewNames);
        return $wlJsParser->render();
    }

    private static function generateName($k) {
        return 'l' . str_replace(array('0','2'), array('l','I'), base_convert($k, 10, 3));
    }
}
