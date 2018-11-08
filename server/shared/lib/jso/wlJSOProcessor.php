<?php

require_once 'wlJSOConfig.php';
require_once 'wlJSOUtils.php';
require_once 'wlJSOCache.php';
require_once 'wlJSODecoyer.php';
require_once 'wlJSODomainLocker.php';
require_once 'wlJSOEncryptor.php';
require_once 'wlJSOExpirator.php';
require_once 'wlJSOMinifier.php';
require_once 'wlJSOScrambler.php';

if(class_exists('wlJSOProcessor')) {
    return;
}
/**
 * WiseLoop JavaScript Obfuscator Processor class definition<br/>
 * 
 * @author WiseLoop
 */
class wlJSOProcessor {

    const SIGNATURE = "//Protected by WiseLoop PHP JavaScript Obfuscator: http://wiseloop.com\r\n";
    const DEFAULT_REPOSITORY_NAME = 'default';

    /**
     * @var string - the actual JavaScript code, or an URL path to a JavaScript file, or a JavaScript filename from the repository
     */
    private $_js;

    /**
     * @var string - if the current JavaScript source code was loaded from a file, this holds the full path to that file
     */
    private $_jsFile;

    /**
     * @var string - holds the actual original unobfuscated JavaScript source code
     */
    private $_jsCode;

    /**
     * @var string - holds the obfuscated JavaScript source code
     */
    private $_jsCodeObfuscated;

    /**
     * @var wlJSOConfig - specifies active configuration options for the obfuscation engine
     */
    private $_config;

    /**
     * @var string - specifies the repository name from where the source code will be loaded
     */
    private $_repositoryName;

    /**
     * @var array - the repository configuration: an array of directories holding JavaScript source files
     */
    private $_repository = null;

    /**
     * @var wlJSOCache - the cache handler
     */
    private $_cache;

    /**
     * Constructor.<br/>
     * Creates a wlJSOProcessor object.
     */
    public function __construct() {
    }

    /**
     * Initializes a wlJSO object.
     * @param string $js the actual JavaScript code, or an URL path to a JavaScript file, or a JavaScript filename from the repository
     * @param wlJSOConfig $config
     * @param string $repositoryName the repository name
     * @return void
     */
    public function init($js = null, $config = null, $repositoryName = null) {
        $this->_js = $js;
        if(!isset($config)) {
            $config = new wlJSOConfig();
        }
        $this->_config = $config;

        if(!isset($repositoryName)) {
            $repositoryName = self::DEFAULT_REPOSITORY_NAME;
        }
        $this->_jsFile = '';
        $this->_jsCodeObfuscated = null;
        $this->_repositoryName = $repositoryName;
        $this->_cache = new wlJSOCache(__DIR__ . '/../cache');

        $repositoryFile = '../repository/' . $this->_repositoryName . '.php';
        if(file_exists($repositoryFile)) {
            $this->_repository = require_once $repositoryFile;
        }
        $this->jsLoad();
    }

    /**
     * Loads JavaScript code from an URL or a string.
     * @return void
     */
    private function jsLoad() {
        if(!isset($this->_js) && !isset($this->_repository)) {
            return;
        }

        if(!isset($this->_js)) {
            if(isset($this->_repository)) {
                foreach($this->_repository as $dir) {
                    $dir = wlJSOUtils::sanitizeDirPath($dir);
                    $dh = @opendir(realpath($dir));
                    if ($dh) {
                        while (false !== ($file = readdir($dh))) {
                            $file = realpath($dir . '/' . $file);
                            if(!is_dir($file) && file_exists($file) && substr($file, -3) == '.js') {
                                $this->_jsCode .= wlJSOUtils::getFileContents($file);
                            }
                        }
                        @closedir($dh);
                    }
                }
            }
        }elseif(substr($this->_js, -3) == '.js') {
            $this->_jsCode = wlJSOUtils::getFileContents($this->_js);
            if($this->_jsCode) {
                $this->_jsFile = $this->_js;
            }else {
                if(isset($this->_repository)) {
                    foreach($this->_repository as $dir) {
                        $dir = wlJSOUtils::sanitizeDirPath($dir);
                        $file = realpath($dir) . '/' . $this->_js;
                        if(file_exists($file)) {
                            $this->_jsCode = wlJSOUtils::getFileContents($file);
                            if($this->_jsCode) {
                                $this->_jsFile = $file;
                                break;
                            }
                        }
                    }
                }
            }
        }else {
            $this->_jsCode = $this->_js;
            if (get_magic_quotes_gpc()) {
                $this->_jsCode = stripslashes($this->_jsCode);
            }
        }
    }

    private function getJsLoadError($template) {
        $jsRes = @file_get_contents(__DIR__ . '/template/' . $template . '.jst');
        if(!$jsRes) {
            return 'alert("JavaScript source code could not be loaded");';
        }
        $repoString = str_ireplace(
            array('array', "\\", "\n", "\r"),
            array('', "/", "\\n", "\\r"),
            print_r($this->_repository, true)
        );
        $jsRes = str_replace(array("\r","\n"), ' ', $jsRes);
        $jsRes = str_replace(
            array('{JS}', '{REPOSITORYNAME}', '{REPOSITORY}'),
            array($this->_js, $this->_repositoryName, $repoString),
            $jsRes);
        return $jsRes;
    }

