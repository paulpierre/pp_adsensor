<?php

/**
 * WiseLoop JavaScript Obfuscator Live File Processor class definition<br/>
 * The JavaScript Obfuscator Runner launches the obfuscation engine against a JavaScript file.<br/>
 * The JavaScript file can be specified using an absolute URL path, or it can reside inside a repository entry.
 * If it resides in a repository entry, the repository name and the filename only must be specified.<br/>
 * The obfuscation engine can be initialized with the arguments passed by $_GET query string or $_POST server variables.<br/>
 * The following GET or POST parameters are expected:
 * - <strong>js</strong>: the actual JavaScript code, or an URL path to a JavaScript file, or a JavaScript filename from the default repository;
 * - <strong>rjs</strong>: specifies the repository name from where the source code will be loaded and the Javascript filename to be processed in the form: <b>?rjs=my-repository/source.js</b><br/>
 * The repository file must be located under <b>/repository</b> directory like /repository/my-repository.php; the .php extension must be skipped
 * - <strong>cfg</strong> (optional): specifies the config (preset) file holding the obfuscation option;<br/>
 * The config file must be located under <b>/config</b> directory like this: /config/minify.php; the .php extension must be skipped
 * - <strong>doDecoy</strong> (optional): specifies if the JavaScript obfuscator should perform an HTTP request check in order to protect the JavaScript source code against direct scrapping by generating a bogus-decoy code on illegal direct-scrapping requests;<br/>
 * This option will override the corresponding option from the given (if it is given) config file via <b>cfg</b> parameter
 * - <strong>doMinify</strong> (optional): specifies if the JavaScript obufscator should perform code minimization;
 * This option will override the corresponding option from the given (if it is given) config file via <b>cfg</b> parameter
 * - <strong>doLockDomain</strong> (optional): specifies if the JavaScript obfuscator should perform domain locking, meaning that the obfuscated javascript code will not work on other internet domains;<br/>
 * This option will override the corresponding option from the given (if it is given) config file via <b>cfg</b> parameter
 * - <strong>doScrambleVars</strong> (optional): specifies if the JavaScript obfuscator should perform names replacement and obfuscation, meaning that the names of variables will be replaced with self generated ones;<br/>
 * This option will override the corresponding option from the given (if it is given) config file via <b>cfg</b> parameter
 * - <strong>encryptionLevel</strong> (optional): specifies how hard the obfuscator will encrypt the JavaScript source code before delivery;<br/>
 * This option will override the corresponding option from the given (if it is given) config file via <b>cfg</b> parameter
 * - <strong>expirationDate</strong> (optional): specifies an expiration date in yyyy-mm-dd format for the obfuscated JavaScript code; if this date is reached, the script will stop working;<br/>
 * This option will override the corresponding option from the given (if it is given) config file via <b>cfg</b> parameter
 * - <strong>showLockAlerts</strong> (optional): specifies if the explaining alert messages will be shown when the script expires or it runs on another internet domain and the lock domain setting is on;<br/>
 * This option will override the corresponding option from the given (if it is given) config file via <b>cfg</b> parameter
 *
 * For inline processing, if using JavaScript file repository (recommended), the repository name and the source file should be specified by <b>repjs</b> query variable:
 * @code
 * jso.php?rjs=my-repository/source.js
 * @endcode
 *
 * The following will obfuscate and merge all the JavaScript files found in the given repository:
 * @code
 * jso.php?rjs=my-repository
 * @endcode
 *
 * For inline processing, if not using JavaScript file repository (not recommended), the source JavaScript URL path should be specified by <b>js</b> query variable:
 * @code
 * jso.php?js=url-path-to-source.js
 * @endcode
 *
 * If everything goes ok, the obfuscated JavaScript code will be delivered to the requester.
 *
 * @see wlJSOProcessor, wlJSOConfig
 * @author WiseLoop
 * @note Using repository entries protects your JavaScript files from direct access by hiding their real paths, and so, the internet users will have access only to the obfuscated JavaScript files only.<br/>
 * Check the documentation further more to find out how to setup your JavaScript files repository.
 *
 * @author WiseLoop
 */
class wlJSORunner {

    /**
     * Constructor.<br/>
     * Initializes an obfuscator processor with the arguments passed by $_GET query string or $_POST server variables and runs it.<br/>
     */
    public function __construct()  {
        require_once 'wlJSOProcessor.php';

        $js = wlJSOUtils::getArrayValue($_GET, 'js', wlJSOUtils::getArrayValue($_POST, 'js'));
        $rjs = wlJSOUtils::getArrayValue($_GET, 'rjs', wlJSOUtils::getArrayValue($_POST, 'rjs'));

        $rep = null;
        if($rjs) {
            $params = wlJSOUtils::completeArray(explode('/', $rjs, 2), 2);
            list($rep, $js) = $params;
        }

        $cfg = wlJSOUtils::getArrayValue($_GET, 'cfg', wlJSOUtils::getArrayValue($_POST, 'cfg'));
        $expirationDate = wlJSOUtils::getArrayValue($_GET, 'expirationDate', wlJSOUtils::getArrayValue($_POST, 'expirationDate'));
        $doDecoy = wlJSOUtils::getArrayValue($_GET, 'doDecoy', wlJSOUtils::getArrayValue($_POST, 'doDecoy'));
        $doMinify = wlJSOUtils::getArrayValue($_GET, 'doMinify', wlJSOUtils::getArrayValue($_POST, 'doMinify'));
        $doLockDomain = wlJSOUtils::getArrayValue($_GET, 'doLockDomain', wlJSOUtils::getArrayValue($_POST, 'doLockDomain'));
        $doScrambleVars = wlJSOUtils::getArrayValue($_GET, 'doScrambleVars', wlJSOUtils::getArrayValue($_POST, 'doScrambleVars'));
        $encryptionLevel = wlJSOUtils::getArrayValue($_GET, 'encryptionLevel', wlJSOUtils::getArrayValue($_POST, 'encryptionLevel'));
        $showLockAlerts = wlJSOUtils::getArrayValue($_GET, 'showLockAlerts', wlJSOUtils::getArrayValue($_POST, 'showLockAlerts'));

        $config = null;
        if($cfg) {
            $config = wlJSOUtils::loadPhpConfig('../config/' . $cfg . '.php');
        }
        if(!$config) {
            $config = wlJSOUtils::loadPhpConfig('../config/default.php');
        }
        if(!$config) {
            $config = new wlJSOConfig();
        }

        if(isset($doDecoy)) {
            $config->DO_DECOY = wlJSOUtils::toBool($doDecoy);
        }
        if(isset($doMinify)) {
            $config->DO_MINIFY = wlJSOUtils::toBool($doMinify);
        }
        if(isset($doLockDomain)) {
            $config->DO_LOCK_DOMAIN = wlJSOUtils::toBool($doLockDomain);
        }
        if(isset($doScrambleVars)) {
            $config->DO_SCRAMBLE_VARS = wlJSOUtils::toBool($doScrambleVars);
        }
        if(isset($encryptionLevel)) {
            $config->ENCRYPTION_LEVEL = intval($encryptionLevel);
        }
        if(isset($expirationDate)) {
            $config->EXPIRATION_DATE = $expirationDate;
        }
        if(isset($showLockAlerts)) {
            $config->SHOW_JS_LOCK_ALERTS = $showLockAlerts;
        }
        $jso = new wlJSOProcessor();
        $jso->init($js, $config, $rep);
        header('Content-Type: application/javascript');
        echo $jso->get();
    }
}
