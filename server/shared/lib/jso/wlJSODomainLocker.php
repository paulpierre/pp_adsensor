<?php

if(class_exists('wlJSODomainLocker')) {
    return;
}

/**
 * WiseLoop JavaScript Obfuscator Web Domain Locker class definition<br/>
 *
 * @author WiseLoop
 */
class wlJSODomainLocker
{
    /**
     * Performs the internet domain lock-up on the given JavaScript source code.<br/>
     * This will protect the resulted obfuscated JavaScript code files against copying to another web domain.<br/>
     * If the obfuscated resulted code is copied to another internet domain, the code will not work.
     * @param string $js the input JavaScript source code
     * @param string $lockMessage expiration message that will be alerted when the script reaches the expiration date (if empty or null, no alert will be shown)
     * @return string the locked JavaScript code
     */
    public static function domainLock($js, $lockMessage = null) {
        $jsRes = @file_get_contents(__DIR__ . '/template/js-lockdomain.jst');
        if(!$jsRes) {
            return $js;
        }
        $jsRes = str_replace(array("\r","\n"), ' ', $jsRes);
        if(isset($_SERVER['SERVER_NAME'])) {
            $jsRes = str_replace(
                array('{DOMAIN}', '{MESSAGE}'),
                array($_SERVER['SERVER_NAME'], $lockMessage),
                $jsRes);
        }else {
            return $js;
        }
        return $jsRes . "\r\n" . $js;
    }
}
