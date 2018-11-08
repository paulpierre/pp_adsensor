<?php


/** +------------------------------------+
 *  | CDN Adsensor.io by paul@pixel6.net |
 *  +------------------------------------+
 *  The "CDN" portion for Adsensor, currently it:
 *  • SDK - Hosts the javascript tracking code track.adsensor
 *  • Banner - Generates banner preview code as well allows us to remotely host javascript for said banner animations
 */
global $app_path,$cm_banner;


/** ===========
 *  PATH CONFIG
 *  =========== */
//operational paths
define('LIB_PATH',$app_path . 'lib/');
define('CONTROLLER_PATH',$app_path . 'controller/');
define('HELPER_PATH',$app_path . 'helper/');
define('ASSETS_PATH',$app_path . 'assets/');


define('SHARED_LIB_PATH',$app_path . '../shared/lib/');
define('SHARED_DATA_PATH',$app_path . '../shared/data/');

/** ===============
 *  LIBRARY LOADING
 *  =============== */
include(SHARED_LIB_PATH . 'utility.php');
include(SHARED_LIB_PATH . 'browser.class.php');
include(SHARED_LIB_PATH . 'identify.class.php');
include(LIB_PATH . 'filter.class.php');
require_once(SHARED_LIB_PATH . 'jso/wlJSO.php');
require_once(SHARED_LIB_PATH . 'packer.php');
require_once(SHARED_LIB_PATH . 'vendor/autoload.php');



/*
$cm_filter = Array(
    '_defaults' => Array(),
    'ip_location'       => Array(FILTER_FLAG_BLACK_LIST,'/(ca|ny)/i'),
    'device_user_agent' =>Array(FILTER_FLAG_BLACK_LIST,'/Xr([A-Z0-9]\w{27})/'),
    //'ip_referrer'       =>Array(FILTER_FLAG_WHITE_LIST,'/https?:\/\/[a-zA-Z0-9.]*\/+[&?._\-A-Za-z0-9]/i')
     //Not the main domain, but have a content-based referrer URL (e.g. http://ads.mopub.com fails, but http://ads.mopub.cm/users works
);


$verify_instance = new Filter(
    Array(
        'device_user_agent'=>'Googlebot/2.1 (+http://www.google.com/bot.html)',
        'ip_address'=>'173.252.249.163',
        'ip_referrer'=>'http://www.google.com/fartetc'
    )
);
$verify_instance->set_filter($cm_filter);
$verify_instance->get_all_data();
$data = $verify_instance->user_data;
print '<pre>is_bot: ' .  ($data['device_is_bot'] == 1) .  ' is_mobile: ' . ($data['device_is_mobile'] == 1) . PHP_EOL ;
exit('<pre><h1>Data1:</h1>'. print_r($data,true). '<pre></pre><h1>is_verified:</h1>' . ($verify_instance->is_verified()?'VALID USER!':'NOT VALID USER!'));

*/


if(isset($argv[1])) $q = explode('/',$argv[1]);
    else $q = explode('/',$_SERVER['REQUEST_URI']);

$controllerObject = strtolower((isset($q[1]))?$q[1]:'');
$controllerFunction = strtolower((isset($q[2]))?$q[2]:'');
$controllerID = strtolower((isset($q[3]))?$q[3]:'');
$controllerData = strtolower((isset($q[4]))?$q[4]:'');
$controllerData2 = strtolower((isset($q[5]))?$q[5]:'');
$controllerData3 = strtolower((isset($q[6]))?$q[6]:'');


/** ==================
 *  CONTROLLER ROUTING
 *  ==================
 */
//Load the object's appropriate controller
$_controller = CONTROLLER_PATH . $controllerObject . '.controller.php';
if(file_exists($_controller))  include($_controller);
    //else show_error();

