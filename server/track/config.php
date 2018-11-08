<?php
set_time_limit(0);
ini_set('mysql.connect_timeout',1600);
ini_set('max_execution_time', 1600);
ini_set('default_socket_timeout',1600);
ini_set("mysql.trace_mode", "0");

date_default_timezone_set('America/Los_Angeles');

switch(MODE)
{
    case 'local':
        define('API_PATH',$app_path);
        define('TMP_PATH',API_PATH . 'tmp/');
        define('WWW_HOST','#########');
        define('API_HOST','localhost');

        define('DATABASE_HOST','127.0.0.1');
        define('DATABASE_PORT',3306);
        define('DATABASE_NAME','adsensor_db');
        define('DATABASE_USERNAME','#########');
        define('DATABASE_PASSWORD','#########');
        define('ENABLE_LOGS',true);
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        break;

    default:
    case 'prod':
        define('API_PATH','');
        define('TMP_PATH','#########');
        define('WWW_HOST','#########');
        define('API_HOST','#########');
        define('DATABASE_HOST','#########');
        define('DATABASE_PORT',3306);
        define('DATABASE_NAME','#########');
        define('DATABASE_USERNAME','#########');
        define('DATABASE_PASSWORD','#########');
        define('ENABLE_LOGS',false);
        error_reporting(E_ERROR | E_PARSE);

        break;
}

/** ========
 *  INCLUDES
 *  ========
 */
//operational paths
define('LIB_PATH',API_PATH . 'lib/');
define('SHARED_LIB_PATH',API_PATH . '../shared/lib/');
define('DATA_PATH',API_PATH . 'data/');
define('SHARED_DATA_PATH',API_PATH . '../shared/data/');

define('MODEL_PATH',API_PATH . 'model/');
define('CONTROLLER_PATH',API_PATH . 'controller/');
define('LOG_PATH',API_PATH . '/log/');


//libraries
include(SHARED_LIB_PATH . 'utility.php');
include(SHARED_LIB_PATH . 'database.class.php');
include(SHARED_LIB_PATH . 'browser.class.php');

//geoip/browser
require_once(SHARED_LIB_PATH . 'vendor/autoload.php');
include(SHARED_LIB_PATH . 'identify.class.php');

//models

include(MODEL_PATH . 'user.model.php');
include(MODEL_PATH . 'device.model.php');
include(MODEL_PATH . 'ip.model.php');
include(MODEL_PATH . 'org.model.php');


//object classes
include(LIB_PATH . 'user.class.php');
include(LIB_PATH . 'tracker.class.php');


?>