<?php
require_once 'wlJSOProcessor.php';

if(class_exists('wlJSO')) {
    return;
}
/**
 * WiseLoop JavaScript Obfuscator class definition<br/>
 * 
 * @author WiseLoop
 */
class wlJSO {

    /**
     * Performs obfuscation against JavaScript code.
     * @param string $js the original JavaScript code, or URL path to a JavaScript file
     * @param bool $doMinify specifies if the obfuscator will perform code minimization
     * @param bool $doScrambleVars specifies if the obfuscator will obfuscate the declared variable names inside the JavaScript source code
     * @param bool $doLockDomain specifies if the obfuscator will lock the JavaScript source code to current domain only
     * @param int $encryptionLevel how hard the obfuscator will encrypt the JavaScript source code before delivery; zero means that no encryption will be made
     * @param string $expirationDate the script expiration date in yyyy-mm-dd format
     * @param bool $showLockAlerts specifies if the explaining alert messages will be shown when the script expires or it runs on another internet domain and the lock domain setting is on
     * @return string the obfuscated JavaScript code
     */
    public static function obfuscate($js, $doMinify = true, $doScrambleVars = true, $doLockDomain = false, $encryptionLevel = 1, $expirationDate = null, $showLockAlerts = false) {
        $config = new wlJSOConfig();
        $config->DO_MINIFY = $doMinify;
        $config->DO_SCRAMBLE_VARS = $doScrambleVars;
        $config->DO_LOCK_DOMAIN = $doLockDomain;
        $config->ENCRYPTION_LEVEL = $encryptionLevel;
        $config->EXPIRATION_DATE = $expirationDate;
        $config->SHOW_JS_LOCK_ALERTS = $showLockAlerts;
        $jso = new wlJSOProcessor();
        $jso->init($js, $config);
        return $jso->get();
    }

    /**
     * Performs obfuscation against a JavaScript code using a preset configuration like minify, decent, default, hard, paranoid, or any other preset created by user.
     * @param string $js the original JavaScript code, or URL path to a JavaScript file
     * @param string $presetName the configuration preset filename located under the /config directory (without .php extension)
     * @return string the obfuscated JavaScript code
     */
    public static function obfuscateByPreset($js, $presetName) {
        $config = null;
        if($presetName) {
            $config = wlJSOUtils::loadPhpConfig(__DIR__ . '/../config/' . $presetName . '.php');
        }
        if(!$config) {
            $config = wlJSOUtils::loadPhpConfig(__DIR__ . '/../config/default.php');
        }
        if(!$config) {
            $config = new wlJSOConfig();
        }
        $jso = new wlJSOProcessor();
        $jso->init($js, $config);
        return $jso->get();
    }
}
