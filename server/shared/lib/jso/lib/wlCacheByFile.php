<?php

/**
 * WiseLoop Cache by File class definition<br/>
 * The CacheByFile object uses file system to manage cache for various data in an associative structure pair (key, data).
 * Each key must be unique and must be specified when storing and retrieving data.
 * The cache data is computed by serializing the original data and it is stored into a file derived from the unique key passed along with the data.
 * An existing directory, the cache time (expressed in seconds) and a file extension must me specified when constructing the CacheByFile object.
 * @author WiseLoop
 */
class wlCacheByFile {

    /**
     * @var string the cache directory
     */
    protected $_dir;

    /**
     * @var int caching time expressed in seconds
     */
    protected $_cacheTime;

    /**
     * @var string extension of the cache files
     */
    protected $_extension;

    /**
     * Constructor.<br/>
     * Creates a wlCacheByFile object.
     * @param string $dir the cache directory
     * @param string $extension the file extension
     * @param int $cacheTime the cache time expressed in seconds
     */
    public function __construct($dir, $extension, $cacheTime = 0) {
        $this->_dir = $dir;
        $this->_cacheTime = $cacheTime;
        $this->_extension = $extension;
    }

    /**
     * Sets the caching time.
     * @param int $cacheTime the new caching time expressed in seconds
     * @return void
     */
    public function setCacheTime($cacheTime) {
        $this->_cacheTime = $cacheTime;
    }

    /**
     * Returns the caching time expressed in seconds.
     * @return int the cache time
     */
    public function getCacheTime() {
        return $this->_cacheTime;
    }

    /**
     * Loads the results form the cache for a specified key.
     * @param string|array $key the cache key
     * @return mixed
     */
    public function loadCache($key) {
        $content = file_get_contents($this->getCacheFilePath($key));
        return unserialize($content);
    }

    /**
     * Saves data to cache.
     * @param string|array $key the cache key
     * @param mixed $data the data to be cached
     * @return bool if the save was successful
     */
    public function saveCache($key, $data) {
        $cacheFilePath = $this->getCacheFilePath($key);
        if (!$cacheFilePath) {
            return false;
        }
        $fh = @fopen($cacheFilePath, 'w');
        if (!$fh) {
            return false;
        }
        fwrite($fh, serialize($data));
        fclose($fh);
        return true;
    }

    /**
     * Returns the cache real file path for a specified key.
     * @param string|array $key the cache key
     * @return string the cache file path
     */
    protected function getCacheFilePath($key) {
        $cacheFileName = $this->getCacheFileName($key);
        if (!$cacheFileName) {
            return false;
        }
        return $this->_dir . '/' . $cacheFileName;
    }

    /**
     * Generates an unique cache file name for a specified key.
     * @param string|array $key the cache key
     * @return string the cache file name
     */
    protected function getCacheFileName($key) {
        if($key == false) {
            return null;
        }
        if(!is_array($key)) {
            $key = array($key);
        }
        $ret = serialize($key);
        return md5($ret) . '.' . $this->_extension;
    }

    /**
     * Tests if the cache is up to date (not expired) for a specified key.
     * @param string|array $key the cache key
     * @return bool if cache is up to date
     */
    public function isCacheUpdated($key) {
        $cacheFilePath = $this->getCacheFilePath($key);
        if (!$cacheFilePath) {
            return false;
        }

        if (file_exists($cacheFilePath) && filemtime($cacheFilePath) + ($this->_cacheTime) >= time()) {
            return true;
        }

        return false;
    }
}
