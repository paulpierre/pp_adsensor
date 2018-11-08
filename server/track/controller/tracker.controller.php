<?php
global $controllerID,$controllerObject,$controllerFunction,$controllerData,$sub_domain;

/** ====================
 *  tracker.controller.php
 *  ====================

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


switch($controllerFunction)
{


    case 'impression_pixel':

        //fetch client side data
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
        $device_plugins                 = (!empty($_GET['pl']))?filter_var($_GET['pl'], FILTER_SANITIZE_NUMBER_INT):null;
        $device_mimetypes               = (!empty($_GET['mt']))?filter_var($_GET['mt'], FILTER_SANITIZE_NUMBER_INT):null;
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

        $ip_campaign_click_id           = (!empty($_GET['clkid']))?filter_var($_GET['clkid'], FILTER_SANITIZE_STRING):null;




        if(!empty($_GET['ref']) && $_GET['ref'] !== 'undefined')
            $ip_referrer = filter_var($_GET['ref'], FILTER_SANITIZE_STRING);
        else if(!empty($_SERVER['HTTP_REFERER'])) $ip_referrer = $_SERVER['HTTP_REFERER'];
            else $ip_referrer = null;


        //$device_user_agent = urlencode($_SERVER['HTTP_USER_AGENT']);
        //$ip_address = (MODE=='local')?generate_random_ip():$_SERVER['HTTP_X_FORWARDED_FOR'];
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
        //$ip_metro_code = $user_data['ip_metro_code'];
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

        //$cookie_frequency_cap = isset($_COOKIE['as_fc'])?$_COOKIE['as_fc']:0;




        //$cookie_view_count++;



        /*
        $is_valid_user =(
            $device_is_bot !== 1 &&
            isset($ip_accept_header)
        )?true:false;
        */

        $cookie_user_fingerprint = isset($_COOKIE['as_fp']) && !empty($_COOKIE['as_fp'])?$_COOKIE['as_fp']:false;

        $cookie_action_counter = isset($_COOKIE['as_ctr'])?intval($_COOKIE['as_ctr']):0; //i set this at -1 because of the browser having to reload and it will double count, so on reload it will = 1
        //$cookie_action_limit = COOKIE_ACTION_LIMIT;
        //$cookie_action_expiration = COOKIE_ACTION_EXPIRATION;



        //$cookie_server_qc = isset($_COOKIE['as_ss_qc'])?intval($_COOKIE['as_ss_qc']):false;

        //lets enforce this logic server side, but if neither server or client checks out, lets null these counters so we don't make mistakes
        //as_error('device_qc: ' . $device_qc . ' server_qc: ' . $cookie_server_qc);

        /*
        if($device_qc == -1 || $cookie_server_qc == -1)
        {
            //$cookie_action_limit = 0;
            $cookie_action_counter = 0;
        } else
            if($cookie_action_counter <= $cookie_action_limit) $cookie_action_counter++;
             //if client and server-side qc checks out, then we assume the client will run the action, so lets increase the counter
        */

        $domain =  $sub_domain[1] . '.' . $sub_domain[2];

        /** ========================
         *  COOKIE FREQUENCY CAPPING
         *  ========================


        if($cookie_frequency_cap == 0)
        {
            setcookie( 'as_fc',1 , COOKIE_FREQUENCY_CAP_EXPIRATION,'/',$domain,false);
        }
         *   */

        //
        //we should trust the fingerprint in the cookie first
        if(!$cookie_user_fingerprint)
            //$user_fingerprint = (!empty($_GET['fp']))?filter_var($_GET['fp'], FILTER_SANITIZE_STRING):md5($cookie_random_number . $ip_asn . $ip_timezone . $ip_country . $ip_domain . $ip_city. $ip_provider . $ip_location . $ip_postal_code . $ip_organization . $ip_provider . $device_user_agent);
        {
            $user_fingerprint = md5($cookie_random_number . $ip_asn . $ip_timezone . $ip_country . $ip_domain . $ip_city . $ip_provider . $ip_location . $ip_postal_code . $ip_organization . $ip_provider . $device_user_agent);
            setcookie( 'as_fp',$user_fingerprint , COOKIE_EXPIRATION,'/',$domain,false); //the user's fingerprint
        }
        else $user_fingerprint = $cookie_user_fingerprint;




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

        /*
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
            'as_cs_qc'=>Array(
                'val'=>($device_qc == null)?-1:$device_qc,
                'exp'=>COOKIE_EXPIRATION),
            'as_ss_qc'=>Array(
                'val'=>$is_valid_user,
                'exp'=>COOKIE_EXPIRATION)
        );

        //error_log('cookies: '.print_r($ac_cookies,true));

        foreach($ac_cookies as $k=>$v)
        {
            setcookie($k,$v['val'],$v['exp'],'/',$domain);
        }*/

        header("Content-Type: image/png");
        header("HTTP/1.1 200 OK");




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
    break;

    


    default:
        show_error();
    break;

}
