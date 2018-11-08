<?php

if(class_exists('wlJSOConfig')) {
    return;
}

/**
 * WiseLoop JavaScript Obfuscator Configuration class definition<br/>
 *
 * @author WiseLoop
 */
class wlJSOConfig {

    /**
     * @var bool - if the obfuscator will perform HTTP request checking and generate bogus JavaScript code if direct scrapping attempts are detected.<br/>
     * (recommended value: TRUE)
     * @see wlJSODecoyer
     */
    public $DO_DECOY = true;

    /**
     * @var bool - if the obfuscator will perform code minification.<br/>
     * (recommended value: TRUE)
     * @see wlJSOMinifier
     */
    public $DO_MINIFY = true;

    /**
     * @var bool - if the obfuscator will lock the JavaScript source code to current domain only.<br/>
     * (recommended value: TRUE)
     * @see wlJSODomainLocker
     */
    public $DO_LOCK_DOMAIN = true;

    /**
     * @var bool - if the obfuscator will obfuscate the declared variable names and functions inside the JavaScript source code.<br/>
     * (recommended value: TRUE)
     * @see wlJSOScrambler
     */
    public $DO_SCRAMBLE_VARS = true;

    /**
     * @var int - specifies how hard the obfuscator will encrypt the JavaScript source code before delivery.<br/>
     * Zero means that no encryption will be performed.
     * @note
     * - Encryption enlarges payload sizes. The higher encryption level, the higher protection is achieved and the larger processed obfuscated code will result.
     * - The browser needs valid JavaScript code to run, and the encrypted code is a valid JavaScript also.
     * This is the reason that the encryption is made using a public key and a JavaScript boot loader function in order the be able to self-decrypt when the browser runs the encrypted code.
     * There is no other way to make the encryption safer.
     * If the browser manages to decrypt the encrypted code, also an ambitious thief can try this by using its own intelligence or some specialized tools.<br/>
     * In conclusion, the encryption feature does not ensure bulletproof protection due to the public nature of JavaScript code.<br/>
     * Keep in mind that all the world's obfuscation techniques are meant to discourage the code thief and cannot guarantee a full bulletproof protection
     * against theft due to the public and open architecture of JavaScript and web browser combination.<br/>
     * (recommended value: 1)
     * @see wlJSOEncryptor
     */
    public $ENCRYPTION_LEVEL = 1;

    /**
     * @var bool - specifies if the explaining alert messages will be shown when the script expires or it runs on another internet domain and the lock domain setting is on.<br/>
     * Set this to FALSE so that the attacker will not know what's happening.<br/>
     * (recommended value: FALSE)
     * @see $MSG_LOCK_DOMAIN, $MSG_EXPIRED
     */
    public $SHOW_JS_LOCK_ALERTS = false;

    /**
     * @var string - the alert message template when the script is copied on another internet domain and the lock domain setting is on.<br/>
     * {JS} and {DOMAIN} will be replaced with their corresponding real values: the JavaScript filename and the valid internet domain.
     * @see $SHOW_JS_LOCK_ALERTS
     */
    public $MSG_LOCK_DOMAIN = '"{JS}" works only on "{DOMAIN}".';


    /**
     * @var string - the expiration date in yyyy-mm-dd format<br/>
     * If no expiration date is desired to be set, then set it to <b>null</b>.
     * @see $MSG_EXPIRED, wlJSOExpirator
     */
    public $EXPIRATION_DATE = null;

    /**
     * @var string - the alert message template when the expire.<br/>
     * {JS} and {DATE} will be replaced with their corresponding real values: the JavaScript filename and the expiration date.
     * @see $SHOW_JS_LOCK_ALERTS, $EXPIRATION_DATE, wlJSOExpirator
     */
    public $MSG_EXPIRED = '"{JS}" has expired on "{DATE}".';

    /**
     * @var int - enable cache to speed up the delivery. Acceptable values:<br/>
     * - 0 - (not recommended) no cache: full processing is done on each request;<br/>
     * This can be painfully slow on large JavaScript files and/or slow machines.
     * - 1 - (recommended) the following processing results will be cached: domain locking, minifying, variable scrambling.<br/>
     * This is the most common value: because the encryption is not cached, the obfuscation will benefit of all the features including the dynamic bytecode encryption.<br/>
     * Please pay attention to large JavaScript files and/or slow machines: the encryption process can be quite slow on these ones.<br/>
     * If the resulting speed is unsatisfactory, you may need to disable the dynamic bytecode encryption by setting the CACHE_LEVEL to value 2.
     * - 2 - (recommended) the full processing result will be cached: domain locking, minifying, variable scrambling, encryption.<br/>
     * Because the encryption result is also cached, this will disable the dynamic feature of encryption.<br/>
     * This is the recommended value for large JavaScript files and/or slow machines.<br/>
     * (recommended values: 1 or 2)
     * @see wlJSOCache
     */
    public $CACHE_LEVEL = 2;

    /**
     * @var bool - if set to true, the returned obfuscated JavaScript code will begin with a comment containing the WiseLoop's signature.<br/>
     * (recommended value: FALSE)
     */
    public $SHOW_WISELOOP_SIGNATURE = false;
}