    /**
     * Returns the obfuscated JavaScript code.
     * @return string
     */
    public function get() {
        if(!$this->_jsCode) {
            if(!$this->_js) {
                return $this->getJsLoadError('js-not-given');
            }
            return $this->getJsLoadError('js-not-found');
        }

        if(isset($this->_jsCodeObfuscated)) {
            return $this->_jsCodeObfuscated;
        }
        return $this->_jsCodeObfuscated = $this->jsObfuscate();
    }

    /**
     * Performs JavaScript code obfuscation and returns the obfuscated code.
     * @return string the obfuscated JavaScript code
     */
    private function jsObfuscate() {
        $expirationMessage = '';
        $lockedMessage = '';
        if($this->_config->SHOW_JS_LOCK_ALERTS) {
            $expirationMessage = str_replace(
                array('{JS}', '{DATE}'),
                array($this->_jsFile ? basename($this->_jsFile) : 'Script', date('Y-m-d', wlJSOUtils::dateToUTime($this->_config->EXPIRATION_DATE))),
                $this->_config->MSG_EXPIRED);
            $lockedMessage = str_replace(
                array('{JS}', '{DOMAIN}'),
                array($this->_jsFile ? basename($this->_jsFile) : 'Script', $_SERVER['HTTP_HOST']),
                $this->_config->MSG_LOCK_DOMAIN);
        }

        $cacheId = $this->getCacheId();

        $wlJsParser = null;

        if(($this->_config->DO_DECOY && wlJSODecoyer::httpCheck()) || !$this->_config->DO_DECOY || !$this->_jsFile) {
            set_time_limit(60 * 5);
            $cached = false;
            if ($this->_cache->isCacheUpdated($cacheId)) {
                $js = $this->_cache->loadCache($cacheId);
                $cached = true;
            }else {
                $js = $this->_jsCode;
                if($this->_config->EXPIRATION_DATE) {
                    $js = wlJSOExpirator::setExpirationDate($js, $this->_config->EXPIRATION_DATE, $expirationMessage);
                }
                if($this->_config->DO_LOCK_DOMAIN) {
                    $js = wlJSODomainLocker::domainLock($js, $lockedMessage);
                }
                if($this->_config->DO_SCRAMBLE_VARS) {
                    if($wlJsParser == null) {
                        $wlJsParser = new wlJSOJsParser($js);
                    }
                    $js = wlJSOScrambler::scramble($wlJsParser);
                }
                if($this->_config->DO_MINIFY) {
                    if($wlJsParser == null) {
                        $wlJsParser = new wlJSOJsParser($js);
                    }
                    $js = wlJSOMinifier::minify($wlJsParser);
                }
                if($cacheId && !$cached) {
                    if($this->_config->CACHE_LEVEL == 1 || ($this->_config->CACHE_LEVEL >=1 && !$this->_config->ENCRYPTION_LEVEL)) {
                        $this->_cache->saveCache($cacheId, $js);
                    }
                }
            }
            if($this->_config->ENCRYPTION_LEVEL) {
                $js = wlJSOEncryptor::encrypt($js, $this->_config->ENCRYPTION_LEVEL);
                if($cacheId && !$cached) {
                    if($this->_config->CACHE_LEVEL >= 2) {
                        $this->_cache->saveCache($cacheId, $js);
                    }
                }
            }
        }else { //generate decoy code and apply active obfuscation settings
            $js = wlJSODecoyer::decoy($this->_jsCode);
            if($this->_config->EXPIRATION_DATE) {
                $js = wlJSOExpirator::setExpirationDate($js, $this->_config->EXPIRATION_DATE, $expirationMessage);
            }
            if($this->_config->DO_LOCK_DOMAIN) {
                $js = wlJSODomainLocker::domainLock($js, $lockedMessage);
            }
            if($this->_config->DO_SCRAMBLE_VARS) {
                if($wlJsParser == null) {
                    $wlJsParser = new wlJSOJsParser($js);
                }
                $js = wlJSOScrambler::scramble($wlJsParser);
            }
            if($this->_config->DO_MINIFY) {
                if($wlJsParser == null) {
                    $wlJsParser = new wlJSOJsParser($js);
                }
                $js = wlJSOMinifier::minify($wlJsParser);
            }
            if($this->_config->ENCRYPTION_LEVEL) {
                $js = wlJSOEncryptor::encrypt($js, $this->_config->ENCRYPTION_LEVEL);
            }
        }
        if($this->_config->SHOW_WISELOOP_SIGNATURE) {
            $js = self::SIGNATURE . $js;
        }
        return $js;
    }

    /**
     * Generates an unique cache file name.
     * @return string the cache file name
     */
    private function getCacheId() {
        if(!$this->_config->CACHE_LEVEL || !$this->_jsFile) {
            return false;
        }
        return array(
            $this->_jsFile,
            $this->_config,
            $this->_repositoryName
        );
    }
}
