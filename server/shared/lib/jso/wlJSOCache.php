<?php

if(class_exists('wlJSOCache')) {
    return;
}

require_once 'lib/wlCacheByFile.php';

/**
 * WiseLoop JavaScript Obfuscator Cache class definition<br/>
 * The Obfuscator Cache object uses file system to manage cache for obfuscated JavaScript files in an associative structure pair (key, data).
 * An existing directory must be specified when constructing the cache object.
 * @code
$jsoCache = new wlJSOCache($dir);
 * @endcode
 *
 * @author WiseLoop
 */
class wlJSOCache extends wlCacheByFile {

    /**
     * Constructor.<br/>
     * Creates a wlJSOCache object.
     * @param string $dir the cache directory
     */
    public function __construct($dir) {
        parent::__construct($dir, 'wljsobs', 0);
    }

    /**
     * Tests if the cache is up to date (not expired) for a specified key.
     * The key is an array consisting of the JavaScript filename, repository and the obfuscation parameters.
     * @param string|array $key the cache key
     * @return bool if cache is up to date
     */
    public function isCacheUpdated($key) {
        $cacheFilePath = $this->getCacheFilePath($key);
        if (!$cacheFilePath) {
            return false;
        }

        if (file_exists($cacheFilePath) && filemtime($cacheFilePath) >= wlJSOUtils::getRemoteFileMTime($cacheFilePath)) {
            return true;
        }

        return false;
    }
}
