<?php
global $controllerObject,$controllerFunction,$controllerID,$controllerData,$controllerData2,$controllerData2, $app_path,$cm_banner,$sub_domain;

include_once(HELPER_PATH . 'ad_tag.helper.php');

$protocol = (isset($cm_banner[$campaign_identifier]['is_ssl']) && $banner_images = $cm_banner[$campaign_identifier]['is_ssl'])?'https://':'http://';

$root_url = $protocol . $_SERVER['SERVER_NAME'] . '/';


$domain =  $sub_domain[1] . '.' . $sub_domain[2];
$cookie_frequency_cap = isset($_COOKIE['as_fc'])?intval($_COOKIE['as_fc']):0;
if($cookie_frequency_cap == 0)
{
    setcookie( 'as_fc',1 , COOKIE_FREQUENCY_CAP_EXPIRATION,'/',$domain,false);
}


switch($controllerObject)
{

    /** +--------------------------+
     *  | Adsensor Tracking JS SDK |
     *  +--------------------------+
     */

    case 'sdk':


        switch($controllerFunction)
        {
            case 'pt': $js_output_type = OBFUSCATE_NONE; break;
            case 'mn': $js_output_type = OBFUSCATE_PACKER; break;
            case 'en': $js_output_type = OBFUSCATE_ENCRYPTION; break;
            default: show_404(); break;
        }

        //this means the cookie has either not been set or expired
        if(!isset($_COOKIE['as_lmt']))
        {
            $domain =  $sub_domain[1] . '.' . $sub_domain[2];
            setcookie('as_lmt',  COOKIE_ACTION_LIMIT , COOKIE_ACTION_EXPIRATION,'/',$domain,false); //the user's fingerprint
            setcookie('as_ctr',  0 , COOKIE_EXPIRATION,'/',$domain,false); //the user's fingerprint

        }


        switch($controllerID)
        {

            //production.adsensor.tracker.mraid.js
            case 'impression_tracker.sdk-v1-mraid.js':
                header("Content-Type: application/javascript");
                //$js = str_replace('{AS_ROOT_DOMAIN}',str_replace('cdn','track',$root_url),file_get_contents($app_path . 'assets/js/production.adsensor.tracker.mraid.js'));
                //$js = str_replace('{AS_ROOT_DOMAIN}',str_replace('cdn','track',$root_url),file_get_contents($app_path . 'assets/js/production.adsensor.tracker.v3.2-obfuscated.js'));
                $js = str_replace('{AS_ROOT_DOMAIN}',str_replace('cdn','track',$root_url),file_get_contents($app_path . 'assets/js/production.adsensor.tracker.v3.3.min.js'));
                exit(obfuscate_js($js,$js_output_type));
                break;

            case 'impression_tracker.sdk-v1.js':
                header("Content-Type: application/javascript");
                //$js = str_replace('{AS_ROOT_DOMAIN}',str_replace('cdn','track',$root_url),file_get_contents($app_path . 'assets/js/production.adsensor.tracker.v1.js'));
                //$js = str_replace('{AS_ROOT_DOMAIN}',str_replace('cdn','track',$root_url),file_get_contents($app_path . 'assets/js/production.adsensor.tracker.v3.2-obfuscated.js'));
                $js = str_replace('{AS_ROOT_DOMAIN}',str_replace('cdn','track',$root_url),file_get_contents($app_path . 'assets/js/production.adsensor.tracker.v3.3.min.js'));

                exit(obfuscate_js($js,$js_output_type));
            break;



            case 'impression_tracker.sdk-v2.js':
                header("Content-Type: application/javascript");
                //$js = str_replace('{AS_ROOT_DOMAIN}',str_replace('cdn','track',$root_url),file_get_contents($app_path . 'assets/js/production.adsensor.tracker.v3.2-obfuscated.js'));
                $js = str_replace('{AS_ROOT_DOMAIN}',str_replace('cdn','track',$root_url),file_get_contents($app_path . 'assets/js/production.adsensor.tracker.v3.3.min.js'));

                //$js = str_replace('{AS_ROOT_DOMAIN}',str_replace('cdn','track',$root_url),file_get_contents($app_path . 'assets/js/production.adsensor.tracker.v3-obfuscated.js'));
                //$js = str_replace('{AS_ROOT_DOMAIN}',str_replace('cdn','track',$root_url),file_get_contents($app_path . 'assets/js/production.adsensor.tracker.v3.2-obfuscated.js'));

                exit(obfuscate_js($js,$js_output_type));
                break;


            case 'impression_tracker.sdk-lp.js':
                header("Content-Type: application/javascript");
                $js = file_get_contents($app_path . 'assets/js/production.adsensor.tracker.v2-obfuscated.js');
                exit($js);
                break;


            case 'impression_tracker.sdk-lp.js':
                header("Content-Type: application/javascript");
                $js = file_get_contents($app_path . 'assets/js/production.adsensor.tracker-min-obf.v2.js');
                exit($js);
                break;

            case 'impression_tracker.sdk-v2.2.js':
                /*
                header("Content-Type: application/javascript");
                $js = file_get_contents($app_path . 'assets/js/production.adsensor.tracker-min-obf.v2.2.js');
                exit($js);*/
                header("Content-Type: application/javascript");
                //$js = str_replace('{AS_ROOT_DOMAIN}',str_replace('cdn','track',$root_url),file_get_contents($app_path . 'assets/js/production.adsensor.tracker.v2.js'));
                //$js = str_replace('{AS_ROOT_DOMAIN}',str_replace('cdn','track',$root_url),file_get_contents($app_path . 'assets/js/production.adsensor.tracker.v3.2-obfuscated.js'));
                $js = str_replace('{AS_ROOT_DOMAIN}',str_replace('cdn','track',$root_url),file_get_contents($app_path . 'assets/js/production.adsensor.tracker.v3.3.min.js'));

                exit(obfuscate_js($js,$js_output_type));
                break;
                //

            case 'impression_tracker.sdk-v2.2-mraid.js':
                //TODO: this is for testing performance, switch it back!
                /*
                header("Content-Type: application/javascript");
                $js = file_get_contents($app_path . 'assets/js/production.adsensor.tracker-min-obf.v2.2.js');
                exit($js);*/
                header("Content-Type: application/javascript");
                //$js = str_replace('{AS_ROOT_DOMAIN}',str_replace('cdn','track',$root_url),file_get_contents($app_path . 'assets/js/production.adsensor.tracker.v2-mraid.js'));
                //$js = str_replace('{AS_ROOT_DOMAIN}',str_replace('cdn','track',$root_url),file_get_contents($app_path . 'assets/js/production.adsensor.tracker.mraid.js'));
                //$js = str_replace('{AS_ROOT_DOMAIN}',str_replace('cdn','track',$root_url),file_get_contents($app_path . 'assets/js/production.adsensor.tracker.v3-obfuscated.js'));
                //$js = str_replace('{AS_ROOT_DOMAIN}',str_replace('cdn','track',$root_url),file_get_contents($app_path . 'assets/js/production.adsensor.tracker.v3.2.js'));
                //$js = str_replace('{AS_ROOT_DOMAIN}',str_replace('cdn','track',$root_url),file_get_contents($app_path . 'assets/js/production.adsensor.tracker.v3.2-obfuscated.js'));
                $js = str_replace('{AS_ROOT_DOMAIN}',str_replace('cdn','track',$root_url),file_get_contents($app_path . 'assets/js/production.adsensor.tracker.v3.3.min.js'));


                //production.adsensor.tracker.v3.js
                exit(obfuscate_js($js,$js_output_type));
                break;


            case 'impression_tracker.sdk-v3.3-ap.js':
                header("Content-Type: application/javascript");
                $raw_js = file_get_contents($app_path . 'assets/js/production.adsensor.tracker.v3.3-ap.js');
                $js = replace_strings($raw_js, Array(
                    AS_DOMAIN=>get_macro(AS_DOMAIN),
                    AS_TRACKER_DOMAIN=>get_macro(AS_TRACKER_DOMAIN),
                    AS_COOKIE_DOMAIN=>get_macro(AS_COOKIE_DOMAIN),
                    AS_ROOT_DOMAIN=>get_macro(AS_ROOT_DOMAIN)));
                exit($js);
            break;


            case 'impression_tracker.sdk-v3.2.js':
                header("Content-Type: application/javascript");
                //$js = str_replace('{AS_ROOT_DOMAIN}',str_replace('cdn','track',$root_url),file_get_contents($app_path . 'assets/js/production.adsensor.tracker.v3.2-obfuscated.js'));
                //$js = str_replace('{AS_ROOT_DOMAIN}',str_replace('cdn','track',$root_url),file_get_contents($app_path . 'assets/js/production.adsensor.tracker.v3.3.min.js'));

                $raw_js = file_get_contents($app_path . 'assets/js/production.adsensor.tracker.v3.3.min.js');
                $js = replace_strings($raw_js, Array(
                    AS_DOMAIN=>get_macro(AS_DOMAIN),
                    AS_TRACKER_DOMAIN=>get_macro(AS_TRACKER_DOMAIN),
                    AS_COOKIE_DOMAIN=>get_macro(AS_COOKIE_DOMAIN),
                    AS_ROOT_DOMAIN=>get_macro(AS_ROOT_DOMAIN)));
                //$js = str_replace('{AS_ROOT_DOMAIN}',str_replace('cdn','track',$root_url),);
                exit($js);

                //exit(obfuscate_js($js,$js_output_type));
                break;

            case 'impression_tracker.sdk-v3.3.js':
                //header("Content-Type: application/javascript");
                //$js = str_replace('{AS_ROOT_DOMAIN}',str_replace('cdn','track',$root_url),file_get_contents($app_path . 'assets/js/production.adsensor.tracker.v3.3.min.js'));
                //exit(obfuscate_js($js,$js_output_type));
                //break;


            case 'impression_tracker.sdk-v3.4.js':
               header("Content-Type: application/javascript");
                $raw_js = file_get_contents($app_path . 'assets/js/production.adsensor.tracker.v3.4.js');// production.adsensor.tracker.v3.4-obfuscated.js
                //$raw_js = file_get_contents($app_path . 'assets/js/production.adsensor.tracker.v3.4-obfuscated.js');
                //$raw_js = file_get_contents($app_path . 'assets/js/production.adsensor.tracker.v3.4.min.js');
                //exit($raw_js);

                $js = replace_strings($raw_js, Array(
                    AS_DOMAIN=>get_macro(AS_DOMAIN),
                    AS_TRACKER_DOMAIN=>get_macro(AS_TRACKER_DOMAIN),
                    AS_COOKIE_DOMAIN=>get_macro(AS_COOKIE_DOMAIN),
                    AS_ROOT_DOMAIN=>get_macro(AS_ROOT_DOMAIN),
                    '{AS_FREQUENCY_CAPPED}'=>$cookie_frequency_cap
                ));
                exit($js);
            break;


            case 'track_tag.js':
                header("Content-Type: application/javascript");
                $raw_js = file_get_contents($app_path . 'assets/js/production.adsensor.tracker.v3.5-obfuscated.js');
                //$raw_js = file_get_contents($app_path . 'assets/js/production.adsensor.tracker.v3.5.js');
                $js = replace_strings($raw_js, Array(
                    AS_DOMAIN=>get_macro(AS_DOMAIN),
                    AS_TRACKER_DOMAIN=>get_macro(AS_TRACKER_DOMAIN),
                    AS_COOKIE_DOMAIN=>get_macro(AS_COOKIE_DOMAIN),
                    AS_ROOT_DOMAIN=>get_macro(AS_ROOT_DOMAIN),
                    AS_JS_ANIMATION_URL=>get_macro(AS_JS_ANIMATION_URL),
                    '{AS_FREQUENCY_CAPPED}'=>$cookie_frequency_cap
                ));
                exit($js);
            break;

            case 'sw-track2.js': case 'sw-track.js':
                header("Content-Type: application/javascript");
                $js = file_get_contents($app_path . 'assets/js/production.nutra_sw.js');
                exit($js);
                break;

            case 'track_tag-mm.js':
                header("Content-Type: application/javascript");
                $js = file_get_contents($app_path . 'assets/js/production.track_tag-mm.js');
                exit($js);
            break;

            case 'track_boostgp.js':
                header("Content-Type: application/javascript");
                //$js = file_get_contents($app_path . 'assets/js/production.batteryboostgp.js');
                $js = file_get_contents($app_path . 'assets/js/production.batteryboostgp-obfuscated.js');
                exit($js);

            case 'track_tag-pm.js':
                header("Content-Type: application/javascript");
                header("X-Robots-Tag: noindex");
                $raw_js = file_get_contents($app_path . 'assets/js/production.track_tag-pm-obfuscated.3.8.js');
                $js = replace_strings($raw_js, Array(
                    AS_DOMAIN=>get_macro(AS_DOMAIN),
                    AS_TRACKER_DOMAIN=>get_macro(AS_TRACKER_DOMAIN),
                    AS_COOKIE_DOMAIN=>get_macro(AS_COOKIE_DOMAIN),
                    AS_ROOT_DOMAIN=>get_macro(AS_ROOT_DOMAIN),
                    AS_JS_ANIMATION_URL=>get_macro(AS_JS_ANIMATION_URL),
                    '{AS_FREQUENCY_CAPPED}'=>$cookie_frequency_cap
                ));
                exit($js);


            break;

            case 'track_tag-alx.js':
                header("Content-Type: application/javascript");
                header("X-Robots-Tag: noindex");
                $raw_js = file_get_contents($app_path . 'assets/js/production.track_tag-alx-obfuscated.js');
                $js = replace_strings($raw_js, Array(
                    AS_DOMAIN=>get_macro(AS_DOMAIN),
                    AS_TRACKER_DOMAIN=>get_macro(AS_TRACKER_DOMAIN),
                    AS_COOKIE_DOMAIN=>get_macro(AS_COOKIE_DOMAIN),
                    AS_ROOT_DOMAIN=>get_macro(AS_ROOT_DOMAIN),
                    AS_JS_ANIMATION_URL=>get_macro(AS_JS_ANIMATION_URL),
                    '{AS_FREQUENCY_CAPPED}'=>$cookie_frequency_cap
                ));
                exit($js);




            default: show_404(); break;


        }

    default: show_404(); break;



}

