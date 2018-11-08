<?php


/** +--------------------------------+
 *  | Adsensor.io by paul@pixel6.net |
 *  +--------------------------------+
 *  a cloaking, anti-fraud, and payload delivery platform
 */


header("Access-Control-Allow-Origin: *");

include_once('config.php');


/** ===========
 *  URL MAPPING
 *  ===========
 */

//Apache rewrite handler
//exit(print_r($argv));
if(isset($argv[1])) $q = explode('/',$argv[1]);

else $q = explode('/',$_SERVER['REQUEST_URI']);

$controllerObject = strtolower((isset($q[1]))?$q[1]:'');
$controllerFunction = strtolower((isset($q[2]))?$q[2]:'');
$controllerID = strtolower((isset($q[3]))?$q[3]:'');
$controllerData = strtolower((isset($q[4]))?$q[4]:'');
$server_name = strtolower($_SERVER['HTTP_HOST']);

/** ==================
 *  CONTROLLER ROUTING
 *  ==================
 */
//Load the object's appropriate controller


$_controller = CONTROLLER_PATH . $controllerObject . '.controller.php';
if(file_exists($_controller))  include($_controller);
    else
    show_error();
/** ==================
 *  CATCH FATAL ERRORS
 *  ==================
 */

function shutdown() {
    $error = error_get_last();
    if ($error['type'] === E_ERROR) {
        // fatal error has occured
        //as_error('parse error function: parse_network_content(): ' . PHP_EOL .'error:'.PHP_EOL . $e->getMessage().'network:' . $network_id . PHP_EOL . 'content:' . $content. PHP_EOL);
        as_error('FATAL ERROR:' . PHP_EOL. 'msg:' .$last_error['message']. PHP_EOL. 'file:'. $last_error['file'] . PHP_EOL. 'line:'. $last_error['line']);
        return false;
    }
}

register_shutdown_function('shutdown');
