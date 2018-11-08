<?php

if(class_exists('wlJSOExpirator')) {
    return;
}

/**
 * WiseLoop JavaScript Obfuscator Expirator class definition<br/>
 *
 * @author WiseLoop
 */
class wlJSOExpirator
{
    /**
     * Sets an expiration date for the given JavaScript source code.<br/>
     * When the expiration date is reached, the script will stop working.
     * @param string $js the input JavaScript source code
     * @param string $expirationTime the expiration date in format yyyy-mm-dd
     * @param string $expirationMessage expiration message that will be alerted when the script reaches the expiration date (if empty or null, no alert will be shown)
     * @return string the locked JavaScript code
     */
    public static function setExpirationDate($js, $expirationTime, $expirationMessage = null) {
        $jsRes = @file_get_contents(__DIR__ . '/template/js-setexpiration.jst');
        if(!$jsRes) {
            return $js;
        }
        $jsRes = str_replace(array("\r","\n"), ' ', $jsRes);
        if(isset($expirationTime)) {
            $expirationUtc = wlJSOUtils::dateToUTime($expirationTime);
            $jsRes = str_replace(
                array('{TIME}', '{MESSAGE}'),
                array($expirationUtc, $expirationMessage),
                $jsRes);
        }else {
            return $js;
        }
        return $jsRes . "\r\n" . $js;
    }
}
