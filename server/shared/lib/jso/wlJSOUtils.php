<?php
if(class_exists('wlJSOUtils')) {
    return;
}
/**
 * WiseLoop JavaScript Obfuscator Utils class definition<br/>
 *
 * @author WiseLoop
 */
class wlJSOUtils {

    /**
     * Converts a value to boolean.
     * @param mixed $val the input value
     * @return bool
     */
    public static function toBool($val) {
        return ($val === true || in_array($val, array('true', 'yes', 'on', 'checked', '1', 1))) ? true : false;
    }

    /**
     * Returns the last modified time of the given $uri (local file or url).
     * @param string $uri the uri (local file or url)
     * @return int last modification timestamp of $uri
     */
    public static function getRemoteFileMTime($uri) {
        if (file_exists($uri)) {
            return filemtime($uri);
        }

        $uri = parse_url($uri);
        $handle = @fsockopen($uri['host'], 80);
        if (!$handle) {
            return 0;
        }

        fputs($handle, "HEAD $uri[path] HTTP/1.1\r\nHost: $uri[host]\r\n\r\n");
        $result = 0;
        while (!feof($handle)) {
            $line = fgets($handle, 1024);
            if (!trim($line)) {
                break;
            }

            $col = strpos($line, ':');
            if ($col !== false) {
                $header = trim(substr($line, 0, $col));
                $value = trim(substr($line, $col + 1));
                if (strtolower($header) == 'last-modified') {
                    $result = strtotime($value);
                    break;
                }
            }
        }
        fclose($handle);
        return $result;
    }

    /**
     * Searches through $array using indexes given in $indexes and returns first value founded.<br/>
     * If nothing is found, returns $default.
     * @param array $array the haystack array
     * @param array|string|int $indexes the indexes
     * @param mixed $default the return value if the $array does not have an index from $indexes array
     * @return mixed
     */
    public static function getArrayValue($array, $indexes, $default = null) {
        if (!isset($array)) {
            return null;
        }

        if (!is_array($array)) {
            return null;
        }

        if (!isset($indexes)) {
            return null;
        }

        if(!is_array($indexes)) {
            $indexes = array($indexes);
        }

        if (is_array($indexes)) {
            foreach ($indexes as $index) {
                if (isset($array[$index])) {
                    return $array[$index];
                }
            }
        }else {
            if (isset($array[$indexes])) {
                return $array[$indexes];
            }
        }

        return $default;
    }

    /**
     * Converts a date to Unix timestamp.<br/>
     * If the input date could not be converted, it will return null.
     * @param string $date the input date formatted as yyyy-mm-dd
     * @return int the Unix timestamp in seconds
     */
    public static function dateToUTime($date) {
        if(!$date) {
            return null;
        }
        $date = date_parse($date);
        if(!is_array($date)) {
            return null;
        }
        if($date['error_count'] !== 0) {
            return null;
        }
        $ret = mktime(0, 0, 0, $date['month'], $date['day'], $date['year']);
        return $ret;
    }

    /**
     * Reads the contents of a file.
     * @param string $filePath the file path
     * @return null|string file contents
     */
    public static function getFileContents($filePath) {
        $fh = @fopen($filePath, 'r');
        if(!$fh) {
            return null;
        }
        $data = fread($fh, filesize($filePath));
        fclose($fh);
        if (get_magic_quotes_runtime()) {
            $data = stripslashes($data);
        }
        return $data;
    }

    /**
     * Sanitizes the given directory path by removing trailing / and \ .
     * @param string $dir
     * @return string string
     */
    public static function sanitizeDirPath($dir) {
        if(in_array(substr($dir, -1), array('/', '\\'))) {
            $dir = substr($dir, 0, strlen($dir) - 1);
        }
        return $dir;
    }

    /**
     * Completes an array with elements having a specified value until it has a certain number of elements.
     * @param array $array
     * @param int $count the number of elements
     * @param null $value the value to be added to array
     * @return array
     */
    public static function completeArray($array, $count, $value = null) {
        if(!is_array($array)) {
            $array = array($array);
        }
        for($i=count($array); $i<$count; $i++) {
            $array[] = $value;
        }
        return $array;
    }

    /**
     * Loads a php configuration file.
     * The given configuration file must return an array().
     * @param string $phpCfgFilePath
     * @return array|null
     */
    public static function loadPhpConfig($phpCfgFilePath) {
        $config = null;
        if(file_exists($phpCfgFilePath)) {
            $config = require_once $phpCfgFilePath;
        }
        return $config;
    }
}
